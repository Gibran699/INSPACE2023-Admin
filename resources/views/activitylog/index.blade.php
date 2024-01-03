
@extends('layouts.comittee')

@push('css')
<link href="{{ asset('src/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('src/assets/extra-libs/datatables.net-bs4/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('src/assets/extra-libs/jvalidation/css/form-validation.css') }}">
<link rel="stylesheet" href="{{ asset('src/assets/extra-libs/sweetalert/sweetalert2.min.css') }}">
@endpush

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
        </div>
        <div class="col-5 align-self-center">
            <a href="{{ route('activitylogs.export') }}" class="btn btn-success float-right mr-2"><i class="fa-sharp fa-solid fa-file-excel"></i> Export</a>
            <form action="{{ route('activitylogs.delete') }}" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger float-right mr-2"><i class="fa fa-trash"></i> Delete All</button>
            </form>
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
                            <th width="15px">No.</th>
                            <th>Subject</th>
                            <th>Url</th>
                            <th>Method</th>
                            <th>Comittee</th>
                            <th>Executed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activity_logs as $activity)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $activity->subject }}</td>
                            <td><span></span> {{ $activity->url }}</td>
                            <td>{{ $activity->method }}</td>
                            <td>{{ $activity->comittee->name }}</td>
                            <td>{{ $activity->created_at }}</td>
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('src/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('src/assets/extra-libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('src/assets/extra-libs/datatables.net/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('src/assets/extra-libs/jvalidation/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('src/assets/extra-libs/jvalidation/js/jquery.validate.additional.min.js') }}"></script>
<script src="{{ asset('src/assets/extra-libs/sweetalert/sweetalert2.all.min.js') }}"></script>
<script>
    var table = $('#table').DataTable({
        responsive: true,
    });
</script>
@endpush
