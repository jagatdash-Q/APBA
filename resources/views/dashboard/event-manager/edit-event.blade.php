@extends('dashboard.layouts.master')
@section('title', __('Edit Event'))
@section('content')
    @push('after-styles')
        <style>
            .card-header {
                cursor: pointer;
            }

            .card .card-header[data-toggle="collapse"]::after {
                color: #4e73df;
                content: '\f077';
            }

            .card .card-header[data-toggle="collapse"].collapsed::after {
                color: #4e73df;
                content: '\f078';
            }

            .del_icon {
                width: 50px;
                margin-left: -30px;
                margin-right: 10px;
                color: red;
                cursor: pointer;
            }

            .speaker-sec {
                padding: 10px;
                border: 1px solid rgba(0, 0, 0, .4) !important;
                border-radius: 10px;
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
                <h3>{{ __('Edit Event') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a>
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
                <form action="{{ route('admin.event.update') }}" method="post" enctype="multipart/form-data"
                    onsubmit="return validateEvent();">
                    @csrf
                    <div class="pt-2">
                        <input type="hidden" name="page_type" id="page_type" value="events">
                        <input type="hidden" name="event_id" id="event_id" value="{{ $events->id }}">
                        <input type="hidden" name="base_url" id="base_url" value="{{ url('') }}">
                        <input type="hidden" name="gallery_images" id="gallery_images" value="">
                        <input type="hidden" name="sorting_len" id="sorting_len" value="">
                        <input type="hidden" name="total_add_more_sec" id="total_add_more_sec"
                            value="{{ count($events->getEventTabs) }}">
                    </div>
                    <div id="main">
                        <div class="container">
                            <div class="card mb-2">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">Event Info :</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> Event Name
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                    name="event_name" id="event_name" type="text"
                                                    oninput="generatePageSlug(this.value,'event_slug','events','draft_btn','submit_btn','{{ $events->event_name }}')"
                                                    value="{{ old('event_name', $events->event_name) }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class=" form-control-label"> Event Slug </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                    name="event_slug" id="event_slug" type="text"
                                                    value="{{ old('event_name', $events->event_slug) }}" readonly></span>
                                            <span id="event_slug_error"> </span>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class=" form-control-label"> Meta Title </label>
                                        </div>
                                        <div class="col-sm-10"> <span class="pr-field"><input placeholder=""
                                                    class="form-control" dir="ltr" name="meta_title" id="meta_title"
                                                    type="text"
                                                    value="{{ old('event_name', $events->meta_title) }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class=" form-control-label"> Meta Keyword </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                    name="meta_keyword" id="meta_keyword" type="text"
                                                    value="{{ old('meta_keyword', $events->meta_keywords) }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class=" form-control-label"> Meta
                                                Description
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="meta_description" id="meta_description"
                                                    type="text"
                                                    value="{{ old('meta_description', $events->meta_desc) }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class="form-control-label"> Event Start date
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="start_date" id="start_date" type="text"
                                                    onkeydown="event.preventDefault()" autocomplete="off"
                                                    value="{{ old('start_date', $events->start_date) }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class=" form-control-label"> Event End date
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="end_date" id="end_date" type="text"
                                                    onkeydown="event.preventDefault()" autocomplete="off"
                                                    value="{{ old('end_date', $events->end_date) }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class=" form-control-label"> Publish Date
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="publish_date" id="publish_date" type="text"
                                                    onkeydown="event.preventDefault()" autocomplete="off"
                                                    value="{{ old('publish_date',$events->publish_date) }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class="form-control-label"> Event Location
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="event_location" id="event_location"
                                                    type="text"
                                                    value="{{ old('event_location', $events->event_location) }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class="form-control-label">Featured Image: </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <div style="width:70%;float:left">
                                                <span class="pr-field">
                                                    @if ($events->getFeaturedImage != null)
                                                        <input type="text" id="featured_image" name="featured_image"
                                                            class="form-control"
                                                            value="{{ $events->getFeaturedImage->file_name }}"
                                                            readonly="" style="margin-bottom:15px">
                                                    @else
                                                        <input type="text" id="featured_image" name="featured_image"
                                                            class="form-control" value="" readonly=""
                                                            style="margin-bottom:15px">
                                                    @endif

                                                </span>
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('featured_image'));">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 30%;float:right; text-align: center;">
                                                @if ($events->getFeaturedImage != null)
                                                    <img src="{{ asset('') }}{{ $events->getFeaturedImage->path }}"
                                                        id="featured_image_preview" style="width: 160px; height: auto;">
                                                @else
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="featured_image_preview" style="width: 160px; height: auto;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class="form-control-label"> Event Status
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            @if ($events->status == '1')
                                                <a href="javascript:void();" style="pointer-events: none;cursor:none;"
                                                    class="btn btn-success btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Active</span>
                                                </a>
                                            @else
                                                <a href="javascript:void();" class="btn btn-warning btn-icon-split" style="pointer-events: none;cursor:none;">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </span>
                                                    <span class="text">Inactive</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div id="accordion" class="accordion-sort">

                                @foreach ($events->getEventTabs as $ind => $val)
                                    @if ($val->tab_type == 'gallery')
                                        <div class="card mb-2 main-container">
                                            <div class="d-flex align-items-center">
                                                <div class="card-header w-100 mr-3 collapsed" id="headingThree"
                                                    data-toggle="collapse" data-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    <h4 class="m-0"><i class="fas fa-arrows-alt mr-3"></i><span
                                                            id="photography_tab_name"
                                                            name="photography_tab_name">{{ $val->tab_name }}</span></h4>
                                                    <input type="hidden" class="sort-val" name="sort_no_photo_graphy"
                                                        id="sort_no_photo_graphy" value="{{ $val->tab_sort_order }}" />
                                                    <input type="hidden" name="photo_graphy_tab_id"
                                                        id="photo_graphy_tab_id" value="{{ $val->id }}" />
                                                </div>
                                                <div class="text-center">

                                                </div>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                                data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-md-2"> <label class="form-control-label"> Tab Name
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <span class="pr-field"><input placeholder=""
                                                                    class="form-control tab-name" dir="ltr"
                                                                    name="photo_gallery_tab" id="photo_gallery_tab"
                                                                    type="text" value="{{ $val->tab_name }}"
                                                                    oninput="changeTabName(this.value,'photography_tab_name')"></span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        @foreach ($events->getEventgallery as $dropzoneImg)
                                                            <div class="col-md-2">
                                                                <img src="{{ asset('dropzone') }}/{{ $dropzoneImg->image }}"
                                                                    height="100px" width="100px"><span class="close-img"
                                                                    onclick="deleteDropzoneImg('{{ $dropzoneImg->id }}');"></span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="fv-row">
                                                        <!--begin::Dropzone-->
                                                        <div class="dropzone" id="dropzonejs_gallery">
                                                            <!--begin::Message-->
                                                            <div class="dz-message needsclick">
                                                                <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                                        class="path1"></span><span
                                                                        class="path2"></span></i>

                                                                <!--begin::Info-->
                                                                <div class="ms-4">
                                                                    <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files
                                                                        here or
                                                                        click to
                                                                        upload.</h3>
                                                                    <span class="fs-7 fw-semibold text-gray-400">Upload up
                                                                        to {{ 30 - count($events->getEventgallery) }}
                                                                        files</span>
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                        </div>
                                                        <!--end::Dropzone-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($val->tab_type == 'speaker')
                                        <div class="card mb-2 main-container">
                                            <div class="d-flex align-items-center">
                                                <div class="card-header w-100 mr-3 collapsed" id="headingTwo"
                                                    data-toggle="collapse" data-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                    <h4 class="m-0"><i class="fas fa-arrows-alt mr-3"></i> <span
                                                            id="featured_speaker_tab_name"
                                                            name="featured_speaker_tab_name">{{ $val->tab_name }}</span>
                                                    </h4>
                                                    <input type="hidden" class="sort-val"
                                                        name="sort_no_featured_speaker" id="sort_no_featured_speaker"
                                                        value="{{ $val->tab_sort_order }}" />
                                                    <input type="hidden" name="featured_speaker_tab_id"
                                                        id="featured_speaker_tab_id" value="{{ $val->id }}" />
                                                </div>
                                                <div class="text-center">

                                                </div>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-md-2"> <label class="form-control-label">
                                                                Tab Name
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <span class="pr-field"><input placeholder=""
                                                                    class="form-control tab-name" dir="ltr"
                                                                    name="featured_speakers_tab"
                                                                    id="featured_speakers_tab" type="text"
                                                                    value="{{ $val->tab_name }}"
                                                                    oninput="changeTabName(this.value,'featured_speaker_tab_name')"></span>
                                                        </div>
                                                    </div>

                                                    <div class="custom-border" id="featured_speakers_add_more_container"
                                                        style="margin-top:10px;">
                                                        <input type="hidden" name="featured_speakers_add_more_count"
                                                            value="{{ count($events->getEventSpeakers) }}"
                                                            id="featured_speakers_add_more_count" />
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <button type="button" class="btn btn-primary float-right"
                                                                    onclick="addspeakers()"> Add More </button>
                                                            </div>
                                                        </div>

                                                        @foreach ($events->getEventSpeakers as $index => $spkr)
                                                            @php $index++; @endphp
                                                            <div class="speaker-sec">
                                                                <input type="hidden"
                                                                    name="featured_speaker_id_{{ $index }}"
                                                                    id="featured_speaker_id_{{ $index }}"
                                                                    value="{{ $spkr->id }}" />
                                                                <div class="form-group row ">
                                                                    <div class="col-md-2"><label
                                                                            class="form-control-label"> Name
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <input type="text"
                                                                            name="featured_speaker_name_{{ $index }}"
                                                                            id="featured_speaker_name_{{ $index }}"
                                                                            class="form-control"
                                                                            value="{{ $spkr->speaker_name }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row ">
                                                                    <div class="col-md-2"><label
                                                                            class="form-control-label"> Designation
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <input type="text"
                                                                            name="featured_speaker_designation_{{ $index }}"
                                                                            id="featured_speaker_designation_{{ $index }}"
                                                                            class="form-control"
                                                                            value="{{ $spkr->speaker_designation }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row ">
                                                                    <div class="col-md-2"><label
                                                                            class="form-control-label"> Speaker Image
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-sm-10">
                                                                        <div style="width:70%;float:left">
                                                                            <span class="pr-field"><input type="text"
                                                                                    id="featured_speaker_url_{{ $index }}"
                                                                                    name="featured_speaker_url_{{ $index }}"
                                                                                    class="form-control"
                                                                                    value="@if (isset($spkr->getSpeakerImage)) {{ $spkr->getSpeakerImage->file_name }} @endif"
                                                                                    readonly=""
                                                                                    style="margin-bottom:15px"></span>
                                                                            <div class="btn btn-success mt-2 btn-sm btn-round"
                                                                                id="banner" data-target="#showsModal"
                                                                                data-toggle="modal"
                                                                                onclick="setModalClickBtnId(document.getElementById('featured_speaker_url_{{ $index }}'));">
                                                                                Select or upload Image </div>
                                                                        </div>
                                                                        <div style="width: 20%;float:right">
                                                                            @if ($spkr->getSpeakerImage != null)
                                                                                <img src="{{ asset('') }}{{ $spkr->getSpeakerImage->path }}"
                                                                                    id="featured_speaker_url_{{ $index }}_preview"
                                                                                    height="100px" width="100px">
                                                                            @else
                                                                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                                                    id="featured_speaker_url_{{ $index }}_preview"
                                                                                    height="100px" width="auto">
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-12"> <label
                                                                            class="form-control-label"> Description:
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-12 no-drag">
                                                                        <input type="hidden"
                                                                            name="featured_speakers_desc_{{ $index }}"
                                                                            id="featured_speakers_desc_{{ $index }}"
                                                                            value="{{ $spkr->speaker_details }}" />
                                                                        <input type="hidden"
                                                                            name="featured_speakers_desc_data_{{ $index }}"
                                                                            id="featured_speakers_desc_data_{{ $index }}"
                                                                            value="{{ $spkr->speaker_details_data }}" />
                                                                        <div
                                                                            id="featured_speakers_gjs_{{ $index }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 mt-2 mb-2">
                                                                    <button type="button" class="btn btn-danger"
                                                                        onclick="removeSpeaker('{{ $spkr->id }}');">
                                                                        Remove </button>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        @php $ind++; @endphp
                                        <div class="card mb-2 main-container">
                                            <div class="d-flex align-items-center">
                                                <div class="card-header w-100 mr-3 collapsed" data-toggle="collapse"
                                                    data-target="#collapse_{{ $ind }}" aria-expanded="false"
                                                    aria-controls="heading_{{ $ind }}">
                                                    <h4 class="m-0"><i class="fas fa-arrows-alt mr-3"></i><span
                                                            id="tab_name_{{ $ind }}"
                                                            name="tab_name_{{ $ind }}">{{ $val->tab_name }}</span>
                                                    </h4>
                                                    <input type="hidden" class="sort-val"
                                                        name="sort_no_{{ $ind }}"
                                                        id="sort_no_{{ $ind }}"
                                                        value="{{ $val->tab_sort_order }}" />
                                                    <input type="hidden" name="tab_id_{{ $ind }}"
                                                        id="tab_id_{{ $ind }}" value="{{ $val->id }}" />
                                                </div>
                                                <div class="text-center">
                                                    <i class="del_icon material-icons"
                                                        onclick="deleteTab('{{ $val->id }}')">&#xe872;</i>
                                                </div>
                                            </div>
                                            <div id="collapse_{{ $ind }}" class="collapse"
                                                aria-labelledby="heading_{{ $ind }}" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-md-2">
                                                            <label for="tab_value_{{ $ind }}"> Title : </label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="text" name="tab_value_{{ $ind }}"
                                                                id="tab_value_{{ $ind }}"
                                                                oninput="changeText({{ $ind }},this.value)"
                                                                class="form-control tab-name"
                                                                value="{{ $val->tab_name }}" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row no-drag">
                                                        <input type="hidden" name="section_desc_{{ $ind }}"
                                                            id="section_desc_{{ $ind }}"
                                                            value="{{ $val->tab_desc }}" />
                                                        <input type="hidden"
                                                            name="section_desc_data_{{ $ind }}"
                                                            id="section_desc_data_{{ $ind }}"
                                                            value="{{ $val->tab_desc_data }}" />
                                                        <div id="section_gjs_{{ $ind }}"></div>
                                                    </div>
                                                    <div id="div_btn_container_{{ $ind }}"
                                                        class="div_btn_container">
                                                        <input type="hidden" name="total_btn_length_{{ $ind }}"
                                                            id="total_btn_length_{{ $ind }}"
                                                            value="{{ count($val->getTabButtons) }}" />

                                                        @foreach ($val->getTabButtons as $btn_len => $tb_btn)
                                                            @php $btn_len++; @endphp
                                                            <div class="row add-more-btn">
                                                                <input type="hidden"
                                                                    name="btn_id_{{ $ind }}_{{ $btn_len }}"
                                                                    id="btn_id_{{ $ind }}_{{ $btn_len }}"
                                                                    value="{{ $tb_btn->id }}" />
                                                                <div class="col-md-2 mt-1">
                                                                    <label> Button title </label>
                                                                </div>
                                                                <div class="col-md-10 mt-1">
                                                                    <input type="text"
                                                                        name="btn_title_{{ $ind }}_{{ $btn_len }}"
                                                                        id="btn_title_{{ $ind }}_{{ $btn_len }}"
                                                                        class="form-control"
                                                                        value="{{ $tb_btn->button_title }}" />
                                                                </div>
                                                                <div class="col-md-2 mt-1">
                                                                    <label> Button label </label>
                                                                </div>
                                                                <div class="col-md-10 mt-1">
                                                                    <input type="text"
                                                                        name="btn_label_{{ $ind }}_{{ $btn_len }}"
                                                                        id="btn_label_{{ $ind }}_{{ $btn_len }}"
                                                                        class="form-control"
                                                                        value="{{ $tb_btn->button_label }}" />
                                                                </div>
                                                                <div class="col-md-2 mt-1">
                                                                    <label> Button link </label>
                                                                </div>
                                                                <div class="col-md-10 mt-1">
                                                                    <input type="url"
                                                                        name="btn_link_{{ $ind }}_{{ $btn_len }}"
                                                                        id="btn_link_{{ $ind }}_{{ $btn_len }}"
                                                                        class="form-control"
                                                                        value="{{ $tb_btn->button_link }}" />
                                                                </div>
                                                                <div class="col-md-12 mt-1">
                                                                    <button
                                                                        onclick="deleteTabButton('{{ $tb_btn->id }}')"
                                                                        type="button"
                                                                        class="btn btn-danger">Remove</button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="form-group row mt-2">
                                                        <button type="button"
                                                            onclick="addNewButton({{ $ind }})"
                                                            class="btn btn-primary">
                                                            Add new button
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row" style="margin-top: 20px;padding-bottom: 5px;margin-left:7px;">
                                    <button class="btn btn-success" type="button" name="button" onclick="addNewTab()">
                                        Create Tab </button>
                                </div>
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
                                    Publish
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
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script>
        let gallary_images = [];
        let i = @php echo (count($events->getEventTabs)+1) @endphp;
        let speaker_count = @php echo count($events->getEventSpeakers) @endphp;
        let gallary_images_count = @php echo count($events->getEventgallery) @endphp;
        gallary_images_count = (30 - gallary_images_count);
        $(document).ready(function() {

            @foreach ($events->getEventTabs as $ind => $val)
                @php $ind++; @endphp
                @if ($val->tab_type == 'others')
                    grapejsInitialize(`section_desc_{{ $ind }}`,
                        `section_desc_data_{{ $ind }}`,
                        `section_gjs_{{ $ind }}`);
                @endif
            @endforeach


            @foreach ($events->getEventSpeakers as $ind => $val)
                @php $ind++; @endphp
                grapejsInitialize(`featured_speakers_desc_{{ $ind }}`,
                    `featured_speakers_desc_data_{{ $ind }}`,
                    `featured_speakers_gjs_{{ $ind }}`);
            @endforeach


            @foreach ($events->getEventgallery as $ind => $val)
                gallary_images.push("{{ $val->image }}");
            @endforeach
            $(".accordion-sort").sortable({
                revert: true,
                cancel: '.no-drag,input',
            });

            $(".accordion-sort").on("sortstop", function(event, ui) {
                $(`.main-container`).each(function(indexInArray, valueOfElement) {
                    let counter = indexInArray;
                    counter++;
                    $(valueOfElement).find('.sort-val').val(counter);
                });
            });

            $("#start_date").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
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
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
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

            $("#publish_date").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
            });

            // Initialize grapejs tabs
        });

        let addNewTab = () => {
            Swal.fire({
                title: 'Enter tab name',
                input: 'text',
                inputLabel: 'Enter tab name',
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return 'Tab name is required!';
                    } else {
                        let error_msg = '';
                        // Check if tab name exist or not 
                        $(`.main-container`).each(function(indexInArray, valueOfElement) {
                            console.log($(valueOfElement).find('.tab-name').val());
                            if ($(valueOfElement).find('.tab-name').val() == value) {
                                error_msg = 'Tab name already given!';
                            }
                        });
                        if (error_msg != '') {
                            return error_msg;
                        } else {

                            // let total_sort_len = parseInt($('#sorting_len').val());
                            // total_sort_len++;
                            $('#accordion').append(`
                        <div class="card mb-2 main-container">
                            <div class="d-flex align-items-center">
                                <div class="card-header w-100 mr-3 collapsed" data-toggle="collapse"
        data-target="#collapse_${i}" aria-expanded="false" aria-controls="heading_${i}">
                                    <h4 class="m-0"><i class="fas fa-arrows-alt mr-3"></i><span id="tab_name_${i}" name="tab_name_${i}">${value}</span> </h4>
                                    <input type="hidden" class="sort-val" name="sort_no_${i}" id="sort_no_${i}" value="${(i+2)}" />
                                </div>
                                <div class="text-center">
                                    <i class="del_icon material-icons" onclick="$(this).closest('.main-container').remove();">&#xe872;</i>
                                </div>
                            </div>
                                <div id="collapse_${i}" class="collapse" aria-labelledby="heading_${i}"
                                    data-parent="#accordion" >
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label for="tab_value_${i}"> Title : </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="tab_value_${i}" id="tab_value_${i}" oninput="changeText(${i},this.value)" class="form-control tab-name" value="${value}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row no-drag">
                                            <input type="hidden" name="section_desc_${i}" id="section_desc_${i}" />
                                            <input type="hidden" name="section_desc_data_${i}" id="section_desc_data_${i}" />
                                            <div id="section_gjs_${i}"></div>
                                        </div>
                                        <div id="div_btn_container_${i}" class="div_btn_container">
                                            <input type="hidden" name="total_btn_length_${i}" id="total_btn_length_${i}" value="0" />
                                        </div>
                                        <div class="form-group row mt-2">
                                            <button type="button" onclick="addNewButton(${i})" class="btn btn-primary">
                                                Add new button
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>`);
                            grapejsInitialize(`section_desc_${i}`,
                                `section_desc_data_${i}`,
                                `section_gjs_${i}`);
                            i++;
                            // $('#sorting_len').val(total_sort_len);

                            let total_add_more_sec = parseInt($('#total_add_more_sec').val());
                            total_add_more_sec++;
                            $('#total_add_more_sec').val(total_add_more_sec);
                        }

                    }
                }
            });
        }

        let changeText = (indx, val) => {
            $('#tab_name_' + indx).html(val);
        }

        let changeTabName = (value, id) => {
            $(`#${id}`).html(value);
        }
        let addNewButton = (val) => {
            let btn_len = parseInt($(`#total_btn_length_${val}`).val());
            btn_len++;
            $(`#div_btn_container_${val}`).append(`
            <div class="row add-more-btn">
                <div class="col-md-2 mt-1">
                    <label> Button title </label>
                </div>
                <div class="col-md-10 mt-1">
                    <input type="text" name="btn_title_${val}_${btn_len}" id="btn_title_${val}_${btn_len}" class="form-control"/>
                </div>
                <div class="col-md-2 mt-1">
                    <label> Button label </label>
                </div>
                <div class="col-md-10 mt-1">
                    <input type="text" name="btn_label_${val}_${btn_len}" id="btn_label_${val}_${btn_len}" class="form-control"/>
                </div>
                <div class="col-md-2 mt-1">
                    <label> Button link </label>
                </div>
                <div class="col-md-10 mt-1">
                    <input type="url" name="btn_link_${val}_${btn_len}" id="btn_link_${val}_${btn_len}" class="form-control"/>
                </div>
                <div class="col-md-12 mt-1">
                    <button onclick="$(this).closest('.add-more-btn').remove()" type="button" class="btn btn-danger">Remove</button>
                </div>
                
            </div>
            `);
            $(`#total_btn_length_${val}`).val(btn_len);
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
                                                            id="featured_speaker_name_${speaker_count}" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group row ">
                                                    <div class="col-md-2"><label class="form-control-label"> Designation
                                                        </label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" name="featured_speaker_designation_${speaker_count}"
                                                            id="featured_speaker_designation_${speaker_count}" class="form-control" value=""/>
                                                    </div>
                                                </div>
                                                <div class="form-group row ">
                                                    <div class="col-md-2"><label class="form-control-label"> Speaker Image
                                                        </label>
                                                    </div>

                                                    <div class="col-sm-10">
                                            <div style="width:70%;float:left">
                                                <span class="pr-field"><input type="text" id="featured_speaker_url_${speaker_count}"
                                                        name="featured_speaker_url_${speaker_count}" class="form-control" value=""
                                                        readonly="" style="margin-bottom:15px"></span>
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('featured_speaker_url_${speaker_count}'));">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 20%;float:right">
                                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="featured_speaker_url_${speaker_count}_preview" height="100px" width="auto">
                                            </div>
                                        </div>
                                                    
                                                </div> 
                                                <div class="form-group row">
                                                    <div class="col-md-12"> <label class="form-control-label"> Description:
                                                        </label>
                                                    </div>
                                                    <div class="col-md-12 no-drag">
                                                        <input type="hidden" name="featured_speakers_desc_${speaker_count}" id="featured_speakers_desc_${speaker_count}" />
                                                        <input type="hidden" name="featured_speakers_desc_data_${speaker_count}" id="featured_speakers_desc_data_${speaker_count}" />
                                                        <div id="featured_speakers_gjs_${speaker_count}"></div> 
                                                    </div>
                                                </div>                 
                    <div class="col-md-12 mt-2 mb-2">
                        <button type="button" class="btn btn-danger" onclick="$(this).closest('.speaker-sec').remove();"> Remove </button>
                    </div>
                </div>
            `);
            grapejsInitialize(`featured_speakers_desc_${speaker_count}`,
                `featured_speakers_desc_data_${speaker_count}`,
                `featured_speakers_gjs_${speaker_count}`);
            $('#featured_speakers_add_more_count').val(speaker_count);
        }


        let validateEvent = () => {
            let is_invalid = 0;
            // Validate Event info 
            let msg = '';
            if ($('#event_name').val() == '') {
                msg = 'Event name is required';
            }
            if ($('#meta_title').val() == '') {
                msg = 'Meta title is required';
            }
            if ($('#meta_keyword').val() == '') {
                msg = 'Meta keyword is required';
            }
            if ($('#meta_description').val() == '') {
                msg = 'Meta Description is required';
            }
            if ($('#start_date').val() == '') {
                msg = 'Event start date is required';
            }
            if ($('#end_date').val() == '') {
                msg = 'Event end date is required';
            }
            if ($('#publish_date').val() == '') {
                msg = 'Publish date is required';
            }
            if ($('#event_location').val() == '') {
                msg = 'Event location is required';
            }
            if ($('#featured_image').val() == '') {
                msg = 'Featured image is required';
            }


            // Validate tab name given or not

            $(`.main-container`).each(function(indexInArray, valueOfElement) {
                if ($(valueOfElement).find('.tab-name').val() == '') {
                    is_invalid++;
                    msg = "Every section's tab name is required";
                }
            });

            // Validate if button details were given or not


            if (is_invalid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: msg,
                });
                return false;
            }

            if (msg != '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: msg,
                });
                return false;
            }

        }


        var myDropzone = new Dropzone("#dropzonejs_gallery", {
            url: "{{ route('drop-zone-file-upload', ['_token' => csrf_token()]) }}",
            paramName: "file",
            addRemoveLinks: true,
            method: "POST",
            maxFilesize: gallary_images_count,
            acceptedFiles: ".jpeg,.jpg,.png,.gif"
        });
        myDropzone.on("error", function(file) {
            if (file.type != 'jpeg' || file.type != 'jpg' || file.type != 'png' || file.type != 'gif') {
                this.removeFile(file);
            }
        });
        myDropzone.on("addedfile", function() {
            if (this.files[gallary_images_count] != null) {
                this.removeFile(this.files[gallary_images_count]);
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Maximum ' + gallary_images_count + ' files can be uploaded',
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


        let deleteDropzoneImg = (id) => {
            Swal.fire({
                title: 'Do you want to delete this event image ?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.event.image.delete') }}",
                        type: 'post',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': id
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.status == 'success') {
                                Swal.fire('Success!', data.message, 'success');
                            } else {
                                Swal.fire('Error!', data.message, 'info')
                            }
                            setTimeout(function() {
                                location.reload(true);
                            }, 2000);
                        },
                        error: function(res) {
                            Swal.fire('Error!', 'Something went wrong please try after sometime',
                                'error');
                            setTimeout(function() {
                                location.reload(true);
                            }, 2000);
                        }
                    });
                }
            })
        }

        let removeSpeaker = (id) => {
            Swal.fire({
                title: 'Do you want to delete this speaker ?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.event.speaker.delete') }}",
                        type: 'post',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': id
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.status == 'success') {
                                Swal.fire('Success!', data.message, 'success');
                            } else {
                                Swal.fire('Error!', data.message, 'info')
                            }
                            setTimeout(function() {
                                location.reload(true);
                            }, 2000);
                        },
                        error: function(res) {
                            Swal.fire('Error!', 'Something went wrong please try after sometime',
                                'error');
                            setTimeout(function() {
                                location.reload(true);
                            }, 2000);
                        }
                    });
                }
            })
        }

        let deleteTab = (id) => {
            Swal.fire({
                title: "Do you want to delete this tab and it's buttons ?",
                showCancelButton: true,
                confirmButtonText: 'Delete',
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.event.tab.delete') }}",
                        type: 'post',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': id
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.status == 'success') {
                                Swal.fire('Success!', data.message, 'success');
                            } else {
                                Swal.fire('Error!', data.message, 'info')
                            }
                            setTimeout(function() {
                                location.reload(true);
                            }, 2000);
                        },
                        error: function(res) {
                            Swal.fire('Error!', 'Something went wrong please try after sometime',
                                'error');
                            setTimeout(function() {
                                location.reload(true);
                            }, 2000);
                        }
                    });
                }
            })
        }

        let deleteTabButton = (id) => {
            Swal.fire({
                title: "Do you want to delete this button?",
                showCancelButton: true,
                confirmButtonText: 'Delete',
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.event.tab.button.delete') }}",
                        type: 'post',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': id
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.status == 'success') {
                                Swal.fire('Success!', data.message, 'success');
                            } else {
                                Swal.fire('Error!', data.message, 'info')
                            }
                            setTimeout(function() {
                                location.reload(true);
                            }, 2000);
                        },
                        error: function(res) {
                            Swal.fire('Error!', 'Something went wrong please try after sometime',
                                'error');
                            setTimeout(function() {
                                location.reload(true);
                            }, 2000);
                        }
                    });
                }
            })
        }
    </script>
@endpush
