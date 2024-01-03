
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
            <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#modalDivision" onclick="addDivision()"><i class="fa fa-plus mr-2"></i> Add Division</button>
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDivision">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title">Add Division</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="name" class="label">Division Name</label>
                                <div>
                                    <input type="text"
                                        class="form-control"
                                        id="name" name="name">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label class="label">Akses Menu</label>
                                @foreach (getRoutes() as $routes)
                                <div class="d-flex mb-2" style="gap: 8px">
                                    <input type="checkbox" name="accessmenu[]" id="{{ $routes }}" value="{{ $routes }}">
                                    <label for="{{ $routes }}" style="margin-bottom: 0px">
                                        {{ getRouteDescription($routes) }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-submit">Add</button>
                </div>
            </form>
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
        ajax: {
            'url': '/division/get-data',
            'type': 'GET',
            'dataSrc': ''
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0)', nRow).html(iDisplayIndexFull +1);
        },
        columns: [
            { data: null},
            { data: 'name'},
            { data: null, render: function (data, type, row, meta) { return `<button class="btn btn-warning text-white" data-toggle="modal" data-target="#modalDivision" onclick="editDivision(${row.id})"><i class="fa fa-edit"></i> Edit</button>`}}
        ],
        dom:
        '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    });


    var url = "";
    var form = $("#form");
    function addDivision() {
        $("#title").text("Add division")
        $(".btn-submit").text("Add")
        // $("#role").val($("#role option:eq(0)").val()).trigger("change")
        url = "/division/store", $(".form-control").removeClass("error")
        form.validate().resetForm()
        form.trigger("reset")
    }

    function editDivision(id) {
        $("#title").text("Edit User")
        $(".btn-submit").text("Update")
        $(".form-control").removeClass("error")
        form.validate().resetForm()
        form.trigger("reset")
        url = `/division/${id}/update`
        $.ajax({
            url: `/division/${id}`,
            type: "get",
            success: function(res) {
                $("#name").val(res.name)
                JSON.parse(res.accessmenu).forEach(function callback (val, key) {
                    $(`#${val}`).prop('checked', true)
                });
            }
        })
    }

    if (form.length) {
        var e = form.validate({
            rules: {
                name: {
                    required: true
                },
            },
            errorPlacement: function (error, element) {
                var elem = element.closest('div');
                error.insertBefore(elem);
            },
            submitHandler: function(e) {
                $.ajax({
                    url: url,
                    type: "post",
                    data: new FormData(e),
                    processData: false,
                    contentType: false,
                    success: function(e) {
                        $("#modalDivision").modal("hide")
                        table.ajax.reload()
                        Swal.fire({
                            title: "Success",
                            text: e.message,
                            icon: "success",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            },
                            buttonsStyling: false
                        })
                    }
                });
            }
        });
    }
</script>
@endpush
