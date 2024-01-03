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
                        <li class="breadcrumb-item">Daftar Seluruh Peserta
                        </li>
                    </ol>
                </nav>
            </div>
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
                            <th>Email</th>
                            <th>City</th>
                            <th>Institution</th>
                            <th width="25%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $participants)
                            <tr>
                                @if ($participants->is_active == 1)
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $participants->name }}</td>
                                <td class="text-center">{{ $participants->email }}</td>
                                <td class="text-center">{{ $participants->city ? $participants->city : '-' }}</td>
                                <td class="text-center">{{ $participants->institution ? Str::title($participants->institution) : '-' }}</td>
                                @else
                                <td class="text-danger text-center">{{ $loop->iteration }}</td>
                                <td class="text-danger">{{ $participants->name }}</td>
                                <td class="text-danger text-center">{{ $participants->email }}</td>
                                <td class="text-danger text-center">{{ $participants->city ? $participants->city : '-' }}</td>
                                <td class="text-danger text-center">{{ $participants->institution ? Str::title($participants->institution) : '-' }}</td>
                                @endif
                                <td class="text-center">
                                    <button class="btn btn-sm btn-default mr-2 btn-primary" data-toggle="modal" data-target="#modal-default-{{ $participants->id }}"><i class="fa fa-eye mr-2"></i> Detail</button>
                                    <button class="btn btn-sm btn-default mr-2 btn-warning text-white" data-toggle="modal" data-target="#modal-reset-{{ $participants->id }}"><i class="fa fa-key mr-2"></i> Reset</button>
                                    <button for="is_active" class="btn btn-sm btn-default mr-2 btn-danger"  data-toggle="modal" data-target="#modal-confirm-{{ $participants->id }}" ><i class="fa fa-toggle-on mr-2"></i> {{ $participants->is_active == 0 ?  'Activate' : 'Deactivate'}}</button>
                                </td>
                            </tr>

                            {{-- participants Show --}}
                            <div class="modal fade" id="modal-default-{{$participants->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ $participants->name }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img src="{{ $ROOT_URL.'/store/'.$participants->avatar }} " alt="{{ $participants->name }}" onerror="this.onerror=null;this.src='/src/assets/images/users/profile-pic.jpg'" width="100" class="mb-3">
                                            </div>
                                            <div class="col-md-9">
                                                <small class="m-0"> NISN / NIM / NIK</small>
                                                <p class="mb-2">{{ $participants->number_id ?  $participants->number_id : '-' }}</p>
                                                <small class="m-0">Name</small>
                                                <p class="mb-2">{{ $participants->name ? $participants->name : '-' }}</p>
                                                <small class="m-0">Email</small>
                                                <p class="mb-2"><i>{{ $participants->email ? $participants->email : '-' }}</i></p>
                                                <small class="m-0">No Hp</small>
                                                <p class="mb-2"><i>{{ $participants->telephone ? $participants->telephone : '-' }}</i></p>
                                                <small class="m-0">Asal Kota </small>
                                                <p class="mb-2"><i>{{ $participants->city ? Str::title($participants->city) : '-' }}</i></p>
                                                <small class="m-0">Asal Provinsi </small>
                                                <p class="mb-2"><i>{{ $participants->province ? $participants->province : '-' }}</i></p>
                                                <small class="m-0">Tempat Lahir </small>
                                                <p class="mb-2"><i>{{ $participants->birthplace ? $participants->birthplace : '-' }}</i></p>
                                                <small class="m-0">Tanggal Lahir</small>
                                                <p class="mb-2"><i>{{ $participants->date_of_birth ? $participants->date_of_birth : '-' }}</i></p>
                                                <small class="m-0">Institusi </small>
                                                <p class="mb-2"><i>{{ $participants->institution ?  $participants->institution : '-'}}</i></p>
                                                <small class="m-0">Kelas </small>
                                                <p class="mb-2"><i>{{ $participants->class_major ? $participants->class_major : '-' }}</i></p>
                                                <small class="m-0">Angkatan </small>
                                                <p class="mb-2"><i>{{ $participants->class_year ? $participants->class_year : '-' }}</i></p>
                                                <small class="m-0">Instagram </small>
                                                <p class="mb-2"><i>{{ $participants->instagram_username ? $participants->instagram_username : '-' }}</i></p>
                                                <small class="m-0">Created Date </small>
                                                <p class="mb-2"><i>{{ $participants->created_at ? \Carbon\Carbon::parse($participants->created_at)->format('D, d M Y H:i:s') : '-'}}</i></p>
                                                <small class="m-0">Updated Date </small>
                                                <p class="mb-2"><i>{{ $participants->updated_at ? \Carbon\Carbon::parse($participants->updated_at)->format('D, d M Y H:i:s') : '-' }}</i></p>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Confirmation --}}
                            <div class="modal fade" id="modal-confirm-{{$participants->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ $participants->name }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-9">
                                                <small class="m-0"></small>
                                                <p class="mb-2">Apakah anda yakin mengubah keaktifan akun {{ $participants->name }} ?</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('participants.update', $participants->id ) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input hidden type="text" name="is_active" class="form-control" value="{{ $participants->is_active }}">
                                            <input hidden type="text" name="id" class="form-control" value="{{ $participants->id }}">
                                            <div class="btn btn-toolbar justify-content-center">
                                                <button for="is_active" class="btn btn-lg btn-default mr-2 btn-success" type="submit" value="">Ya</button>
                                                <button type="button" class="btn btn-lg btn-default mr-2 btn-danger" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            {{-- resetPassword --}}
                            <div class="modal fade" id="modal-reset-{{$participants->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ $participants->name }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-9">
                                                <small class="m-0"></small>
                                                <p class="mb-2">Apakah anda yakin mengubah Password akun {{ $participants->name }} ?</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('participants.resetPassword', $participants->id ) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input hidden type="text" name="is_active" class="form-control" value="{{ $participants->is_active }}">
                                            <input hidden type="text" name="id" class="form-control" value="{{ $participants->id }}">
                                            <div class="btn btn-toolbar justify-content-center">
                                                <button for="is_active" class="btn btn-lg btn-default mr-2 btn-success" type="submit" value="">Ya</button>
                                                <button type="button" class="btn btn-lg btn-default mr-2 btn-danger" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
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
