<?php

namespace App\Http\Controllers\Playground;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\ProgramTeam;
use App\Models\Team;
use App\Models\User;
use App\Models\TeamUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    public function index(){
        $title = 'Registration';
        $users = User::all();
        $programs = Program::all();

        return view('playground.registration.index',[
            'title' => $title,
            'users' => $users,
            'programs' => $programs,
        ]);
    }

    public function user_index(){
        $title = 'Registration';
        $users = User::all();
        $programs = Program::all();

        return view('playground.registration.user_index',[
            'title' => $title,
            'users' => $users,
            'programs' => $programs,
        ]);
    }

    public function store(Request $request){
        // dd($request->all());
        $program = Program::find($request->program);
        // dd($program->program_themes->first()->id);
        DB::beginTransaction();

        try {
            $team = Team::create([
                'name' => $request->team_name,
                'leader_id' => $request->leader,
                'institution' => 'Institut Teknologi Kalimantan',
                'major' => 'Sistem Informasi',
                'code' => strtoupper($request->team_name),
            ]);

            foreach ($request->team_member as $member) {
                $members = TeamUser::create([
                    'user_id' => $member,
                    'team_id' => $team->id,
                ]);
            }

            $program_team = ProgramTeam::create([
                'team_id' => $team->id,
                'program_id' => $program->id,
                'program_theme_id' => $program->program_themes->first()->id,
            ]);

            DB::commit();

            return redirect()->route('registration.upload',[
                'program' => $program->slug,
                'team' => $team->code
            ])->with('success','Berhasil!');

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error','Hau...' . $th->getMessage());
        }
    }

    public function user_store(Request $request){
        // dd($request->all());
        $program = Program::find($request->program);
        // dd($program->program_themes->first()->id);
        DB::beginTransaction();

        try {
            $program_team = ProgramTeam::create([
                'user_id' => $request->user_id,
                'program_id' => $program->id,
                'program_theme_id' => $program->program_themes->first()->id,
            ]);

            DB::commit();

            return redirect()->route('registration.upload.user',[
                'program' => $program->slug,
                'user' => $request->user_id
            ])->with('success','Berhasil!');

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error','Hau...' . $th->getMessage());
        }
    }

    public function upload($program_slug, $team_code){
        $title = 'Upload File';
        $program = Program::where('slug', $program_slug)->first();
        $team = Team::where('code', $team_code)->first();

        return view('playground.registration.upload',[
            'title' => $title,
            'program' => $program,
            'team' => $team,
        ]);
    }

    public function user_upload($program_slug, $user_id){
        $title = 'Upload File';
        $program = Program::where('slug', $program_slug)->first();
        $user = User::find($user_id);

        return view('playground.registration.user_upload',[
            'title' => $title,
            'program' => $program,
            'user' => $user,
        ]);
    }

    public function store_upload(Request $request, $program_slug, $team_code){
        $program = Program::where('slug', $program_slug)->first();
        $team = Team::where('code', $team_code)->first();

        if($request->hasFile('twibbon')){
            $path = $program_slug . "/" . $team->code . "/";
            $file_name = time() . '_' . $request->file('twibbon')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->twibbon));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('team_id', $team->id)->update([
                'twibbon' => $route_file
            ]);
        
        }

        if($request->hasFile('payment_proof')){
            $path = $program_slug . "/" . $team->code . "/";
            $file_name = time() . '_' . $request->file('payment_proof')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->payment_proof));
            
            \DB::table('program_team')->where('program_id', $program->id)->where('team_id', $team->id)->update([
                'payment_proof' => $route_file
            ]);
        }

        if($request->hasFile('file_stage_1')){
            $path = $program_slug . "/" . $team->code . "/";
            $file_name = time() . '_' . $request->file('file_stage_1')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->file_stage_1));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('team_id', $team->id)->update([
                'file_stage_1' => $route_file
            ]);
        }

        if($request->hasFile('file_stage_2')){
            $path = $program_slug . "/" . $team->code . "/";
            $file_name = time() . '_' . $request->file('file_stage_2')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->file_stage_2));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('team_id', $team->id)->update([
                'file_stage_2' => $route_file
            ]);
        }

        if($request->hasFile('proposal')){
            $path = $program_slug . "/" . $team->code . "/";
            $file_name = time() . '_' . $request->file('proposal')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->proposal));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('team_id', $team->id)->update([
                'proposal' => $route_file
            ]);
        }

        if($request->hasFile('report')){
            $path = $program_slug . "/" . $team->code . "/";
            $file_name = time() . '_' . $request->file('report')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->report));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('team_id', $team->id)->update([
                'report' => $route_file
            ]);
        }

        if($request->hasFile('originality')){
            $path = $program_slug . "/" . $team->code . "/";
            $file_name = time() . '_' . $request->file('originality')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->originality));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('team_id', $team->id)->update([
                'originality' => $route_file
            ]);
        }

        if($request->hasFile('report')){
            $path = $program_slug . "/" . $team->code . "/";
            $file_name = time() . '_' . $request->file('report')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->report));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('team_id', $team->id)->update([
                'report' => $route_file
            ]);
        }

        if($request->hasFile('presentation')){
            $path = $program_slug . "/" . $team->code . "/";
            $file_name = time() . '_' . $request->file('presentation')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->presentation));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('team_id', $team->id)->update([
                'presentation' => $route_file
            ]);
        }

        if($request->result_link != null){
            $program_team = ProgramTeam::where([
                'program_id' => $program->id,
                'team_id' => $team->id,
            ])->first()->update([
                'result_link' => $request->result_link
            ]);
        }

        // dd($program_team);

        return redirect()->back();
    }

    public function user_store_upload(Request $request, $program_slug, $user_id){
        $program = Program::where('slug', $program_slug)->first();
        $user = User::find($user_id);

        if($request->hasFile('twibbon')){
            $path = $program_slug . "/" . $user->id . ' - ' . $user->name . "/";
            $file_name = time() . '_' . $request->file('twibbon')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->twibbon));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('user_id', $user->id)->update([
                'twibbon' => $route_file
            ]);
        
        }

        if($request->hasFile('payment_proof')){
            $path = $program_slug . "/" . $user->id . ' - ' . $user->name . "/";
            $file_name = time() . '_' . $request->file('payment_proof')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->payment_proof));
            
            \DB::table('program_team')->where('program_id', $program->id)->where('user_id', $user->id)->update([
                'payment_proof' => $route_file
            ]);
        }

        if($request->hasFile('file_stage_1')){
            $path = $program_slug . "/" . $user->id . ' - ' . $user->name . "/";
            $file_name = time() . '_' . $request->file('file_stage_1')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->file_stage_1));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('user_id', $user->id)->update([
                'file_stage_1' => $route_file
            ]);
        }

        if($request->hasFile('file_stage_2')){
            $path = $program_slug . "/" . $user->id . ' - ' . $user->name . "/";
            $file_name = time() . '_' . $request->file('file_stage_2')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->file_stage_2));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('user_id', $user->id)->update([
                'file_stage_2' => $route_file
            ]);
        }

        if($request->hasFile('proposal')){
            $path = $program_slug . "/" . $user->id . ' - ' . $user->name . "/";
            $file_name = time() . '_' . $request->file('proposal')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->proposal));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('user_id', $user->id)->update([
                'proposal' => $route_file
            ]);
        }

        if($request->hasFile('report')){
            $path = $program_slug . "/" . $user->id . ' - ' . $user->name . "/";
            $file_name = time() . '_' . $request->file('report')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->report));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('user_id', $user->id)->update([
                'report' => $route_file
            ]);
        }

        if($request->hasFile('originality')){
            $path = $program_slug . "/" . $user->id . ' - ' . $user->name . "/";
            $file_name = time() . '_' . $request->file('originality')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->originality));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('user_id', $user->id)->update([
                'originality' => $route_file
            ]);
        }

        if($request->hasFile('report')){
            $path = $program_slug . "/" . $user->id . ' - ' . $user->name . "/";
            $file_name = time() . '_' . $request->file('report')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->report));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('user_id', $user->id)->update([
                'report' => $route_file
            ]);
        }

        if($request->hasFile('presentation')){
            $path = $program_slug . "/" . $user->id . ' - ' . $user->name . "/";
            $file_name = time() . '_' . $request->file('presentation')->getClientOriginalName();
            $route_file = $path . $file_name;
            Storage::disk('public')->put($route_file, File::get($request->presentation));

            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('user_id', $user->id)->update([
                'presentation' => $route_file
            ]);
        }

        if($request->result_link != null){
            $program_team = \DB::table('program_team')->where('program_id', $program->id)->where('user_id', $user->id)->update([
                'result_link' => $request->result_link
            ]);
        }

        // dd($program_team);

        return redirect()->back();
    }

}
