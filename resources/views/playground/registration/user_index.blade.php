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
                    <h3 class="card-title mb-3">Choose Program</h3>
                    <form action="{{ route('registration.store.user') }}" method="post">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="program">Program</label>
                            <select name="program" id="program" class="form-control" required>
                                <option selected disabled>Choose Program</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label for="user_id">Participant</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option selected disabled>Choose Participant</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success float-right"><i class="fas fa-save mr-2"></i> Save</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection