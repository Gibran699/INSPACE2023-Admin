<?php

namespace App\Http\Controllers;

use App\Models\Comittee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ComitteeImport;
use App\Models\Division;
use Illuminate\Support\Facades\DB;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class ComitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Comittees";
        $data_comittees = Comittee::all();
        return view('comittees.index', [
            'title' => $title,
            'comittees' => $data_comittees,
        ]);
    }

    public function getData()
    {
        if (request()->ajax()) {
            $data_comittees = Comittee::with('division')->get();

            return response()->json($data_comittees);
        }
        abort(404);
    }

    public function show(Comittee $comittee)
    {
        return response()->json($comittee->load('division'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comittee  $comittee
     * @return \Illuminate\Http\Response
     */
    public function reset_password(Comittee $comittee)
    {
        if (request()->ajax()) {
            $comittee->update(['password' => bcrypt('password')]);
            addToLog('Reset password');

            return response()->json(['message' => 'Comittee password has been reset!'], 200);
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comittee  $comittee
     * @return \Illuminate\Http\Response
     */
    public function update(Comittee $comittee)
    {
        if (request()->ajax()) {
            $comittee->update(['is_active' => $comittee->is_active ? 0 : 1]);
            addToLog('Aktivasi panitia');

            return response()->json(['message' => 'Comittee has been updated!'], 200);
        }
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comittee  $comittee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comittee $comittee)
    {
        //
    }

    public function importForm()
    {
        $title = "Import Comittee";
        return view('import-form', [
            'title' => $title,
        ]);
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new ComitteeImport, $request->file('file')->store('temp'));
            DB::commit();
            addToLog('Import data panitia');
            return redirect()->route('comittees.index')->with('success', 'Comittee has been updated!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->route('comittee.import')->with(['error' => 'Comitte not successfully saved.' . $th->getMessage()]);
        }
    }

    public function settings()
    {
        $title = 'Profile';
        $comittee = Comittee::findOrFail(auth()->guard('comittee')->user()->id);
        $divisions = Division::all();

        return view('comittees.settings', compact('title', 'comittee', 'divisions'));
    }

    public function update_settings(Request $request)
    {
        $comittee = Comittee::findOrFail(auth()->guard('comittee')->user()->id);
        DB::beginTransaction();
        try {
            $comittee->division_id = $request->division;
            $comittee->position = $request->position;
            $comittee->telephone = $request->telephone;

            $comittee->update();

            DB::commit();
            addToLog('Update profil');
            return redirect()->back()->with('success', 'Profile telah berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Profile gagal diperbarui. ' . $th->getMessage());
        }
    }

    public function settings_password()
    {
        $title = 'Ganti Password';

        return view('comittees.setting_password', [
            'title' => $title,
        ]);
    }

    public function update_settings_password(Request $request)
    {
        $this->validate($request, [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ], [
            'new_confirm_password.same' => 'Password Baru dan Konfirmasi Password Baru harus sama.'
        ]);

        try {
            $user = Comittee::find(auth()->guard('comittee')->user()->id);
            $user->password = Hash::make($request->new_password);
            $user->update();
            addToLog('Update password');
            return redirect()->back()->with('success', 'Password telah berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Password gagal diperbarui. ' . $th->getMessage());
        }
    }
}
