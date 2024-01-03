
@extends('layouts.comittee')

@push('css')
<link href="{{ asset('src/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('src/assets/extra-libs/datatables.net-bs4/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('src/assets/extra-libs/datatables.net-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
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
                        <li class="breadcrumb-item">Daftar Seluruh Panitia
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <a href="{{ route('comittees.importForm') }}" class="btn btn-secondary float-right"><i class="fa fa-plus mr-2"></i> Import Comittee</a>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="detail-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <small class="m-0">NIM</small>
                    <p class="mb-2" id="nim-content"></p>
                    <small class="m-0">Name</small>
                    <p class="mb-2" id="name-content"></p>
                    <small class="m-0">Email</small>
                    <p class="mb-2"><i id="email-content"></i></p>
                    <small class="m-0">Division</small>
                    <p class="mb-2"><i id="division-content"></i></p>
                    <small class="m-0">Position</small>
                    <p class="mb-2"><i id="position-content"></i></p>
                    <small class="m-0">Telephone</small>
                    <p class="mb-2"><i id="telephone-content"></i></p>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    @include('layouts.message')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="table" class="table table-bordered table-hover" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th width="15px">No.</th>
                                <th>Name</th>
                                <th>Division</th>
                                <th>Position</th>
                                <th width="30%">Actions</th>
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
            'url': '/comittees/get-data',
            'type': 'GET',
            'dataSrc': ''
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0)', nRow).html(iDisplayIndexFull +1);
        },
        columns: [
            { data: null},
            { data: 'name'},
            { data: 'division.name' },
            { data: 'position'},
            { data: null, render: function (data, type, row, meta) { return `<button type="button" class="btn btn-icon btn-primary" onclick="showDetail(${row.id})"><i class="fa fa-eye"></i> Detail</button> <button type="button" class="btn btn-icon btn-${row.is_active == 1 ? 'success' : 'danger'}" onclick="toggleActiveComittee(${row.id})"><i class="fa fa-toggle-${row.is_active == 1 ? 'on' : 'off'}"></i> ${row.is_active == 1 ? 'Active' : 'Deactive'}</button> <button type="button" class="btn btn-icon btn-warning text-white" onclick="resetPassword(${row.id})"><i class="fa fa-key"></i> Reset Password</button>`}}
        ],
        dom:
        '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    });


    function showDetail(id) {
        $.ajax({
            url: `/comittees/show/${id}`,
            type: 'get',
            success: function(res) {
                $('#detail-title').html(res.name)
                $('#nim-content').html(res.nim)
                $('#name-content').html(res.name)
                $('#email-content').html(res.email)
                $('#division-content').html(res.division.name)
                $('#position-content').html(res.position)
                $('#telephone-content').html(res.telephone)

                $('#modal-detail').modal('show');
            },
        });
    }

    function resetPassword(id) {
        Swal.fire({
            title: 'Reset Password',
            text: "Are you sure? you won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Reset it!',
            customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ml-1'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: `/comittees/reset-password/${id}`,
                    type: 'post',
                    success: function(res) {
                        Swal.fire({
                        icon: 'success',
                        title: 'Reset!',
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

    function toggleActiveComittee(id) {
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
                url: `/comittees/update/${id}`,
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
