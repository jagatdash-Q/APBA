@extends('dashboard.layouts.master')
@section('title', __('Create New Event'))
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
                <form action="{{ route('admin.event.store') }}" method="post" enctype="multipart/form-data"
                    onsubmit="return validateEvent();">
                    @csrf
                    <div class="pt-2">
                        <input type="hidden" name="page_type" id="page_type" value="events">
                        <input type="hidden" name="base_url" id="base_url" value="{{ url('') }}">
                        <input type="hidden" name="gallery_images" id="gallery_images" value="">
                        <input type="hidden" name="sorting_len" id="sorting_len" value="2">
                        <input type="hidden" name="total_add_more_sec" id="total_add_more_sec" value="0">
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
                                                    oninput="generatePageSlug(this.value,'event_slug','events','draft_btn','submit_btn')"
                                                    value="{{ old('event_name') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class=" form-control-label"> Event Slug </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                    name="event_slug" id="event_slug" type="text"
                                                    value="{{ old('event_slug') }}" readonly></span>
                                            <span id="event_slug_error"> </span>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class=" form-control-label"> Meta Title </label>
                                        </div>
                                        <div class="col-sm-10"> <span class="pr-field"><input placeholder=""
                                                    class="form-control" dir="ltr" name="meta_title" id="meta_title"
                                                    type="text" value="{{ old('meta_title') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class=" form-control-label"> Meta Keyword </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                    name="meta_keyword" id="meta_keyword" type="text"
                                                    value="{{ old('meta_keyword') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class=" form-control-label"> Meta
                                                Description
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                    name="meta_description" id="meta_description" type="text"
                                                    value="{{ old('meta_description') }}"></span>
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
                                                    value="{{ old('start_date') }}"></span>
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
                                                    value="{{ old('end_date') }}"></span>
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
                                                    value="{{ old('publish_date') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class="form-control-label"> Event Location
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="event_location" id="event_location"
                                                    type="text" value="{{ old('event_location') }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class="form-control-label">Featured Image: </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <div style="width:70%;float:left">
                                                <span class="pr-field"><input type="text" id="featured_image"
                                                        name="featured_image" class="form-control" value=""
                                                        readonly="" style="margin-bottom:15px"></span>
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('featured_image'));">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 30%;float:right; text-align: center;">
                                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="featured_image_preview" style="width: 160px; height: auto;">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div id="accordion" class="accordion-sort">
                                <div class="card mb-2 main-container">
                                    <div class="d-flex align-items-center">
                                        <div class="card-header w-100 mr-3 collapsed" id="headingTwo"
                                            data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            <h4 class="m-0"><i class="fas fa-arrows-alt mr-3"></i> <span
                                                    id="featured_speaker_tab_name"
                                                    name="featured_speaker_tab_name">Featured Speakers</span></h4>
                                            <input type="hidden" class="sort-val" name="sort_no_featured_speaker"
                                                id="sort_no_featured_speaker" value="1" />
                                        </div>
                                        <div class="text-center">

                                        </div>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-md-2"> <label class="form-control-label"> Featured
                                                        Speakers
                                                    </label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <span class="pr-field"><input placeholder=""
                                                            class="form-control tab-name" dir="ltr"
                                                            name="featured_speakers_tab" id="featured_speakers_tab"
                                                            type="text" value="Featured Speakers"
                                                            oninput="changeTabName(this.value,'featured_speaker_tab_name')"></span>
                                                </div>
                                            </div>

                                            <div class="custom-border" id="featured_speakers_add_more_container"
                                                style="margin-top:10px;">
                                                <input type="hidden" name="featured_speakers_add_more_count"
                                                    value="1" id="featured_speakers_add_more_count" />
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-primary float-right"
                                                            onclick="addspeakers()"> Add More </button>
                                                    </div>
                                                </div>
                                                {{-- <div class="speaker-sec">
                                                    <div class="form-group row ">
                                                        <div class="col-md-2"><label class="form-control-label"> Name
                                                            </label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="text" name="featured_speaker_name_1"
                                                                id="featured_speaker_name_1"
                                                                class="form-control featured_speaker_name"
                                                                value="{{ old('featured_speaker_name_1') }}" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row ">
                                                        <div class="col-md-2"><label class="form-control-label">
                                                                Designation
                                                            </label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="text" name="featured_speaker_designation_1"
                                                                id="featured_speaker_designation_1"
                                                                class="form-control featured_speaker_designation"
                                                                value="{{ old('featured_speaker_designation_1') }}" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row ">
                                                        <div class="col-md-2"><label class="form-control-label"> Button
                                                                url
                                                            </label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="text" name="featured_speaker_url_1"
                                                                id="featured_speaker_url_1"
                                                                class="form-control featured_speaker_url"
                                                                value="{{ old('featured_speaker_url_1') }}" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row ">
                                                        <div class="col-md-12"> <label class="form-control-label">
                                                                Description:
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12 no-drag">
                                                            <input type="hidden" name="featured_speakers_desc_1"
                                                                id="featured_speakers_desc_1" />
                                                            <input type="hidden" name="featured_speakers_desc_data_1"
                                                                id="featured_speakers_desc_data_1" />
                                                            <div id="featured_speakers_gjs_1"></div>
                                                        </div>
                                                    </div>
                                                </div> --}}


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-2 main-container">
                                    <div class="d-flex align-items-center">
                                        <div class="card-header w-100 mr-3 collapsed" id="headingThree"
                                            data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            <h4 class="m-0"><i class="fas fa-arrows-alt mr-3"></i><span
                                                    id="photography_tab_name" name="photography_tab_name">Photography
                                                    session</span></h4>
                                            <input type="hidden" class="sort-val" name="sort_no_photo_graphy"
                                                id="sort_no_photo_graphy" value="2" />
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
                                                            type="text" value="Photography session"
                                                            oninput="changeTabName(this.value,'photography_tab_name')"></span>
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
                                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or
                                                                click to
                                                                upload.</h3>
                                                            <span class="fs-7 fw-semibold text-gray-400">Upload up to 30
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
        let i = 1;
        let speaker_count = 1;
        var expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
        $(document).ready(function() {
            $(".accordion-sort").sortable({
                revert: true,
                cancel: '.no-drag,input,button',
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
            grapejsInitialize(`featured_speakers_desc_1`,
                `featured_speakers_desc_data_1`,
                `featured_speakers_gjs_1`);
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
                    <input type="text" name="btn_title_${val}_${btn_len}" id="btn_title_${val}_${btn_len}" class="form-control btn_title"/>
                </div>
                <div class="col-md-2 mt-1">
                    <label> Button label </label>
                </div>
                <div class="col-md-10 mt-1">
                    <input type="text" name="btn_label_${val}_${btn_len}" id="btn_label_${val}_${btn_len}" class="form-control btn_label"/>
                </div>
                <div class="col-md-2 mt-1">
                    <label> Button link </label>
                </div>
                <div class="col-md-10 mt-1">
                    <input type="text" name="btn_link_${val}_${btn_len}" id="btn_link_${val}_${btn_len}" class="form-control btn_link"/>
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
                                                            id="featured_speaker_name_${speaker_count}" class="form-control featured_speaker_name"/>
                                                    </div>
                                                </div>
                                                <div class="form-group row ">
                                                    <div class="col-md-2"><label class="form-control-label"> Designation
                                                        </label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" name="featured_speaker_designation_${speaker_count}"
                                                            id="featured_speaker_designation_${speaker_count}" class="form-control featured_speaker_designation" value=""/>
                                                    </div>
                                                </div>
                                                <div class="form-group row ">
                                                    <div class="col-md-2"><label class="form-control-label"> Speaker Image
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-10">
                                            <div style="width:70%;float:left">
                                                <span class="pr-field"><input type="text" id="featured_speaker_url_${speaker_count}"
                                                        name="featured_speaker_url_${speaker_count}" class="form-control featured_speaker_url" value=""
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


                // Validate add more button details given or not
                $(valueOfElement).find('.add-more-btn').each(function(indx, val) {
                    if ($(val).find('.btn_title').val() == '') {
                        is_invalid++;
                        msg = "Button title is required";
                    }

                    if ($(val).find('.btn_label').val() == '') {
                        is_invalid++;
                        msg = "Button label is required";
                    }

                    if ($(val).find('.btn_link').val() == '') {
                        is_invalid++;
                        msg = "Button link is required";
                    }
                    if (!validate_url($(val).find('.btn_link').val())) {
                        is_invalid++;
                        msg = "Please enter a valid url";
                    }


                });

                // Validate if featured speaker details were given or not
                $(valueOfElement).find('.speaker-sec').each(function(indx, val) {
                    if ($(val).find('.featured_speaker_name').val() == '') {
                        is_invalid++;
                        msg = "Speaker name is required";
                    }

                    if ($(val).find('.featured_speaker_designation').val() == '') {
                        is_invalid++;
                        msg = "Speaker designation is required";
                    }

                    if ($(val).find('.featured_speaker_url').val() == '') {
                        is_invalid++;
                        msg = "Speaker image is required";
                    }
                    // if (!validate_url($(val).find('.featured_speaker_url').val())) {
                    //     is_invalid++;
                    //     msg = "Please enter a valid url for speaker button";
                    // }


                });


            });




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


        const validate_url = url => {
            var re_weburl = new RegExp(
                "^" +
                "(?:(?:(?:https?|ftp):)?\\/\\/)" +
                "(?:\\S+(?::\\S*)?@)?" +
                "(?:" +
                "(?!(?:10|127)(?:\\.\\d{1,3}){3})" +
                "(?!(?:169\\.254|192\\.168)(?:\\.\\d{1,3}){2})" +
                "(?!172\\.(?:1[6-9]|2\\d|3[0-1])(?:\\.\\d{1,3}){2})" +
                "(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])" +
                "(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}" +
                "(?:\\.(?:[1-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))" +
                "|" +
                "(?:" +
                "(?:" +
                "[a-z0-9\\u00a1-\\uffff]" +
                "[a-z0-9\\u00a1-\\uffff_-]{0,62}" +
                ")?" +
                "[a-z0-9\\u00a1-\\uffff]\\." +
                ")+" +
                "(?:[a-z\\u00a1-\\uffff]{2,}\\.?)" +
                ")" +
                "(?::\\d{2,5})?" +
                "(?:[/?#]\\S*)?" +
                "$", "i"
            );

            return re_weburl.test(url)
        }
    </script>
@endpush
