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
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ Str::title($title) }}</h3>
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
        <form action="{{ route('programs.update', $program->id) }}" method="post" id="form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control"
                                            id="name" name="name" placeholder="Masukan Nama Program/Acara..."
                                            value="{{ $program->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="slug">Slug</label>
                                        <input type="text" class="form-control"
                                            id="slug" name="slug" placeholder="Masukan Slug... (Ex: uiux-2022)"
                                            value="{{ $program->slug }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label for="short_description">Short Description</label>
                                        <input type="text" class="form-control"
                                            id="short_description" name="short_description"
                                            placeholder="Masukan Deskripsi Singkat..." value="{{ $program->short_description }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control"
                                            rows="4" placeholder="Masukkan Deskripsi Lengkap...">{{ $program->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="logo">Logo</label>
                                        <input type="file" class="form-control"
                                            id="logo" name="logo" accept=".png,.jpg,.jpeg">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="guidebook">Guidebook (*pdf)</label>
                                        <input type="file" class="form-control"
                                            id="guidebook" name="guidebook" accept=".pdf">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label for="wa_link">Wa Link</label>
                                        <input type="text" class="form-control"
                                            id="wa_link" name="wa_link" placeholder="Wa Link" value="{{ $program->wa_link }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label for="comittee_id">Contact Person</label>
                                        <select class="form-control" id="comittee_id"
                                            name="comittee_id" width="100%">
                                            <option selected disabled>Pilih Narahubung...</option>
                                            @foreach ($comittees as $comittee)
                                                <option value="{{ $comittee->id }}"
                                                    {{ $program->comittee_id == $comittee->id ? 'selected' : '' }}>
                                                    {{ $comittee->nim }} | {{ $comittee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control"
                                            id="price" name="price" placeholder="Masukan Biaya Pendaftaran..." value="{{ $program->price }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="group_settings">Group Settings</label>
                                        <div class="form-check radio">
                                            <label for="individual"><input class="form-check-input" name="group_settings"
                                                type="radio" id="individual" value="0" {{ $program->is_group ? '' : 'checked' }} readonly> Individual</label><br>
                                            <label for="group"><input class="form-check-input" name="group_settings"
                                                type="radio" id="group" value="1" {{ $program->is_group ? 'checked' : '' }} readonly> Group</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="group_settings">Category</label>
                                        <div class="form-check radio">
                                            <label for="competition" onclick="javascript:showEmbed(false)"><input class="form-check-input" name="category"
                                                type="radio" id="competition" value="Competition" {{ $program->category == 'Competition' ? 'checked' : '' }}> Competition</label><br>
                                            <label for="tournament" onclick="javascript:showEmbed(true)"><input class="form-check-input" name="category"
                                                type="radio" id="tournament" value="Tournament" {{ $program->category == 'Tournament' ? 'checked' : '' }}> Tournament</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="embed-form" style="{{ $program->category == 'Competition' ? 'display:none' : ''}}">
                                    <div class="form-group mb-4">
                                        <label for="embed_link">Embed Link</label>
                                        <input type="text" class="form-control"
                                            id="embed_link" name="embed_link"
                                            placeholder="Https://xxxxxxxx.com/embed/xxxxx" value="{{ $program->embed_link }}">
                                    </div>
                                </div>
                                <div class="col-12" id="limit-form" style="{{ $program->category == 'Competition' ? 'display:none' : ''}}">
                                    <div class="form-group mb-4">
                                        <label for="participant-limit">Participant Limit</label>
                                        <input type="number" class="form-control"
                                            id="participant-limit" name="participant_limit"
                                            placeholder="Participant limit" value="{{ $program->participant_limit }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="max_team">Max Team</label>
                                <input type="number" class="form-control"
                                    id="max_team" name="max_team"
                                    placeholder="Masukan Jumlah Maksimum Anggota Tim... (Isi 0 Jika Individu)"
                                    value="{{ $program->max_team }}">
                            </div>

                            <div class="form-group mb-4 def-theme">
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label for="theme">Theme</label>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-outline-primary btn-sm float-right" id="btn-add-theme"
                                            type="button" data-repeater-create><i class="fas fa-plus mr-2"></i> Add Theme</button>
                                    </div>
                                </div>

                                <div data-repeater-list="themes">
                                    @foreach (json_decode($program->sub_tema) as $sub_tema)
                                    <div data-repeater-item>
                                        <div class="row mb-4">
                                            <div class="col-md-11">
                                                <input type="text"
                                                class="form-control theme"
                                                value="{{ $sub_tema->name }}"
                                                name="name" placeholder="Masukan Tema...">
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button class="btn btn-danger btn-block" data-repeater-delete type="button"><i
                                                    class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="first_place">First Place</label>
                                        <input type="number" class="form-control required-field"
                                            id="first_place" name="first_place"
                                            placeholder="0" value="{{ $program->stages_data->get('first_place') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="seccond_place">Seccond Place</label>
                                        <input type="number" class="form-control required-field"
                                            id="seccond_place" name="seccond_place"
                                            placeholder="0" value="{{ $program->stages_data->get('seccond_place') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label for="third_place">Third Place</label>
                                        <input type="number" class="form-control required-field"
                                            id="third_place" name="third_place"
                                            placeholder="0" value="{{ $program->stages_data->get('third_place') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="def-stage">
                <div class="row">
                    <div class="col-12 mb-2">
                        <button class="btn btn-outline-primary btn-sm float-right" id="btn-add-theme"
                            type="button" data-repeater-create><i class="fas fa-plus mr-2"></i> Add Stage</button>
                    </div>
                </div>
                <div data-repeater-list="stage">
                    @foreach ($program->stages_data->get('stage_list') as $stage_data)
                    <div data-repeater-item >
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mb-4">
                                                        <label for="label">Label</label>
                                                        <input type="text" class="form-control required-field" id="label" name="label" value="{{ $stage_data->label }}" placeholder="Ex: Stage 1">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group mb-4">
                                                        <label>Keterangan</label>
                                                        <input type="text" class="form-control required-field" name="keterangan" value="{{ $stage_data->keterangan }}" placeholder="Ex: Open Registration">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group mb-4">
                                                        <label>Open Registration</label>
                                                        <input type="datetime-local"
                                                            class="form-control required-field"
                                                            name="open_registration"
                                                            value="{{ $stage_data->open_registration }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group mb-4">
                                                        <label>Close Registration</label>
                                                        <input type="datetime-local"
                                                            class="form-control required-field"
                                                            name="close_registration"
                                                            value="{{ $stage_data->close_registration }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group mb-4">
                                                        <label>Start Selection</label>
                                                        <input type="datetime-local"
                                                            class="form-control required-field"
                                                            name="start_selection"
                                                            value="{{ $stage_data->start_selection }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group mb-4">
                                                        <label>End Selection</label>
                                                        <input type="datetime-local"
                                                            class="form-control required-field"
                                                            name="end_selection"
                                                            value="{{ $stage_data->end_selection }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group mb-4">
                                                        <label>Announcement</label>
                                                        <input type="datetime-local"
                                                            class="form-control required-field"
                                                            name="announcement"
                                                            value="{{ $stage_data->announcement }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mb-2 border p-2">
                                                    <div class="col-12">
                                                        <div class="form-group mb-4">
                                                            <label>Label</label>
                                                            <input type="text" class="form-control" name="file_label" value="{{ $stage_data->file_label }}" placeholder="Ex: Proposal">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group mb-4">
                                                            <label>Description</label>
                                                            <textarea name="file_desc" class="form-control file-desc" placeholder="description">{{ $stage_data->file_desc }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-danger btn-block" data-repeater-delete type="button"><i
                                        class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="start_payment">Start Payment</label>
                                            <input type="datetime-local"
                                                class="form-control"
                                                id="start_payment" name="start_payment" value="{{ $program->stages_data->get('start_payment') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="end_payment">End Payment</label>
                                            <input type="datetime-local"
                                                class="form-control"
                                                value="{{ $program->stages_data->get('end_payment') }}"
                                                id="end_payment" name="end_payment">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="finalist_announcement">Finalist Announcement</label>
                                            <input type="datetime-local"
                                                class="form-control"
                                                value="{{ $program->stages_data->get('finalist_announcement') }}"
                                                id="finalist_announcement" name="finalist_announcement">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="technical_meeting">Technical Meeting</label>
                                            <input type="datetime-local"
                                                class="form-control"
                                                value="{{ $program->stages_data->get('technical_meeting') }}"
                                                id="technical_meeting" name="technical_meeting">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-4">
                                            <label for="final">Final</label>
                                            <input type="datetime-local"
                                                class="form-control" id="final"
                                                value="{{ $program->stages_data->get('final') }}"
                                                name="final">
                                        </div>
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('src/assets/extra-libs/jrepeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('src/assets/extra-libs/jvalidation/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('src/assets/extra-libs/jvalidation/js/jquery.validate.additional.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            var file_desc = $('.file-desc')
            file_desc.each(function () {
                var $this = $(this);
                $this.summernote({
                    toolbar: [
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                    ]
                });
            });
            $('#comittee_id').select2({
                width: '100%'
            });

            let category = $('#category');

            var form = $('#form')
            if (form.length) {
                var validate = form.validate({
                    rules: {
                        'name': {
                            required: true
                        },
                        'slug': {
                            required: true
                        },
                        'short_description': {
                            required: true
                        },
                        'description': {
                            required: true
                        },
                        'guidebook': {
                            accept:"application/pdf"
                        },
                        'logo': {
                            accept:"image/jpg,image/jpeg,image/png"
                        },
                        'comittee_id': {
                            required: true,
                        },
                        'price': {
                            required: true,
                            max: 2147483647
                        },
                        'group_settings': {
                            required: true,
                        },
                        'category': {
                            required: true,
                        },
                        'embed_link': {
                            url: true
                        },
                        'max_team': {
                            required: true,
                        },
                        'start_payment': {
                            required: true,
                        },
                        'end_payment': {
                            required: true,
                        },
                    },
                    errorPlacement: function(error, element) {
                        if (element.is(":radio")) {
                            error.appendTo(element.parents('.radio'));
                        } else { // This is the default behavior
                            error.insertBefore(element);
                        }
                    }
                });
                $.validator.addClassRules("theme", {
                    required: true
                });
                $.validator.addClassRules("required-field", {
                    required: true
                });
            }
        });

        $('.def-theme').repeater({
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                },
            });

        $('.def-stage').repeater({
            show: function () {
                $(this).slideDown();
                $('.file-desc').each(function () {
                    var $this = $(this);
                    $this.summernote('destroy');
                    $this.summernote({
                        toolbar: [
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link']],
                        ['view', ['codeview']]
                        ]
                    });
                });
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            },
        });

        function showEmbed(toggle) {
            if (toggle) {
                $('#embed-form').css('display', 'block');
                $('#limit-form').css('display', 'block');
            } else {
                $('#embed_link').val('');
                $('#embed-form').css('display', 'none');
                $('#participant-limit').val('');
                $('#limit-form').css('display', 'none');
            }
        }
    </script>
@endpush
