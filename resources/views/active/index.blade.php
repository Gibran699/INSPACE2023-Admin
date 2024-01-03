
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
                        <li class="breadcrumb-item">Daftar Seluruh Peserta Lomba
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
                <div class="card-body table-responsive">
                    <table id="table" class="table table-bordered table-hover" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">No.</th>
                                <th width="20%">Name</th>
                                @foreach ($program->stagesData->get('stage_list') as $stage)
                                <th>{{ $stage->label }}</th>
                                @endforeach
                                <th>Payment</th>
                                @if(auth()->guard('comittee')->user()->division->name == 'Web Development' or auth()->guard('comittee')->user()->division->name == 'Acara')
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teams as $team)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $program->is_group ? $team->team->name : $team->user->name }}</td>
                                    @foreach ($team->stagesDoc->d() as $key => $doc)
                                    <td>
                                        @if (!$team->stagesDoc->d()[$key]->status && date('Y-m-d H:i:s', strtotime($program->stagesData->get('stage_list')[$key]->end_selection)) < now())
                                            <span class="badge badge-danger">Eliminated</span>
                                        @elseif (!$team->stagesDoc->d()[$key]->status)
                                            <span class="badge badge-warning">{{$team->stagesDoc->d()[$key]->file !== null ? 'Uploaded &' : '' }} Checking...</span>
                                        @else
                                            <span class="badge badge-success">Passed</span>
                                        @endif
                                    </td>
                                    @endforeach
                                    <td>
                                        @if($team->is_paid == 1)
                                            <span class="badge badge-success">Paid</span>
                                        @elseif($team->is_paid == 0 and $team->payment_proof != null)
                                            <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#payment-{{ $program->is_group ? $team->team->id : $team->user->id }}"><i class="fas fa-eye mr-2"></i>Proof</button>
                                            <div class="modal fade" id="payment-{{ $program->is_group ? $team->team->id : $team->user->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Payment Proof</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <img src="{{ $ROOT_URL.'/store/' . $team->payment_proof }}" alt="payment" width="100%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <form action="{{ route('active.program.accept_payment',[
                                                                            'program' => $program->slug,
                                                                            'uKey' => $program->is_group ? $team->team->code : $team->user->id
                                                                        ]) }}" method="post">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-success"><i class="fas fa-check mr-2"></i> Accept Payment</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($team->is_paid == 0 and $team->payment_proof == null)
                                            <span class="badge badge-warning">Unpaid</span>
                                        @else
                                            <span class="badge badge-default">Undefined</span>
                                        @endif
                                    </td>
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
    var table = $('#table').DataTable({
        stateSave: true
    });
</script>
@endsection
