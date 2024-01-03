<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Program;
use App\Models\User;
use App\Models\ProgramTeam;
use App\Models\TeamUser;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ActiveProgramController extends Controller
{
    public function index($program_slug){
        $program = Program::where('slug', $program_slug)->firstOrFail();
        $teams = $program->program_teams;
        $title = $program->name;

        return view('active.index',[
            'program' => $program,
            'teams' => $teams,
            'title' => $title,
        ]);
    }

    public function details($program_slug, $uKey){
        $title = 'Details';
        $program = Program::where('slug', $program_slug)->firstOrFail();

        if ($program->is_group) {
            $team = Team::where('code', $uKey)->firstOrFail();
            $program_team =  ProgramTeam::where('program_id', $program->id)->where('team_id', $team->id)->first();

            return view('active.team_details', [
                'title' => $title,
                'program' => $program,
                'team' => $team,
                'program_team' => $program_team,
            ]);
        } else {
            $user = User::findOrFail($uKey);
            $program_team = ProgramTeam::where('program_id', $program->id)->where('user_id', $user->id)->first();

            return view('active.user_details', [
                'title' => $title,
                'program' => $program,
                'user' => $user,
                'program_team' => $program_team,
            ]);
        }
    }

    public function winner($program_slug){
        $title = 'Winner';
        $program = Program::where('slug', $program_slug)->firstOrFail();

        if ($program->is_group) {
            $datas = Team::whereIn('id', $program->stagesData->winner)->get();
        } else {
            $datas = User::whereIn('id', $program->stagesData->winner)->get();
        }
        return view('active.winner', [
            'title' => $title,
            'program' => $program,
            'datas' => $datas
        ]);
    }

    public function add_winner($program_slug){
        $title = 'Add Winner';
        $program = Program::where('slug', $program_slug)->firstOrFail();

        if ($program->is_group) {
            $program_teams = $program->program_teams->where('user_id', null);
        } else {
            $program_teams= $program->program_teams->where('team_id', null);
        }

        return view('active.add_winner', [
            'title' => $title,
            'program' => $program,
            'program_teams' => $program_teams
        ]);
    }

    public function save_winner(Request $request, $program_slug){
        $program = Program::where('slug', $program_slug)->firstOrFail();
        DB::beginTransaction();
        try {
            $data = $program->stages_data;
            $data->winner = [$request->winner_1, $request->winner_2, $request->winner_3];

            $program->update(['stage' => json_encode($data)]);
            DB::commit();
            addToLog('Memilih pemenang');
            return redirect()->route('active.program.winner', [
                'program' => $program->slug,
            ])->with('success', 'Winner successfully saved');
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return redirect()->route('active.program.add_winner', [
                'program' => $program->slug,
            ])->with('error', 'Winner not successfully saved');
        }
    }

    public function selection($program_slug, $no_stage){
        $program = Program::where('slug', $program_slug)->firstOrFail();
        $title = $program->name;
        $teams = $program->program_teams;

        if (date('Y-m-d H:i:s', strtotime($program->stagesData->end_payment)) <= date('Y-m-d', strtotime($program->stagesData->get('stage_list')[$program->currentStage]->close_registration)) && date('Y-m-d', strtotime($program->stagesData->end_payment)) >= date('Y-m-d H:i:s', strtotime($program->stagesData->get('stage_list')[$program->currentStage]->open_registration))) {
            $teams = $program->program_teams->where('is_paid',1);
        }

        return view('active.selection',[
            'program' => $program,
            'teams' => $teams,
            'title' => $title,
            'stage' => $no_stage,
        ]);
    }

    public function update_selection(Request $request, $program_slug, $no_stage){
        if($request->id == null){
            return redirect()->back()->with('error', 'Nothing saved.');
        }

        DB::beginTransaction();
        try {
            $program = Program::where('slug', $program_slug)->firstOrFail();
            $program_team = ProgramTeam::where('program_id', $program->id)->whereIn('id', $request->id)->get();

            foreach ($program_team as $key => $value) {
                $stageData = $value->stages_doc->d();
                $stageData[$no_stage-1]->status = 1;
                $value->update(['stage_doc' => json_encode($stageData)]);
            }

            DB::commit();
            addToLog('Seleksi stage '. $no_stage);
            return redirect()->route('active.program.selection', [
                'program' => $program->slug,
                'no_stage' => $no_stage
            ])->with('success', 'Selection successfully saved');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('active.program.selection', [
                'program' => $program->slug,
                'no_stage' => $no_stage
            ])->with('error', 'Selection not successfully saved');
            //throw $th;
        }
    }

    public function accept_payment(Request $request, $program_slug, $uKey){
        $program = Program::where('slug', $program_slug)->first();

        DB::beginTransaction();

        try {
            if ($program->is_group) {
                $team = Team::where('code', $uKey)->firstOrFail();
                $programTeam = $program->program_teams->where('team_id', $team->id)->first();
            } else {
                $user = User::findOrFail($uKey);
                $programTeam = $program->program_teams->where('user_id', $user->id)->first();
            }

            $programTeam->update([
                'is_paid' => 1
            ]);

            DB::commit();
            addToLog('Validasi pembayaran');
            return redirect()->back()->with('success','Payment successfully updated');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error','Payment not successfully updated');
        }
    }

    public function generateManageOtp()
    {
        if (auth()->guard('comittee')->user()->verificationCode()->exists()) {
            auth()->guard('comittee')->user()->verificationCode()->delete();
        }
        $verificationCode = VerificationCode::create(['comittee_id' => auth()->guard('comittee')->user()->id, 'otp' => Str::random(5)]);

        return response()->json(['otp' => $verificationCode->otp]);
    }

    public function deleteProgramTeamFile($otp, $path)
    {
        $response = Http::post((config('app.root_url') ?: request()->root()).'/api/f/delete', [
            'path' => $path,
            'otp' => $otp,
        ]);

        return $response->json();
    }

    public function ManageProgramTeam(Request $request, $uKey, ProgramTeam $program_team)
    {
        DB::beginTransaction();
        try {
            $verificationCode = VerificationCode::where('otp', $request->otp)->first();
            if ($verificationCode && $verificationCode->created_at->diffInMinutes(now()) < 6) {
                // check if someone checking delete and change leader in same user
                if (($request->has('leader') && $request->has('delete')) && in_array($request->leader, $request->delete)) {
                    return response()->json(['message' => "The user who wants to be deleted cannot be appointed as the leader."], 400);
                }

                // Change leader
                if ($request->has('leader')) {
                    //get leader cancidate
                    $getLeaderCandidate = $program_team->team->team_users->find($request->leader);

                    //insert last leader to member
                    TeamUser::create(['team_id' => $program_team->team->id, 'user_id' => $program_team->team->leader_id]);

                    //change leader candidate to leader
                    $program_team->team->update(['leader_id' => $getLeaderCandidate->user_id]);
                    $getLeaderCandidate->delete();

                }

                // Delete Member
                if ($request->has('delete')) {
                    TeamUser::whereIn('id', $request->delete)->delete();
                }

                // Delete Paymen Proof
                if ($request->has('is_paid')) {
                    /** Delete File */
                    $this->deleteProgramTeamFile($verificationCode->otp, $program_team->payment_proof);

                    /** Change payment proof to null */
                    $program_team->payment_proof = null;
                }

                // Delete Stage File
                $stageData = $program_team->stagesDoc->d();
                if ($request->has('stage')) {
                    /** Delete stage File */
                    $this->deleteProgramTeamFile($verificationCode->otp, $stageData[array_key_first($request->stage)]->file);

                    /** Change selected stage file to null */
                    $stageData[array_key_first($request->stage)]->file = null;
                    $program_team->stage_doc = json_encode($stageData);
                }

                $program_team->save();
                DB::commit();
                addToLog('Manajemen lomba peserta');
                return response()->json(['message' => 'Successfully updated.']);
            }
            return response()->json(['message' => 'Invalid OTP'], 400);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => 'Failed Update.'], 400);
        }
    }
}
