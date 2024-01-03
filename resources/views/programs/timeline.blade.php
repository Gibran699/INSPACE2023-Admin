@extends('layouts.comittee')

@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('src/dist/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('src/dist/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('src/assets/extra-libs/jvalidation/css/form-validation.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1"></h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item">Tambah Sebuah Program/Acara
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        @include('layouts.message')
        <form action="" method="post" id="form" enctype="multipart/form-data">
        @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-4 def-theme">
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label for="theme">Timeline</label>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-outline-primary btn-sm float-right" id="btn-add-theme"
                                            type="button" data-repeater-create><i class="fas fa-plus mr-2"></i> Tambah Tahap</button>
                                    </div>
                                </div>

                                <div data-repeater-list="timeline">
                                    @if ($program->timeline != null)
                                    @foreach (json_decode($program->timeline) as $timeline)
                                    <div data-repeater-item>
                                        <div class="row mb-4">
                                            <div class="col-12 mb-2">
                                                <label>Keterangan</label>
                                                <input type="text"
                                                class="form-control required-field theme"
                                                name="keterangan"  placeholder="Tahap" value="{{ $timeline->keterangan }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Tanggal Mulai</label>
                                                <input type="date"
                                                class="form-control required-field theme"
                                                name="date_start" value="{{ $timeline->date_start }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Tanggal Selesai (*Optional)</label>
                                                <input type="date"
                                                class="form-control theme"
                                                name="date_end" value="{{ $timeline->date_end }}">
                                            </div>
                                            <div class="col-12 d-flex align-items-end mt-2">
                                                <button class="btn btn-danger btn-block" data-repeater-delete type="button"><i
                                                    class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div data-repeater-item>
                                        <div class="row mb-4">
                                            <div class="col-12 mb-2">
                                                <label>Keterangan</label>
                                                <input type="text"
                                                class="form-control required-field theme"
                                                name="keterangan" placeholder="Tahap">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Tanggal Mulai</label>
                                                <input type="date"
                                                class="form-control required-field theme"
                                                name="date_start">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Tanggal Selesai (*Optional)</label>
                                                <input type="date"
                                                class="form-control theme"
                                                name="date_end">
                                            </div>
                                            <div class="col-12 d-flex align-items-end mt-2">
                                                <button class="btn btn-danger btn-block" data-repeater-delete type="button"><i
                                                    class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-success float-right" type="submit"><i
                                            class="fas fa-save mr-2"></i>Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="{{ asset('src/assets/extra-libs/jrepeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('src/assets/extra-libs/jvalidation/js/jquery.validate.min.js') }}"></script>
    <script>
        var form = $('#form')
        if (form.length) {
            var validate = form.validate();
            $.validator.addClassRules("required-field", {
                required: true
            });
        }

        $('.def-theme').repeater({
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            },
        });

    </script>
@endpush
