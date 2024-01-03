@extends('layouts.comittee')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item">deskripsi content
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Deskripsi Inspace</h3> <br>
                    <!-- index.blade.php -->
                    @foreach ($deskripsi as $desk)
                        @if ($desk->content == "inspace" && $desk->id == 2 )
                        <form>
                            @csrf
                            <div class="form-group mb-3">
                                <label for="title">Judul</label>
                                <input readonly type="text" name="question" class="form-control rounded-0 @error('title') is-invalid @enderror" id="title" value="{{ $desk->tittle }}">
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="short_description">Deskripsi Singkat</label>
                                <textarea style="height: 100px;" readonly cols="30" rows="10" name="answer" class="form-control rounded-0 @error('short_description') is-invalid @enderror" id="short_description">{{ $desk->short_description }}</textarea>
                                @error('short_description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="short_description">Deskripsi</label>
                                <textarea readonly cols="30" rows="10" name="answer" class="form-control rounded-0 @error('short_description') is-invalid @enderror" id="short_description">{{ $desk->deskripsi }}</textarea>
                                @error('short_description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="foto">Gambar</label>
                                <br>
                                <img src="{{ asset('images/' . $desk->foto) }}" alt="" width="50%">
                            </div>
                            <div class="form-group mb-3">
                                <label for="short_description">Link</label>
                                <input readonly type="text" name="font" class="form-control rounded-0 @error('short_description') is-invalid @enderror" id="short_description" placeholder="Masukkan jawaban..." value="{{ $desk->link }}">

                            </div>
                        </form>
                        <div class="modal fade" id="modal-inspace">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">inspace</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="container">
                                            <form action="{{ route('deskripsi.update', ['deskripsi' => $desk->id]) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group mb-3">
                                                    <label for="title">judul</label>
                                                    <input  type="text" name="tittle" class="form-control rounded-0 @error('title') is-invalid @enderror" id="title" placeholder="Masukkan Judul" value="{{ $desk->tittle}}">
                                                    @error('title')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="short_description">deskripsi Singkat</label>
                                                    <textarea style="height: 100px"  cols="30" rows="10" name="short_description" class="form-control rounded-0 @error('short_description') is-invalid @enderror" placeholder="Masukkan Deskripsi" id="short_description">{{$desk->short_description}}</textarea>
                                                    @error('short_description')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="short_description">deskripsi</label>
                                                    <textarea  cols="30" rows="10" name="deskripsi" class="form-control rounded-0 @error('short_description') is-invalid @enderror" placeholder="Masukkan Deskripsi" id="short_description">{{$desk->deskripsi}}</textarea>
                                                    @error('short_description')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="short_description">Gambar</label>
                                                    <input  type="file" name="foto" class="form-control rounded-0 @error('short_description') is-invalid @enderror" id="short_description" placeholder="" value="{{ old('short_description') }}" accept="image/png, image/jpg, image/jpeg">
                                                    @error('short_description')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="short_description">Link</label>
                                                    <input  type="text" name="link" class="form-control rounded-0 @error('short_description') is-invalid @enderror" id="short_description" placeholder="Masukkan Link" value="{{ $desk->link }}">
                                                    @error('short_description')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8"></div>
                                                    <div class="col-md-4">
                                                        <button class="btn btn-primary float-right mt-2"><i class="fas fa-edit mr-2"></i> Edit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <button class="btn btn-primary float-right mt-2" data-toggle="modal" data-target="#modal-inspace"><i class="fas fa-edit mr-2"></i> Edit</button>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach


                </div>
            </div>

            {{-- sistem informasi --}}

        </div>
    </div>
    <div class="container-fluid">
        @include('layouts.message')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Deskripsi Sistem informasi</h3> <br>
                        <!-- index.blade.php -->
                        @foreach ($deskripsi as $desk)
                            @if ($desk->content == "sistem informasi" && $desk->id == 1 )
                            <form>
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="title">Judul</label>
                                    <input readonly type="text" name="question" class="form-control rounded-0 @error('title') is-invalid @enderror" id="title" value="{{ $desk->tittle }}">
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="short_description">Deskripsi Singkat</label>
                                    <textarea style="height:100px" readonly cols="30" rows="10" name="answer" class="form-control rounded-0 @error('short_description') is-invalid @enderror" id="short_description">{{ $desk->short_description }}</textarea>
                                    @error('short_description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="short_description">Deskripsi</label>
                                    <textarea readonly cols="30" rows="10" name="answer" class="form-control rounded-0 @error('short_description') is-invalid @enderror" id="short_description">{{ $desk->deskripsi }}</textarea>
                                    @error('short_description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="foto">Gambar</label>
                                    <br>
                                    <img src="{{ asset('images/' . $desk->foto) }}" alt="" width="50%">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="short_description">Link</label>
                                    <input readonly type="text" name="font" class="form-control rounded-0 @error('short_description') is-invalid @enderror" id="short_description" placeholder="Masukkan jawaban..." value="{{ $desk->link }}">

                                </div>
                            </form>
                            <div class="modal fade" id="modal-si">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">inspace</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="container">
                                                <form action="{{ route('deskripsi.update', ['deskripsi' => $desk->id]) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group mb-3">
                                                        <label for="title">judul</label>
                                                        <input  type="text" name="tittle" class="form-control rounded-0 @error('title') is-invalid @enderror" id="title" placeholder="Masukkan Judul" value="{{ $desk->tittle }}">
                                                        @error('title')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="short_description">deskripsi Singkat</label>
                                                        <textarea style="height: 100px"  cols="30" rows="10" name="short_description" class="form-control rounded-0 @error('short_description') is-invalid @enderror" placeholder="Masukkan Deskripsi" id="short_description">{{$desk->short_description}}</textarea>
                                                        @error('short_description')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="short_description">deskripsi</label>
                                                        <textarea  cols="30" rows="10" name="deskripsi" class="form-control rounded-0 @error('short_description') is-invalid @enderror" placeholder="Masukkan Deskripsi" id="short_description">{{$desk->deskripsi}}</textarea>
                                                        @error('short_description')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="short_description">Gambar</label>
                                                        <input  type="file" name="foto" class="form-control rounded-0 @error('short_description') is-invalid @enderror" id="short_description" placeholder="Masukkan Foto" value="" accept="image/png, image/jpg, image/jpeg">
                                                        @error('short_description')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="short_description">Link</label>
                                                        <input  type="text" name="link" class="form-control rounded-0 @error('short_description') is-invalid @enderror" id="short_description" placeholder="Masukkan Link" value="{{ $desk->link }}">
                                                        @error('short_description')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-4">
                                                            <button class="btn btn-primary float-right mt-2"><i class="fas fa-edit mr-2"></i> Edit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary float-right mt-2" data-toggle="modal" data-target="#modal-si"><i class="fas fa-edit mr-2"></i> Edit</button>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach


                    </div>
                </div>

                {{-- sistem informasi --}}

            </div>
        </div>


@endsection

