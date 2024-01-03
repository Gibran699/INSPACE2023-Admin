
@extends('layouts.comittee')

@push('css')
<link rel="stylesheet" href="{{ asset('src/assets/extra-libs/sweetalert/sweetalert2.min.css') }}">
@endpush

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item">Details {{ $team->name }} for {{ $program->name }}
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
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ $ROOT_URL.'/store/'.$team->logo }}" onerror="this.onerror=null;this.src='/images/inspace-logo.png'" alt="Team Logo" width="100%">
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <small class="m-0">Name/Code</small>
                                    <p class="mb-2">{{ $team->name }}/{{ $team->code }}</p>

                                    <small class="m-0">Leader</small>
                                    <p class="mb-2">{{ $team->user->name }}</p>

                                    <small class="m-0">Member</small>
                                    @foreach($team->team_users as $member)
                                        <p class="mb-2">{{ $loop->iteration }}. {{ $member->user->name }}</p>
                                    @endforeach
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <small class="m-0">Leader's Institution</small>
                                    <p class="mb-2">{{ $team->user->institution }}</p>

                                    <small class="m-0">Leader's Class/Major</small>
                                    <p class="mb-2">{{ $team->user->class_major }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <small class="m-0">Payment</small>
                                    @if($program_team->is_paid == 1)
                                        <p class="mb-2"><a href="#" data-toggle="modal" data-target="#payment">See Proof (Paid)</a></p>
                                        <div class="modal fade" id="payment">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Payment Proof</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <img src="{{ $ROOT_URL.'/store/' . $program_team->payment_proof }}" alt="payment" width="100%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($program_team->is_paid == 0 and $program_team->payment_proof != null)
                                        <p class="mb-2"><a href="#" data-toggle="modal" data-target="#payment">See Proof and Accept Payment</a></p>
                                        <div class="modal fade" id="payment">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Payment Proof</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <img src="{{ $ROOT_URL.'/store/' . $program_team->payment_proof }}" alt="payment" width="100%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <form action="{{ route('active.program.accept_payment',[
                                                                            'program' => $program->slug,
                                                                            'uKey' => $team->code
                                                                        ]) }}" method="post">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-success"><i class="fas fa-check mr-2"></i> Accept Payment</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <p class="mb-2">Unpaid</p>
                                    @endif

                                    @foreach ($program_team->stages_doc->d() as $key => $file)
                                    <small class="m-0">File Stage {{ $key+1 }}</small>
                                        @if($file->file == null)
                                            <p>Not submitted yet</p>
                                        @else
                                            <p class="mb-2"><a href="{{ $ROOT_URL.'/store/'.$file->file }}">Download</a></p>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <small class="m-0">Registered At</small>
                                    <p class="mb-2">{{ $program_team->created_at != null ?  $program_team->created_at->format('D, d M Y H:i:s') . ' WITA' : '-'}}</p>
                                </div>
                            </div>
                            {{-- <hr>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <a href="{{ route('active.program.download_files', [
                                            'program' => $program->slug,
                                            'team' => $team->code
                                        ]) }}" class="btn btn-success btn-sm"><i class="fas fa-download mr-2"></i> Download All Files</a>
                                </div>
                                <div class="col-md-6 col-sm-12"></div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="form" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <small class="m-0">Leader Name</small>
                        <p class="mb-2">{{ $team->user->name }}</p>
                        <table class="table table-striped">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Delete</th>
                                <th>Change Leader</th>
                            </tr>
                            @forelse ($team->team_users as $member)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $member->user->name }}</td>
                                <td>
                                    <input type="checkbox" name="delete[]" value="{{ $member->id }}">
                                </td>
                                <td>
                                    <input type="radio" name="leader" value="{{ $member->id }}">
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4"><center>This team doesn't have member</center></td>
                            </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <small class="m-0">{{ $team->name }}</small>
                        <p class="mb-2">File Management</p>
                        <table class="table table-striped">
                            <tr>
                                <th>Payment</th>
                                <td>
                                    @if ($program_team->is_paid == 1)
                                        <span class="badge badge-success">Paid</span>
                                    @elseif($program_team->is_paid == 0 and $program_team->payment_proof != null)
                                        <fieldset class="checkbox">
                                            <label>
                                                <input type="checkbox" name="is_paid" value="1"> Delete Proof
                                            </label>
                                        </fieldset>
                                    @else
                                        <span class="badge badge-warning">Unpaid</span>
                                    @endif
                                </td>
                            </tr>
                            @foreach ($program_team->stages_doc->d() as $key => $file)
                            <tr>
                                <th>Stage {{ $key + 1 }}</th>
                                <td>
                                    @if (!$program_team->stagesDoc->d()[$key]->status && date('Y-m-d H:i:s', strtotime($program->stagesData->get('stage_list')[$key]->end_selection)) < now())
                                        <span class="badge badge-danger">Eliminated</span>
                                    @elseif (!$program_team->stagesDoc->d()[$key]->status)
                                        @if ($key > 0 && !$program_team->stagesDoc->d()[$key-1]->status && date('Y-m-d H:i:s', strtotime($program->stagesData->get('stage_list')[$key-1]->end_selection)) < now())
                                            <span class="badge badge-danger">Eliminated</span>
                                        @elseif ($program_team->stagesDoc->d()[$key]->file == null)
                                        <span class="badge badge-warning">Not submitted yet</span>
                                        @else
                                            <fieldset class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="stage[{{ $key }}]" value="1"> Delete File
                                                </label>
                                            </fieldset>
                                        @endif
                                    @else
                                        <span class="badge badge-success">Passed</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-success float-right" data-toggle="modal" data-target="#modal-confirm" type="button"><i
                    class="fas fa-save mr-2"></i>Confirm Changes</button>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="modal-confirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <small class="m-0"></small>
                        <p class="mb-2">Apakah anda yakin melakukan perubahan?</p>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-primary" onclick="generateOtp()">Generate Opt</button>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control" id="otp" readonly required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn btn-toolbar justify-content-center">
                    <button for="is_active" class="btn btn-lg btn-default mr-2 btn-success" onclick="manageProgramTeam()">Ya</button>
                    <button type="button" class="btn btn-lg btn-default mr-2 btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('src/assets/extra-libs/sweetalert/sweetalert2.all.min.js') }}"></script>
<script>
    var url = url = window.location.pathname.split('/');
    function generateOtp() {
        $.ajax({
            url: '/'+url[1]+'/'+url[2]+'/generate-otp',
            type: "get",
            processData: false,
            contentType: false,
            success: function(res) {
                $('#otp').val(res.otp)
            }
        });
    }

    function manageProgramTeam() {
        if ($('#otp').val().length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Errors!',
                text: 'OTP cannot be empty',
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
            return
        }

        formData = new FormData($('#form')[0]);
        formData.append('otp', $('#otp').val())
        $.ajax({
            url: '/'+url[1]+'/'+url[2]+'/manage/{{ $program_team->id }}',
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#modal-confirm').modal('hide')
                Swal.fire({
                    icon: 'success',
                    title: 'success!',
                    text: res.message,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
                setTimeout(function () { document.location.reload(); }, 1000);
            },
            error: function (res) {
                $('#modal-confirm').modal('hide')
                Swal.fire({
                    icon: 'error',
                    title: 'Errors!',
                    text: res.responseJSON.message,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    }
</script>
@endsection
