@extends('layouts.comittee')

@section('content')
@include('layouts.message')
<div class="container-fluid">
    <section style="padding-top:60px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header">
                            Import
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data" action="{{ route('comittees.import') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="titile">Choose CSV</label>
                                    <input type="file" @error('file') is-invalid @enderror name="file" class="form-control">
                                </div>
                                @error('file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <button type="submit" class="button btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
