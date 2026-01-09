@extends('dashboard.layouts.master')
@section('title', __($resource == null ? 'Create Resource Page Content' : 'Edit Resource Page Content'))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}">
    <style>
        .action_table_data {
            display: flex;
            justify-content: center;
            width: 100%;
        }
    </style>
@endpush
@section('content')
    @include('dashboard.common.index')
    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __($resource == null ? 'Create Resource Page Content' : 'Edit Resource Page Content') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    <a href="{{ route('admin.contents.manage') }}">{{ __('Content Manager') }}</a>
                </small>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.resource.store') }}" method="POST" id="resource_form">
                            @csrf
                            <input type="hidden" name="base_url" id="base_url" value="{{ url('') }}">
                            <input type="hidden" name="content_id" id="content_id"
                                value="{{ $resource != null ? $resource->content_id : $content_details->id }}">
                            <input type="hidden" name="menu_section_count" id="menu_section_count"
                                value="{{ $resource == null ? 0 : count($resource->getResourceMenu) }}">
                            <input type="hidden" name="uuid" id="uuid"
                                value="{{ $resource == null ? Str::uuid()->toString() : $resource->uuid }}  ">
                            <input type="hidden" name="menu_count" id="menu_count" value="0">
                            <input type="hidden" name="page_type" id="page_type"
                                value="{{ $resource != null ? 'update' : 'create' }}">
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
                                                @if ($resource != null) oninput="generatePageSlug(this.value,'page_slug','resource','draft_btn','submit_btn','{{ $resource->page_name }}')"
                                                @else
                                                oninput="generatePageSlug(this.value,'page_slug','resource','draft_btn','submit_btn')" @endif
                                                value="{{ $resource != null ? $resource->page_name : '' }}"
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
                                                value="{{ $resource != null ? $resource->page_slug : '' }}"
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
                                                value="{{ $resource != null ? $resource->meta_title : '' }}"
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
                                                value="{{ $resource != null ? $resource->meta_keyword : '' }}"
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
                                                value="{{ $resource != null ? $resource->meta_description : '' }}"
                                                required></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Title<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="title" id="title" type="text"
                                                value="{{ $resource != null ? $resource->title : '' }}" required></span>
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
                                                required>{{ $resource != null ? $resource->description : '' }}</textarea>
                                        </span>
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
                                                value="{{ $resource != null ? $resource->banner_title : '' }}"
                                                oninput="text_change('banner_title','draggable_web_', 'draggable_tablet_','draggable_mobile_')"
                                                required></span>
                                    </div>
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Banner Description</label>
                                        <span class="pr-field"><input type="text" class="form-control text-secondary"
                                                name="banner_desc" id="banner_desc" placeholder="Banner Description"
                                                value="{{ $resource != null ? $resource->banner_desc : '' }}"
                                                oninput="text_change('banner_desc','draggable2_web_', 'draggable2_tablet_','draggable2_mobile_')"></span>
                                    </div>
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Button Link</label>
                                        <span class="pr-field"><input type="url" class="form-control text-secondary"
                                                value="{{ $resource != null ? $resource->button_link : '' }}"
                                                name="button_link" id="button_link" placeholder="Button Link"></span>
                                    </div>
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Button Name</label>
                                        <span class="pr-field"><input type="text" class="form-control text-secondary"
                                                name="button_name" id="button_name" placeholder="Banner text"
                                                value="{{ $resource != null ? $resource->button_name : '' }}"
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
                                                    value="{{ $resource != null ? ($resource->getBannerImageWeb != null ? $resource->getBannerImageWeb->file_name : '') : '' }}"
                                                    name="banner_image_web" class="form-control"
                                                    onkeydown="return false;" autocomplete="off"
                                                    style="margin-bottom:15px" value="" required>
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('banner_image_web'),document.getElementById('parent_div_web_image_'),'','' )">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 18%;float:right;    margin-left: 15px;">
                                                <img src="{{ $resource != null ? ($resource->getBannerImageWeb != null ? asset('/') . $resource->getBannerImageWeb->path : asset('assets/dashboard/images/image_not_found.png')) : asset('assets/dashboard/images/image_not_found.png') }}"
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
                                                    value="{{ $resource != null ? ($resource->getBannerImageTab != null ? $resource->getBannerImageTab->file_name : '') : '' }}"
                                                    style="margin-bottom:15px" value="" required>
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('banner_image_tablet'),document.getElementById('parent_div_tablet_image_'),'','' )">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 18%;float:right;    margin-left: 15px;">
                                                <img src="{{ $resource != null ? ($resource->getBannerImageTab != null ? asset('/') . $resource->getBannerImageTab->path : asset('assets/dashboard/images/image_not_found.png')) : asset('assets/dashboard/images/image_not_found.png') }}"
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
                                                    value="{{ $resource != null ? ($resource->getBannerImageMobile != null ? $resource->getBannerImageMobile->file_name : '') : '' }}"
                                                    style="margin-bottom:15px" value="" required>
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('banner_image_mobile'),document.getElementById('parent_div_mobile_image_'),'','' )">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 18%;float:right;    margin-left: 15px;">
                                                <img src="{{ $resource != null ? ($resource->getBannerImageMobile != null ? asset('/') . $resource->getBannerImageMobile->path : asset('assets/dashboard/images/image_not_found.png')) : asset('assets/dashboard/images/image_not_found.png') }}"
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
                                                        value="{{ $resource != null ? $resource->banner_title_left_pos_web : '' }}">
                                                    <input type="hidden" id="banner_title_top_pos_web_"
                                                        name="banner_title_top_pos_web_"
                                                        value="{{ $resource != null ? $resource->banner_title_top_pos_web : '' }}">
                                                    <input type="hidden" id="banner_desc_left_pos_web_"
                                                        name="banner_desc_left_pos_web_"
                                                        value="{{ $resource != null ? $resource->banner_desc_left_pos_web_ : '' }}">
                                                    <input type="hidden" id="banner_desc_top_pos_web_"
                                                        name="banner_desc_top_pos_web_"
                                                        value="{{ $resource != null ? $resource->banner_desc_top_pos_web : '' }}">
                                                    <input type="hidden" id="button_name_left_pos_web_"
                                                        name="button_name_left_pos_web_"
                                                        value="{{ $resource != null ? $resource->button_name_left_pos_web_ : '' }}">
                                                    <input type="hidden" id="button_name_top_pos_web_"
                                                        name="button_name_top_pos_web_"
                                                        value="{{ $resource != null ? $resource->button_name_top_pos_web : '' }}">
                                                    @if ($resource != null)
                                                        @if ($resource->getBannerImageWeb != null)
                                                            @if (in_array($resource->getBannerImageWeb->file_ext, ['mp4', 'webm', 'ogg']))
                                                                <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                                    alt="image not found"
                                                                    style="position: absolute; height: 300px; width: 100%; "
                                                                    id="parent_div_web_image_" />
                                                            @else
                                                                <img src="{{ asset('') }}{{ $resource->getBannerImageWeb->path }}"
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
                                                        style="position:absolute;color:white; cursor: move;left:{{ $resource != null ? $resource->banner_title_left_pos_web : 0 }}%;top:{{ $resource != null ? $resource->banner_title_top_pos_web : 0 }}%">
                                                        @if ($resource != null)
                                                            @if ($resource->banner_title != '')
                                                                {{ $resource->banner_title }}
                                                            @endif
                                                        @endif
                                                    </span>
                                                    <br><br>
                                                    <span id="draggable2_web_"
                                                        class="banner-description-lg draggable_text2"
                                                        onclick="showPosition('draggable2_web_','parent_div_web_image_','banner_desc_left_pos_web_', 'banner_desc_top_pos_web_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $resource != null ? $resource->banner_desc_left_pos_web : 0 }}%;top:{{ $resource != null ? $resource->banner_desc_left_pos_web : 0 }}%">
                                                        @if ($resource != null)
                                                            @if ($resource->banner_desc != '')
                                                                {{ $resource->banner_desc }}
                                                            @endif
                                                        @endif
                                                    </span>
                                                    <br><br>
                                                    <a id="draggable3_web_" class="trasparent-btn-white draggable_text3"
                                                        onclick="showPosition('draggable3_web_','parent_div_web_image_','button_name_left_pos_web_','button_name_top_pos_web_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $resource != null ? $resource->button_name_left_pos_web : 0 }}%;top:{{ $resource != null ? $resource->button_name_top_pos_web : 0 }}%">
                                                        @if ($resource != null)
                                                            @if ($resource->button_name != '')
                                                                {{ $resource->button_name }}
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
                                                        value="{{ $resource != null ? $resource->banner_title_left_pos_tablet : '' }}">
                                                    <input type="hidden" id="banner_title_top_pos_tablet_"
                                                        name="banner_title_top_pos_tablet_"
                                                        value="{{ $resource != null ? $resource->banner_title_top_pos_tablet : '' }}">
                                                    <input type="hidden" id="banner_desc_left_pos_tablet_"
                                                        name="banner_desc_left_pos_tablet_"
                                                        value="{{ $resource != null ? $resource->banner_desc_left_pos_tablet : '' }}">
                                                    <input type="hidden" id="banner_desc_top_pos_tablet_"
                                                        name="banner_desc_top_pos_tablet_"
                                                        value="{{ $resource != null ? $resource->banner_desc_top_pos_tablet : '' }}">
                                                    <input type="hidden" id="button_name_left_pos_tablet_"
                                                        name="button_name_left_pos_tablet_"
                                                        value="{{ $resource != null ? $resource->button_name_left_pos_tablet : '' }}">
                                                    <input type="hidden" id="button_name_top_pos_tablet_"
                                                        name="button_name_top_pos_tablet_"
                                                        value="{{ $resource != null ? $resource->button_name_top_pos_tablet : '' }}">
                                                    @if ($resource != null)
                                                        @if ($resource->getBannerImageTab != null)
                                                            @if (in_array($resource->getBannerImageTab->file_ext, ['mp4', 'webm', 'ogg']))
                                                                <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                                    alt="image not found"
                                                                    style="position: absolute; height: 300px; width: 768px; object-fit: cover; "
                                                                    id="parent_div_tablet_image_" />
                                                            @else
                                                                <img src="{{ asset('') }}{{ $resource->getBannerImageTab->path }}"
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
                                                        style="position:absolute;color:white; cursor: move;left:{{ $resource != null ? $resource->banner_title_left_pos_tablet : 0 }}%;top:{{ $resource != null ? $resource->banner_title_top_pos_tablet : 0 }}%">
                                                        @if ($resource != null)
                                                            @if ($resource->banner_title != '')
                                                                {{ $resource->banner_title }}
                                                            @endif
                                                        @endif
                                                    </span>
                                                    <br><br>
                                                    <span id="draggable2_tablet_"
                                                        class="banner-description-md draggable_text2"
                                                        onclick="showPosition('draggable2_tablet_','parent_div_tablet_image_','banner_desc_left_pos_tablet_','banner_desc_top_pos_tablet_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $resource != null ? $resource->banner_desc_left_pos_tablet : 0 }}%;top:{{ $resource != null ? $resource->banner_desc_top_pos_tablet : 0 }}%">
                                                        @if ($resource != null)

                                                            @if ($resource->banner_desc != '')
                                                                {{ $resource->banner_desc }}
                                                            @endif
                                                        @endif

                                                    </span>
                                                    <br><br>
                                                    <a id="draggable3_tablet_"
                                                        class="trasparent-btn-white draggable_text3"
                                                        onclick="showPosition('draggable3_tablet_','parent_div_tablet_image_','button_name_left_pos_tablet_','button_name_top_pos_tablet_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $resource != null ? $resource->button_name_left_pos_tablet : 0 }}%;top:{{ $resource != null ? $resource->button_name_top_pos_tablet : 0 }}%">
                                                        @if ($resource != null)

                                                            @if ($resource->button_name != '')
                                                                {{ $resource->button_name }}
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
                                                        value="{{ $resource != null ? $resource->banner_title_left_pos_mobile : '' }}">
                                                    <input type="hidden" id="banner_title_top_pos_mobile_"
                                                        name="banner_title_top_pos_mobile_"
                                                        value="{{ $resource != null ? $resource->banner_title_top_pos_mobile : '' }}">
                                                    <input type="hidden" id="banner_desc_left_pos_mobile_"
                                                        name="banner_desc_left_pos_mobile_"
                                                        value="{{ $resource != null ? $resource->banner_desc_left_pos_mobile : '' }}">
                                                    <input type="hidden" id="banner_desc_top_pos_mobile_"
                                                        name="banner_desc_top_pos_mobile_"
                                                        value="{{ $resource != null ? $resource->banner_desc_top_pos_mobile : '' }}">
                                                    <input type="hidden" id="button_name_left_pos_mobile_"
                                                        name="button_name_left_pos_mobile_"
                                                        value="{{ $resource != null ? $resource->button_name_left_pos_mobile : '' }}">
                                                    <input type="hidden" id="button_name_top_pos_mobile_"
                                                        name="button_name_top_pos_mobile_"
                                                        value="{{ $resource != null ? $resource->button_name_top_pos_mobile : '' }}">
                                                    @if ($resource != null)
                                                        @if ($resource->getBannerImageMobile != null)
                                                            @if (in_array($resource->getBannerImageMobile->file_ext, ['mp4', 'webm', 'ogg']))
                                                                <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                                    alt="image not found"
                                                                    style="position: absolute;height: 300px; width: 375px; object-fit: cover; "
                                                                    id="parent_div_mobile_image_" />
                                                            @else
                                                                <img src="{{ asset('') }}{{ $resource->getBannerImageMobile->path }}"
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
                                                        style="position:absolute;color:white; cursor: move;left:{{ $resource != null ? $resource->banner_title_left_pos_mobile : 0 }}%;top:{{ $resource != null ? $resource->banner_title_top_pos_mobile : 0 }}%">
                                                        @if ($resource != null)

                                                            @if ($resource->banner_title != '')
                                                                {{ $resource->banner_title }}
                                                            @endif
                                                        @endif

                                                    </span>
                                                    <br><br>
                                                    <span id="draggable2_mobile_"
                                                        class="banner-description-sm draggable_text2"
                                                        onclick="showPosition('draggable2_mobile_','parent_div_mobile_image_','banner_desc_left_pos_mobile_','banner_desc_top_pos_mobile_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $resource != null ? $resource->banner_desc_left_pos_mobile : 0 }}%;top:{{ $resource != null ? $resource->banner_desc_top_pos_mobile : 0 }}%">
                                                        @if ($resource != null)

                                                            @if ($resource->banner_desc != '')
                                                                {{ $resource->banner_desc }}
                                                            @endif
                                                        @endif

                                                    </span>
                                                    <br><br>
                                                    <a id="draggable3_mobile_"
                                                        class="trasparent-btn-white draggable_text3"
                                                        onclick="showPosition('draggable3_mobile_','parent_div_mobile_image_','button_name_left_pos_mobile_','button_name_top_pos_mobile_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $resource != null ? $resource->button_name_left_pos_mobile : 0 }}%;top:{{ $resource != null ? $resource->button_name_top_pos_mobile : 0 }}%">
                                                        @if ($resource != null)

                                                            @if ($resource->button_name != '')
                                                                {{ $resource->button_name }}
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
                                <legend>Menu Section :</legend>
                                @if ($resource == null)
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="card-title">Section-1</h5>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="card-title float-right"> <a href="javascript:void(0)"
                                                    id="add_menu_section" onclick="add_menu_section()"
                                                    class="btn btn-primary btn-sm float-left"><i class="icon-add"></i>Add
                                                    More Section</a></h5>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-row">
                                    @if ($resource == null)
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group m-0">
                                                        <label for="menu_section_0_title" class="col-form-label s-12">Menu
                                                            Section
                                                            Title:<span class="text-danger">*</span></label>
                                                        <input id="menu_section_0_title" placeholder="Enter Menu Title"
                                                            class="form-control r-0 light s-12"
                                                            name="menu_section_0_title" type="text" required
                                                            value="">
                                                        <input id="menu_section_0_uuid" placeholder="Enter Menu Title"
                                                            class="form-control r-0 light s-12" name="menu_section_0_uuid"
                                                            type="hidden" value="{{ Str::uuid()->toString() }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-6 mt-2" style="top:25px">
                                                    <h5 class="">Cards</h5>
                                                </div>
                                                <div class="col-6 mt-2" style="top:15px">
                                                    <h5 class="float-right">
                                                        <a href="javascript:void(0)" id="add_more_card"
                                                            onclick="add_more_field('0')"
                                                            class="btn btn-primary btn-sm float-right"><i
                                                                class="icon-add mr-2"></i>Add
                                                            More Card</a>
                                                    </h5>
                                                </div>
                                                <div class="col-12">
                                                    <hr>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered m-a-0" id="cards_0">
                                                            <thead class="dker">
                                                                <tr>
                                                                    <th class="custom-th">{{ __('Sl') }}</th>
                                                                    <th class="custom-th">{{ __('Title') }}</th>
                                                                    <th class="custom-th">{{ __('Icon') }}</th>
                                                                    <th class="custom-th">{{ __('Hover Icon') }}</th>
                                                                    <th class="custom-th">{{ __('link') }}</th>
                                                                    <th class="custom-th">{{ __('Status') }}
                                                                    </th>
                                                                    <th class="text-center" style="width:100px;">
                                                                        {{ __('Action') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="append_card_data_0">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div id="append_menu_section"></div>
                                </div>
                            </fieldset>
                            <button type="submit" class="btn btn-success" style="margin-left: 20px;margin-bottom:20px"
                                id="submit_btn">{{ $resource != null ? 'Update' : 'Save' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Modal -->
<div class="modal fade" id="addCardModal" tabindex="-1" role="dialog" aria-labelledby="addCardTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="append_modal" role="document">
    </div>
</div>

@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/script.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/menu_banner_image_pos.js') }}"></script>
    <script>
        var image_url = "{{ asset('') }}";
        var count = parseInt("{{ $resource != null ? 0 : 1 }}");
        $(document).ready(function() {
            var menu_data = {!! json_encode($resource != null ? $resource->getResourceMenu : null) !!};
            if (menu_data != null)
                getMenuData(menu_data);

            $('#cards_0').DataTable({
                "searching": false,
                "paging": false
            });
        });



        const getMenuData = (menu) => {
            menu.forEach(element => {
                count++;
                var fieldHTML = `
                <div id="append_menu_section_${element['section_id']}">`;
                if (count != 1) {
                    fieldHTML += `<hr>`;
                }
                fieldHTML += `<div class="row">
                        <div class="col-6">
                            <h5 class="card-title">Section-${count}</h5>
                        </div>`;
                if (count == 1) {
                    fieldHTML += ` <div class="col-6">
                                            <h5 class="card-title float-right"> <a href="javascript:void(0)"
                                                    id="add_menu_section" onclick="add_menu_section()" class="btn btn-primary btn-sm float-left"><i
                                                        class="icon-add"></i>Add
                                                    More Section</a></h5>
                                        </div>`;
                } else {
                    fieldHTML += `<div class="col-6">
                            <h5 class="card-title float-right"><a href="javascript:void(0)" onclick="remove_menu_section('${element['section_id']}','true')"
                                    class="btn btn-danger btn-sm float-right"><i class="icon-remove mr-2"></i>Remove</a></h5>
                        </div>`;
                }

                fieldHTML += ` </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group m-0">
                                        <label for="menu_section_${element['section_id']}_title" class="col-form-label s-12">Menu
                                            Section
                                            Title:<span class="text-danger">*</span></label>
                                        <input id="menu_section_${element['section_id']}_title" placeholder="Enter Menu Title"
                                            class="form-control r-0 light s-12" name="menu_section_${element['section_id']}_title"
                                            type="text" required value="${element['menu']}">
                                            <input id="menu_section_${element['section_id']}_uuid" placeholder="Enter Menu Title"
                                                            class="form-control r-0 light s-12" name="menu_section_${element['section_id']}_uuid"
                                                            type="hidden" value="${element['uuid']}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-6 mt-2" style="top:25px">
                                    <h5 class="">Cards</h5>
                                </div>
                                <div class="col-6 mt-2" style="top:15px">
                                    <h5 class="float-right">
                                        <a href="javascript:void(0)" id="add_more_card"
                                            onclick="add_more_field('${element['section_id']}')"
                                            class="btn btn-primary btn-sm float-right"><i
                                                class="icon-add mr-2"></i>Add
                                            More Card</a>
                                    </h5>
                                </div>
                                <div class="col-12">
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-bordered m-a-0" id="cards_${count}">
                                            <thead class="dker">
                                                <tr>
                                                    <th class="custom-th">{{ __('Sl') }}</th>
                                                    <th class="custom-th">{{ __('Title') }}</th>
                                                    <th class="custom-th">{{ __('Icon') }}</th>
                                                    <th class="custom-th">{{ __('Hover Icon') }}</th>
                                                    <th class="custom-th">{{ __('link') }}</th>
                                                    <th class="custom-th">{{ __('Publish Date') }}</th>
                                                    <th class="custom-th">{{ __('Status') }}
                                                    </th>
                                                    <th class="text-center" style="width:100px;">
                                                        {{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="append_card_data_${element['section_id']}">`;
                if (element['get_resource_card'].length > 0) {
                    var sl = 1;
                    element['get_resource_card'].forEach(card => {
                        console.log(card['publish_date']);
                        let programDate = '';
                        if(card['publish_date']!=null){
                            programDate = new Date(card['publish_date']);
                        }
                        
                        fieldHTML += ` <tr>
                                                <td>${sl}</td>
                                                <td>${card['title']}</td>
                                                <td style="background:grey;">
                                                    <img src="${image_url+card['get_icon']['path']}"
                                                                                              alt="Icon" width="75px" height="75px"
                                                        style="object-fit: contain;">
                                                </td>
                                                <td>
                                                    <img src="${image_url+card['get_hover_icon']['path']}"
                                                        alt="Icon" width="75px" height="75px"
                                                        style="object-fit: contain;">
                                                </td>
                                                <td>${card['link']}</td>
                                                <td>${ programDate==''?'': programDate.toLocaleDateString('en-US', dateOptions)}</td>
                                                <td>${card['status']=='0'?'Private':'Public'}</td>
                                                <td>
                                                    <div class="action_table_data">
                                                    <a href="javascript:void(0)" onclick="editFunction('${card['id']}','${card['uuid']}','${card['section_id']}','${uuid}')"
                                                    class="btn btn-info btn-circle btn-sm mr-2">
                                                    <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form 
                                                        id="delete_form_${card['id']}">
                                                     
                                                        <input type="hidden" name="uuid" id="uuid"
                                                            value="${card['uuid']}">
                                                        <input type="hidden" name="menu_section_count" id="menu_section_count"
                                                            value="${element['section_id']}">
                                                        <input type="hidden" name="card_count" id="card_count"
                                                            value="${card_count}">
                                                        <input type="hidden" name="temp_uuid" value="${uuid}" />
                                                        <a onclick="deleteFunction('${card['id']}','${element['section_id']}')"
                                                        class="btn btn-danger btn-circle btn-sm">
                                                        <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </form>
                                                    </div>
                                                </td>
                                            </tr>`;
                        sl = sl + 1;
                    });
                }

                fieldHTML += ` </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
    `;
                $('#menu_count').val(count);
                $('#append_menu_section').append(fieldHTML);
                $('#menu_section_count').val(count);

            });

            if (menu.length > 0) {
                var check_count = 1;
                menu.forEach(element => {
                    // count = parseInt(element['section_id']);
                    $('#cards_' + check_count).dataTable({
                        "searching": false,
                        "paging": false
                    });
                    check_count++;
                });
            }

        }

        // $('#add_menu_section').click(function() {
        const add_menu_section = () => {
            // var menu_count = $('#menu_count').val();
            count++;
            var fieldHTML = `
            <div id="append_menu_section_${count}">
                <hr>
                <div class="row">
                                    <div class="col-6">
                                        <h5 class="card-title">Section-${count}</h5>
                                    </div>
                                  
                                        <div class="col-6">
                                        <h5 class="card-title float-right"><a href="javascript:void(0)" onclick="remove_menu_section('${count}')"
                                                class="btn btn-danger btn-sm float-right"><i class="icon-remove mr-2"></i>Remove</a></h5>
                                   
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group m-0">
                                                    <label for="menu_section_${count}_title" class="col-form-label s-12">Menu
                                                        Section
                                                        Title:<span class="text-danger">*</span></label>
                                                    <input id="menu_section_${count}_title" placeholder="Enter Menu Title"
                                                        class="form-control r-0 light s-12" name="menu_section_${count}_title"
                                                        type="text" required value="">
                                                        <input id="menu_section_${count}_uuid" placeholder="Enter Menu Title"
                                                            class="form-control r-0 light s-12" name="menu_section_${count}_uuid"
                                                            type="hidden" value="{{ Str::uuid()->toString() }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-6 mt-2" style="top:25px">
                                                <h5 class="">Cards</h5>
                                            </div>
                                            <div class="col-6 mt-2" style="top:15px">
                                                <h5 class="float-right">
                                                    <a href="javascript:void(0)" id="add_more_card"
                                                        onclick="add_more_field('${count}')"
                                                        class="btn btn-primary btn-sm float-right"><i
                                                            class="icon-add mr-2"></i>Add
                                                        More Card</a>
                                                </h5>
                                            </div>
                                            <div class="col-12">
                                                <hr>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered m-a-0" id="cards_${count}">
                                                        <thead class="dker">
                                                            <tr>
                                                                <th class="custom-th">{{ __('Sl') }}</th>
                                                                <th class="custom-th">{{ __('Title') }}</th>
                                                                <th class="custom-th">{{ __('Icon') }}</th>
                                                                <th class="custom-th">{{ __('Hover Icon') }}</th>
                                                                <th class="custom-th">{{ __('link') }}</th>
                                                                <th class="custom-th">{{ __('Status') }}
                                                                </th>
                                                                <th class="text-center" style="width:100px;">
                                                                    {{ __('Action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="append_card_data_${count}">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                `;
            $('#append_menu_section').append(fieldHTML);
            $('#menu_section_count').val(count);
            $('#cards_' + count).dataTable({
                "searching": false,
                "paging": false
            });
            document.getElementById(`menu_section_${count}_title`).focus();
        }
        // });

        function remove_menu_section(count, is_update) {

            Swal.fire({
                title: 'Are you sure to delete?',
                text: "You won't be able to revert this! This section will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (is_update == 'true') {
                        $.ajax({
                            url: "{{ route('admin.resource.remove.section') }}",
                            type: "POST",
                            data: {
                                resource_uuid: uuid,
                                section_id: count
                            },
                            headers: {
                                'X-CSRF-Token': "{{ csrf_token() }}"
                            },
                            datatype: 'json',
                            success: function(response) {
                                $('#append_menu_section_' + count).remove();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong! Please try after sometime.',
                                    'error'
                                );
                            }
                        });
                    } else {
                        $('#append_menu_section_' + count).remove();
                    }
                }
            })
        }

        var card_count = 0;
        var uuid = $('#uuid').val();

        function add_more_field(menu_section_count) {
            card_count = card_count + 1;
            $('#append_modal').html('');
            var modalFieldHtml = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Card</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                 <form id="submit_card_${menu_section_count}_${card_count}">
                    <input type="hidden" name="menu_section_count" value="${menu_section_count}" />
                    <input type="hidden" name="card_count" value="${card_count}" />
                    <input type="hidden" name="resource_uuid" value="${uuid}" />
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group m-0">
                                            <label for="card_section_${menu_section_count}_title_${card_count}" class="col-form-label s-12">Card
                                                Title:<span class="text-danger">*</span></label>
                                            <input id="card_section_${menu_section_count}_title_${card_count}" placeholder="Enter card title"
                                                class="form-control r-0 light s-12" name="card_section_${menu_section_count}_title_${card_count}"
                                                type="text" required value="">
                                                
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group m-0">
                                            <label for="card_section_${menu_section_count}_url_${card_count}" class="col-form-label s-12">Card
                                                URL:<span class="text-danger">*</span></label>
                                            <input id="card_section_${menu_section_count}_url_${card_count}" placeholder="Enter card url"
                                                class="form-control r-0 light s-12" name="card_section_${menu_section_count}_url_${card_count}"
                                                type="text" required value="">
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="form-group m-0">
                                            <label for="card_section_${menu_section_count}_icon_${card_count}" class="col-form-label s-12">Icon:<span class="text-danger">*</span></label>
                                            <input type="text" id="card_section_${menu_section_count}_icon_${card_count}"
                                                name="card_section_${menu_section_count}_icon_${card_count}" class="form-control r-0 light s-12"
                                                onkeydown="return false;" autocomplete="off" readonly required>

                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('card_section_${menu_section_count}_icon_${card_count}'),document.getElementById('card_section_${menu_section_count}_icon_${card_count}_preview'),'','' )">
                                                    Select or upload Image </div>
                                           <div class="mt-1" style="float:right;">
                                            <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="card_section_${menu_section_count}_icon_${card_count}_preview" height="100px" width="auto" style="background:grey;" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="form-group m-0">
                                            <label for="card_section_${menu_section_count}_hover_icon_${card_count}" class="col-form-label s-12">Hover Icon:<span class="text-danger">*</span></label>
                                            <input type="text" id="card_section_${menu_section_count}_hover_icon_${card_count}"
                                                name="card_section_${menu_section_count}_hover_icon_${card_count}" class="form-control r-0 light s-12"
                                                onkeydown="return false;" autocomplete="off" readonly required>

                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('card_section_${menu_section_count}_hover_icon_${card_count}'),document.getElementById('card_section_${menu_section_count}_hover_icon_${card_count}_preview'),'','' )">
                                                    Select or upload Image </div>
                                           <div class="mt-1" style="float:right;">
                                            <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="card_section_${menu_section_count}_hover_icon_${card_count}_preview" height="100px" width="auto" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group m-0">
                                            <label for="card_section_${menu_section_count}_date_${card_count}" class="col-form-label s-12">Publish Date:<span class="text-danger">*</span></label>
                                            <input id="card_section_${menu_section_count}_date_${card_count}" placeholder=""
                                                class="form-control r-0 light s-12" name="card_section_${menu_section_count}_date_${card_count}"
                                                type="date" required value="">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                            <label for="card_section_${menu_section_count}_status_${card_count}" class="col-form-label s-12">Status:<span class="text-danger">*</span></label>
                                    <span class="pr-field ml-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="card_section_${menu_section_count}_status_${card_count}"
                                                id="card_section_${menu_section_count}_status_${card_count}" value="0">
                                            <label class="form-check-label" for="card_section_${menu_section_count}_status_${card_count}">Private</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="card_section_${menu_section_count}_status_${card_count}"
                                                id="card_section_${menu_section_count}_status_${card_count}" value="1" checked>
                                            <label class="form-check-label" for="card_section_${menu_section_count}_status_${card_count}">Public</label>
                                        </div>
                                    </span>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="createCard('${menu_section_count}',${card_count})">Save changes</button>
                    </div>
                </div>`;
            $('#append_modal').html(modalFieldHtml);
            $('#addCardModal').modal('show');
        }


        const createCard = (menu_section_count, card_count) => {

            var title = document.getElementById('card_section_' + menu_section_count + '_title_' + card_count).value;
            if (title == '') {
                document.getElementById('card_section_' + menu_section_count + '_title_' + card_count).style
                    .borderColor = "red";
                document.getElementById('card_section_' + menu_section_count + '_title_' + card_count).focus();
                return false;
            } else {
                document.getElementById('card_section_' + menu_section_count + '_title_' + card_count).style
                    .borderColor = "#e1e8ee";
            }

            var url = document.getElementById('card_section_' + menu_section_count + '_url_' + card_count).value;
            if (url == '') {
                document.getElementById('card_section_' + menu_section_count + '_url_' + card_count).style
                    .borderColor = "red";
                document.getElementById('card_section_' + menu_section_count + '_url_' + card_count).focus();
                return false;
            } else {
                document.getElementById('card_section_' + menu_section_count + '_url_' + card_count).style
                    .borderColor = "#e1e8ee";
            }

            var icon = document.getElementById('card_section_' + menu_section_count + '_icon_' + card_count).value;
            if (icon == '') {
                document.getElementById('card_section_' + menu_section_count + '_icon_' + card_count).style
                    .borderColor = "red";
                document.getElementById('card_section_' + menu_section_count + '_icon_' + card_count).focus();
                return false;
            } else {
                document.getElementById('card_section_' + menu_section_count + '_icon_' + card_count).style
                    .borderColor = "#e1e8ee";
            }

            var hover_icon = document.getElementById('card_section_' + menu_section_count + '_hover_icon_' + card_count)
                .value;
            if (hover_icon == '') {
                document.getElementById('card_section_' + menu_section_count + '_hover_icon_' + card_count).style
                    .borderColor = "red";
                document.getElementById('card_section_' + menu_section_count + '_hover_icon_' + card_count).focus();
                return false;
            } else {
                document.getElementById('card_section_' + menu_section_count + '_hover_icon_' + card_count).style
                    .borderColor = "#e1e8ee";
            }


            var date = document.getElementById('card_section_' + menu_section_count + '_date_' + card_count)
                .value;
            if (date == '') {
                document.getElementById('card_section_' + menu_section_count + '_date_' + card_count).style
                    .borderColor = "red";
                document.getElementById('card_section_' + menu_section_count + '_date_' + card_count).focus();
                return false;
            } else {
                document.getElementById('card_section_' + menu_section_count + '_date_' + card_count).style
                    .borderColor = "#e1e8ee";
            }

            $.ajax({
                url: "{{ route('admin.resource.temp.card.create') }}",
                type: "POST",
                data: $('#submit_card_' + menu_section_count + '_' + card_count).serialize(),
                headers: {
                    'X-CSRF-Token': "{{ csrf_token() }}"
                },
                datatype: 'json',
                success: function(response) {
                    getTempCardAppendData(response, menu_section_count);
                    $('#addCardModal').modal('hide');
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'Something went wrong! Please try after sometime.',
                        'error'
                    );
                }
            });
        }

        const dateOptions = {
            weekday: 'long', // 'l' for full weekday name
            month: 'long', // 'm' for full month name
            day: 'numeric', // 'd' for day of the month
            year: 'numeric' // 'Y' for four-digit year
        };

        function getTempCardAppendData(response, menu_section_count) {

            var cardFieldHtml = ``;
            
            if (response.length > 0) {
                
                var temp_count = 1;
                response.forEach(element => {
                    let programDate = null;
                    console.log(element['publish_date']);
                    if(element['publish_date']!=null){
                        programDate = new Date(element['publish_date']);
                    }
                    
                    cardFieldHtml += `<tr>
                                                <td>${temp_count}</td>
                                                <td>${element['title']}</td>
                                                <td style="background:grey;">
                                                    <img src="${image_url+element['get_icon']['path']}"
                                                        alt="Icon" width="75px" height="75px"
                                                        style="object-fit: contain;">
                                                </td>
                                                <td>
                                                    <img src="${image_url+element['get_hover_icon']['path']}"
                                                        alt="Icon" width="75px" height="75px"
                                                        style="object-fit: contain;">
                                                </td>
                                                <td>${element['link']}</td>
                                                <td>${programDate==null?'':
                                                    programDate.toLocaleDateString('en-US', dateOptions)}</td>
                                                <td>${element['status']=='0'?'Private':'Public'}</td>
                                                <td>
                                                    <div class="action_table_data">
                                                    <a href="javascript:void(0)" onclick="editFunction('${element['id']}','${element['uuid']}','${menu_section_count}','${uuid}')"
                                                    class="btn btn-info btn-circle btn-sm mr-2">
                                                    <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    <form 
                                                        id="delete_form_${element['id']}">
                                                     
                                                        <input type="hidden" name="uuid" id="uuid"
                                                            value="${element['uuid']}">
                                                        <input type="hidden" name="menu_section_count" id="menu_section_count"
                                                            value="${menu_section_count}">
                                                        <input type="hidden" name="card_count" id="card_count"
                                                            value="${card_count}">
                                                        <input type="hidden" name="temp_uuid" value="${uuid}" />
                                                        <a onclick="deleteFunction('${element['id']}','${menu_section_count}')"
                                                        class="btn btn-danger btn-circle btn-sm">
                                                        <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </form>
                                                    </div>
                                                </td>
                                            </tr>`;
                    temp_count = temp_count + 1;
                });
            }

            $('#append_card_data_' + menu_section_count).html(cardFieldHtml);
            var cardFieldHtml = ``;
        }

        const deleteFunction = (id, menu_section_count) => {
            Swal.fire({
                title: 'Are you sure to delete?',
                text: "You won't be able to revert this! This card will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.resource.temp.card.delete') }}",
                        type: "POST",
                        data: $("#delete_form_" + id).serialize(),
                        headers: {
                            'X-CSRF-Token': "{{ csrf_token() }}"
                        },
                        datatype: 'json',
                        success: function(response) {
                            getTempCardAppendData(response, menu_section_count);
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Something went wrong! Please try after sometime.',
                                'error'
                            );
                        }

                    });

                }
            })
        }

        function editFunction(id, uuid, menu_section_count, resource_uuid) {
            $.ajax({
                url: "{{ route('admin.resource.temp.card.edit') }}",
                type: "GET",
                datatype: 'json',
                data: {
                    uuid: uuid,
                    menu_section_count: menu_section_count,
                    resource_uuid: resource_uuid
                },
                success: function(response) {
                    if (response != '') {
                        $('#append_modal').html('');
                        var modalFieldHtml = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Card</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                 <form id="edit_card_${id}">
                    <input type="hidden" name="menu_section_count" value="${menu_section_count}" />
                    <input type="hidden" name="uuid" value="${uuid}" />
                    <input type="hidden" name="resource_uuid" value="${resource_uuid}" />
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group m-0">
                                            <label for="card_section_${menu_section_count}_title_${id}" class="col-form-label s-12">Card
                                                Title:<span class="text-danger">*</span></label>
                                            <input id="card_section_${menu_section_count}_title_${id}" placeholder="Enter card title"
                                                class="form-control r-0 light s-12" name="card_section_${menu_section_count}_title_${id}"
                                                type="text" required value="${response['title']}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group m-0">
                                            <label for="card_section_${menu_section_count}_url_${id}" class="col-form-label s-12">Card
                                                URL:<span class="text-danger">*</span></label>
                                            <input id="card_section_${menu_section_count}_url_${id}" placeholder="Enter card url"
                                                class="form-control r-0 light s-12" name="card_section_${menu_section_count}_url_${id}"
                                                type="text" required value="${response['link']}">
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="form-group m-0">
                                            <label for="card_section_${menu_section_count}_icon_${id}" class="col-form-label s-12">Icon:<span class="text-danger">*</span></label>
                                            <input type="text" id="card_section_${menu_section_count}_icon_${id}"
                                                name="card_section_${menu_section_count}_icon_${id}" class="form-control r-0 light s-12"
                                                onkeydown="return false;" autocomplete="off" value="${response['get_icon']['file_name']}" readonly required>

                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('card_section_${menu_section_count}_icon_${id}'),document.getElementById('card_section_${menu_section_count}_icon_${id}_preview'),'','' )">
                                                    Select or upload Image </div>
                                           <div class="mt-1" style="float:right;">
                                            <img src="${image_url+response['get_icon']['path']}"
                                                    id="card_section_${menu_section_count}_icon_${id}_preview" height="100px" width="auto" style="background:grey;" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="form-group m-0">
                                            <label for="card_section_${menu_section_count}_hover_icon_${id}" class="col-form-label s-12">Hover Icon:<span class="text-danger">*</span></label>
                                            <input type="text" id="card_section_${menu_section_count}_hover_icon_${id}"
                                                name="card_section_${menu_section_count}_hover_icon_${id}" class="form-control r-0 light s-12"
                                                onkeydown="return false;" autocomplete="off" value="${response['get_hover_icon']['file_name']}" readonly required>

                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('card_section_${menu_section_count}_hover_icon_${id}'),document.getElementById('card_section_${menu_section_count}_hover_icon_${id}_preview'),'','' )">
                                                    Select or upload Image </div>
                                           <div class="mt-1" style="float:right;">
                                            <img src="${image_url+response['get_hover_icon']['path']}"
                                                    id="card_section_${menu_section_count}_hover_icon_${id}_preview" height="100px" width="auto" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group m-0">
                                            <label for="card_section_${menu_section_count}_date_${id}" class="col-form-label s-12">Publish Date:<span class="text-danger">*</span></label>
                                            <input id="card_section_${menu_section_count}_date_${id}" placeholder=""
                                                class="form-control r-0 light s-12" name="card_section_${menu_section_count}_date_${id}"
                                                type="date" required value="${response['publish_date']}">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                            <label for="card_section_${menu_section_count}_status_${id}" class="col-form-label s-12">Status:<span class="text-danger">*</span></label>
                                    <span class="pr-field ml-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="card_section_${menu_section_count}_status_${id}"
                                                id="card_section_${menu_section_count}_status_${id}" value="0" ${response['status']=='0'?'checked':''}>
                                            <label class="form-check-label" for="card_section_${menu_section_count}_status_${id}">Private</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="card_section_${menu_section_count}_status_${id}"
                                                id="card_section_${menu_section_count}_status_${id}" value="1" ${response['status']=='1'?'checked':''} >
                                            <label class="form-check-label" for="card_section_${menu_section_count}_status_${id}">Public</label>
                                        </div>
                                    </span>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="editCard('${menu_section_count}',${id})">Update</button>
                    </div>
                </div>`;
                        $('#append_modal').html(modalFieldHtml);
                        $('#addCardModal').modal('show');
                    }

                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'Something went wrong! Please try after sometime.',
                        'error'
                    );
                }
            });
        }

        function editCard(menu_section_count, id) {
            var title = document.getElementById('card_section_' + menu_section_count + '_title_' + id).value;
            if (title == '') {
                document.getElementById('card_section_' + menu_section_count + '_title_' + id).style
                    .borderColor = "red";
                document.getElementById('card_section_' + menu_section_count + '_title_' + id).focus();
                return false;
            } else {
                document.getElementById('card_section_' + menu_section_count + '_title_' + id).style
                    .borderColor = "#e1e8ee";
            }

            var url = document.getElementById('card_section_' + menu_section_count + '_url_' + id).value;
            if (url == '') {
                document.getElementById('card_section_' + menu_section_count + '_url_' + id).style
                    .borderColor = "red";
                document.getElementById('card_section_' + menu_section_count + '_url_' + id).focus();
                return false;
            } else {
                document.getElementById('card_section_' + menu_section_count + '_url_' + id).style
                    .borderColor = "#e1e8ee";
            }

            var icon = document.getElementById('card_section_' + menu_section_count + '_icon_' + id).value;
            if (icon == '') {
                document.getElementById('card_section_' + menu_section_count + '_icon_' + id).style
                    .borderColor = "red";
                document.getElementById('card_section_' + menu_section_count + '_icon_' + id).focus();
                return false;
            } else {
                document.getElementById('card_section_' + menu_section_count + '_icon_' + id).style
                    .borderColor = "#e1e8ee";
            }

            var hover_icon = document.getElementById('card_section_' + menu_section_count + '_hover_icon_' + id)
                .value;
            if (hover_icon == '') {
                document.getElementById('card_section_' + menu_section_count + '_hover_icon_' + id).style
                    .borderColor = "red";
                document.getElementById('card_section_' + menu_section_count + '_hover_icon_' + id).focus();
                return false;
            } else {
                document.getElementById('card_section_' + menu_section_count + '_hover_icon_' + id).style
                    .borderColor = "#e1e8ee";
            }

            var date = document.getElementById('card_section_' + menu_section_count + '_date_' + id)
                .value;
            if (date == '') {
                document.getElementById('card_section_' + menu_section_count + '_date_' + id).style
                    .borderColor = "red";
                document.getElementById('card_section_' + menu_section_count + '_date_' + id).focus();
                return false;
            } else {
                document.getElementById('card_section_' + menu_section_count + '_date_' + id).style
                    .borderColor = "#e1e8ee";
            }
            $.ajax({
                url: "{{ route('admin.resource.temp.card.update') }}",
                type: "POST",
                data: $("#edit_card_" + id).serialize(),
                headers: {
                    'X-CSRF-Token': "{{ csrf_token() }}"
                },
                datatype: 'json',
                success: function(response) {
                    getTempCardAppendData(response, menu_section_count);
                    $('#addCardModal').modal('hide');
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'Something went wrong! Please try after sometime.',
                        'error'
                    );
                }

            });
        }
    </script>
@endpush
