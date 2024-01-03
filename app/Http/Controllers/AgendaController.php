<?php

namespace App\Http\Controllers;

use App\Exports\AgendaTicketsParticipantExport;
use App\Models\Agenda;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AgendaController extends Controller
{
    public function index()
    {
        return view('agenda.index',[
            'title' => 'Agenda'
        ]);
    }

    public function getData()
    {
        if (request()->ajax()) {
            $agendas = Agenda::latest()->get();

            return response()->json($agendas);
        }

        return abort(404);
    }

    private function saveFile($file, $path, $old_file = null)
    {
        if ($old_file) {
            if (File::exists(public_path($path). $old_file )) {
                FIle::delete(public_path($path). $old_file );
            }
        }

        $filename = STR::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)). '.' .$file->getClientOriginalExtension();

		$file->move($path,$filename);

        return $filename;
    }

    public function store(Request $request)
    {
        if (request()->ajax()) {
            Agenda::create([
                'theme' => $request->theme,
                'image' => $this->saveFile($request->image, 'file/agenda/'),
                'short_description' => $request->short_description,
                'link_wa' => $request->link_wa,
                'open_registration' => $request->open_registration,
                'close_registration' => $request->close_registration,
                'is_active' => 0
            ]);
            addToLog('Menambah Agenda');
            return response()->json(['message' => 'Agenda successfully saved!'], 200);
        }
        abort(404);
    }

    public function activateAgenda(Agenda $agenda)
    {
        if (request()->ajax()) {
            Agenda::where('is_active', 1)->update(['is_active' => 0]);
            $agenda->update(['is_active' => $agenda->is_active ? 0 : 1]);
            addToLog('Aktivasi Agenda');

            return response()->json(['message' => 'Agenda successfully updated!'], 200);
        }
        abort(404);
    }

    public function show(Agenda $agenda)
    {
        if (request()->ajax()) {
            return response()->json($agenda, 200);
        }
        abort(404);
    }

    public function update(Request $request, Agenda $agenda)
    {
        if (request()->ajax()) {
            $agenda->update([
                'theme' => $request->theme,
                'image' => $request->hasFile('image') ? $this->saveFile($request->image, 'file/agenda/', $agenda->image) : $agenda->image,
                'short_description' => $request->short_description,
                'link_wa' => $request->link_wa,
                'open_registration' => $request->open_registration,
                'close_registration' => $request->close_registration,
            ]);
            addToLog('Update Agenda');
            return response()->json(['message' => 'Agenda successfully update!'], 200);
        }
        abort(404);
    }

    public function export(Request $request, Agenda $agenda)
    {
        if (!$request->has('is_export_ticket') && !$request->has('export_data')) {
            return back()->withError('Failed to export participant data');
        }

        addToLog('Export Peserta Agenda');
        return Excel::download(new AgendaTicketsParticipantExport($agenda, $request), 'daftarPeserta.xlsx');
    }
}
