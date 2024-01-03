<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\ProgramTeam;
use App\Models\User;
use App\Models\Comittee;
use App\Models\Program;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $data_team = ProgramTeam::all();
        $data_comittees = Comittee::all();
        $data_user = User::all();
        $program = Program::all();
        $agenda = Agenda::where('is_active', 1)->first();
        return view('dashboard.index', [
            'title' => $title,
            'teams' => $data_team,
            'program' => $program,
            'comittees' => $data_comittees,
            'user' => $data_user,
            'agenda' => $agenda
        ]);
    }
}
