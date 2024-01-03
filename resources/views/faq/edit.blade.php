@extends('layouts.comittee')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item">Add Faq
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
                    <form action="{{ route('faq.update', $faqs->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="title">Pertanyaan</label>
                            <input type="text" name="question" class="form-control rounded-0 @error('title') is-invalid @enderror" id="title" placeholder="Masukkan Pertanyaan..." value="{{ $faqs->question }}">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="short_description">Jawaban</label>
                            <textarea name="answer" class="form-control rounded-0 @error('short_description') is-invalid @enderror" placeholder="Masukkan jawaban..." id="short_description" cols="30" rows="10">{{ $faqs->answer }}</textarea>
                            @error('short_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="short_description">Icon</label>
                            <input type="text" name="font" class="form-control rounded-0 @error('font') is-invalid @enderror" id="font" placeholder="cth: fa fa-mortar-board" value="{{ $faqs->font }}">
                            <small id="font" class="form-text text-muted">choose you are icon. <a href="https://fontawesome.com/v4/icons/" target="_blank" rel="noopener noreferrer"> Click here to see icon</a></small>
                            @error('font')
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

