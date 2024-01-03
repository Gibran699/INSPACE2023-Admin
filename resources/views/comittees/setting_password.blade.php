@extends('layouts.comittee')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-10 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
        </div>
    </div>
</div>


@include('layouts.message')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('comittees.update_settings_password') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Sekarang</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" placeholder="Input Password Sekarang...">
                                    @error('current_password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" placeholder="Input Password Baru...">
                                    @error('new_password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="new_confirm_password" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control @error('new_confirm_password') is-invalid @enderror" id="new_confirm_password" name="new_confirm_password" placeholder="Input Konfirmasi Password Baru...">
                                    @error('new_confirm_password')
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
