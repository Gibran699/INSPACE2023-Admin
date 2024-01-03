@extends('layouts.comittee')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Hello, {{ \Illuminate\Support\Str::words(auth()->guard('comittee')->user()->name, 2, '') }}!</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item">{{ $title }}</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    @include('layouts.message')
    <div class="row">

        <!-- LOMBA LOMBA -->
        @foreach ($program as $program )
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-75 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 15px;">
                                {{ $program->name }}
                                </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 20px;">
                                {{ $teams->where('program_id', '=', $program->id)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas far fa-check-circle fa-2x "></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @if ($agenda)
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex justify-content-center align-content-center"><span class="badge badge-success">Active Agenda</span></div>
                    <div class="d-flex justify-content-center align-content-center"><h4>{{ $agenda->theme }}</h4></div>
                    <div class="d-flex justify-content-center align-content-center"><h3>Total Participant: {{ $agenda->total_participant_agenda }}</h3></div>
                    <div class="d-flex justify-content-center align-content-center"><h3><span class="badge badge-success">Hadir</span>: {{ $agenda->getParticipantAttendance(1) }}</h3></div>
                    <div class="d-flex justify-content-center align-content-center"><h3><span class="badge badge-danger">Tidak Hadir</span>: {{ $agenda->getParticipantAttendance(0) }}</h3></div>
                </div>
            </div>
        </div>
        @forelse ($agenda->tickets as $ticket)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-75 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 15px;">
                                <a href="{{ route('agenda.ticket.participant', ['agenda' => $agenda->id, 'ticket' => $ticket->id]) }}">{{ $ticket->name }}</a>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 20px;">
                                {{ $ticket->tickets_sold }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas far fa-check-circle fa-2x "></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        @endforelse
        @endif
    </div>
</div>

@endsection
