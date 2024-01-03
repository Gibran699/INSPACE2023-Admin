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
                        <li class="breadcrumb-item">Daftar Media Partner</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <a href="{{ route('medpart.create') }}" class="btn btn-secondary float-right"><i class="fa fa-plus mr-2"></i> Add Media Partner</a>
        </div>
    </div>
</div>
<div class="container-fluid">
    @include('layouts.message')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table id="table" class="table table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th width="15px">No.</th>
                                <th>Nama</th>
                                <th>Logo</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        {{-- <tbody> --}}
                            {{-- Use a loop to iterate over the data --}}
                            {{-- @foreach($data as $datas)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $datas->nama_medpart }}</td>
                                    <td class="text-center"><a href="{{$datas->gambar}}" target="_blank"> <img src="{{ $datas->gambar }}" height="50" width="50"> </a></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-icon btn-{{ $datas->is_active == 1 ? 'success' : 'danger' }}" onclick="toggleActiveMedpart(${row.id})">
                                            <i class="fa fa-toggle-{{ $datas->is_active ? 'on' : 'off' }}"></i>
                                            {{ $datas->is_active == 1 ? 'Active' : 'Deactive' }}
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn btn-toolbar justify-content-center">
                                            <a href="{{ route('medpart.edit', $datas->id) }}" class="btn btn-sm btn-primary mr-2"><i class="fa fa-edit"></i></a>
                                        </div>
                                        <form action="{{ route('medpart.destroy', $datas->id) }}" method="post" onsubmit="return confirm('Are you sure want to delete this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach --}}
                        {{-- </tbody> --}}
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
            'url': '/medpart/get-data',
            'type': 'GET',
            'dataSrc': ''
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(0)', nRow).html(iDisplayIndexFull +1);
        },
        columns: [
            { data: null },
            { data: 'nama_medpart' },
            {   data: null,
                render: function(data, type, row, meta) {
                    if (row.gambar) {
                    const imageUrl = "{{ asset('uploads') }}/" + row.gambar;
                    return `<a href="${imageUrl}" target="_blank"> <img src="${imageUrl}" height="50" width="50"> </a>`;
                    } else {
                    return '';
                    }
                }},
            {
                data: null, render: function (data, type, row, meta) { return `<button type="button" class="btn btn-icon btn-${row.is_active == 1 ? 'success' : 'danger'}" onclick="toggleActiveMedpart(${row.id})"><i class="fa fa-toggle-${row.is_active == 1 ? 'on' : 'off'}"></i> ${row.is_active == 1 ? 'Active' : 'Deactive'}</button> `; }
            },
            {
                data: null, render: function(data, type, row, meta) {
                    var editUrl = "{{ route('medpart.edit', ['medpart' => ':id']) }}";
                    editUrl = editUrl.replace(':id', row.id);

                    var deleteUrl = "{{ route('medpart.destroy', ['medpart' => ':id']) }}";
                    deleteUrl = deleteUrl.replace(':id', row.id);

                    return `
                        <div class="btn-group">
                            <a href="${editUrl}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <form action="${deleteUrl}" method="post" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    `;
                }

            }
        ],
        columnDefs: [
            {
                targets: [0, 2, 3, 4], // Apply alignment to all columns
                className: 'text-center', // Add the 'text-center' class to align the content to the center
            }
        ],
        dom:
        '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    });

    function toggleActiveMedpart(id) {
            Swal.fire({
                title: 'Change Status',
                text: "Are you sure? You won't be able to revert this!",
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
                        url: `/medpart/toggle-active/${id}`,
                        type: 'post',
                        success: function (res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: res.message,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            table.ajax.reload();
                        },
                    });
                }
            });
        }

</script>
@endpush
