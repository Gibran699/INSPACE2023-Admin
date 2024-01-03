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
                    <h3 class="card-title mb-3">Choose Program & Create Team</h3>
                    <a href="{{ route('registration.user') }}" class="mb-4">Click here for Individual</a><br><br>
                    <form action="{{ route('registration.store') }}" method="post">
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
                            <label for="team_name">Team Name</label>
                            <input type="text" name="team_name" id="team_name" class="form-control" required>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="leader">Team Leader</label>
                            <select name="leader" id="leader" class="form-control" required>
                                <option selected disabled>Choose Team Leader</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label for="team_member_1">Team Member 1</label>
                            <select name="team_member[]" id="team_member_1" class="form-control" required>
                                <option selected disabled>Choose Team Member</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="team_member_2">Team Member 2</label>
                            <select name="team_member[]" id="team_member_2" class="form-control" required>
                                <option selected disabled>Choose Team Member</option>
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