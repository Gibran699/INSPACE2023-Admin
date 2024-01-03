@extends('layouts.comittee')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item">Tambah Announcement/Pengumuman 
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
                <div class="card-body">
                    <form action="{{ route('announcements.store') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control rounded-0 @error('title') is-invalid @enderror" id="title" placeholder="Masukkan Judul..." value="{{ old('title') }}">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="short_description">Short Description</label>
                            <input type="text" name="short_description" class="form-control rounded-0 @error('short_description') is-invalid @enderror" id="short_description" placeholder="Masukkan Deskripsi Singkat..." value="{{ old('short_description') }}">
                            @error('short_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <input type="text" name="description" class="form-control rounded-0 @error('description') is-invalid @enderror" id="description" placeholder="Masukkan Deskripsi..." value="{{ old('description') }}">
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="datetime">Datetime</label>
                            <input type="datetime-local" name="datetime" class="form-control rounded-0 @error('datetime') is-invalid @enderror" id="datetime" placeholder="Masukkan Tanggal..." value="{{ old('datetime') }}">
                            @error('datetime')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <button class="btn btn-primary float-right mt-2"><i class="fas fa-save mr-2"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

@endsection

