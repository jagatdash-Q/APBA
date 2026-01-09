@extends('dashboard.layouts.master')
@section('title', __('Update News'))
@section('content')
    @push('after-styles')
        <style>
            #danger {
                color: red;
            }
        </style>
        <link rel="stylesheet" href="{{ asset('assets/dashboard/dropzone/dropzone.css') }}">
    @endpush
    @include('dashboard.common.index')
    <div class="padding">
        <div class="box m-b-0">
            <div class="box-header dker">
                <h3>{{ __('Update News') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    {{ __('Update News') }}
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
                <form action="{{ route('admin.update.news') }}" method="post" enctype="multipart/form-data"
                    onsubmit="return validateNews();">
                    @csrf
                    <input type="hidden" id="uuid" name="uuid" value="{{ $news->uid }}">
                    <div id="main">
                        <div class="container">
                            <div class="card mb-2">
                                <fieldset class="fieldset-design">
                                    <legend class="fieldset-legend">News Info:</legend>
                                    <div class="form-group row">
                                        <div class="col-md-2"> <label class="form-control-label"> News Name <span
                                                    id="danger">*</span> :
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                    name="news_name" id="news_name" type="text"
                                                    oninput="generatePageSlug(this.value,'news_slug','news','draft_btn','submit_btn','{{$news->event_name}}')"
                                                    value="{{ $news->event_name }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class=" form-control-label"> News Slug :</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                    name="news_slug" id="news_slug" type="text"
                                                    value="{{ $news->event_slug }}" readonly></span>
                                            <span id="news_slug_error"> </span>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class="form-control-label"> News Start date :
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                    name="start_date" id="start_date" type="text"
                                                    onkeydown="event.preventDefault()" autocomplete="off"
                                                    value="{{ $news->start_date }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class=" form-control-label"> News End date :
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                    name="end_date" id="end_date" type="text"
                                                    onkeydown="event.preventDefault()" autocomplete="off"
                                                    value="{{ $news->end_date }}"></span>
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
                                                    value="{{ $news->publish_date }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class=" form-control-label"> Meta Title <span id="danger">*</span>
                                                :</label>
                                        </div>
                                        <div class="col-sm-10"> <span class="pr-field"><input placeholder=""
                                                    class="form-control" dir="ltr" name="meta_title" id="meta_title"
                                                    type="text" value="{{ $news->meta_title }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class=" form-control-label"> Meta Keyword <span id="danger">*</span>
                                                :</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="meta_keyword" id="meta_keyword" type="text"
                                                    value="{{ $news->meta_keywords }}"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class=" form-control-label"> Meta
                                                Description <span id="danger">*</span> :
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <span class="pr-field"><input placeholder="" class="form-control"
                                                    dir="ltr" name="meta_description" id="meta_description"
                                                    type="text" value="{{ $news->meta_desc }}"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label class="form-control-label">Featured Image <span id="danger">*</span>
                                                :
                                            </label>
                                        </div>
                                        <div class="col-sm-10">
                                            <div style="width:70%;float:left">
                                                <span class="pr-field"><input type="text" id="featured_image"
                                                        name="featured_image" class="form-control"
                                                        value="{{ $news->getFeaturedImage != null ? $news->getFeaturedImage->file_name : '' }}"
                                                        readonly="" style="margin-bottom:15px"></span>
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('featured_image'));">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 20%;float:right">
                                                <img src="{{ $news->getFeaturedImage == null ? asset('assets/dashboard/images/image_not_found.png') : asset($news->getFeaturedImage->path) }}"
                                                    id="featured_image_preview" height="100px" width="100px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"> <label class=" form-control-label"> News Description <span
                                                    id="danger">*</span> :
                                            </label>
                                        </div>
                                        <div class="col-md-12 no-drag">
                                            <input type="hidden" value="{{ $news->news_admin_desc }}" name="news_desc"
                                                id="news_desc" />
                                            <input type="hidden" value="{{ $news->news_desc }}" name="news_desc_data"
                                                id="news_desc_data" />
                                            <div id="news_gjs"></div>
                                        </div>
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
            grapejsInitialize(`news_desc`,
                `news_desc_data`,
                `news_gjs`);
        });


        let validateNews = () => {

            let is_invalid = 0;
            // Validate News info 
            let msg = '';
            if ($('#news_name').val() == '') {
                msg = 'News name is required';
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
            // if ($('#start_date').val() == '') {
            //     msg = 'News start date is required';
            // }
            // if ($('#end_date').val() == '') {
            //     msg = 'News end date is required';
            // }
            if ($('#publish_date').val() == '') {
                msg = 'Publish date is required';
            }
            if ($('#featured_image').val() == '') {
                msg = 'Featured image is required';
            }
            if ($('#news_desc_data').val() == '' || $('#news_desc').val() == '') {
                msg = 'News Description is required';
            }


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
    </script>
@endpush
