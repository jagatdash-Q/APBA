@extends('dashboard.layouts.master')
@section('title', __('Create New Event'))
@section('content')
    @push('after-styles')
        <style>
            #pills-tabContent .tab-pane {
                /* padding: 10px;
                                            margin: 10px;
                                            border:1px solid rgba(0, 0, 0, .4) !important;
                                            border-radius: 10px; */
            }

            .custom-border {
                border: 1px solid rgba(0, 0, 0, .4) !important;
                border-radius: 10px;
                padding: 10px;
            }

            .speaker-sec {
                margin-top: 10px;
                margin-bottom: 10px;
            }
        </style>
        <link rel="stylesheet" href="{{ asset('assets/dashboard/dropzone/dropzone.css') }}">
    @endpush
    @include('dashboard.common.index')
    <div class="padding">
        <div class="box m-b-0">
            <div class="box-header dker">
                <h3>{{ __('Create New Event') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    {{ __('Create a New Event') }}
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">

                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <form action="{{ route('admin.event.store') }}" method="post" enctype="multipart/form-data">
                    <div class="card pt-2">
                        @csrf
                        <input type="hidden" name="page_type" id="page_type" value="events">
                        <input type="hidden" name="base_url" id="base_url" value="{{ url('') }}">
                        <input type="hidden" name="gallery_images" id="gallery_images" value="">

                        <div class="col-lg-12 m-0">
                            <div class="alert alert-warning m-b-0">
                                Please fill the below details
                                <ul>
                                    <li>Event info</li>
                                    <li>Introduction</li>
                                    <li>Conference Registration Rate</li>
                                    <li>Hotel Venue & Accommodation</li>
                                </ul>
                            </div>
                        </div>

                        <fieldset class="fieldset-design">
                            <legend class="fieldset-legend">Event Info :</legend>
                            <div class="form-group row">
                                <div class="col-md-2"> <label class=" form-control-label"> Event Name
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required=""
                                            dir="ltr" name="event_name" id="event_name" type="text"
                                            oninput="generatePageSlug(this.value,'event_slug','events','draft_btn','submit_btn')"
                                            value="{{ old('event_name') }}"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class=" form-control-label"> Event Slug </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required=""
                                            dir="ltr" name="event_slug" id="event_slug" type="text"
                                            value="{{ old('event_slug') }}" readonly></span>
                                    <span id="event_slug_error"> </span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class=" form-control-label"> Meta Title </label>
                                </div>
                                <div class="col-sm-10"> <span class="pr-field"><input placeholder="" class="form-control"
                                            required="" dir="ltr" name="meta_title" id="meta_title" type="text"
                                            value="{{ old('meta_title') }}"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class=" form-control-label"> Meta Keyword </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required=""
                                            dir="ltr" name="meta_keyword" id="meta_keyword" type="text"
                                            value="{{ old('meta_keyword') }}"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2"> <label class=" form-control-label"> Meta
                                        Description
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required=""
                                            dir="ltr" name="meta_description" id="meta_description" type="text"
                                            value="{{ old('meta_description') }}"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2"> <label class="form-control-label"> Event Start date
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required=""
                                            dir="ltr" name="start_date" id="start_date" type="text"
                                            onkeydown="event.preventDefault()" autocomplete="off"
                                            value="{{ old('start_date') }}"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2"> <label class=" form-control-label"> Event End date
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required=""
                                            dir="ltr" name="end_date" id="end_date" type="text"
                                            onkeydown="event.preventDefault()" autocomplete="off"
                                            value="{{ old('end_date') }}"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class="form-control-label">Featured Image: </label>
                                </div>
                                <div class="col-sm-10">
                                    <div style="width:70%;float:left">
                                        <span class="pr-field"><input type="text" id="featured_image"
                                                name="featured_image" class="form-control" value="" readonly=""
                                                style="margin-bottom:15px"></span>
                                        <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                            data-target="#showsModal" data-toggle="modal"
                                            onclick="setModalClickBtnId(document.getElementById('featured_image'));">
                                            Select or upload Image </div>
                                    </div>
                                    <div style="width: 20%;float:right">
                                        <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                            id="featured_image_preview" height="100px" width="auto">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="card pt-2 mt-2 container-fluid p-2">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-introduction-tab" data-toggle="pill"
                                    href="#pills-introduction" role="tab" aria-controls="pills-introduction"
                                    aria-selected="true">Introduction</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-conference-tab" data-toggle="pill"
                                    href="#pills-conference" role="tab" aria-controls="pills-conference"
                                    aria-selected="false">Conference
                                    Highlight</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-conference-registration-rate-tab" data-toggle="pill"
                                    href="#pills-conference-registration-rate" role="tab"
                                    aria-controls="pills-conference-registration-rate" aria-selected="false">Conference
                                    Registration Rate</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-annual-general-meeting-tab" data-toggle="pill"
                                    href="#pills-annual-general-meeting" role="tab"
                                    aria-controls="pills-annual-general-meeting" aria-selected="false">A-PBA Annual
                                    General Meeting (AGM)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-who-should-attend-tab" data-toggle="pill"
                                    href="#pills-who-should-attend" role="tab"
                                    aria-controls="pills-who-should-attend" aria-selected="false">Who Should Attend</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-pre-conference-workshop-tab" data-toggle="pill"
                                    href="#pills-pre-conference-workshop" role="tab"
                                    aria-controls="pills-pre-conference-workshop" aria-selected="false">Pre-Conference
                                    Workshop, Conference Program & Visa Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-biosafety-professional-certification-tab"
                                    data-toggle="pill" href="#pills-biosafety-professional-certification" role="tab"
                                    aria-controls="pills-biosafety-professional-certification" aria-selected="false">IFBA
                                    Biosafety Professional Certification Course & Examination</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-poster-submission-tab" data-toggle="pill"
                                    href="#pills-poster-submission" role="tab"
                                    aria-controls="pills-poster-submission" aria-selected="false">Poster Submission</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-featured-speakers-tab" data-toggle="pill"
                                    href="#pills-featured-speakers" role="tab"
                                    aria-controls="pills-featured-speakers" aria-selected="false">Featured Speakers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-hotel-venue-tab" data-toggle="pill"
                                    href="#pills-hotel-venue" role="tab" aria-controls="pills-hotel-venue"
                                    aria-selected="false">Hotel Venue & Accommodation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-sponsorship-exhibition-tab" data-toggle="pill"
                                    href="#pills-sponsorship-exhibition" role="tab"
                                    aria-controls="pills-sponsorship-exhibition" aria-selected="false">Sponsorship &
                                    Exhibition</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-photo-gallery-tab" data-toggle="pill"
                                    href="#pills-photo-gallery" role="tab" aria-controls="pills-photo-gallery"
                                    aria-selected="false">Photo Gallery</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-introduction" role="tabpanel"
                                aria-labelledby="pills-introduction-tab">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">Introduction :</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Title
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="introduction_title" id="introduction_title"
                                                    type="text" required value="{{ old('introduction_title') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="introduction_tab" id="introduction_tab"
                                                    type="text" required value="{{ old('introduction_tab') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class="form-control-label">
                                                Description
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field">
                                                <textarea class="form-control" name="introduction_desc" id="introduction_desc" rows="5" required>{{ old('introduction_desc') }}</textarea>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="tab-pane fade" id="pills-conference" role="tabpanel"
                                aria-labelledby="pills-conference-tab">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">Conference Highlight :</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="conference_highlight_tab"
                                                    id="conference_highlight_tab" type="text"
                                                    value="{{ old('conference_highlight_tab') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Title
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="conference_highlight_title"
                                                    id="conference_highlight_title" type="text"
                                                    value="{{ old('conference_highlight_title') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class="form-control-label">
                                                Description
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field">
                                                <textarea class="form-control" name="conference_highlight_desc" id="conference_highlight_desc" rows="5">{{ old('conference_highlight_desc') }}</textarea>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="tab-pane fade" id="pills-conference-registration-rate" role="tabpanel"
                                aria-labelledby="pills-conference-registration-rate-tab">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">Conference Registration Rate :</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="conference_registration_rate_tab"
                                                    id="conference_registration_rate_tab" type="text" required
                                                    value="{{ old('conference_registration_rate_tab') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Title
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="conference_registration_rate_title"
                                                    id="conference_registration_rate_title" type="text" required
                                                    value="{{ old('conference_registration_rate_title') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Description
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <input id="conference_registration_rate_desc"
                                                name="conference_registration_rate_desc" type="hidden" />
                                            <input id="conference_registration_rate_desc_data" type="hidden"
                                                name="conference_registration_rate_desc_data" />
                                            <div id="conference_registration_rate_gjs"></div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="tab-pane fade" id="pills-annual-general-meeting" role="tabpanel"
                                aria-labelledby="pills-annual-general-meeting-tab">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">A-PBA Annual
                                        General Meeting (AGM)</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="pills_annual_general_meeting_tab"
                                                    id="pills_annual_general_meeting_tab" type="text"
                                                    value="{{ old('pills_annual_general_meeting_tab') }}"></span>
                                        </div>
                                    </div>
                                </fieldset>

                            </div>
                            <div class="tab-pane fade" id="pills-who-should-attend" role="tabpanel"
                                aria-labelledby="pills-who-should-attend-tab">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">Who Should Attend :</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="who_should_attend_tab"
                                                    id="who_should_attend_tab" type="text"
                                                    value="{{ old('who_should_attend_tab') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Title
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="who_should_attend_title"
                                                    id="who_should_attend_title"
                                                    value="{{ old('who_should_attend_title') }}" type="text"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Description
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <input id="who_should_attend_title_desc" name="who_should_attend_title_desc"
                                                type="hidden" />
                                            <input id="who_should_attend_title_desc_data" type="hidden"
                                                name="who_should_attend_title_desc_data" />
                                            <div id="who_should_attend_title_desc_gjs"></div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="tab-pane fade" id="pills-pre-conference-workshop" role="tabpanel"
                                aria-labelledby="pills-pre-conference-workshop-tab">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">Pre-Conference Workshop, Conference Program & Visa
                                        Information :</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="pre_conference_workshop_tab"
                                                    id="pre_conference_workshop_tab"
                                                    value="{{ old('pre_conference_workshop_tab') }}"
                                                    type="text"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Title
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="pre_conference_workshop_title"
                                                    id="pre_conference_workshop_title" type="text"
                                                    value="{{ old('pre_conference_workshop_title') }}"></span>
                                        </div>
                                    </div>
                                    <div class="custom-border" id="pre_conference_workshop_add_more_container">
                                        <input type="hidden" name="pre_conference_workshop_add_more_count"
                                            value="1" id="pre_conference_workshop_add_more_count" />
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-primary float-right"
                                                    onclick="addPreConWorkShop()"> Add More </button>
                                            </div>
                                        </div>

                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Title
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="pre_conference_workshop_title_1"
                                                    id="pre_conference_workshop_title_1" class="form-control"
                                                    value="{{ old('pre_conference_workshop_title_1') }}" />
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Button Name
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="pre_conference_workshop_btn_1"
                                                    id="pre_conference_workshop_btn_1" class="form-control"
                                                    value="{{ old('pre_conference_workshop_btn_1') }}" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label class="form-control-label"> PDF: </label>
                                            </div>
                                            <div class="col-sm-10">
                                                <div style="width:70%;float:left">
                                                    <span class="pr-field"><input type="text"
                                                            id="pre_conference_workshop_image_1"
                                                            name="pre_conference_workshop_image_1" class="form-control"
                                                            value="" readonly=""
                                                            style="margin-bottom:15px"></span>
                                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                        data-target="#showsModal" data-toggle="modal"
                                                        onclick="setModalClickBtnId(document.getElementById('pre_conference_workshop_image_1'),'','','','pdf');">
                                                        Select or upload Pdf </div>
                                                </div>
                                                <div style="width: 20%;float:right">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="pre_conference_workshop_image_1_preview" height="100px"
                                                        width="auto">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                            <div class="tab-pane fade" id="pills-biosafety-professional-certification" role="tabpanel"
                                aria-labelledby="pills-biosafety-professional-certification-tab">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">IFBA Biosafety Professional Certification Course &
                                        Examination:</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="biosafety_professional_certification_tab"
                                                    id="biosafety_professional_certification_tab" type="text"
                                                    value="{{ old('biosafety_professional_certification_tab') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Title
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="biosafety_professional_certification_title"
                                                    id="biosafety_professional_certification_title" type="text"
                                                    value="{{ old('biosafety_professional_certification_title') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class="form-control-label">Image: </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <div style="width:70%;float:left">
                                                <span class="pr-field"><input type="text"
                                                        id="biosafety_professional_certification_image"
                                                        name="biosafety_professional_certification_image"
                                                        class="form-control" value="" readonly=""
                                                        style="margin-bottom:15px"></span>
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('biosafety_professional_certification_image'));">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 20%;float:right">
                                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="biosafety_professional_certification_image_preview" height="100px"
                                                    width="auto">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="custom-border"
                                        id="biosafety_professional_certification_add_more_container">
                                        <input type="hidden" name="biosafety_professional_certification_add_more_count"
                                            value="1" id="biosafety_professional_certification_add_more_count" />
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-primary float-right"
                                                    onclick="addBioProfCer()"> Add More </button>
                                            </div>
                                        </div>

                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Title
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="biosafety_professional_certification_title_1"
                                                    id="biosafety_professional_certification_title_1" class="form-control"
                                                    value="{{ old('biosafety_professional_certification_title_1') }}" />
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Button Name
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="biosafety_professional_certification_btn_1"
                                                    id="biosafety_professional_certification_btn_1" class="form-control"
                                                    value="{{ old('biosafety_professional_certification_btn_1') }}" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label class="form-control-label"> PDF: </label>
                                            </div>
                                            <div class="col-sm-10">
                                                <div style="width:70%;float:left">
                                                    <span class="pr-field"><input type="text"
                                                            id="biosafety_professional_certification_image_1"
                                                            name="biosafety_professional_certification_image_1"
                                                            class="form-control" value="" readonly=""
                                                            style="margin-bottom:15px"></span>
                                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                        data-target="#showsModal" data-toggle="modal"
                                                        onclick="setModalClickBtnId(document.getElementById('biosafety_professional_certification_image_1'));">
                                                        Select or upload PDF </div>
                                                </div>
                                                <div style="width: 20%;float:right">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="biosafety_professional_certification_image_1_preview"
                                                        height="100px" width="auto">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="tab-pane fade" id="pills-poster-submission" role="tabpanel"
                                aria-labelledby="pills-poster-submission-tab">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">Poster Submission:</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="poster_submission_tab"
                                                    id="poster_submission_tab" value="{{ old('poster_submission_tab') }}"
                                                    type="text"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Title
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="poster_submission_title"
                                                    id="poster_submission_title"
                                                    value="{{ old('poster_submission_title') }}" type="text"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <div class="col-md-2"><label class="form-control-label"> Description
                                            </label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea name="poster_submission_desc" id="poster_submission_desc" class="form-control">{{ old('poster_submission_desc') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <div class="col-md-2"><label class="form-control-label"> Button Name
                                            </label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" name="poster_submission_button"
                                                id="poster_submission_button" class="form-control"
                                                value="{{ old('poster_submission_button') }}" />
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <div class="col-md-2"><label class="form-control-label"> Button Link
                                            </label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="url" name="poster_submission_button_link"
                                                id="poster_submission_button_link" class="form-control"
                                                value="{{ old('poster_submission_button_link') }}" />
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                            <div class="tab-pane fade" id="pills-featured-speakers" role="tabpanel"
                                aria-labelledby="pills-featured-speakers-tab">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">Featured Speakers</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="featured_speakers_tab"
                                                    id="featured_speakers_tab" type="text"
                                                    value="{{ old('featured_speakers_tab') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Title
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="featured_speakers_title"
                                                    id="featured_speakers_title"
                                                    value="{{ old('featured_speakers_title') }}" type="text"></span>
                                        </div>
                                    </div>
                                    <div class="custom-border" id="featured_speakers_add_more_container">
                                        <input type="hidden" name="featured_speakers_add_more_count" value="1"
                                            id="featured_speakers_add_more_count" />
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-primary float-right"
                                                    onclick="addspeakers()"> Add More </button>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Name
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="featured_speaker_name_1"
                                                    id="featured_speaker_name_1" class="form-control"
                                                    value="{{ old('featured_speaker_name_1') }}" />
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Designation
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="featured_speaker_designation_1"
                                                    id="featured_speaker_designation_1" class="form-control"
                                                    value="{{ old('featured_speaker_designation_1') }}" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label class="form-control-label"> Image: </label>
                                            </div>
                                            <div class="col-sm-10">
                                                <div style="width:70%;float:left">
                                                    <span class="pr-field"><input type="text"
                                                            id="featured_speaker_image_1" name="featured_speaker_image_1"
                                                            class="form-control" value="" readonly=""
                                                            style="margin-bottom:15px"></span>
                                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                        data-target="#showsModal" data-toggle="modal"
                                                        onclick="setModalClickBtnId(document.getElementById('featured_speaker_image_1'));">
                                                        Select or upload Image </div>
                                                </div>
                                                <div style="width: 20%;float:right">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="featured_speaker_image_1_preview" height="100px"
                                                        width="auto">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2 mb-2">
                                            <textarea name="featured_speaker_desc_1" id="featured_speaker_desc_1">{{ old('featured_speaker_desc_1') }}</textarea>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label class="form-control-label">Speaker Description Image: </label>
                                            </div>
                                            <div class="col-sm-10">
                                                <div style="width:70%;float:left">
                                                    <span class="pr-field"><input type="text"
                                                            id="featured_speaker_desc_1_image_1"
                                                            name="featured_speaker_desc_1_image_1" class="form-control"
                                                            value="" readonly=""
                                                            style="margin-bottom:15px"></span>
                                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                        data-target="#showsModal" data-toggle="modal"
                                                        onclick="setModalClickBtnId(document.getElementById('featured_speaker_desc_1_image_1'));">
                                                        Select or upload Image </div>
                                                </div>
                                                <div style="width: 20%;float:right">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="featured_speaker_desc_1_image_1_preview" height="100px"
                                                        width="auto">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12 mt-2 mb-2">
                                                <button type="button" class="btn btn-primary float-right"
                                                    onclick="addMoreSpeakerImages('1')">Add More Desc Images</button>
                                            </div>
                                        </div>
                                        <div id="featured_speaker_desc_1_image_container">
                                            <input type="hidden" name="featured_speaker_desc_1_image_length"
                                                id="featured_speaker_desc_1_image_length" value="1">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="tab-pane fade" id="pills-hotel-venue" role="tabpanel"
                                aria-labelledby="pills-hotel-venue-tab">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">Hotel Venue & Accommodation :</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="hotel_venue_tab" id="hotel_venue_tab"
                                                    type="text" required value="{{ old('hotel_venue_tab') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Title
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="hotel_venue_title" id="hotel_venue_title"
                                                    type="text" required
                                                    value="{{ old('hotel_venue_title') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class="form-control-label"> Image: </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <div style="width:70%;float:left">
                                                <span class="pr-field"><input type="text" id="hotel_venue_image"
                                                        name="hotel_venue_image" class="form-control" value=""
                                                        readonly="" required style="margin-bottom:15px"></span>
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('hotel_venue_image'));">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 20%;float:right">
                                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="hotel_venue_image_preview" height="100px" width="auto">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class="form-control-label">
                                                Address
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field">
                                                <textarea class="form-control" name="hotel_venue_address" id="hotel_venue_address" rows="5" required>{{ old('hotel_venue_address') }}</textarea>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tel
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="hotel_venue_tel" id="hotel_venue_tel"
                                                    type="number" required value="{{ old('hotel_venue_tel') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Reservation
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="hotel_venue_reservation"
                                                    id="hotel_venue_reservation" required type="text"
                                                    value="{{ old('hotel_venue_reservation') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Fax
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="hotel_venue_fax" id="hotel_venue_fax"
                                                    type="text" required value="{{ old('hotel_venue_fax') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Website Link
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="hotel_venue_web_link" id="hotel_venue_web_link"
                                                    type="text" required
                                                    value="{{ old('hotel_venue_web_link') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class="form-control-label">
                                                Description
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field">
                                                <textarea class="form-control" name="hotel_venue_description" id="hotel_venue_description" rows="5" required>{{ old('hotel_venue_description') }}</textarea>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="tab-pane fade" id="pills-sponsorship-exhibition" role="tabpanel"
                                aria-labelledby="pills-sponsorship-exhibition-tab">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">Sponsorship & Exhibition :</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="sponsorship_exhibition_tab"
                                                    id="sponsorship_exhibition_tab"
                                                    value="{{ old('sponsorship_exhibition_tab') }}"
                                                    type="text"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Title
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="sponsorship_exhibition_title"
                                                    id="sponsorship_exhibition_title"
                                                    value="{{ old('sponsorship_exhibition_title') }}"
                                                    type="text"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class="form-control-label">
                                                Description
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field">
                                                <textarea class="form-control" name="sponsorship_exhibition_desc" id="sponsorship_exhibition_desc" rows="5">{{ old('sponsorship_exhibition_desc') }}</textarea>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="custom-border" id="sponsorship_exhibition_add_more_container">
                                        <input type="hidden" name="sponsorship_exhibition_add_more_count" value="1"
                                            id="sponsorship_exhibition_add_more_count" />
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-primary float-right"
                                                    onclick="addsponsership()"> Add More </button>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Title
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="sponsorship_exhibition_title_1"
                                                    id="sponsorship_exhibition_title_1" class="form-control"
                                                    value="{{ old('sponsorship_exhibition_title_1') }}" />
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Button Name
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="sponsorship_exhibition_btn_1"
                                                    id="sponsorship_exhibition_btn_1" class="form-control"
                                                    value="{{ old('sponsorship_exhibition_btn_1') }}" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label class="form-control-label"> Image: </label>
                                            </div>
                                            <div class="col-sm-10">
                                                <div style="width:70%;float:left">
                                                    <span class="pr-field"><input type="text"
                                                            id="sponsorship_exhibition_image_1"
                                                            name="sponsorship_exhibition_image_1" class="form-control"
                                                            value="" readonly=""
                                                            style="margin-bottom:15px"></span>
                                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                        data-target="#showsModal" data-toggle="modal"
                                                        onclick="setModalClickBtnId(document.getElementById('sponsorship_exhibition_image_1'));">
                                                        Select or upload Image </div>
                                                </div>
                                                <div style="width: 20%;float:right">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="sponsorship_exhibition_image_1_preview" height="100px"
                                                        width="auto">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                            <div class="tab-pane fade" id="pills-photo-gallery" role="tabpanel"
                                aria-labelledby="pills-photo-gallery-tab">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">Photo Gallery :</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="photo_gallery_tab" id="photo_gallery_tab"
                                                    type="text" value="{{ old('photo_gallery_tab') }}"></span>
                                        </div>
                                    </div>
                                    <div class="fv-row">
                                        <!--begin::Dropzone-->
                                        <div class="dropzone" id="dropzonejs_gallery">
                                            <!--begin::Message-->
                                            <div class="dz-message needsclick">
                                                <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                        class="path1"></span><span class="path2"></span></i>

                                                <!--begin::Info-->
                                                <div class="ms-4">
                                                    <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click
                                                        to
                                                        upload.</h3>
                                                    <span class="fs-7 fw-semibold text-gray-400">Upload up to 30
                                                        files</span>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                        </div>
                                        <!--end::Dropzone-->
                                    </div>

                                </fieldset>



                            </div>
                        </div>
                    </div>

                    <div id="end-content">
                        <div class="col-md-12">
                            <div class="form-group row" style="margin-top: 20px;padding-bottom: 5px;margin-left:7px;">
                                <button class="btn btn-warning" type="submit" name="submit" value="0"
                                    id="draft_btn">
                                    Draft </button>
                                <button class="btn btn-success" type="submit" name="submit" value="1"
                                    id="submit_btn" style="margin-left:20px;">
                                    Save
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
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('assets/dashboard/dropzone/dropzone.js') }}"></script>
    <script>
        let gallary_images = [];
        $(document).ready(function() {
            $("#start_date").datepicker({
                minDate: ('0'),
                dateFormat: 'yy-mm-dd',
                onSelect: function(date) {
                    var date2 = $('#start_date').datepicker('getDate');
                    // date2.setDate(date2.getDate() + 1);
                    date2.setDate(date2.getDate());
                    $('#end_date').datepicker('setDate', date2);
                    //sets minDate to dt1 date + 1
                    $('#end_date').datepicker('option', 'minDate', date2);
                },
            });
            $("#end_date").datepicker({
                minDate: ('0'),
                dateFormat: 'yy-mm-dd',
                onClose: function() {
                    var dt1 = $('#start_date').datepicker('getDate');
                    var dt2 = $('#end_date').datepicker('getDate');
                    //check to prevent a user from entering a date below date of dt1
                    if (dt2 <= dt1) {
                        var minDate = $('#end_date').datepicker('option', 'minDate');
                        $('#end_date').datepicker('setDate', minDate);
                    }
                }
            });
            CKEDITOR.replace('hotel_venue_description', {
                filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
            CKEDITOR.replace('featured_speaker_desc_1', {
                filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
            CKEDITOR.replace('conference_highlight_desc', {
                filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
            Dropzone.autoDiscover = false;
            grapejsInitialize('conference_registration_rate_desc', 'conference_registration_rate_desc_data',
                'conference_registration_rate_gjs');
            grapejsInitialize('who_should_attend_title_desc', 'who_should_attend_title_desc_data',
                'who_should_attend_title_desc_gjs');

        });
        var myDropzone = new Dropzone("#dropzonejs_gallery", {
            url: "{{ route('drop-zone-file-upload', ['_token' => csrf_token()]) }}",
            paramName: "file",
            method: "POST",
            maxFilesize: 30,
            acceptedFiles: ".jpeg,.jpg,.png,.gif"
        });
        myDropzone.on("error", function(file) {
            if (file.type != 'jpeg' || file.type != 'jpg' || file.type != 'png' || file.type != 'gif') {
                this.removeFile(file);
            }
        });
        myDropzone.on("addedfile", function() {
            if (this.files[30] != null) {
                this.removeFile(this.files[30]);
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Maximum 30 files can be uploaded',
                });
            }
        });
        myDropzone.on("success", function({
            xhr
        }) {
            let gallary_images_arr = JSON.parse(xhr.response);
            gallary_images.push(gallary_images_arr.success)
            $('#gallery_images').val(JSON.stringify(gallary_images));
        });

        let workshop_count = 1;
        let bio_prof_cer_count = 1;
        let speaker_count = 1;
        let sponser_count = 1;
        let addBioProfCer = () => {
            bio_prof_cer_count++;
            $('#biosafety_professional_certification_add_more_container').append(`
            <div class="bio-prof-sec">
            <div class="form-group row">
                                            <div class="col-md-2"><label class="form-control-label"> Title
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="biosafety_professional_certification_title_${bio_prof_cer_count}" id="biosafety_professional_certification_title_${bio_prof_cer_count}" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Button Name
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="biosafety_professional_certification_btn_${bio_prof_cer_count}" id="biosafety_professional_certification_btn_${bio_prof_cer_count}" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label class="form-control-label"> PDF:  </label>
                                            </div>
                                            <div class="col-sm-10">
                                                <div style="width:70%;float:left">
                                                    <span class="pr-field"><input type="text" id="biosafety_professional_certification_image_${bio_prof_cer_count}"
                                                            name="biosafety_professional_certification_image_${bio_prof_cer_count}" class="form-control" value=""
                                                            readonly="" style="margin-bottom:15px"></span>
                                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                        data-target="#showsModal" data-toggle="modal"
                                                        onclick="setModalClickBtnId(document.getElementById('biosafety_professional_certification_image_${bio_prof_cer_count}','','','','pdf'));">
                                                        Select or upload Pdf </div>
                                                </div>
                                                <div style="width: 20%;float:right">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="biosafety_professional_certification_image_${bio_prof_cer_count}_preview" height="100px" width="auto">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-danger" onclick="$(this).closest('.bio-prof-sec').remove();"> Remove </button>
                                            </div>
                                        </div></div>`);
            $('#biosafety_professional_certification_add_more_count').val(bio_prof_cer_count);
        }
        let addPreConWorkShop = () => {
            workshop_count++;
            $('#pre_conference_workshop_add_more_container').append(`
            <div class="workshop-sec"> 
            <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Title
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="pre_conference_workshop_title_${workshop_count}" id="pre_conference_workshop_title_${workshop_count}" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Button Name
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="pre_conference_workshop_btn_${workshop_count}" id="pre_conference_workshop_btn_${workshop_count}" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label class="form-control-label"> PDF:  </label>
                                            </div>
                                            <div class="col-sm-10">
                                                <div style="width:70%;float:left">
                                                    <span class="pr-field"><input type="text" id="pre_conference_workshop_image_${workshop_count}"
                                                            name="pre_conference_workshop_image_${workshop_count}" class="form-control" value=""
                                                            readonly="" style="margin-bottom:15px"></span>
                                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                        data-target="#showsModal" data-toggle="modal"
                                                        onclick="setModalClickBtnId(document.getElementById('pre_conference_workshop_image_${workshop_count}'),'','','','pdf');">
                                                        Select or upload Pdf </div>
                                                </div>
                                                <div style="width: 20%;float:right">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="pre_conference_workshop_image_${workshop_count}_preview" height="100px" width="auto">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-danger" onclick="$(this).closest('.workshop-sec').remove();"> Remove </button>
                                            </div>
                                        </div></div>`);
            $('#pre_conference_workshop_add_more_count').val(workshop_count);
        }
        let addspeakers = () => {
            speaker_count++;
            $('#featured_speakers_add_more_container').append(`
            <div class="speaker-sec">
                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Name
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="featured_speaker_name_${speaker_count}"
                                                    id="featured_speaker_name_${speaker_count}"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Designation
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="featured_speaker_designation_${speaker_count}"
                                                    id="featured_speaker_designation_${speaker_count}"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label class="form-control-label"> Image: </label>
                                            </div>
                                            <div class="col-sm-10">
                                                <div style="width:70%;float:left">
                                                    <span class="pr-field"><input type="text"
                                                            id="featured_speaker_image_${speaker_count}"
                                                            name="featured_speaker_image_${speaker_count}"
                                                            class="form-control" value="" readonly=""
                                                            style="margin-bottom:15px"></span>
                                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                        data-target="#showsModal" data-toggle="modal"
                                                        onclick="setModalClickBtnId(document.getElementById('featured_speaker_image_${speaker_count}'));">
                                                        Select or upload Image </div>
                                                </div>
                                                <div style="width: 20%;float:right">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="featured_speaker_image_${speaker_count}_preview"
                                                        height="100px" width="auto">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2 mb-2">
                                                <textarea name="featured_speaker_desc_${speaker_count}" id="featured_speaker_desc_${speaker_count}"></textarea>    
                                            </div>

                                            
                                        </div><div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label class="form-control-label">Speaker Description Image: </label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <div style="width:70%;float:left">
                                                        <span class="pr-field"><input type="text"
                                                                id="featured_speaker_desc_${speaker_count}_image_1"
                                                                name="featured_speaker_desc_${speaker_count}_image_1" class="form-control"
                                                                value="" readonly=""
                                                                style="margin-bottom:15px"></span>
                                                        <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                            data-target="#showsModal" data-toggle="modal"
                                                            onclick="setModalClickBtnId(document.getElementById('featured_speaker_desc_${speaker_count}_image_1'));">
                                                            Select or upload Image </div>
                                                    </div>
                                                    <div style="width: 20%;float:right">
                                                        <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                            id="featured_speaker_desc_${speaker_count}_image_1_preview" height="100px"
                                                            width="auto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12 mt-2 mb-2">
                                                    <button type="button" class="btn btn-primary float-right"
                                                        onclick="addMoreSpeakerImages('${speaker_count}')">Add More Desc Images</button>
                                                </div>
                                            </div>
                                        
                                            <div id="featured_speaker_desc_${speaker_count}_image_container">
                                                <input type="hidden" name="featured_speaker_desc_${speaker_count}_image_length" id="featured_speaker_desc_${speaker_count}_image_length" value="1">
                                            </div>

                                            <div class="col-md-12 mt-2 mb-2">
                                                <button type="button" class="btn btn-danger" onclick="$(this).closest('.speaker-sec').remove();"> Remove </button>
                                            </div></div>`);

            CKEDITOR.replace(`featured_speaker_desc_${speaker_count}`, {
                filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
            $('#featured_speakers_add_more_count').val(speaker_count);
        }
        let addsponsership = () => {
            sponser_count++;
            $('#sponsorship_exhibition_add_more_container').append(`
            <div class="sponser-sec">
            <div class="form-group row">
                                            <div class="col-md-2"><label class="form-control-label"> Title
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="sponsorship_exhibition_title_${sponser_count}" id="sponsorship_exhibition_title_${sponser_count}" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <div class="col-md-2"><label class="form-control-label"> Button Name
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="sponsorship_exhibition_btn_${sponser_count}" id="sponsorship_exhibition_btn_${sponser_count}" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label class="form-control-label"> PDF:  </label>
                                            </div>
                                            <div class="col-sm-10">
                                                <div style="width:70%;float:left">
                                                    <span class="pr-field"><input type="text" id="sponsorship_exhibition_image_${sponser_count}"
                                                            name="sponsorship_exhibition_image_${sponser_count}" class="form-control" value=""
                                                            readonly="" style="margin-bottom:15px"></span>
                                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                        data-target="#showsModal" data-toggle="modal"
                                                        onclick="setModalClickBtnId(document.getElementById('sponsorship_exhibition_image_${sponser_count}','','','','pdf'));">
                                                        Select or upload Pdf </div>
                                                </div>
                                                <div style="width: 20%;float:right">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="sponsorship_exhibition_image_${sponser_count}_preview" height="100px" width="auto">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-danger" onclick="$(this).closest('.sponser-sec').remove();"> Remove </button>
                                            </div>
                                        </div></div>`);
            $('#sponsorship_exhibition_add_more_count').val(sponser_count);
        }

        let addMoreSpeakerImages = (divcounter) => {
            let flag_count = $(`#featured_speaker_desc_${divcounter}_image_length`).val();
            flag_count = (parseInt(flag_count) + 1);
            $(`#featured_speaker_desc_${divcounter}_image_container`).append(`<div class="form-group row speaker-desc-image">
                                            <div class="col-sm-2">
                                                <label class="form-control-label">Speaker Description Image: </label>
                                            </div>
                                            <div class="col-sm-10">
                                                <div style="width:70%;float:left">
                                                    <span class="pr-field"><input type="text"
                                                            id="featured_speaker_desc_${divcounter}_image_${flag_count}" name="featured_speaker_desc_${divcounter}_image_${flag_count}"
                                                            class="form-control" value="" readonly=""
                                                            style="margin-bottom:15px"></span>
                                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                        data-target="#showsModal" data-toggle="modal"
                                                        onclick="setModalClickBtnId(document.getElementById('featured_speaker_desc_${divcounter}_image_${flag_count}'));">
                                                        Select or upload Image </div>
                                                </div>
                                                <div style="width: 20%;float:right">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="featured_speaker_desc_${divcounter}_image_${flag_count}_preview" height="100px"
                                                        width="auto">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-danger" onclick="$(this).closest('.speaker-desc-image').remove();"> Remove </button>
                                            </div>
                                        </div>`);
            $(`#featured_speaker_desc_${divcounter}_image_length`).val(flag_count);
        }
    </script>
@endpush
