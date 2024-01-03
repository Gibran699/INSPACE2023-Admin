@extends('layouts.comittee')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item">Playground
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
                <div class="card-body">
                    <h3 class="card-title mb-3">Upload File</h3>
                    <form action="{{ route('registration.upload.save.user', [
                            'program' => $program->slug,
                            'user' => $user->id,
                        ]) }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group mb-4">
                            <label for="twibbon">Twibbon</label>
                            <input type="file" name="twibbon" id="twibbon" class="form-control">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="payment_proof">Payment Proof</label>
                            <input type="file" name="payment_proof" id="payment_proof" class="form-control">
                        </div>

                        <div class="form-group mb-4">
                            <label for="originality">Originality</label>
                            <input type="file" name="originality" id="originality" class="form-control">
                        </div>

                        <div class="form-group mb-4">
                            <label for="file_stage_1">File Stage 1</label>
                            <input type="file" name="file_stage_1" id="file_stage_1" class="form-control">
                        </div>

                        <div class="form-group mb-4">
                            <label for="file_stage_2">File Stage 2</label>
                            <input type="file" name="file_stage_2" id="file_stage_2" class="form-control">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="proposal">Proposal</label>
                            <input type="file" name="proposal" id="proposal" class="form-control">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="report">Report</label>
                            <input type="file" name="report" id="report" class="form-control">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="presentation">Presentation</label>
                            <input type="file" name="presentation" id="presentation" class="form-control">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="result_link">Result Link</label>
                            <input type="text" name="result_link" id="result_link" class="form-control">
                        </div>

                        <button class="btn btn-success float-right" type="submit"><i class="fas fa-save mr-2"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection