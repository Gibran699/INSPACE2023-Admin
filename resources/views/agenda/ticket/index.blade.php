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
                        <li class="breadcrumb-item">Daftar Seluruh Tiket
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#modalTicket" onclick="addTicket()"><i class="fa fa-plus mr-2"></i> Add Tiket</button>
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
                                <th>Nama Tiket</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Tiket Terjual</th>
                                <th>Batas User</th>
                                <th>Benefit</th>
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

<div class="modal fade" id="modalTicket">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title">Add Ticket</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="name" class="label">Nama Tiket</label>
                                <div>
                                    <input type="text"
                                        class="form-control"
                                        id="name" name="name" placeholder="Nama Tiket">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="price" class="label">Harga Tiket</label>
                                <div>
                                    <input type="number" min="0"
                                        class="form-control"
                                        id="price" name="price" placeholder="Harga">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="stock" class="label">Stok</label>
                                <div>
                                    <input type="number" min="0"
                                        class="form-control"
                                        id="stock" name="stock" placeholder="Stok">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="user-limit" class="label">Batas Partisipan</label>
                                <div>
                                    <input type="number" min="0"
                                        class="form-control"
                                        id="user-limit" name="user_limit" placeholder="Batas">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-4 benefits">
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="theme">Benefit</label>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-primary btn-sm float-right" id="btn-add-theme"
                                    type="button" data-repeater-create><i class="fas fa-plus mr-2"></i> Add Theme</button>
                            </div>
                        </div>
                        <div data-repeater-list="benefit">
                            <div data-repeater-item id="wrap-benefit">
                                <div class="row mb-4">
                                    <div class="col-md-10">
                                        <input type="text"
                                        class="form-control benefit"
                                        name="desc" placeholder="Masukan Benefit">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button class="btn btn-danger btn-block" data-repeater-delete type="button"><i
                                            class="fas fa-trash"></i></button>
                                    </div>
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
<script src="{{ asset('src/assets/extra-libs/jrepeater/jquery.repeater.min.js') }}"></script>
<script>
    var table = $('#table').DataTable({
        responsive: true,
        ajax: {
            'url': '/agenda/{{ $agenda->id }}/ticket/get-data',
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
            { data: 'stock' },
            { data: 'tickets_sold' },
            { data: 'user_limit' },
            { data: 'benefits', render: function(data) {
                var benefit = ''
                $.each(JSON.parse(data), function (index, value) {
                    benefit += `<span class="badge badge-info">${value.desc}</span> `
                });
                return benefit
            }},
            {
                data: null, render: function (data, type, row, meta) { return `<button class="btn btn-warning text-white" data-toggle="modal" data-target="#modalTicket" onclick="editTicket(${row.id})"><i class="fa fa-edit"></i> Edit</button> <a href="ticket/${row.id}/participant" class="btn btn-primary"><i class="fa fa-users"></i> Participant</a>`; }
            }
        ],
        dom:
        '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    });

    var $repeater = $('.benefits').repeater({
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        },
    });

    var url = "";
    var form = $("#form");
    function addTicket() {
        $("#title").text("Add Ticket")
        $(".btn-submit").text("Add")
        url = "/agenda/{{$agenda->id}}/ticket/store"

        // Reset form and validation
        $(".form-control").removeClass("error")
        form.validate().resetForm()
        form.trigger("reset")

        // Reset form repeater
        $('[data-repeater-item]').slice(1).remove();
    }

    function editTicket(id) {
        $("#title").text("Edit Agenda")
        $(".btn-submit").text("Update")
        $(".form-control").removeClass("error")
        form.validate().resetForm()
        form.trigger("reset")
        url = `/agenda/{{$agenda->id}}/ticket/${id}/update`
        $.ajax({
            url: `/agenda/{{$agenda->id}}/ticket/${id}`,
            type: "get",
            success: function(res) {
                $("#name").val(res.name)
                $("#price").val(res.price)
                $("#stock").val(res.stock)
                $("#user-limit").val(res.user_limit)
                $repeater.setList(JSON.parse(res.benefits))
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
                },
                user_limit: {
                    required: true
                }
            },
            errorPlacement: function (error, element) {
                var elem = element.closest('div');
                error.insertBefore(element);
            },
            submitHandler: function(e) {
                $.ajax({
                    url: url,
                    type: "post",
                    data: new FormData(e),
                    processData: false,
                    contentType: false,
                    success: function(e) {
                        $("#modalTicket").modal("hide")
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
        $.validator.addClassRules("benefit", {
            required: true
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

