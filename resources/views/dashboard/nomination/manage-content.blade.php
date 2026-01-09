@extends('dashboard.layouts.master')
@section('title', __('Nomination Content Details'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush

    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Nomination Content Details') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    <a href="{{ route('admin.nomination.dashboard') }}">{{ __('Nomination Dashboard') }}</a> /
                    {{ __('Manage Nomination Content') }}
                </small>
            </div>
            <div class="card">
                <div class="card-header" style="font-size: 18px;">
                    <span class="icon text-red-50 mr-2" style="color: blue;">
                        <i class="fas fa-user-friends"></i>
                    </span>Manage Nomination Content
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.nomination.create.content') }}" method="post"
                                onsubmit="return ValidateForm()">
                                @csrf
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">Content Details :</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Title
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                    name="heading" id="heading" type="text"
                                                    value="@if ($content != null) {{ $content->heading }} @endif"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12"> <label class="form-control-label"> Nomination Details
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="hidden" name="description" id="description"
                                                    value="@if ($content != null) {{ $content->description }} @endif" />
                                                <input type="hidden" name="description_data" id="description_data"
                                                    value="@if ($content != null) {{ $content->description_data }} @endif" />
                                                <div id="description_gjs"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12"> <label class="form-control-label"> Nomination Content
                                                Details
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="hidden" name="content_description" id="content_description"
                                                    value="@if ($content != null) {{ $content->content_description }} @endif" />
                                                <input type="hidden" name="content_description_data" id="content_description_data"
                                                    value="@if ($content != null) {{ $content->content_description_data }} @endif" />
                                                <div id="content_description_gjs"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <button class="btn btn-success" type="submit" name="submit" id="submit_btn">
                                                Publish
                                            </button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script>
        $(document).ready(function() {
            grapejsInitialize(`description`, `description_data`, `description_gjs`);
            grapejsInitialize(`content_description`, `content_description_data`, `content_description_gjs`);

        });

        let ValidateForm = () => {
            let message = '';
            if ($('#description').val() == '') {
                message = "Nomination details is required";
            }
            if ($('#heading').val() == '') {
                message = "Title is required";
            }

            if ($('#content_description').val() == '') {
                message = "Nomination content details is required";
            }


            if (message != '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: message,
                });
                return false;
            }
            return true;
        }
    </script>
@endpush
