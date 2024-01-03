
@extends('layouts.comittee')

@push('css')
<link href="{{ asset('src/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('src/assets/extra-libs/datatables.net-bs4/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item">Daftar Seluruh Peserta Lomba - Stage {{ $stage }}
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
                    <form action="{{ route('active.program.selection.update', [
                                    'program' => $program->slug,
                                    'no_stage' => $stage
                                    ]) }}" method="post" id="form">
                        @csrf
                        <table id="table" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="2px">No</th>
                                    <th>Name</th>
                                    @if(auth()->guard('comittee')->user()->division->name == 'Web Development' or auth()->guard('comittee')->user()->division->name == 'Acara')
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teams as $team)
                                <tr class="text-center">
                                    <td width="2px">
                                        @if (!$team->stagesDoc->d()[$stage-1]->status && $team->lastFinishedStage >= $stage-1)
                                        <input type="checkbox" name="id[]" value="{{ $team->id }}">
                                        @endif
                                    </td>
                                    <td>{{ $program->is_group ? $team->team->name : $team->user->name }}</td>
                                    @if(auth()->guard('comittee')->user()->division->name == 'Web Development' or auth()->guard('comittee')->user()->division->name == 'Acara')
                                    <td>
                                        <a href="{{ route('active.program.details' ,[
                                            'program' => $program->slug,
                                            'uKey' => $program->is_group ? $team->team->code : $team->user->id
                                        ]) }}" class="btn btn-sm btn-primary mb-2"><i class="fas fa-eye mr-2"></i>Details</a><br>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($program->currentStage != $stage-1 || $program->is_after_stage)
                            <button class="btn btn-success mt-2" disabled><i class="fas fa-check mr-2"></i> Passed Selection</button>
                        @else
                            <button class="btn btn-success mt-2"><i class="fas fa-check mr-2"></i> Passed Selection</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('src/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('src/assets/extra-libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('src/assets/extra-libs/datatables.net/js/dataTables.responsive.min.js')}}"></script>
<script>
    $('#table').DataTable({
        responsive: true
    });
</script>
@endsection
