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
                        <li class="breadcrumb-item">Daftar Pemenang Lomba
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            @if( ($program->winner_team_1 == null or $program->winner_user_1 == null) and ($program->winner_team_2 == null or $program-> winner_user_2 == null) and ($program->winner_team_3 == null or $program->winner_user_3 == null) )
                <a href="{{ route('active.program.add_winner', $program->slug) }}" class="btn btn-success float-right"><i class="fas fa-plus mr-2"></i>Add Winner</a>
            @endif
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
                    <table id="table" class="table table-bordered table-hover" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th width="15px">No.</th>
                                <th>Name/Team Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">{{ $data->name }}</td>
                                <td class="text-center">
                                    <a href="{{ route('active.program.details' ,[
                                        'program' => $program->slug,
                                        'uKey' => $data->code ?? $data->id
                                    ]) }}" class="btn btn-sm btn-primary mb-2"><i class="fas fa-eye mr-2"></i>Details</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
