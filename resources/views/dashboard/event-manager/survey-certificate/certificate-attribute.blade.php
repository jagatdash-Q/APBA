@extends('dashboard.layouts.master')
@section('title', __('Certificate Attributes'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Certificate Attributes') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home /
                    </a>
                    {{ __('Certificate Attributes') }}
                </small>
            </div>
            <div class="card mb-5">
                <div class="card-header" style="font-size: 18px;">
                    {{ $certificate_attribute == null ? 'Create' : 'Edit' }} Certificate Attributes
                </div>
                <form action="{{ route('admin.certificate.attributes.create') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="uuid"
                        value="{{ $certificate_attribute == null ? Str::uuid()->toString() : $certificate_attribute->uuid }}">

                    <input type="hidden" name="type" value="{{ $certificate_attribute == null ? 0 : 1 }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Introducer Name 1<span id="danger">*</span></label>
                                <input type="text" class="form-control text-secondary" placeholder="Introducer Name"
                                    name="introducer_name_1" id="introducer_name_1"
                                    value="{{ $certificate_attribute == null ? old('introducer_name_1') : $certificate_attribute->introducer_name_1 }}"
                                    required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Introducer Name 2<span id="danger">*</span></label>
                                <input type="text" class="form-control text-secondary" placeholder="Introducer Name"
                                    name="introducer_name_2" id="introducer_name_2"
                                    value="{{ $certificate_attribute == null ? old('introducer_name_2') : $certificate_attribute->introducer_name_2 }}"
                                    required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Introducer Company Name 1<span id="danger">*</span></label>
                                <input type="text" class="form-control text-secondary" placeholder="Company Name"
                                    name="introducer_company_1" id="introducer_company_1"
                                    value="{{ $certificate_attribute == null ? old('introducer_company_1') : $certificate_attribute->introducer_company_1 }}"
                                    required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Introducer Company Name 2<span id="danger">*</span></label>
                                <input type="text" class="form-control text-secondary" placeholder="Company Name"
                                    name="introducer_company_2" id="introducer_company_2"
                                    value="{{ $certificate_attribute == null ? old('introducer_company_2') : $certificate_attribute->introducer_company_2 }}"
                                    required>
                            </div>
                            <div class="col-6 mt-2">
                                <label class="form-label">Logo 1 (180px x 100px)<span id="danger">*</span></label>
                                <input type="file" class="form-control text-secondary" accept="image/*" name="logo_1"
                                    id="logo_1" {{ $certificate_attribute == null ? 'required' : '' }}>
                            </div>
                            <div class="col-6 mt-2">
                                <div id="imagePreview_1">
                                    <img src="{{ $certificate_attribute == null ? asset('assets/dashboard/images/image_not_found.png') : asset('assets/dashboard/apba_certificate_design' . '/' . $certificate_attribute->logo_1) }}"
                                        height="100px" width="auto">
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <label class="form-label">Logo 2 (180px x 100px)<span id="danger">*</span></label>
                                <input type="file" class="form-control text-secondary" accept="image/*" name="logo_2"
                                    id="logo_2" {{ $certificate_attribute == null ? 'required' : '' }}>
                            </div>
                            <div class="col-6 mt-2">
                                <div id="imagePreview_2">
                                    <img src="{{ $certificate_attribute == null ? asset('assets/dashboard/images/image_not_found.png') : asset('assets/dashboard/apba_certificate_design' . '/' . $certificate_attribute->logo_2) }}"
                                        height="100px" width="auto">
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <label class="form-label">Certificate Background Image<span id="danger">*</span></label>
                                <input type="file" class="form-control text-secondary" accept="image/*"
                                    name="background_image" id="background_image"
                                    {{ $certificate_attribute == null ? 'required' : '' }}>
                            </div>
                            <div class="col-6 mt-2">
                                <div id="imagePreview_3">
                                    <img src="{{ $certificate_attribute == null ? asset('assets/dashboard/images/image_not_found.png') : asset('assets/dashboard/apba_certificate_design' . '/' . $certificate_attribute->background_image) }}"
                                        height="100px" width="auto">
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <label class="form-label">Signature 1 (180px x 100px)<span id="danger">*</span></label>
                                <input type="file" class="form-control text-secondary" accept="image/*"
                                    name="signature_1" id="signature_1"
                                    {{ $certificate_attribute == null ? 'required' : '' }}>
                            </div>
                            <div class="col-6 mt-2">
                                <div id="imagePreview_4">
                                    <img src="{{ $certificate_attribute == null ? asset('assets/dashboard/images/image_not_found.png') : asset('assets/dashboard/apba_certificate_design' . '/' . $certificate_attribute->signature_1) }}"
                                        height="100px" width="auto">
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <label class="form-label">Signature 2 (180px x 100px)<span id="danger">*</span></label>
                                <input type="file" class="form-control text-secondary" accept="image/*"
                                    name="signature_2" id="signature_2"
                                    {{ $certificate_attribute == null ? 'required' : '' }}>
                            </div>
                            <div class="col-6 mt-2">
                                <div id="imagePreview_5">
                                    <img src="{{ $certificate_attribute == null ? asset('assets/dashboard/images/image_not_found.png') : asset('assets/dashboard/apba_certificate_design' . '/' . $certificate_attribute->signature_2) }}"
                                        height="100px" width="auto">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="end-content">
                        <div class="col-md-12">
                            <div class="form-group row" style="margin-top: 10px;padding-bottom: 5px;">
                                <button class="btn btn-success" type="submit" id="submit_btn"
                                    style="margin-left:20px;">
                                    {{ $certificate_attribute == null ? 'Submit' : 'Update' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script>
        $("#logo_1").on("change", function(e) {
            var file = e.target.files[0];
            if (file) {
                $("#imagePreview_1").html('');
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageData = e.target.result;
                    $("#imagePreview_1").html('<img src="' + imageData +
                        '" alt="Image Preview" width="200" max-height="120" height="100" style="object-fit: contain;">'
                    );
                };
                reader.readAsDataURL(file);
            }
        });
        $("#logo_2").on("change", function(e) {
            var file = e.target.files[0];
            if (file) {
                $("#imagePreview_2").html('');
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageData = e.target.result;
                    $("#imagePreview_2").html('<img src="' + imageData +
                        '" alt="Image Preview" width="200" max-height="120" height="100" style="object-fit: contain;">'
                    );
                };
                reader.readAsDataURL(file);
            }
        });
        $("#background_image").on("change", function(e) {
            var file = e.target.files[0];
            if (file) {
                $("#imagePreview_3").html('');
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageData = e.target.result;
                    $("#imagePreview_3").html('<img src="' + imageData +
                        '" alt="Image Preview" width="200" max-height="120" height="100" style="object-fit: contain;">'
                    );
                };
                reader.readAsDataURL(file);
            }
        });
        $("#signature_1").on("change", function(e) {
            var file = e.target.files[0];
            if (file) {
                $("#imagePreview_4").html('');
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageData = e.target.result;
                    $("#imagePreview_4").html('<img src="' + imageData +
                        '" alt="Image Preview" width="200" max-height="120" height="100" style="object-fit: contain;">'
                    );
                };
                reader.readAsDataURL(file);
            }
        });
        $("#signature_2").on("change", function(e) {
            var file = e.target.files[0];
            if (file) {
                $("#imagePreview_5").html('');
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageData = e.target.result;
                    $("#imagePreview_5").html('<img src="' + imageData +
                        '" alt="Image Preview" width="200" max-height="120" height="100" style="object-fit: contain;">'
                    );
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
