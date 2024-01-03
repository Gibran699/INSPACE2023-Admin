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
                        <li class="breadcrumb-item">Daftar Announcement/Pengumuman
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <a href="{{ route('announcements.create') }}" class="btn btn-secondary float-right"><i class="fa fa-plus mr-2"></i> Add Announcement</a>
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
                                <th>Title</th>
                                <th>Description</th>
                                <th>Short Description</th>
                                <th>Date Time</th>
                                <th>Program</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($announcement as $announcement)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $announcement->title }}</td>
                                    <td class="text-center">{{ $announcement->description }}</td>
                                    <td class="text-center">{{ $announcement->short_description }}</td>
                                    <td class="text-center">{{ $announcement->datetime ? \Carbon\Carbon::parse($announcement->datetime)->format('d M Y'):'-'}}</td>
                                    <td class="text-center">{{ $announcement->program_id }}</td>
                                    <td class="text-center">
                                        <div class="btn btn-toolbar justify-content-center">
                                            <a href="{{ route('announcements.edit', $announcement->id) }}" method=post class="btn btn-sm btn-primary mr-2"><i class="fa fa-edit"></i></a>
                                        </div>
                                        <form action="{{ route('announcements.destroy', $announcement->id) }}" method="post" onsubmit=" return confirm('Are you sure want to delete this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger "><i class="fa fa-trash"></i></button>
                                        </form>

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
    var table = $('#table').DataTable({
        responsive: true
    });
</script>
@endsection
