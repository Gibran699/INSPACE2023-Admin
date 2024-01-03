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
                        <li class="breadcrumb-item">Daftar Addon
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#modalAddon" onclick="addAddon()"><i class="fa fa-plus mr-2"></i> Add Addon</button>
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
                                <th>Image</th>
                                <th>Stock</th>
                                <th>Addon Terjual</th>
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
            <form id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
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
                                <label for="stock" class="label">Stock</label>
                                <div>
                                    <input type="number" min="0"
                                        class="form-control"
                                        id="stock" name="stock" placeholder="Stock">
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
            'url': '/addon-variant/{{ $variant->id }}/addon/get-data',
            'type': 'GET',
            'dataSrc': ''
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0)', nRow).html(iDisplayIndexFull +1);
        },
        columns: [
            { data: null },
            { data: null,
                render: function(data, type, row, meta) {
                    if (row.image) {
                    const imageUrl = "{{ asset('file/addon') }}/" + row.image;
                    return `<a href="${imageUrl}" target="_blank"> <img src="${imageUrl}" height="50" width="50"> </a>`;
                    } else {
                    return '';
                    }
            }},
            { data: 'stock' },
            { data: 'addon_sold' },
            {
                data: null, render: function (data, type, row, meta) { return `<button class="btn btn-warning text-white" data-toggle="modal" data-target="#modalAddon" onclick="editAddon(${row.id})"><i class="fa fa-edit"></i> Edit</button>`; }
            }
        ],
        dom:
        '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    });

    var url = "";
    var form = $("#form");
    function addAddon() {
        $("#title").text("Add Addon")
        $(".btn-submit").text("Add")
        $('#image').removeClass('ignore')
        url = "/addon-variant/{{ $variant->id }}/addon/store"
        $(".form-control").removeClass("error")
        form.validate().resetForm()
        form.trigger("reset")
    }

    function editAddon(id) {
        $("#title").text("Edit Addon")
        $(".btn-submit").text("Update")
        $('#image').addClass('ignore')
        $(".form-control").removeClass("error")
        form.validate().resetForm()
        form.trigger("reset")
        url = `/addon-variant/{{ $variant->id }}/addon/${id}/update`
        $.ajax({
            url: `/addon-variant/{{ $variant->id }}/addon/${id}`,
            type: "get",
            success: function(res) {
                $("#stock").val(res.stock)
            }
        })
    }

    if (form.length) {
        var e = form.validate({
            ignore: '.ignore',
            rules: {
                image: {
                    required: true,
                    accept:"image/jpg,image/jpeg,image/png"
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
</script>
@endpush

