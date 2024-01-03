
@extends('layouts.comittee')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item">Tambah Pemenang Lomba
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
        <div class="col-md-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('active.program.add_winner.save', $program->slug) }}" method="post">
                        @csrf
                        <div class="form-group mb-4">
                            @if($program->winner_team_1 == null or $program->winner_user_1 == null)
                                <label for="winner_1">Winner 1</label>
                                <select class="form-control mb-2" name="winner_1" id="winner_1">
                                    <option selected disabled>{{ $program->is_group ? 'Choose Team' : 'Choose Participant' }}</option>
                                    @foreach($program_teams as $program_team)
                                        @if ($program_team->stages_doc->d()[$program->current_stage]->status)
                                            @if ($program->is_group)
                                            <option value="{{ $program_team->team_id }}">{{ $program_team->team->code }} | {{ $program_team->team->name }}</option>
                                            @else
                                            <option value="{{ $program_team->user_id }}">{{ $program_team->user->name }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="form-group mb-4">
                            @if($program->winner_team_2 == null or $program->winner_user_2 == null)
                                <label for="winner_2">Winner 2</label>
                                <select class="form-control mb-2" name="winner_2" id="winner_2">
                                    <option selected disabled>{{ $program->is_group ? 'Choose Team' : 'Choose Participant' }}</option>
                                    @foreach($program_teams as $program_team)
                                        @if ($program_team->stages_doc->d()[$program->current_stage]->status)
                                            @if ($program->is_group)
                                            <option value="{{ $program_team->team_id }}">{{ $program_team->team->code }} | {{ $program_team->team->name }}</option>
                                            @else
                                            <option value="{{ $program_team->user_id }}">{{ $program_team->user->name }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="form-group mb-4">
                            @if($program->winner_team_3 == null or $program->winner_user_3 == null)
                                <label for="winner_3">Winner 3</label>
                                <select class="form-control mb-2" name="winner_3" id="winner_3">
                                    <option selected disabled>{{ $program->is_group ? 'Choose Team' : 'Choose Participant' }}</option>
                                    @foreach($program_teams as $program_team)
                                        @if ($program_team->stages_doc->d()[$program->current_stage]->status)
                                            @if ($program->is_group)
                                            <option value="{{ $program_team->team_id }}">{{ $program_team->team->code }} | {{ $program_team->team->name }}</option>
                                            @else
                                            <option value="{{ $program_team->user_id }}">{{ $program_team->user->name }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-success float-right"><i class="fas fa-save mr-2"></i>Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $('#table').DataTable();
</script>
@endsection
