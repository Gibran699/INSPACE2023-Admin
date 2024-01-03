@extends('layouts.comittee')

@push('css')
<link rel="stylesheet" href="{{ asset('src/dist/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('src/dist/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                        <li class="breadcrumb-item">Daftar Seluruh Agenda
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#modalAgenda" onclick="addAgenda()"><i class="fa fa-plus mr-2"></i> Add Agenda</button>
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
                                <th width="30%">Tema</th>
                                <th>Open Registration</th>
                                <th>Close Registration</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<div class="modal fade" id="modalExport">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Export Agenda</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formExport" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="email" class="label">Export Data</label>
                                <div class="mb-3">
                                    <select name="export_data[]" id="export-data" class="form-control" multiple="multiple">
                                        <option value="1">Kuiah</option>
                                        <option value="2">SMA/SMK</option>
                                        <option value="3">Umum</option>
                                    </select>
                                </div>
                                <div class="form-check form-check-inline">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="is_export_ticket" value="1" id="checkTicket">
                                        <label class="custom-control-label" for="checkTicket">Export semua data per tiket</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-submit">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgenda">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title">Add Agenda</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="theme" class="label">Theme</label>
                                <div>
                                    <input type="text"
                                        class="form-control"
                                        id="theme" name="theme" placeholder="Theme">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="image" class="label">Image</label>
                                <div>
                                    <input type="file"
                                        class="form-control"
                                        id="image" name="image" placeholder="image" accept=".png,.jpg,.jpeg">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="link_wa" class="label">Link Whatsapp</label>
                                <div>
                                    <input type="text"
                                        class="form-control"
                                        id="link_wa" name="link_wa" placeholder="Link">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="short-description" class="label">Short Description</label>
                                <div>
                                    <textarea name="short_description" id="short-description" class="form-control" placeholder="Short Description" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="open_registration" class="label">Open Registration</label>
                                <div>
                                    <input type="datetime-local"
                                        class="form-control"
                                        id="open_registration" name="open_registration">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="close_registration" class="label">Close Registration</label>
                                <div>
                                    <input type="datetime-local"
                                        class="form-control"
                                        id="close_registration" name="close_registration">
                                </div>
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
<script src="{{ asset('src/dist/select2/js/select2.full.min.js') }}"></script>
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
            'url': '/agenda/get-data',
            'type': 'GET',
            'dataSrc': ''
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0)', nRow).html(iDisplayIndexFull +1);
        },
        columns: [
            { data: null },
            { data: 'theme' },
            { data: 'open_registration' },
            { data: 'close_registration' },
            {
                data: null, render: function (data, type, row, meta) { return `<button type="button" class="btn btn-icon btn-${row.is_active == 1 ? 'success' : 'danger'}" onclick="toggleActiveAgenda(${row.id})"><i class="fa fa-toggle-${row.is_active == 1 ? 'on' : 'off'}"></i></button>`; }
            },
            {
                data: null, render: function (data, type, row, meta) { return `<button class="btn btn-warning text-white" data-toggle="modal" data-target="#modalAgenda" onclick="editAgenda(${row.id})"><i class="fa fa-edit"></i> Edit</button> <a href="/agenda/${row.id}/ticket" class="btn btn-primary"><i class="fa-solid fa-ticket"></i> Tickets</a> <button class="btn btn-success btn-export" data-toggle="modal" data-target="#modalExport" onclick="setExport(${row.id})"><i class="fa-sharp fa-solid fa-file-excel"></i> Export</button>`; }
            }
        ],
        dom:
        '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    });

    $('#export-data').select2({
        width: '100%'
    });

    $('.btn-submit').on('click', function(){
        $('#modalExport').modal('hide')
    });

    function setExport(id) {
        $('#formExport').attr('action', `/agenda/${id}/export`)
    }

    var url = "";
    var form = $("#form");
    function addAgenda() {
        $("#title").text("Add Agenda")
        $(".btn-submit").text("Add")
        $('#image').removeClass('ignore')
        url = "/agenda/store"
        $(".form-control").removeClass("error")
        form.validate().resetForm()
        form.trigger("reset")
    }

    function editAgenda(id) {
        $("#title").text("Edit Agenda")
        $(".btn-submit").text("Update")
        $('#image').addClass('ignore')
        $(".form-control").removeClass("error")
        form.validate().resetForm()
        form.trigger("reset")
        url = `/agenda/${id}/update`
        $.ajax({
            url: `/agenda/${id}`,
            type: "get",
            success: function(res) {
                $("#theme").val(res.theme)
                $("#short-description").val(res.short_description)
                $("#open_registration").val(res.open_registration)
                $("#close_registration").val(res.close_registration)
                $("#link_wa").val(res.link_wa)
            }
        })
    }

    if (form.length) {
        var e = form.validate({
            ignore: '.ignore',
            rules: {
                theme: {
                    required: true
                },
                short_description: {
                    required: true
                },
                link_wa: {
                    required: true,
                    url: true
                },
                image: {
                    required: true,
                    accept:"image/jpg,image/jpeg,image/png"
                },
                open_registration: {
                    required: true
                },
                close_registration: {
                    required: true
                }
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
                        $("#modalAgenda").modal("hide")
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

    function toggleActiveAgenda(id) {
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
                url: `/agenda/toggle-active/${id}`,
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

