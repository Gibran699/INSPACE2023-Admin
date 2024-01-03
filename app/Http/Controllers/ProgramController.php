<?php

namespace App\Http\Controllers;

use App\Exports\ActiveProgramExport;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Comittee;
use App\Models\ProgramTheme;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Program\StoreRequest;
use App\Http\Requests\Program\UpdateRequest;
use Exception;
use Illuminate\Support\Str;
use File;
use Maatwebsite\Excel\Facades\Excel;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Programs";
        $programs = Program::all();

        return view('programs.index', [
            'title' => $title,
            'programs' => $programs,
        ]);
    }

    public function getData() {
        if (request()->ajax()) {
            $programs = Program::with('comittee')->orderBy('is_active', 'DESC')->get();
            return response()->json($programs);
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add Program";
        $comittees = Comittee::whereHas('division', function($query) {
            $query->where('id', 2);
        })->get();

        return view('programs.create', [
            'title' => $title,
            'comittees' => $comittees,
        ]);
    }

    public function activateProgram($id){
        if (request()->ajax()) {
            $program = Program::find($id);
            $program->update(['is_active' => $program->is_active ? 0 : 1]);
            addToLog('Aktivasi Lomba');

            return response()->json(['message' => 'Program has been updated!'], 200);
        }
        abort(404);
    }

    private function formatStageInput($request)
    {
        $data = [
            'stage_list' => $request->stage,
            'first_place' => $request->first_place,
            'seccond_place' => $request->seccond_place,
            'third_place' => $request->third_place,
            'start_payment' => $request->start_payment,
            'end_payment' => $request->end_payment,
            'finalist_announcement' => $request->finalist_announcement,
            'technical_meeting' => $request->technical_meeting,
            'final' => $request->final,
            'winner' => []
        ];

        return json_encode($data);
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
        DB::beginTransaction();
        try {
            $program = Program::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'max_team' => $request->max_team,
                'price' => $request->price,
                'guidebook' => $this->saveFile($request->guidebook, 'file/program/guidebook/'),
                'logo' => $this->saveFile($request->logo, 'file/program/icon'),
                'sub_tema' => json_encode($request->themes),
                'category' => $request->category,
                'wa_link' => $request->wa_link,
                'comittee_id' => $request->comittee_id,
                'stage' => $this->formatStageInput($request),
                'is_group' => $request->group_settings,
                'participant_limit' => $request->participant_limit,
            ]);

            if ($request->has('embed_link')) {
                $program->embed_link = $request->embed_link;
                $program->save();
            }

            DB::commit();
            addToLog('Menambah data lomba');
            return redirect()->route('programs.index')->with(['success' => 'Program successfully saved.']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('programs.create')->with(['error' => 'Program not successfully saved.' . $th->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        $title = "Edit Program";
        $comittees = Comittee::whereHas('division', function($query) {
            $query->where('id', 2);
        })->get();

        return view('programs.edit', [
            'title' => $title,
            'comittees' => $comittees,
            'program' => $program,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $program = Program::findOrFail($id);
        DB::beginTransaction();
        try {
            $program->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'max_team' => $request->max_team,
                'price' => $request->price,
                'guidebook' => $request->hasFile('guidebook') ?  $this->saveFile($request->guidebook, 'file/program/guidebook/', $program->guidebook) : $program->guidebook,
                'logo' =>  $request->hasFile('logo') ? $this->saveFile($request->logo, 'file/program/icon', $program->guidebook) : $program->logo,
                'sub_tema' => json_encode($request->themes),
                'wa_link' => $request->wa_link,
                'category' => $request->category,
                'comittee_id' => $request->comittee_id,
                'stage' => $this->formatStageInput($request),
                'is_group' => $request->group_settings,
                'participant_limit' => $request->participant_limit,
            ]);

            if ($request->has('embed_link')) {
                $program->embed_link = $request->embed_link;
                $program->save();
            }

            DB::commit();
            addToLog('Mengubah data lomba');
            return redirect()->route('programs.index')->with(['success' => 'Program successfully updated.']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            $program = Program::findOrFail($id);
            return redirect()->route('programs.edit', $program->id)->with(['error' => 'Program not successfully updated.' . $th->getMessage()]);
        }
    }

    public function exportActiveProgram()
    {
        addToLog('Export data peserta lomba');
        return Excel::download(new ActiveProgramExport, 'daftarPeserta.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // timelines settings
    public function makeOrEditTimeline(Program $program)
    {
        return view('programs.timeline', [
            'title' => 'Timeline Setting',
            'program' => $program
        ]);
    }

    public function saveTimeline(Request $request,Program $program)
    {
        DB::beginTransaction();
        try {
            if (!$request->timeline) {
                throw new Exception('Timeline Canot be Null');
            }
            $program->update(['timeline' => json_encode($request->timeline)]);

            DB::commit();
            addToLog('Kustomisasi timeline lomba');
            return redirect()->route('programs.index')->with(['success' => 'Timeline Setting Successfull']);
        } catch (\Throwable $th) {
            return redirect()->route('programs.makeOrEditTimline', $program)->with(['error' => 'Timeline Setting Failed: '. $th->getMessage()]);
        }
    }
}
