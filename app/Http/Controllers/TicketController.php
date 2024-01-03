<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Models\Agenda;
use App\Models\Participant;
use App\Models\ParticipantTicket;
use App\Models\Ticket;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TicketController extends Controller
{
    public function index(Agenda $agenda)
    {
        if ($agenda) {
            return view('agenda.ticket.index', [
                'title' => 'Ticket',
                'agenda' => $agenda
            ]);
        }
        abort(404);
    }

    public function getData($agenda)
    {
        if (request()->ajax()) {
            $ticket = Ticket::where(['agenda_id' => $agenda])->get();
            return response()->json($ticket, 200);
        }
        abort(404);
    }

    public function store(Request $request, $agenda)
    {
        if (request()->ajax()) {
            Ticket::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
                'stock' => $request->stock,
                'user_limit' => $request->user_limit,
                'benefits' => json_encode($request->benefit),
                'agenda_id' => $agenda
            ]);
            addToLog('Menambah Tiket');
            return response()->json(['message' => 'Ticket successfully saved!'], 200);
        }
        abort(404);
    }

    public function show(Agenda $agenda, Ticket $ticket)
    {
        if (request()->ajax() && $ticket->agenda->id === $agenda->id) {
            return response()->json($ticket, 200);
        }
        abort(404);
    }

    public function update(Request $request, $agenda, Ticket $ticket)
    {
        if (request()->ajax()) {
            $ticket->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
                'stock' => $request->stock,
                'user_limit' => $request->user_limit,
                'benefits' => json_encode($request->benefit),
            ]);
            addToLog('Mengubah Tiket');
            return response()->json(['message' => 'Ticket successfully Updated!'], 200);
        }
        abort(404);
    }

    public function participant(Agenda $agenda, Ticket $ticket)
    {
        if ($agenda) {
            return view('agenda.participant.index', [
                'title' => 'Agenda Participant',
                'ticket' => $ticket,
                'agenda' => $agenda
            ]);
        }
        abort(404);
    }

    public function reSend(Request $request,Agenda $agenda, Ticket $ticket, Participant $participant)
    {
        // set participant ticket and participant agenda
        $recent_ticket_participant = $participant->participantTicket->ticket->id;
        $recent_agenda_participant = $participant->participantTicket->ticket->agenda->id;

        if (!$participant->participantTicket->is_paid) {
            return redirect()->back()->with('error', 'Tidak dapat mengirim ulang pesan untuk tiket yang pembayarannya belum terverifikasi');
        }

        // check if this participant in the right ticket and agenda
        if ($recent_agenda_participant == $agenda->id && $recent_ticket_participant == $ticket->id) {
            $participant->update(['email' => $request->email]);
            $data = ['participant' => $participant, 'qr_link' => route('ticket.checkIn', encrypt([$participant->participantTicket->id, $participant->nama]))];
            dispatch(new SendMailJob($data));

            addToLog('Resend Email atas nama: '. $participant->nama);
            return redirect()->back()->with('success' , 'Resend email successfully.');
        }
        return redirect()->back()->with('error' , 'Peserta tidak terdaftar di dalam agenda ini');
    }

    public function declineProof(Agenda $agenda, Ticket $ticket, ParticipantTicket $participant_ticket)
    {
        if (auth()->guard('comittee')->user()->verificationCode()->exists()) {
            auth()->guard('comittee')->user()->verificationCode()->delete();
        }

        $verificationCode = VerificationCode::create(['comittee_id' => auth()->guard('comittee')->user()->id, 'otp' => Str::random(5)]);
        DB::beginTransaction();
        try {

            $response = Http::post((config('app.root_url') ?: request()->root()).'/api/f/delete', [
                'path' => $participant_ticket->payment_proof,
                'otp' => $verificationCode->otp,
            ]);

            if (!$response) {
                return redirect()->back()->with('error', 'Token Expired');
            }

            $participant_ticket->addons()->detach();
            $participant_ticket->delete();

            DB::commit();
            addToLog('Verifikasi bukti pembayaran tiket');
            return redirect()->back()->with('success', 'Payment successfully declined!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed declined proof'. $th->getMessage());
        }

    }

    public function acceptProof(Agenda $agenda, Ticket $ticket, ParticipantTicket $participant_ticket)
    {
        $participant_ticket->update(['is_paid' => 1]);

        foreach ($participant_ticket->participants as $participant) {
            $data = ['participant' => $participant, 'qr_link' => route('ticket.checkIn', encrypt([$participant_ticket->id, $participant->nama]))];
            dispatch(new SendMailJob($data));
        }

        addToLog('Verifikasi bukti pembayaran tiket');
        return redirect()->back()->with('success','Payment successfully accepted!');
    }

    public function comitteCheckIn(Agenda $agenda, Ticket $ticket, ParticipantTicket $participant_ticket, Participant $participant)
    {
        if (!$participant_ticket->is_checkin) {
            $participant_ticket->update(['is_checkin' => 1, 'check_in_datetime' => now()]);
        }

        $participant->update(['is_checkin' => 1]);
        return redirect()->back()->with('success','Participant successfully validated!');
    }

    public function checkIn($data)
    {
        if (!auth()->guard('comittee')->check()) {
            return redirect(config('app.root_url'));
        }

        if (accessMenu('agenda')) {
            $data = decrypt($data);
            $participant_ticket = ParticipantTicket::find($data[0]);
            if ($participant_ticket) {
                $seccond_checkin = 1;
                if (!$participant_ticket->is_checkin) {
                    $participant_ticket->update(['is_checkin' => 1, 'check_in_datetime' => now()]);
                    $seccond_checkin = 0;
                }
                $participant_ticket->participants()->where('nama', 'LIKE', "%{$data[1]}%")->update(['is_checkin' => 1]);

                return view('agenda.ticket.checkin', ['nama' => $data[1], 'participant_ticket' => $participant_ticket, 'seccond_checkin' => $seccond_checkin]);
            }
            return "Tiket Tidak Ditemukan";
        }

        return redirect()->route('dashboard');
    }

    public function sampleCheckIn()
    {
        if (!auth()->guard('comittee')->check()) {
            return redirect(config('app.root_url'));
        }

        if (accessMenu('agenda')) {
            return view('agenda.ticket.samplecheckin');
        }

        return redirect()->route('dashboard');
    }

}
