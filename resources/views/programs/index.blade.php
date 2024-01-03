
@extends('layouts.comittee')

@push('css')
<link href="{{ asset('src/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('src/assets/extra-libs/datatables.net-bs4/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('src/assets/extra-libs/sweetalert/sweetalert2.min.css') }}">
@endpush

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item">Daftar Seluruh Program/Acara
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
        @if(auth()->guard('comittee')->user()->division->name == 'Web Development' or auth()->guard('comittee')->user()->division->name == 'Acara')
            <a href="{{ route('programs.create') }}" class="btn btn-secondary float-right"><i class="fa fa-plus mr-2"></i> Add Program</a>
        @endif
        <a href="{{ route('programs.exportActiveProgram') }}" class="btn btn-success float-right mr-2"><i class="fa-sharp fa-solid fa-file-excel"></i> Export</a>
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
                            <th>Name</th>
                            <th width="25%">Sub Tema</th>
                            <th>Contact Person</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
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
<script src="{{ asset('src/assets/extra-libs/sweetalert/sweetalert2.all.min.js') }}"></script>
<script>
    var table = $('#table').DataTable({
        responsive: true,
        ajax: {
            'url': '/programs/get-data',
            'type': 'GET',
            'dataSrc': ''
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0)', nRow).html(iDisplayIndexFull +1);
        },
        columns: [
            { data: null},
            { data: 'name'},
            { data: 'sub_tema', render: function(data) {
                var sub_tema = ''
                $.each(JSON.parse(data), function (index, value) {
                    sub_tema += `<span class="badge badge-info">${value.name}</span> `
                });
                return sub_tema
            }},
            { data: 'comittee.name' },
            { data: null, render: function (data, type, row, meta) { return `<a href="/programs/edit/${row.id}" class="btn btn-warning text-white"><i class="fa fa-edit"></i> Edit</a> <button type="button" class="btn btn-icon btn-${row.is_active == 1 ? 'success' : 'danger'}" onclick="toggleActivePrograms(${row.id})"><i class="fa fa-toggle-${row.is_active == 1 ? 'on' : 'off'}"></i></button> <a href="/programs/timeline/${row.id}" class="btn btn-info"><i class="fa fa-timeline"></i></a>`}}
        ],
        dom:
        '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    });

    function toggleActivePrograms(id) {
      Swal.fire({
        title: 'Change Status',
        text: "Are you sure? you won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Change it!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: `/programs/toggle-activate/${id}`,
                type: 'post',
                success: function(res) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: res.message,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                    });
                    table.ajax.reload()
                },
            });
        }
      });
    }
</script>
@endpush
