@extends('dashboard.layouts.master')
@section('title', __($contact_us == null ? 'Create Contact Us Page Content' : 'Edit Contact Us Page Content'))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}">
    <style>
        .action_table_data {
            display: flex;
            border-bottom-width: 0 !important;
        }
    </style>
@endpush
@section('content')
    @include('dashboard.common.index')
    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __($contact_us == null ? 'Create Contact Us Page Content' : 'Edit Contact Us Page Content') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    <a href="{{ route('admin.contents.manage') }}">{{ __('Content Manager') }}</a>
                </small>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.contact.us.store') }}" method="POST" id="contact_us_form">
                            @csrf
                            <input type="hidden" name="base_url" id="base_url" value="{{ url('') }}">
                            <input type="hidden" name="content_id" id="content_id"
                                value="{{ $contact_us != null ? $contact_us->content_id : $content_details->id }}">

                            <input type="hidden" name="uuid" id="uuid"
                                value="{{ $contact_us == null ? Str::uuid()->toString() : $contact_us->uuid }}  ">

                            <input type="hidden" name="page_type" id="page_type"
                                value="{{ $contact_us != null ? 'update' : 'create' }}">
                            <fieldset>
                                <legend>Page Info :</legend>
                                <div class="form-group row">
                                    <div class="col-md-2"> <label class=" form-control-label"> Page Name<span
                                                class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="page_name" id="page_name" type="text"
                                                @if ($contact_us != null) oninput="generatePageSlug(this.value,'page_slug','contact-us','draft_btn','submit_btn','{{ $contact_us->page_name }}')"
                                                @else
                                                oninput="generatePageSlug(this.value,'page_slug','contact-us','draft_btn','submit_btn')" @endif
                                                value="{{ $contact_us != null ? $contact_us->page_name : '' }}"
                                                required></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Page Slug<span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="page_slug" id="page_slug" type="text"
                                                value="{{ $contact_us != null ? $contact_us->page_slug : '' }}"
                                                readonly></span>
                                        <span id="page_slug_error"> </span>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Meta Title<span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-sm-10"> <span class="pr-field">
                                            <input placeholder="" class="form-control" dir="ltr" name="meta_title"
                                                id="meta_title" type="text"
                                                value="{{ $contact_us != null ? $contact_us->meta_title : '' }}"
                                                required></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Meta Keyword<span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="meta_keyword" id="meta_keyword" type="text"
                                                value="{{ $contact_us != null ? $contact_us->meta_keyword : '' }}"
                                                required></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2"> <label class=" form-control-label"> Meta
                                            Description<span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="meta_description" id="meta_description" type="text"
                                                value="{{ $contact_us != null ? $contact_us->meta_description : '' }}"
                                                required></span>
                                    </div>
                                </div>


                            </fieldset>

                            <fieldset>
                                <legend>Banner Section :</legend>
                                <div class="card-body" style="padding:10px">
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Banner Heading<span
                                                class="text-danger">*</span></label>
                                        <span class="pr-field"><input type="text" class="form-control text-secondary"
                                                name="banner_title" id="banner_title" placeholder="Banner Heading"
                                                value="{{ $contact_us != null ? $contact_us->banner_title : '' }}"
                                                oninput="text_change('banner_title','draggable_web_', 'draggable_tablet_','draggable_mobile_')"
                                                required></span>
                                    </div>
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Banner Description</label>
                                        <span class="pr-field"><input type="text" class="form-control text-secondary"
                                                name="banner_desc" id="banner_desc" placeholder="Banner Description"
                                                value="{{ $contact_us != null ? $contact_us->banner_desc : '' }}"
                                                oninput="text_change('banner_desc','draggable2_web_', 'draggable2_tablet_','draggable2_mobile_')"></span>
                                    </div>
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Button Link</label>
                                        <span class="pr-field"><input type="url" class="form-control text-secondary"
                                                value="{{ $contact_us != null ? $contact_us->button_link : '' }}"
                                                name="button_link" id="button_link" placeholder="Button Link"></span>
                                    </div>
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Button Name</label>
                                        <span class="pr-field"><input type="text" class="form-control text-secondary"
                                                name="button_name" id="button_name" placeholder="Banner text"
                                                value="{{ $contact_us != null ? $contact_us->button_name : '' }}"
                                                oninput="text_change('button_name','draggable3_web_', 'draggable3_tablet_','draggable3_mobile_')"></span>
                                    </div>
                                    <div class="mb-3" style="padding:10px">

                                        <div class="col-md-2">
                                            <label class="form-label" for="banner_image_web">Desktop Banner Image:<span
                                                    class="text-danger">*</span>(1339px
                                                x 300px)</label>
                                        </div>

                                        <div class="row col-md-10" style="margin-left:0px">
                                            <div style="width:80%;float:left"><input type="text" id="banner_image_web"
                                                    value="{{ $contact_us != null ? ($contact_us->getBannerImageWeb != null ? $contact_us->getBannerImageWeb->file_name : '') : '' }}"
                                                    name="banner_image_web" class="form-control"
                                                    onkeydown="return false;" autocomplete="off"
                                                    style="margin-bottom:15px" value="" required>
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('banner_image_web'),document.getElementById('parent_div_web_image_'),'','' )">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 18%;float:right;    margin-left: 15px;">
                                                <img src="{{ $contact_us != null ? ($contact_us->getBannerImageWeb != null ? asset('/') . $contact_us->getBannerImageWeb->path : asset('assets/dashboard/images/image_not_found.png')) : asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="banner_image_web_preview" height="100px" width="auto" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3" style="padding:10px">
                                        <div class="col-md-2">
                                            <label class="form-label" for="banner_image_tablet">Tablet Banner Image:<span
                                                    class="text-danger">*</span>(768px
                                                x
                                                300px)</label>
                                        </div>
                                        <div class="row col-md-10" style="margin-left:0px">
                                            <div style="width:80%;float:left"><input type="text"
                                                    id="banner_image_tablet" name="banner_image_tablet"
                                                    class="form-control" onkeydown="return false;" autocomplete="off"
                                                    value="{{ $contact_us != null ? ($contact_us->getBannerImageTab != null ? $contact_us->getBannerImageTab->file_name : '') : '' }}"
                                                    style="margin-bottom:15px" value="" required>
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('banner_image_tablet'),document.getElementById('parent_div_tablet_image_'),'','' )">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 18%;float:right;    margin-left: 15px;">
                                                <img src="{{ $contact_us != null ? ($contact_us->getBannerImageTab != null ? asset('/') . $contact_us->getBannerImageTab->path : asset('assets/dashboard/images/image_not_found.png')) : asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="banner_image_tablet_preview" height="100px" width="auto" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3" style="padding:10px">
                                        <div class="col-md-2">
                                            <label class="form-label" for="banner_image_mobile">Mobile Banner Image:<span
                                                    class="text-danger">*</span>(375px
                                                x
                                                300px)</label>
                                        </div>
                                        <div class="row col-md-10" style="margin-left:0px">
                                            <div style="width:80%;float:left">
                                                <input type="text" id="banner_image_mobile" name="banner_image_mobile"
                                                    class="form-control" onkeydown="return false;" autocomplete="off"
                                                    value="{{ $contact_us != null ? ($contact_us->getBannerImageMobile != null ? $contact_us->getBannerImageMobile->file_name : '') : '' }}"
                                                    style="margin-bottom:15px" value="" required>
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('banner_image_mobile'),document.getElementById('parent_div_mobile_image_'),'','' )">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 18%;float:right;    margin-left: 15px;">
                                                <img src="{{ $contact_us != null ? ($contact_us->getBannerImageMobile != null ? asset('/') . $contact_us->getBannerImageMobile->path : asset('assets/dashboard/images/image_not_found.png')) : asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="banner_image_mobile_preview" height="100px" width="auto" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body" style="padding:10px">
                                    <div id="image_preview_container">
                                        <ul class="nav nav-md" style="background-color: white" id="img_prev_tab__">
                                            <li class="nav-item inline" style="border: 0px" onclick="changeTab()">
                                                <a class="nav-link active nav-img-prev" href=""
                                                    id="webviewtabmenu" data-toggle="tab"
                                                    data-target="#img_prev_tab__web_" style="padding: 0.2rem 0.75rem;">
                                                    <span class="text-lg">
                                                        <i class="fa fa-desktop" aria-hidden="true"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item inline" style="border: 0px" onclick="changeTab()">
                                                <a class="nav-link  nav-img-prev" href="" data-toggle="tab"
                                                    data-target="#img_prev_tab__tablet_" style="padding: 0.2rem 0.75rem;">
                                                    <span class="text-lg">
                                                        <i class="fa fa-tablet" aria-hidden="true"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item inline" style="border: 0px" onclick="changeTab()">
                                                <a class="nav-link  nav-img-prev" href="" data-toggle="tab"
                                                    data-target="#img_prev_tab__mobile_" style="padding: 0.2rem 0.75rem;">
                                                    <span class="text-lg">
                                                        <i class="fa fa-mobile" aria-hidden="true"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item inline" style="border: 0px" id="expand_icon">
                                                <a class="nav-link  nav-img-prev" href="#" data-toggle="tab"
                                                    data-target="#img_prev_tab__web_" onclick="expandDiv();"
                                                    style="padding: 0.2rem 0.75rem;">
                                                    <span class="text-lg">
                                                        <i class="fa fa-expand" aria-hidden="true"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item inline" style="border: 0px;display: none;"
                                                id="compress_icon">
                                                <a class="nav-link  nav-img-prev" href="#" data-toggle="tab"
                                                    data-target="#img_prev_tab__web_" onclick="compressDiv();"
                                                    style="padding: 0.2rem 0.75rem;">
                                                    <span class="text-lg">
                                                        <i class="fa fa-compress" aria-hidden="true"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li class="nav-item inline" style="border: 0px; display:none"
                                                id="left_all_pos_list_item_">
                                                <button class="btn btn-primary btn-sm" type="button"
                                                    name="left_align_content" id="left_align_content_"
                                                    onclick="changeAllTextPosition('left')">Left</button>
                                            </li>

                                            <li class="nav-item inline" style="border: 0px; display:none"
                                                id="center_all_pos_list_item_">
                                                <button class="btn btn-primary btn-sm" type="button"
                                                    name="center_align_content" id="left_align_content_"
                                                    onclick="changeAllTextPosition('center')">Center</button>
                                            </li>

                                            <li class="nav-item inline" type="button" style="border: 0px; display:none"
                                                id="right_all_pos_list_item_">
                                                <button class="btn btn-primary btn-sm" type="button"
                                                    name="right_align_content" id="left_align_content_"
                                                    onclick="changeAllTextPosition('right')">Right</button>
                                            </li>



                                            <li class="nav-item inline" style="border: 0px;float: right; display:none"
                                                id="top_position_list_item_">
                                                <input type="text" name="top_position_test" id="top_position_test_"
                                                    class="form-control" placeholder="Top Margin"
                                                    oninput="changeTextPosition(this.value, 'top')" title="Top Margin">
                                            </li>

                                            <li class="nav-item inline"
                                                style="border: 0px;float: right;margin-right:10px; display:none"
                                                id="left_position_list_item_">
                                                <input type="text" name="left_position_test" id="left_position_test_"
                                                    class="form-control" placeholder="Left Margin"
                                                    oninput="changeTextPosition(this.value, 'left')" title="Left Margin">
                                            </li>
                                        </ul>
                                        <div class="tab-content clear b-t" id="img_prev_content">
                                            <div class="tab-pane active" id="img_prev_tab__web_" aria-expanded="true">
                                                <div id="parent_div_web_"
                                                    style="position: relative; overflow: hidden;  height: 300px;">
                                                    <input type="hidden" id="banner_title_left_pos_web_"
                                                        name="banner_title_left_pos_web_"
                                                        value="{{ $contact_us != null ? $contact_us->banner_title_left_pos_web : '' }}">
                                                    <input type="hidden" id="banner_title_top_pos_web_"
                                                        name="banner_title_top_pos_web_"
                                                        value="{{ $contact_us != null ? $contact_us->banner_title_top_pos_web : '' }}">
                                                    <input type="hidden" id="banner_desc_left_pos_web_"
                                                        name="banner_desc_left_pos_web_"
                                                        value="{{ $contact_us != null ? $contact_us->banner_desc_left_pos_web_ : '' }}">
                                                    <input type="hidden" id="banner_desc_top_pos_web_"
                                                        name="banner_desc_top_pos_web_"
                                                        value="{{ $contact_us != null ? $contact_us->banner_desc_top_pos_web : '' }}">
                                                    <input type="hidden" id="button_name_left_pos_web_"
                                                        name="button_name_left_pos_web_"
                                                        value="{{ $contact_us != null ? $contact_us->button_name_left_pos_web_ : '' }}">
                                                    <input type="hidden" id="button_name_top_pos_web_"
                                                        name="button_name_top_pos_web_"
                                                        value="{{ $contact_us != null ? $contact_us->button_name_top_pos_web : '' }}">
                                                    @if ($contact_us != null)
                                                        @if ($contact_us->getBannerImageWeb != null)
                                                            @if (in_array($contact_us->getBannerImageWeb->file_ext, ['mp4', 'webm', 'ogg']))
                                                                <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                                    alt="image not found"
                                                                    style="position: absolute; height: 300px; width: 100%; "
                                                                    id="parent_div_web_image_" />
                                                            @else
                                                                <img src="{{ asset('') }}{{ $contact_us->getBannerImageWeb->path }}"
                                                                    alt="image not found"
                                                                    style="position: absolute; height: 300px; width: 100%; "
                                                                    id="parent_div_web_image_" />
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                                alt="image not found"
                                                                style="position: absolute; height: 300px; width: 100%; "
                                                                id="parent_div_web_image_" />
                                                        @endif
                                                    @else
                                                        <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                            alt="image not found"
                                                            style="position: absolute; height: 300px; width: 100%; "
                                                            id="parent_div_web_image_" />
                                                    @endif
                                                    <span id="draggable_web_" class="banner-text-lg draggable_text1"
                                                        onclick="showPosition('draggable_web_','parent_div_web_image_','banner_title_left_pos_web_','banner_title_top_pos_web_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $contact_us != null ? $contact_us->banner_title_left_pos_web : 0 }}%;top:{{ $contact_us != null ? $contact_us->banner_title_top_pos_web : 0 }}%">
                                                        @if ($contact_us != null)
                                                            @if ($contact_us->banner_title != '')
                                                                {{ $contact_us->banner_title }}
                                                            @endif
                                                        @endif
                                                    </span>
                                                    <br><br>
                                                    <span id="draggable2_web_"
                                                        class="banner-description-lg draggable_text2"
                                                        onclick="showPosition('draggable2_web_','parent_div_web_image_','banner_desc_left_pos_web_', 'banner_desc_top_pos_web_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $contact_us != null ? $contact_us->banner_desc_left_pos_web : 0 }}%;top:{{ $contact_us != null ? $contact_us->banner_desc_left_pos_web : 0 }}%">
                                                        @if ($contact_us != null)
                                                            @if ($contact_us->banner_desc != '')
                                                                {{ $contact_us->banner_desc }}
                                                            @endif
                                                        @endif
                                                    </span>
                                                    <br><br>
                                                    <a id="draggable3_web_" class="trasparent-btn-white draggable_text3"
                                                        onclick="showPosition('draggable3_web_','parent_div_web_image_','button_name_left_pos_web_','button_name_top_pos_web_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $contact_us != null ? $contact_us->button_name_left_pos_web : 0 }}%;top:{{ $contact_us != null ? $contact_us->button_name_top_pos_web : 0 }}%">
                                                        @if ($contact_us != null)
                                                            @if ($contact_us->button_name != '')
                                                                {{ $contact_us->button_name }}
                                                            @endif
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>

                                            {{-- Tablet  --}}
                                            <div class="tab-pane" id="img_prev_tab__tablet_" aria-expanded="true">
                                                <div id="parent_div_tablet_"
                                                    style="position: relative; overflow: hidden;  height: 300px;width: 768px; ">
                                                    <input type="hidden" id="banner_title_left_pos_tablet_"
                                                        name="banner_title_left_pos_tablet_"
                                                        value="{{ $contact_us != null ? $contact_us->banner_title_left_pos_tablet : '' }}">
                                                    <input type="hidden" id="banner_title_top_pos_tablet_"
                                                        name="banner_title_top_pos_tablet_"
                                                        value="{{ $contact_us != null ? $contact_us->banner_title_top_pos_tablet : '' }}">
                                                    <input type="hidden" id="banner_desc_left_pos_tablet_"
                                                        name="banner_desc_left_pos_tablet_"
                                                        value="{{ $contact_us != null ? $contact_us->banner_desc_left_pos_tablet : '' }}">
                                                    <input type="hidden" id="banner_desc_top_pos_tablet_"
                                                        name="banner_desc_top_pos_tablet_"
                                                        value="{{ $contact_us != null ? $contact_us->banner_desc_top_pos_tablet : '' }}">
                                                    <input type="hidden" id="button_name_left_pos_tablet_"
                                                        name="button_name_left_pos_tablet_"
                                                        value="{{ $contact_us != null ? $contact_us->button_name_left_pos_tablet : '' }}">
                                                    <input type="hidden" id="button_name_top_pos_tablet_"
                                                        name="button_name_top_pos_tablet_"
                                                        value="{{ $contact_us != null ? $contact_us->button_name_top_pos_tablet : '' }}">
                                                    @if ($contact_us != null)
                                                        @if ($contact_us->getBannerImageTab != null)
                                                            @if (in_array($contact_us->getBannerImageTab->file_ext, ['mp4', 'webm', 'ogg']))
                                                                <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                                    alt="image not found"
                                                                    style="position: absolute; height: 300px; width: 768px; object-fit: cover; "
                                                                    id="parent_div_tablet_image_" />
                                                            @else
                                                                <img src="{{ asset('') }}{{ $contact_us->getBannerImageTab->path }}"
                                                                    alt="image not found"
                                                                    style="position: absolute; height: 300px; width: 768px; object-fit: cover; "
                                                                    id="parent_div_tablet_image_" />
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                                alt="image not found"
                                                                style="position: absolute; height: 300px; width: 768px; object-fit: cover; "
                                                                id="parent_div_tablet_image_" />
                                                        @endif
                                                    @else
                                                        <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                            alt="image not found"
                                                            style="position: absolute; height: 300px; width: 768px; object-fit: cover; "
                                                            id="parent_div_tablet_image_" />
                                                    @endif
                                                    <span id="draggable_tablet_" class="banner-text-md draggable_text1"
                                                        onclick="showPosition('draggable_tablet_','parent_div_tablet_image_','banner_title_left_pos_tablet_','banner_title_top_pos_tablet_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $contact_us != null ? $contact_us->banner_title_left_pos_tablet : 0 }}%;top:{{ $contact_us != null ? $contact_us->banner_title_top_pos_tablet : 0 }}%">
                                                        @if ($contact_us != null)
                                                            @if ($contact_us->banner_title != '')
                                                                {{ $contact_us->banner_title }}
                                                            @endif
                                                        @endif
                                                    </span>
                                                    <br><br>
                                                    <span id="draggable2_tablet_"
                                                        class="banner-description-md draggable_text2"
                                                        onclick="showPosition('draggable2_tablet_','parent_div_tablet_image_','banner_desc_left_pos_tablet_','banner_desc_top_pos_tablet_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $contact_us != null ? $contact_us->banner_desc_left_pos_tablet : 0 }}%;top:{{ $contact_us != null ? $contact_us->banner_desc_top_pos_tablet : 0 }}%">
                                                        @if ($contact_us != null)

                                                            @if ($contact_us->banner_desc != '')
                                                                {{ $contact_us->banner_desc }}
                                                            @endif
                                                        @endif

                                                    </span>
                                                    <br><br>
                                                    <a id="draggable3_tablet_"
                                                        class="trasparent-btn-white draggable_text3"
                                                        onclick="showPosition('draggable3_tablet_','parent_div_tablet_image_','button_name_left_pos_tablet_','button_name_top_pos_tablet_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $contact_us != null ? $contact_us->button_name_left_pos_tablet : 0 }}%;top:{{ $contact_us != null ? $contact_us->button_name_top_pos_tablet : 0 }}%">
                                                        @if ($contact_us != null)

                                                            @if ($contact_us->button_name != '')
                                                                {{ $contact_us->button_name }}
                                                            @endif
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                            {{-- End of Tablet --}}

                                            {{-- Mobile  --}}
                                            <div class="tab-pane " id="img_prev_tab__mobile_" aria-expanded="true">
                                                <div id="parent_div_mobile_"
                                                    style="position: relative;overflow: hidden;  height: 300px; width: 375px;">
                                                    <input type="hidden" id="banner_title_left_pos_mobile_"
                                                        name="banner_title_left_pos_mobile_"
                                                        value="{{ $contact_us != null ? $contact_us->banner_title_left_pos_mobile : '' }}">
                                                    <input type="hidden" id="banner_title_top_pos_mobile_"
                                                        name="banner_title_top_pos_mobile_"
                                                        value="{{ $contact_us != null ? $contact_us->banner_title_top_pos_mobile : '' }}">
                                                    <input type="hidden" id="banner_desc_left_pos_mobile_"
                                                        name="banner_desc_left_pos_mobile_"
                                                        value="{{ $contact_us != null ? $contact_us->banner_desc_left_pos_mobile : '' }}">
                                                    <input type="hidden" id="banner_desc_top_pos_mobile_"
                                                        name="banner_desc_top_pos_mobile_"
                                                        value="{{ $contact_us != null ? $contact_us->banner_desc_top_pos_mobile : '' }}">
                                                    <input type="hidden" id="button_name_left_pos_mobile_"
                                                        name="button_name_left_pos_mobile_"
                                                        value="{{ $contact_us != null ? $contact_us->button_name_left_pos_mobile : '' }}">
                                                    <input type="hidden" id="button_name_top_pos_mobile_"
                                                        name="button_name_top_pos_mobile_"
                                                        value="{{ $contact_us != null ? $contact_us->button_name_top_pos_mobile : '' }}">
                                                    @if ($contact_us != null)
                                                        @if ($contact_us->getBannerImageMobile != null)
                                                            @if (in_array($contact_us->getBannerImageMobile->file_ext, ['mp4', 'webm', 'ogg']))
                                                                <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                                    alt="image not found"
                                                                    style="position: absolute;height: 300px; width: 375px; object-fit: cover; "
                                                                    id="parent_div_mobile_image_" />
                                                            @else
                                                                <img src="{{ asset('') }}{{ $contact_us->getBannerImageMobile->path }}"
                                                                    alt="image not found"
                                                                    style="position: absolute;height: 300px; width: 375px; object-fit: cover; "
                                                                    id="parent_div_mobile_image_" />
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                                alt="image not found"
                                                                style="position: absolute;height: 300px; width: 375px; object-fit: cover; "
                                                                id="parent_div_mobile_image_" />
                                                        @endif
                                                    @else
                                                        <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                            alt="image not found"
                                                            style="position: absolute;height: 300px; width: 375px; object-fit: cover; "
                                                            id="parent_div_mobile_image_" />
                                                    @endif
                                                    <span id="draggable_mobile_" class="banner-text-sm draggable_text1"
                                                        onclick="showPosition('draggable_mobile_','parent_div_mobile_image_','banner_title_left_pos_mobile_','banner_title_top_pos_mobile_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $contact_us != null ? $contact_us->banner_title_left_pos_mobile : 0 }}%;top:{{ $contact_us != null ? $contact_us->banner_title_top_pos_mobile : 0 }}%">
                                                        @if ($contact_us != null)

                                                            @if ($contact_us->banner_title != '')
                                                                {{ $contact_us->banner_title }}
                                                            @endif
                                                        @endif

                                                    </span>
                                                    <br><br>
                                                    <span id="draggable2_mobile_"
                                                        class="banner-description-sm draggable_text2"
                                                        onclick="showPosition('draggable2_mobile_','parent_div_mobile_image_','banner_desc_left_pos_mobile_','banner_desc_top_pos_mobile_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $contact_us != null ? $contact_us->banner_desc_left_pos_mobile : 0 }}%;top:{{ $contact_us != null ? $contact_us->banner_desc_top_pos_mobile : 0 }}%">
                                                        @if ($contact_us != null)

                                                            @if ($contact_us->banner_desc != '')
                                                                {{ $contact_us->banner_desc }}
                                                            @endif
                                                        @endif

                                                    </span>
                                                    <br><br>
                                                    <a id="draggable3_mobile_"
                                                        class="trasparent-btn-white draggable_text3"
                                                        onclick="showPosition('draggable3_mobile_','parent_div_mobile_image_','button_name_left_pos_mobile_','button_name_top_pos_mobile_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $contact_us != null ? $contact_us->button_name_left_pos_mobile : 0 }}%;top:{{ $contact_us != null ? $contact_us->button_name_top_pos_mobile : 0 }}%">
                                                        @if ($contact_us != null)

                                                            @if ($contact_us->button_name != '')
                                                                {{ $contact_us->button_name }}
                                                            @endif
                                                        @endif

                                                    </a>
                                                </div>
                                            </div>
                                            {{-- End of mobile --}}
                                        </div>
                                        {{-- Image preview of dynamic image positioning end --}}
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Content Section :</legend>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Title<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="title" id="title" type="text"
                                                value="{{ $contact_us != null ? $contact_us->title : '' }}"
                                                required></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Description<span
                                                class="text-danger">*</span></label>
                                    </div>

                                    <div class="col-sm-10">
                                        <span class="pr-field">
                                            <textarea name="description" id="description" class="form-control r-0 light s-12" cols="5" rows="3"
                                                required>{{ $contact_us != null ? $contact_us->description : '' }}</textarea>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Address<span
                                                class="text-danger">*</span></label>
                                    </div>

                                    <div class="col-sm-10">
                                        <span class="pr-field">
                                            <textarea name="address_1" id="address_1" class="form-control r-0 light s-12" cols="5" rows="3"
                                                required>{{ $contact_us != null ? $contact_us->address_1 : '' }}</textarea>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label">Optional Address </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field">
                                            <textarea name="address_2" id="address_2" class="form-control r-0 light s-12" cols="5" rows="3">{{ $contact_us != null ? $contact_us->address_2 : '' }}</textarea>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Map<span class="text-danger">*</span></label>
                                    </div>

                                    <div class="col-sm-10">
                                        <span class="pr-field">
                                            <textarea name="google_map" id="google_map" class="form-control r-0 light s-12" cols="5" rows="3"
                                                required>{{ $contact_us != null ? $contact_us->google_map : '' }}</textarea>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Email</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="email" id="email" type="email"
                                                value="{{ $contact_us != null ? $contact_us->email : '' }}"
                                                ></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Phone Number</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="mobile" id="mobile" type="text"
                                                value="{{ $contact_us != null ? $contact_us->mobile : '' }}"
                                                ></span>
                                    </div>
                                </div>
                            </fieldset>
                            <button type="submit" class="btn btn-success" style="margin-left: 20px;margin-bottom:20px"
                                id="submit_btn">{{ $contact_us != null ? 'Publish' : 'Publish' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/script.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/menu_banner_image_pos.js') }}"></script>
@endpush
