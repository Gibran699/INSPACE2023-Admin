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
                    <form action="{{ route('announcements.update', $announcement->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="title">Announcement Title</label>
                            <input type="text" name="title" class="form-control rounded-0 @error('title') is-invalid @enderror" id="title" placeholder="Input announcement title..." value="{{ $announcement->title }}">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <input type="text" name="description" class="form-control rounded-0 @error('description') is-invalid @enderror" id="description" placeholder="Input description..." value="{{ $announcement->description }}">
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="short_description">Short Description</label>
                            <input type="text" name="short_description" class="form-control rounded-0 @error('short_description') is-invalid @enderror" id="short_description" placeholder="Input short_description..." value="{{  $announcement->short_description }}">
                            @error('short_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="datetime">Datetime ({{ \Carbon\Carbon::parse($announcement->datetime)->format('d M Y ') }})</label>
                            <input type="datetime-local" name="datetime" class="form-control rounded-0 @error('datetime') is-invalid @enderror" id="datetime"  >
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
<!-- /.content -->

@endsection

