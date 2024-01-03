<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ParticipantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Participants";
        $data_participants = User::all();
        return view('participants.index', [
            'title' => $title,
            'participants' => $data_participants,
        ]);
    }

    public function resetPassword(User $user)
    {
        // Generate new random string password
        $new_password = Str::random(10);

        // Update password
        $user->update(['password' => bcrypt($new_password)]);
        addToLog('Reset Password Peserta');
        return redirect()->route('participants.index')->with('success', 'User '.$user->name.' has been reset with new password: '.$new_password);
    }

    public function update(Request $request, User $user)
    {
        User::where('id', $request->id)->update(['is_active' => !$user->is_active]);
        addToLog('Menonaktifkan Peserta');
        return redirect()->route('participants.index')->with('update', 'user has been updated!');
    }
}
