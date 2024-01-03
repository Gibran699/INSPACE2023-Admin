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
                        <li class="breadcrumb-item">Daftar Seluruh Variant Addon
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#modalAddon" onclick="addAddonVariant()"><i class="fa fa-plus mr-2"></i> Add Addon Variant</button>
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
                                <th>Price</th>
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

<div class="modal fade" id="modalAddon">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title">Add Agenda</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="name" class="label">Name</label>
                                <div>
                                    <input type="text"
                                        class="form-control"
                                        id="name" name="name" placeholder="Name">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="price" class="label">Harga</label>
                                <div>
                                    <input type="number" min="0"
                                        class="form-control"
                                        id="price" name="price" placeholder="Harga">
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
            'url': '/addon-variant/get-data',
            'type': 'GET',
            'dataSrc': ''
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0)', nRow).html(iDisplayIndexFull +1);
        },
        columns: [
            { data: null },
            { data: 'name' },
            { data: 'price' },
            {
                data: null, render: function (data, type, row, meta) { return `<button type="button" class="btn btn-icon btn-${row.is_active == 1 ? 'success' : 'danger'}" onclick="toggleActiveAgenda(${row.id})"><i class="fa fa-toggle-${row.is_active == 1 ? 'on' : 'off'}"></i></button>`; }
            },
            {
                data: null, render: function (data, type, row, meta) { return `<button class="btn btn-warning text-white" data-toggle="modal" data-target="#modalAddon" onclick="editAddonVariant(${row.id})"><i class="fa fa-edit"></i> Edit</button> <a href="/addon-variant/${row.id}/addon" class="btn btn-primary"><i class="fa-solid fa-puzzle-piece"></i> Addons</a>`; }
            }
        ],
        dom:
        '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    });

    var url = "";
    var form = $("#form");
    function addAddonVariant() {
        $("#title").text("Add Addon Variant")
        $(".btn-submit").text("Add")
        url = "/addon-variant/store"
        $(".form-control").removeClass("error")
        form.validate().resetForm()
        form.trigger("reset")
    }

    function editAddonVariant(id) {
        $("#title").text("Edit Addon Variant")
        $(".btn-submit").text("Update")
        $(".form-control").removeClass("error")
        form.validate().resetForm()
        form.trigger("reset")
        url = `/addon-variant/${id}/update`
        $.ajax({
            url: `/addon-variant/${id}`,
            type: "get",
            success: function(res) {
                $("#name").val(res.name)
                $("#price").val(res.price)
                $("#stock").val(res.stock)
            }
        })
    }

    if (form.length) {
        var e = form.validate({
            rules: {
                name: {
                    required: true
                },
                price: {
                    required: true
                },
                stock: {
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
                        $("#modalAddon").modal("hide")
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
                url: `/addon-variant/toggle-active/${id}`,
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

