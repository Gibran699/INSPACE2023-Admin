@extends('layouts.comittee')

@push('css')
    <link href="{{ asset('src/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('src/assets/extra-libs/datatables.net-bs4/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('src/assets/extra-libs/jvalidation/css/form-validation.css') }}">
@endpush

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item">Daftar Seluruh Peserta
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-5 align-self-center">
                <a href="{{ route('agenda.ticket.index', ['agenda' => $agenda->id]) }}" class="btn btn-danger float-right">Back</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        @include('layouts.message')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="table" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="15px">No.</th>
                                    <th>Ticket</th>
                                    <th>Participant</th>
                                    <th>Payment Status</th>
                                    <th>Check-In Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ticket->participant_tickets->sortBy('is_paid')->values() as $key => $participant_ticket)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $participant_ticket->ticket->name }}</td>
                                    <td>
                                        <table width="100%">
                                            <tr>
                                                <th>Nama</th>
                                                <th>No Hp</th>
                                                <th>Email</th>
                                                <th>Institusi</th>
                                                <th>Kehadiran</th>
                                                <th>Action</th>
                                            </tr>
                                            @foreach ($participant_ticket->participants as $k => $participant)
                                                <tr>
                                                    <td>{{ $participant->nama }}</td>
                                                    <td>{{ $participant->no_hp }}</td>
                                                    <td>{{ $participant->email }}</td>
                                                    <td>{{ $participant->institusi == 1 ? 'Kuliah' : ($participant->institusi == 2 ? 'SMA/SMK' : 'Umum') }}</td>
                                                    <td>
                                                        @if ($participant->is_checkin == 1)
                                                        <span class="badge badge-success">Hadir</span>
                                                        @else
                                                        <span class="badge badge-danger" data-toggle="modal" data-target="#checkin-{{$key}}-{{$k}}">Belum Hadir</span>
                                                        @endif
                                                        <div class="modal fade" id="checkin-{{$key}}-{{$k}}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Payment Proof</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Apakah anda yakin ingin validasi kehadiran dari peserta ini?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-xmark mr-2"></i> Close</button>
                                                                        <form action="{{ route('agenda.ticket.comitteCheckIn', ['agenda' => $ticket->agenda->id, 'ticket' => $ticket->id, 'participant_ticket' => $participant_ticket->id, 'participant' => $participant->id]) }}" method="post">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-success"><i class="fas fa-check mr-2"></i> Validate</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($participant_ticket->is_paid)
                                                        <button class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#re-send" onclick="reSend({{ $participant->id }}, '{{ $participant->email }}')"><i class="fa-solid fa-arrows-rotate"></i> Re-Send</button>
                                                        @else
                                                        <span class="badge badge-danger">Unpaid</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($participant_ticket->is_paid == 1)
                                        <span class="badge badge-success" data-toggle="modal" data-target="#payment-{{$key}}">Paid</span>
                                        @else
                                        <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#payment-{{$key}}"><i class="fas fa-eye mr-2"></i>Proof</button>
                                        @endif
                                        <div class="modal fade" id="payment-{{$key}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Payment Proof</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row align-items-center">
                                                            @if ($participant_ticket->addons()->exists())
                                                            <div class="col-12 d-flex justify-content-start"><h3>Addons:</h3></div>
                                                            @foreach ($participant_ticket->addons as $addon)
                                                            <div class="col-4"><img src="{{ asset('file/addon/'. $addon->image) }}" alt="wrapkit" width="120"></div>
                                                            <div class="col-8 d-flex justify-content-start"><h2>: {{ $addon->pivot->stock }} X Rp. {{ number_format($addon->addonVariant->price, 0, ',', '.') }}</h2></div>
                                                            @endforeach
                                                            <div class="col-12"><hr class="my-3"></div>
                                                            @endif
                                                            <div class="col-12">
                                                                <img src="{{ $ROOT_URL.'/store/' . $participant_ticket->payment_proof }}" alt="payment" width="100%">
                                                            </div>
                                                            <div class="col-12">
                                                                <hr class="my-3">
                                                                <h2>Total: Rp. {{ number_format($participant_ticket->total_price, 0, ',', '.') }}</h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($participant_ticket->is_paid != 1)
                                                    <div class="modal-footer">
                                                        <form action="{{ route('agenda.ticket.declineProof', ['agenda' => $ticket->agenda->id, 'ticket' => $ticket->id, 'participant_ticket' => $participant_ticket->id]) }}" method="post">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger"><i class="fa fa-xmark mr-2"></i> Decline Payment</button>
                                                        </form>
                                                        <form action="{{ route('agenda.ticket.acceptProof', ['agenda' => $ticket->agenda->id, 'ticket' => $ticket->id, 'participant_ticket' => $participant_ticket->id]) }}" method="post">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success"><i class="fas fa-check mr-2"></i> Accept Payment</button>
                                                        </form>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-{{ $participant_ticket->is_checkin == 1 ? 'success' : 'danger' }}">{{ $participant_ticket->is_checkin == 1 ? 'Check-In' : 'Unregistered' }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="re-send">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Resend Email</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="form" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label for="email" class="label">New Email</label>
                                        <div>
                                            <input type="email"
                                                class="form-control"
                                                id="email" name="email" placeholder="email" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-submit">Resend</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('src/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('src/assets/extra-libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('src/assets/extra-libs/datatables.net/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('src/assets/extra-libs/jvalidation/js/jquery.validate.min.js') }}"></script>
    <script>
        var table = $('#table').DataTable({
            stateSave: true
        });

        var form = $("#form");
        function reSend(id, email) {
            form.validate().resetForm()
            form.trigger("reset")
            form.attr('action', `/agenda/{{ $agenda->id }}/ticket/{{ $ticket->id }}/participant/${id}/re-send`)
            $(".form-control").removeClass("error")
            $('#email').val(email)
        }

        if (form.length) {
            var e = form.validate({
                rules: {
                    email: {
                        required: true
                    },
                },
                errorPlacement: function (error, element) {
                    var elem = element.closest('div');
                    error.insertBefore(elem);
                },
            });
        }
    </script>
@endsection
