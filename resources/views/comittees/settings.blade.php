@extends('layouts.comittee')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-10 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
        </div>
        <div class="col-2 justify-content-end">
            <a href="{{ route('comittees.settings_password') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-key fa-sm text-white-50"></i> Ganti Password</a>
        </div>
    </div>
</div>


@include('layouts.message')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Data</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('comittees.update_settings') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim" value="{{ $comittee->nim }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" value="{{ $comittee->name }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" value="{{ $comittee->email }}" disabled>
                                </div>
                                @if ($comittee->division->name == 'Web Development')
                                <div class="mb-3">
                                    <label for="division" class="form-label">Divisi</label>
                                    <select name="division" id="division" class="form-control" required>
                                        @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}" {{ $division->id == $comittee->division_id ? 'selected' : '' }}>{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('division')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="position" class="form-label">Posisi</label>
                                    <input type="text" class="form-control" id="position" name="position" value="{{ old('position', $comittee->position) }}" placeholder="Input Position..." required>
                                </div>
                                @endif
                                <div class="mb-3">
                                    <label for="telephone" class="form-label">Telephone</label>
                                    <input type="text" class="form-control  @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone', $comittee->telephone) }}" placeholder="Input telephone...">
                                    @error('telephone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success float-right"><i class="fas fa-save mr-2"></i> Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
