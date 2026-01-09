@extends('dashboard.layouts.master')
@section('title', __('Edit About us Page Content'))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}">
@endpush
@section('content')
    @include('dashboard.common.index')
    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Edit About us Page Content') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    <a href="{{ route('admin.contents.manage') }}">{{ __('Content Manager') }}</a>
                </small>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.content.about-page.update') }}" method="POST"
                            id="about_page_create_form" onsubmit="return validateForm();">
                            @csrf
                            <input type="hidden" name="base_url" id="base_url" value="{{ url('') }}">
                            <input type="hidden" name="about_contents_id" id="about_contents_id"
                                value="{{ $about_content_details->id }}">
                            <input type="hidden" name="content_id" id="content_id"
                                value="{{ $about_content_details->content_id }}">
                            <input type="hidden" name="card_section_details" id="card_section_details" />
                            <input type="hidden" id="section_details_id" name="section_details_id" />
                            <input type="hidden" id="card_details_id" name="card_details_id" />
                            <fieldset>
                                <legend>Page Info :</legend>
                                <div class="form-group row">
                                    <div class="col-md-2"> <label class=" form-control-label"> Page Name
                                        </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field">
                                            <input placeholder="" class="form-control" dir="ltr" name="page_name"
                                                id="page_name" type="text"
                                                oninput="generatePageSlug(this.value,'page_slug','about_us','draft_btn','submit_btn','{{ $about_content_details->page_name }}')"
                                                value="{{ $about_content_details->page_name }}"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Page Slug </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="page_slug" id="page_slug" type="text" readonly
                                                value="{{ $about_content_details->page_slug }}"></span>
                                        <span id="page_slug_error"> </span>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Meta Title </label>
                                    </div>
                                    <div class="col-sm-10"> <span class="pr-field"><input placeholder=""
                                                class="form-control" dir="ltr" name="meta_title" id="meta_title"
                                                value="{{ $about_content_details->meta_title }}" type="text"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Meta Keyword </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="meta_keyword" id="meta_keyword" type="text"
                                                value="{{ $about_content_details->meta_keywoard }}"></span>
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
                                                value="{{ $about_content_details->meta_description }}"></span>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Banner Section :</legend>
                                <div class="card-body" style="padding:10px">
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Banner Heading</label>
                                        <span class="pr-field"><input type="text" class="form-control text-secondary"
                                                name="banner_title" id="banner_title" placeholder="Banner Heading"
                                                oninput="text_change('banner_title','draggable_web_', 'draggable_tablet_','draggable_mobile_')"
                                                value="{{ $about_content_details->heading }}"></span>
                                    </div>
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Banner Description</label>
                                        <span class="pr-field"><input type="text" class="form-control text-secondary"
                                                name="banner_desc" id="banner_desc" placeholder="Banner Description"
                                                oninput="text_change('banner_desc','draggable2_web_', 'draggable2_tablet_','draggable2_mobile_')"
                                                value="{{ $about_content_details->banner_desc }}"></span>
                                    </div>
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Button Link</label>
                                        <span class="pr-field"><input type="url" class="form-control text-secondary"
                                                name="button_link" id="button_link" placeholder="Button Link"
                                                value="{{ $about_content_details->button_link }}"></span>
                                    </div>
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Button Name</label>
                                        <span class="pr-field"><input type="text" class="form-control text-secondary"
                                                name="button_name" id="button_name" placeholder="Banner text"
                                                oninput="text_change('button_name','draggable3_web_', 'draggable3_tablet_','draggable3_mobile_')"
                                                value="{{ $about_content_details->button_name }}"></span>
                                    </div>
                                    <div class="mb-3" style="padding:10px">

                                        <div class="col-md-2">
                                            <label class="form-label" for="banner_image_web">Desktop Banner Image:(1339px
                                                x 300px)</label>
                                        </div>

                                        <div class="row col-md-10" style="margin-left:0px">
                                            <div style="width:80%;float:left">
                                                @if ($about_content_details->getBannerImageWeb != null)
                                                    <input type="text" id="banner_image_web" name="banner_image_web"
                                                        class="form-control" readonly style="margin-bottom:15px"
                                                        value="{{ $about_content_details->getBannerImageWeb->file_name }}">
                                                @else
                                                    <input type="text" id="banner_image_web" name="banner_image_web"
                                                        class="form-control" readonly style="margin-bottom:15px"
                                                        value="">
                                                @endif


                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('banner_image_web'),document.getElementById('parent_div_web_image_'),'','' )">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 18%;float:right;margin-left: 15px;">
                                                @if ($about_content_details->getBannerImageWeb != null)
                                                    @if (in_array($about_content_details->getBannerImageWeb->file_ext, ['mp4', 'webm', 'ogg']))
                                                        <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                            id="banner_image_web_preview" height="100px"
                                                            width="auto" />
                                                    @else
                                                        <img src="{{ asset('') }}{{ $about_content_details->getBannerImageWeb->path }}"
                                                            id="banner_image_web_preview" height="100px"
                                                            width="auto" />
                                                    @endif
                                                @else
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="banner_image_web_preview" height="100px" width="auto" />
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3" style="padding:10px">
                                        <div class="col-md-2">
                                            <label class="form-label" for="banner_image_tablet">Tablet Banner Image:(768px
                                                x
                                                300px)</label>
                                        </div>
                                        <div class="row col-md-10" style="margin-left:0px">
                                            <div style="width:80%;float:left">
                                                @if ($about_content_details->getBannerImageTab != null)
                                                    <input type="text" id="banner_image_tablet"
                                                        name="banner_image_tablet" class="form-control" readonly
                                                        style="margin-bottom:15px"
                                                        value="{{ $about_content_details->getBannerImageTab->file_name }}">
                                                @else
                                                    <input type="text" id="banner_image_tablet"
                                                        name="banner_image_tablet" class="form-control" readonly
                                                        style="margin-bottom:15px" value="">
                                                @endif

                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('banner_image_tablet'),document.getElementById('parent_div_tablet_image_'),'','' )">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 18%;float:right;    margin-left: 15px;">
                                                @if ($about_content_details->getBannerImageTab != null)
                                                    @if (in_array($about_content_details->getBannerImageTab->file_ext, ['mp4', 'webm', 'ogg']))
                                                        <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                            id="banner_image_tablet_preview" height="100px"
                                                            width="auto" />
                                                    @else
                                                        <img src="{{ asset('') }}{{ $about_content_details->getBannerImageTab->path }}"
                                                            id="banner_image_tablet_preview" height="100px"
                                                            width="auto" />
                                                    @endif
                                                @else
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="banner_image_tablet_preview" height="100px" width="auto" />
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3" style="padding:10px">
                                        <div class="col-md-2">
                                            <label class="form-label" for="banner_image_mobile">Mobile Banner Image:(375px
                                                x
                                                300px)</label>
                                        </div>
                                        <div class="row col-md-10" style="margin-left:0px">
                                            <div style="width:80%;float:left">

                                                @if ($about_content_details->getBannerImageMobile != null)
                                                    <input type="text" id="banner_image_mobile"
                                                        name="banner_image_mobile" class="form-control" readonly
                                                        style="margin-bottom:15px"
                                                        value="{{ $about_content_details->getBannerImageMobile->file_name }}">
                                                @else
                                                    <input type="text" id="banner_image_mobile"
                                                        name="banner_image_mobile" class="form-control" readonly
                                                        style="margin-bottom:15px" value="">
                                                @endif

                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('banner_image_mobile'),document.getElementById('parent_div_mobile_image_'),'','' )">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 18%;float:right;    margin-left: 15px;">

                                                @if ($about_content_details->getBannerImageMobile != null)
                                                    @if (in_array($about_content_details->getBannerImageMobile->file_ext, ['mp4', 'webm', 'ogg']))
                                                        <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                            id="banner_image_mobile_preview" height="100px"
                                                            width="auto" />
                                                    @else
                                                        <img src="{{ asset('') }}{{ $about_content_details->getBannerImageMobile->path }}"
                                                            id="banner_image_mobile_preview" height="100px"
                                                            width="auto" />
                                                    @endif
                                                @else
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="banner_image_mobile_preview" height="100px" width="auto" />
                                                @endif
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
                                                        value="{{ $about_content_details->banner_title_left_pos_web }}">
                                                    <input type="hidden" id="banner_title_top_pos_web_"
                                                        name="banner_title_top_pos_web_"
                                                        value="{{ $about_content_details->banner_title_top_pos_web }}">
                                                    <input type="hidden" id="banner_desc_left_pos_web_"
                                                        name="banner_desc_left_pos_web_"
                                                        value="{{ $about_content_details->banner_desc_left_pos_web }}">
                                                    <input type="hidden" id="banner_desc_top_pos_web_"
                                                        name="banner_desc_top_pos_web_"
                                                        value="{{ $about_content_details->banner_desc_top_pos_web }}">
                                                    <input type="hidden" id="button_name_left_pos_web_"
                                                        name="button_name_left_pos_web_"
                                                        value="{{ $about_content_details->button_name_left_pos_web }}">
                                                    <input type="hidden" id="button_name_top_pos_web_"
                                                        name="button_name_top_pos_web_"
                                                        value="{{ $about_content_details->button_name_top_pos_web }}">

                                                    @if ($about_content_details->getBannerImageWeb != null)
                                                        @if (in_array($about_content_details->getBannerImageWeb->file_ext, ['mp4', 'webm', 'ogg']))
                                                            <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                                alt="image not found"
                                                                style="position: absolute; height: 300px; width: 100%; "
                                                                id="parent_div_web_image_" />
                                                        @else
                                                            <img src="{{ asset('') }}{{ $about_content_details->getBannerImageWeb->path }}"
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
                                                        style="position:absolute;color:white; cursor: move;left:{{ $about_content_details->banner_title_left_pos_web }}%;top:{{ $about_content_details->banner_title_top_pos_web }}%">
                                                        @if ($about_content_details->heading != '')
                                                            {{ $about_content_details->heading }}
                                                        @else
                                                            Banner
                                                        @endif
                                                    </span>
                                                    <br><br>
                                                    <span id="draggable2_web_"
                                                        class="banner-description-lg draggable_text2"
                                                        onclick="showPosition('draggable2_web_','parent_div_web_image_','banner_desc_left_pos_web_', 'banner_desc_top_pos_web_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $about_content_details->banner_desc_left_pos_web }}%;top:{{ $about_content_details->banner_desc_left_pos_web }}%">
                                                        @if ($about_content_details->banner_desc != '')
                                                            {{ $about_content_details->banner_desc }}
                                                        @else
                                                            Banner Desc
                                                        @endif
                                                    </span>
                                                    <br><br>
                                                    <a id="draggable3_web_" class="trasparent-btn-white draggable_text3"
                                                        onclick="showPosition('draggable3_web_','parent_div_web_image_','button_name_left_pos_web_','button_name_top_pos_web_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $about_content_details->button_name_left_pos_web }}%;top:{{ $about_content_details->button_name_top_pos_web }}%">
                                                        @if ($about_content_details->button_name != '')
                                                            {{ $about_content_details->button_name }}
                                                        @else
                                                            Button
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
                                                        value="{{ $about_content_details->banner_title_left_pos_tablet }}">
                                                    <input type="hidden" id="banner_title_top_pos_tablet_"
                                                        name="banner_title_top_pos_tablet_"
                                                        value="{{ $about_content_details->banner_title_top_pos_tablet }}">
                                                    <input type="hidden" id="banner_desc_left_pos_tablet_"
                                                        name="banner_desc_left_pos_tablet_"
                                                        value="{{ $about_content_details->banner_desc_left_pos_tablet }}">
                                                    <input type="hidden" id="banner_desc_top_pos_tablet_"
                                                        name="banner_desc_top_pos_tablet_"
                                                        value="{{ $about_content_details->banner_desc_top_pos_tablet }}">
                                                    <input type="hidden" id="button_name_left_pos_tablet_"
                                                        name="button_name_left_pos_tablet_"
                                                        value="{{ $about_content_details->button_name_left_pos_tablet }}">
                                                    <input type="hidden" id="button_name_top_pos_tablet_"
                                                        name="button_name_top_pos_tablet_"
                                                        value="{{ $about_content_details->button_name_top_pos_tablet }}">


                                                    @if ($about_content_details->getBannerImageTab != null)
                                                        @if (in_array($about_content_details->getBannerImageTab->file_ext, ['mp4', 'webm', 'ogg']))
                                                            <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                                alt="image not found"
                                                                style="position: absolute; height: 300px; width: 768px; object-fit: cover; "
                                                                id="parent_div_tablet_image_" />
                                                        @else
                                                            <img src="{{ asset('') }}{{ $about_content_details->getBannerImageTab->path }}"
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
                                                        style="position:absolute;color:white; cursor: move;left:{{ $about_content_details->banner_title_left_pos_tablet }}%;top:{{ $about_content_details->banner_title_top_pos_tablet }}%">
                                                        @if ($about_content_details->heading != '')
                                                            {{ $about_content_details->heading }}
                                                        @else
                                                            Banner Title
                                                        @endif
                                                    </span>
                                                    <br><br>
                                                    <span id="draggable2_tablet_"
                                                        class="banner-description-md draggable_text2"
                                                        onclick="showPosition('draggable2_tablet_','parent_div_tablet_image_','banner_desc_left_pos_tablet_','banner_desc_top_pos_tablet_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $about_content_details->banner_desc_left_pos_tablet }}%;top:{{ $about_content_details->banner_desc_top_pos_tablet }}%">
                                                        @if ($about_content_details->banner_desc != '')
                                                            {{ $about_content_details->banner_desc }}
                                                        @else
                                                            Banner Description
                                                        @endif
                                                    </span>
                                                    <br><br>
                                                    <a id="draggable3_tablet_"
                                                        class="trasparent-btn-white draggable_text3"
                                                        onclick="showPosition('draggable3_tablet_','parent_div_tablet_image_','button_name_left_pos_tablet_','button_name_top_pos_tablet_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $about_content_details->button_name_left_pos_tablet }}%;top:{{ $about_content_details->button_name_top_pos_tablet }}%">
                                                        @if ($about_content_details->button_name != '')
                                                            {{ $about_content_details->button_name }}
                                                        @else
                                                            Button
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
                                                        value="{{ $about_content_details->banner_title_left_pos_mobile }}">
                                                    <input type="hidden" id="banner_title_top_pos_mobile_"
                                                        name="banner_title_top_pos_mobile_"
                                                        value="{{ $about_content_details->banner_title_top_pos_mobile }}">
                                                    <input type="hidden" id="banner_desc_left_pos_mobile_"
                                                        name="banner_desc_left_pos_mobile_"
                                                        value="{{ $about_content_details->banner_desc_left_pos_mobile }}">
                                                    <input type="hidden" id="banner_desc_top_pos_mobile_"
                                                        name="banner_desc_top_pos_mobile_"
                                                        value="{{ $about_content_details->banner_desc_top_pos_mobile }}">
                                                    <input type="hidden" id="button_name_left_pos_mobile_"
                                                        name="button_name_left_pos_mobile_"
                                                        value="{{ $about_content_details->button_name_left_pos_mobile }}">
                                                    <input type="hidden" id="button_name_top_pos_mobile_"
                                                        name="button_name_top_pos_mobile_"
                                                        value="{{ $about_content_details->button_name_top_pos_mobile }}">


                                                    @if ($about_content_details->getBannerImageMobile != null)
                                                        @if (in_array($about_content_details->getBannerImageMobile->file_ext, ['mp4', 'webm', 'ogg']))
                                                            <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                                alt="image not found"
                                                                style="position: absolute;height: 300px; width: 375px; object-fit: cover; "
                                                                id="parent_div_mobile_image_" />
                                                        @else
                                                            <img src="{{ asset('') }}{{ $about_content_details->getBannerImageMobile->path }}"
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
                                                        style="position:absolute;color:white; cursor: move;left:{{ $about_content_details->banner_title_left_pos_mobile }}%;top:{{ $about_content_details->banner_title_top_pos_mobile }}%">
                                                        @if ($about_content_details->heading != '')
                                                            {{ $about_content_details->heading }}
                                                        @else
                                                            Banner Title
                                                        @endif
                                                    </span>
                                                    <br><br>
                                                    <span id="draggable2_mobile_"
                                                        class="banner-description-sm draggable_text2"
                                                        onclick="showPosition('draggable2_mobile_','parent_div_mobile_image_','banner_desc_left_pos_mobile_','banner_desc_top_pos_mobile_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $about_content_details->banner_desc_left_pos_mobile }}%;top:{{ $about_content_details->banner_desc_top_pos_mobile }}%">
                                                        @if ($about_content_details->banner_desc != '')
                                                            {{ $about_content_details->banner_desc }}
                                                        @else
                                                            Banner Description
                                                        @endif
                                                    </span>
                                                    <br><br>
                                                    <a id="draggable3_mobile_"
                                                        class="trasparent-btn-white draggable_text3"
                                                        onclick="showPosition('draggable3_mobile_','parent_div_mobile_image_','button_name_left_pos_mobile_','button_name_top_pos_mobile_','')"
                                                        style="position:absolute;color:white; cursor: move;left:{{ $about_content_details->button_name_left_pos_mobile }}%;top:{{ $about_content_details->button_name_top_pos_mobile }}%">
                                                        @if ($about_content_details->button_name != '')
                                                            {{ $about_content_details->button_name }}
                                                        @else
                                                            Button
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
                                <legend>Section 1 :</legend>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="welcome_head"
                                            placeholder="Welcome Text" name="welcome_head"
                                            value="{{ $about_content_details->welcome_head }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="welcome_desc" class="form-control" id="welcome_desc">{{ $about_content_details->welcome_desc }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" style="min-height:50px;">
                                    <button class="btn btn-success float-right" onclick="addCard('section_1');"
                                        data-toggle="modal" data-target="#Carddetailsmodel" style="margin-top: 10px;"
                                        type="button">
                                        Add a new section </button>
                                </div>
                                <div class="col-md-12" id="section_1_card_container">
                                    <table>
                                        <thead>
                                            <tr>
                                                <td>Image </td>
                                                <td>Content </td>
                                                <td>Action </td>
                                            </tr>
                                        </thead>
                                        <tbody id="section_1_card_container_body">
                                            @if (count($about_content_details->getFirstSectionCard))
                                                @for ($i = 0; $i < count($about_content_details->getFirstSectionCard); $i++)
                                                    @if ($about_content_details->getFirstSectionCard[$i]->getImageDetails != null)
                                                        <tr>
                                                            <td><img src="{{ asset('') }}{{ $about_content_details->getFirstSectionCard[$i]->getImageDetails->path }}"
                                                                    alt="..." height="50px" width="auto"></td>
                                                            <td>{{ $about_content_details->getFirstSectionCard[$i]->desc }}
                                                            </td>
                                                            <td>
                                                                <a onclick="editCard('{{ $about_content_details->getFirstSectionCard[$i]->id }}','section_1');"
                                                                    href="javascript:void(0)" data-toggle="modal"
                                                                    data-target="#Carddetailseditmodel"style="color: black;"><i
                                                                        class="material-icons"
                                                                        style="font-size: 15px;">&#xe3c9;</i></a>
                                                                <a href="javascript:void(0)"
                                                                    onclick="deleteCard('{{ $about_content_details->getFirstSectionCard[$i]->id }}','{{ $about_content_details->getFirstSectionCard[$i]->section_id }}')"
                                                                    style="color: black;"><i class="material-icons"
                                                                        style="font-size: 15px;">&#xe872;</i></a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endfor
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Section 2 :</legend>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="section_2_head_1"> Heading 1</label>
                                        <input type="text" class="form-control form-control-user"
                                            id="section_2_head_1" name="section_2_head_1"
                                            value="{{ $about_content_details->section_2_head_1 }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="section_2_desc_1"> Description 1</label>
                                        <textarea name="section_2_desc_1" class="form-control" id="section_2_desc_1">{{ $about_content_details->section_2_desc_1 }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="section_2_head_2"> Heading 2</label>
                                        <input type="text" class="form-control form-control-user"
                                            id="section_2_head_2" name="section_2_head_2"
                                            value="{{ $about_content_details->section_2_head_2 }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="section_2_desc_2"> Description 2</label>
                                        <textarea name="section_2_desc_2" class="form-control" id="section_2_desc_2">{{ $about_content_details->section_2_desc_2 }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="section_2_head_3"> Heading 3</label>
                                        <input type="text" class="form-control form-control-user"
                                            id="section_2_head_3" name="section_2_head_3"
                                            value="{{ $about_content_details->section_2_head_3 }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="section_2_desc_3"> Description 3</label>
                                        <textarea name="section_2_desc_3" class="form-control" id="section_2_desc_3">{{ $about_content_details->section_2_desc_3 }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <label class="form-label" for="section_2_img">Image:</label>
                                    </div>
                                    <div class="row col-md-10" style="margin-left:0px">
                                        <div style="width:80%;float:left">
                                            @if ($about_content_details->getsecondSectionImage != null)
                                                <input type="text" id="section_2_img" name="section_2_img"
                                                    class="form-control" readonly style="margin-bottom:15px"
                                                    value="{{ $about_content_details->getsecondSectionImage->file_name }}">
                                            @else
                                                <input type="text" id="section_2_img" name="section_2_img"
                                                    class="form-control" readonly style="margin-bottom:15px"
                                                    value="">
                                            @endif

                                            <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                class="lib" data-target="#showsModal" data-toggle="modal"
                                                onclick="setModalClickBtnId(document.getElementById('section_2_img'),'','','' )">
                                                Select or upload Image </div>
                                        </div>
                                        <div style="width: 18%;float:right;margin-left: 15px;">
                                            @if ($about_content_details->getsecondSectionImage != null)
                                                @if (in_array($about_content_details->getsecondSectionImage->file_ext, ['mp4', 'webm', 'ogg']))
                                                    <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                        alt="image not found" id="section_2_img_preview" height="100px"
                                                        width="auto" />
                                                @else
                                                    <img src="{{ asset('') }}{{ $about_content_details->getsecondSectionImage->path }}"
                                                        alt="image not found" id="section_2_img_preview" height="100px"
                                                        width="auto" />
                                                @endif
                                            @else
                                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                    alt="image not found" id="section_2_img_preview" height="100px"
                                                    width="auto" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Section 3 :</legend>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="objective_head"> Heading </label>
                                        <input type="text" class="form-control form-control-user" id="objective_head"
                                            name="objective_head" value="{{ $about_content_details->objective_head }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="objective_desc"> Description </label>
                                        <textarea name="objective_desc" class="form-control" id="objective_desc">{{ $about_content_details->objective_desc }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" style="min-height:50px;">
                                    <button type="button" class="btn btn-success float-right"
                                        onclick="addCard('section_3');" data-toggle="modal"
                                        data-target="#Section2carddetailsmodel" style="margin-top: 10px;">
                                        Add a new section </button>
                                </div>
                                <div class="col-md-12" id="section_3_card_container">
                                    <table>
                                        <thead>
                                            <tr>
                                                <td>Image </td>
                                                <td>Hover Image </td>
                                                <td>Content </td>
                                                <td>Action </td>
                                            </tr>
                                        </thead>
                                        <tbody id="section_3_card_container_body">
                                            @if (count($about_content_details->getThirdSectionCard))
                                                @for ($i = 0; $i < count($about_content_details->getThirdSectionCard); $i++)
                                                    <tr>
                                                        <td>
                                                            @if ($about_content_details->getThirdSectionCard[$i]->getImageDetails != null)
                                                                <img class="mb-3"
                                                                    src="{{ asset('') }}{{ $about_content_details->getThirdSectionCard[$i]->getImageDetails->path }}"
                                                                    alt="..." height="50px" width="auto">
                                                            @else
                                                                <img class="mb-3"
                                                                    src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                                    alt="..." height="50px" width="auto">
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if ($about_content_details->getThirdSectionCard[$i]->hoverImageDetails != null)
                                                                <img class="mb-3"
                                                                    src="{{ asset('') }}{{ $about_content_details->getThirdSectionCard[$i]->hoverImageDetails->path }}"
                                                                    alt="..." height="50px" width="auto">
                                                            @else
                                                                <img class="mb-3"
                                                                    src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                                    alt="..." height="50px" width="auto">
                                                            @endif
                                                        </td>

                                                        <td>
                                                            {{ $about_content_details->getThirdSectionCard[$i]->desc }}
                                                        </td>
                                                        <td><a onclick="editCard('{{ $about_content_details->getThirdSectionCard[$i]->id }}','section_3');"
                                                                href="javascript:void(0)" data-toggle="modal"
                                                                data-target="#Section2carddetailseditmodel"style="color: black;"><i
                                                                    class="material-icons"
                                                                    style="font-size: 15px;">&#xe3c9;</i></a>
                                                            <a href="javascript:void(0)"
                                                                onclick="deleteCard('{{ $about_content_details->getThirdSectionCard[$i]->id }}','{{ $about_content_details->getThirdSectionCard[$i]->section_id }}')"
                                                                style="color: black;"><i class="material-icons"
                                                                    style="font-size: 15px;">&#xe872;</i></a>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>

                            <button type="submit" class="btn btn-success" style="margin-left: 20px;margin-bottom:20px"
                                id="submit_btn">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')

    <div class="modal fade" id="Carddetailsmodel" tabindex="-1" role="dialog" aria-labelledby="CarddetailsmodelLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CarddetailsmodelLabel">Card details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            
                            <div class="col-md-2">
                                <label class="form-label" for="card_img">Image:</label>
                            </div>
                            <div class="row col-md-10" style="margin-left:0px">
                                <div style="width:79%;float:left">
                                    <input type="text" id="card_img" name="card_img" class="form-control" readonly
                                        style="margin-bottom:15px" value="">
                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                        data-target="#showsModal" data-toggle="modal"
                                        onclick="setModalClickBtnId(document.getElementById('card_img'),'','','' )">
                                        Select or upload Image </div>
                                </div>
                                <div style="width: 18%;float:right;margin-left: 15px;">
                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                        id="card_img_preview" height="100px" width="auto" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc_card" class="col-form-label">Desc:</label>
                            <textarea class="form-control" id="desc_card" placeholder=""></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveSectionDetails();">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Carddetailseditmodel" tabindex="-1" role="dialog"
        aria-labelledby="CarddetailsmodelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CarddetailsmodelLabel">Card details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="form-label" for="card_img_edit">Image:</label>
                            </div>
                            <div class="row col-md-10" style="margin-left:0px">
                                <div style="width:78%;float:left">
                                    <input type="text" id="card_img_edit" name="card_img_edit" class="form-control"
                                        readonly style="margin-bottom:15px" value="">
                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                        data-target="#showsModal" data-toggle="modal"
                                        onclick="setModalClickBtnId(document.getElementById('card_img_edit'),'','','' )">
                                        Select or upload Image </div>
                                </div>
                                <div style="width: 18%;float:right;margin-left: 15px;">
                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                        id="card_img_edit_preview" height="100px" width="auto" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc_card" class="col-form-label">Desc:</label>
                            <textarea class="form-control" id="desc_card_edit" placeholder=""></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateSectionDetails();">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Section2carddetailseditmodel" tabindex="-1" role="dialog"
        aria-labelledby="Section2carddetailseditmodelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Section2carddetailseditmodelLabel">Card details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="form-label" for="card_img_1_edit">Image:</label>
                            </div>
                            <div class="row col-md-10" style="margin-left:0px">
                                <div style="width:79%;float:left">
                                    <input type="text" id="card_img_1_edit" name="card_img_1_edit" class="form-control"
                                        readonly style="margin-bottom:15px" value="">
                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                        data-target="#showsModal" data-toggle="modal"
                                        onclick="setModalClickBtnId(document.getElementById('card_img_1_edit'),'','','' )">
                                        Select or upload Image </div>
                                </div>
                                <div style="width: 18%;float:right;margin-left: 15px;">
                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                        id="card_img_1_edit_preview" height="100px" width="auto" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="form-label" for="card_img_2_edit">Hover Image:</label>
                            </div>
                            <div class="row col-md-10" style="margin-left:0px">
                                <div style="width:79%;float:left">
                                    <input type="text" id="card_img_2_edit" name="card_img_2_edit" class="form-control"
                                        readonly style="margin-bottom:15px" value="">
                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                        data-target="#showsModal" data-toggle="modal"
                                        onclick="setModalClickBtnId(document.getElementById('card_img_2_edit'),'','','' )">
                                        Select or upload Image </div>
                                </div>
                                <div style="width: 18%;float:right;margin-left: 15px;">
                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                        id="card_img_2_edit_preview" height="100px" width="auto" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc_card" class="col-form-label">Desc:</label>
                            <textarea class="form-control" id="desc_2_card_edit" placeholder=""></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateThirdSectionDetails();">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Section2carddetailsmodel" tabindex="-1" role="dialog"
        aria-labelledby="Section2carddetailsmodelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Section2carddetailsmodelLabel">Card details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="form-label" for="card_img_1">Image:</label>
                            </div>
                            <div class="row col-md-10" style="margin-left:0px">
                                <div style="width:79%;float:left">
                                    <input type="text" id="card_img_1" name="card_img_1" class="form-control"
                                        readonly style="margin-bottom:15px" value="">
                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                        data-target="#showsModal" data-toggle="modal"
                                        onclick="setModalClickBtnId(document.getElementById('card_img_1'),'','','' )">
                                        Select or upload Image </div>
                                </div>
                                <div style="width: 18%;float:right;    margin-left: 15px;">
                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                        id="card_img_1_preview" height="100px" width="auto" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="form-label" for="card_img_2">Image:</label>
                            </div>
                            <div class="row col-md-10" style="margin-left:0px">
                                <div style="width:79%;float:left">
                                    <input type="text" id="card_img_2" name="card_img_2" class="form-control"
                                        readonly style="margin-bottom:15px" value="">
                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                        data-target="#showsModal" data-toggle="modal"
                                        onclick="setModalClickBtnId(document.getElementById('card_img_2'),'','','' )">
                                        Select or upload Image </div>
                                </div>
                                <div style="width: 18%;float:right;    margin-left: 15px;">
                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                        id="card_img_2_preview" height="100px" width="auto" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc_card_2" class="col-form-label">Desc:</label>
                            <textarea class="form-control" id="desc_card_2" placeholder=""></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveSecondSectionDetails();">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('after-scripts')
<script src="{{ asset('assets/dashboard/js/script.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/menu_banner_image_pos.js') }}"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('welcome_desc', {
                filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
        });


        let addCard = (section) => {
            $('#card_section_details').val('');
            $('#card_section_details').val(section);
        }

        let editCard = (id, section_id) => {
            $('#section_details_id').val(section_id);
            $.ajax({
                url: "{{ route('admin.content.about.card.edit') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': id,
                },
                success: function(data) {
                    if(section_id=='section_1'){
                        if (data.status == 'success') {
                            if (data.result != null) {
                                $('#card_details_id').val(data.result.id);
                                $('#desc_card_edit').val(data.result.desc);
                                if (data.result.get_image_details != null) {
                                    $('#card_img_edit_preview').attr('src', "{{ asset('') }}" +
                                        `${data.result.get_image_details.path}`);
                                    $('#card_img_edit').val(data.result.get_image_details.file_name);
                                }
                            }
                        }
                    }else{
                        if (data.status == 'success') {
                            if (data.result != null) {
                                $('#card_details_id').val(data.result.id);
                                $('#desc_2_card_edit').val(data.result.desc);
                                if (data.result.get_image_details != null) {
                                    $('#card_img_1_edit_preview').attr('src', "{{ asset('') }}" +
                                        `${data.result.get_image_details.path}`);
                                    $('#card_img_1_edit').val(data.result.get_image_details.file_name);
                                }
                                if (data.result.hover_image_details != null) {
                                    $('#card_img_2_edit_preview').attr('src', "{{ asset('') }}" +
                                        `${data.result.hover_image_details.path}`);
                                    $('#card_img_2_edit').val(data.result.hover_image_details.file_name);
                                }
                            }
                        }
                    }
                    // console.log(data);
                },
                error: function(error) {

                }
            });
        }

        let updateSectionDetails = () => {
            if ($('#card_img_edit').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please choose image',
                });
                return false;
            }
            if ($('#desc_card_edit').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please enter description',
                });
                return false;
            }
            $.ajax({
                url: "{{ route('admin.content.about.card.update') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'card_img': $('#card_img_edit').val(),
                    'desc_card': $('#desc_card_edit').val(),
                    'card_details_id': $('#card_details_id').val(),
                },
                success: function(data) {
                    if (data.status == 'success') {

                        Swal.fire(data.message);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: data.message,
                        });
                    }
                    html = '';
                    data.result.forEach(res => {
                        let img = '';
                        let alt_tag = '';
                        if (res.get_image_details != null) {
                            img = "{{ asset('') }}" + `${res.get_image_details.path}`;
                        } else {
                            img =
                                "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                        }
                        html +=
                            `<tr><td> <img src="${img}" height="50px" width="50px"> </td><td> ${res.desc} </td> <td><a onclick="editCard(${res.id},'${res.section_id}');" href="javascript:void(0)" data-toggle="modal" data-target="#Carddetailseditmodel" style="color: black;"><i class="material-icons" style="font-size: 15px;">&#xe3c9;</i></a>
                                <a href="javascript:void(0)" onclick="deleteCard(${res.id},'${res.section_id}')" style="color: black;"><i class="material-icons" style="font-size: 15px;">&#xe872;</i></a>
                                                            </td> </tr>`;

                    });
                    $('#' + $('#section_details_id').val() + '_card_container_body').html(html);

                },
                error: function(error) {
                    console.log(error);
                }
            });
            $('#card_img_edit_preview').attr("src", "{{ asset('assets/dashboard/images/image_not_found.png') }}");
            $('#card_img_edit').val("");
            $('#desc_card_edit').val("");
            $('#Carddetailseditmodel').modal('hide');
        }


        let updateThirdSectionDetails = () => {
            
            if ($('#card_img_1_edit').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please choose image',
                });
                return false;
            }
            if ($('#card_img_2_edit').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please choose hover image',
                });
                return false;
            }
            if ($('#desc_2_card_edit').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please enter description',
                });
                return false;
            }
            $.ajax({
                url: "{{ route('admin.content.about.card.update') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'card_img': $('#card_img_1_edit').val(),
                    'card_img_2': $('#card_img_2_edit').val(),
                    'desc_card': $('#desc_2_card_edit').val(),
                    'card_details_id': $('#card_details_id').val(),
                },
                success: function(data) {
                    if (data.status == 'success') {
                        Swal.fire(data.message);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: data.message,
                        });
                    }
                    html = '';
                    data.result.forEach(res => {
                        let img = '';
                        let img_2 = '';
                        let alt_tag = '';
                        if (res.get_image_details != null) {
                            img = "{{ asset('') }}" + `${res.get_image_details.path}`;
                        } else {
                            img =
                                "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                        }
                        if (res.hover_image_details != null) {
                            img_2 = "{{ asset('') }}" + `${res.hover_image_details.path}`;
                        } else {
                            img_2 =
                                "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                        }
                        html +=
                            `<tr><td> <img src="${img}" height="50px" width="50px"> </td><td> <img src="${img_2}" height="50px" width="50px"> </td><td> ${res.desc} </td> <td><a onclick="editCard(${res.id},'${res.section_id}');" href="javascript:void(0)" data-toggle="modal" data-target="#Section2carddetailseditmodel" style="color: black;"><i class="material-icons" style="font-size: 15px;">&#xe3c9;</i></a>
                                <a href="javascript:void(0)" onclick="deleteCard(${res.id},'${res.section_id}')" style="color: black;"><i class="material-icons" style="font-size: 15px;">&#xe872;</i></a>
                                                            </td> </tr>`;

                    });
                    $('#section_3_card_container_body').html(html);

                },
                error: function(error) {
                    console.log(error);
                }
            });
            $('#card_img_1_edit_preview').attr("src", "{{ asset('assets/dashboard/images/image_not_found.png') }}");
            $('#card_img_2_edit_preview').attr("src", "{{ asset('assets/dashboard/images/image_not_found.png') }}");
            $('#card_img_1_edit').attr("src", "{{ asset('assets/dashboard/images/image_not_found.png') }}");
            $('#card_img_2_edit').val("");
            $('#desc_2_card_edit').val("");
            $('#card_details_id').val("");
            $('#Section2carddetailseditmodel').modal('hide');
        }

        let deleteCard = (id, section_id) => {
            Swal.fire({
                title: 'Do you want to delete this card details?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `Don't`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.content.about.card.delete') }}",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': id,
                            'section_id': section_id,
                        },
                        success: function(data) {
                            html = '';
                            data.result.forEach(res => {
                                let img = '';
                                let img_2 = '';
                                let alt_tag = '';
                                if (res.get_image_details != null) {
                                    img = "{{ asset('') }}" +
                                        `${res.get_image_details.path}`;
                                } else {
                                    img =
                                        "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                                }

                                if(section_id=='section_3'){

                                    
                                    if (res.hover_image_details != null) {
                                        img_2 = "{{ asset('') }}" +
                                            `${res.hover_image_details.path}`;
                                    } else {
                                        img_2 =
                                            "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                                    }
                                    html +=
                                    `<tr><td> <img src="${img}" height="50px" width="50px"> </td><td> <img src="${img_2}" height="50px" width="50px"> </td><td> ${res.desc} </td> <td><a onclick="editCard(${res.id},'${res.section_id}');" href="javascript:void(0)" data-toggle="modal" data-target="#Carddetailseditmodel" style="color: black;"><i class="material-icons" style="font-size: 15px;">&#xe3c9;</i></a>
                                    <a href="javascript:void(0)" onclick="deleteCard(${res.id},'${res.section_id}')" style="color: black;"><i class="material-icons" style="font-size: 15px;">&#xe872;</i></a></td> </tr>`;
                                }else{
                                    html +=
                                    `<tr><td> <img src="${img}" height="50px" width="50px"> </td><td> ${res.desc} </td> <td><a onclick="editCard(${res.id},'${res.section_id}');" href="javascript:void(0)" data-toggle="modal" data-target="#Carddetailseditmodel" style="color: black;"><i class="material-icons" style="font-size: 15px;">&#xe3c9;</i></a>
                                    <a href="javascript:void(0)" onclick="deleteCard(${res.id},'${res.section_id}')" style="color: black;"><i class="material-icons" style="font-size: 15px;">&#xe872;</i></a></td> </tr>`;
                                }

                               

                            });
                            $('#' + section_id + '_card_container_body').html(
                                html);
                            Swal.fire(data.message);
                        },
                        error: function(error) {

                        }
                    });
                }
            })
        }

        let saveSectionDetails = () => {
            if ($('#card_img').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please choose image',
                });
                return false;
            }
            if ($('#desc_card').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please enter description',
                });
                return false;
            }
            let section_id = $('#card_section_details').val();
            $('#' + $('#card_section_details').val() + '_card_container').removeClass('disp-none');
            $.ajax({
                url: "{{ route('admin.content.about.card.create') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'card_img': $('#card_img').val(),
                    'desc_card': $('#desc_card').val(),
                    'section_id': $('#card_section_details').val(),
                    'about_contents_id': "{{ $about_content_details->id }}",
                },
                success: function(data) {
                    html = '';
                    data.result.forEach(res => {
                        let img = '';
                        let alt_tag = '';
                        if (res.get_image_details != null) {
                            img = "{{ asset('') }}" + `${res.get_image_details.path}`;;
                        } else {
                            img = "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                        }
                        html +=
                            `<tr><td> <img src="${img}" height="50px" width="50px"> </td><td> ${res.desc} </td> <td>
                            <a onclick="editCard('${res.id}','${res.section_id}');"
                                href="javascript:void(0)" data-toggle="modal"
                                data-target="#Carddetailseditmodel"style="color: black;"><i
                                    class="material-icons"
                                    style="font-size: 15px;">&#xe3c9;</i></a>
                            <a href="javascript:void(0)"
                                onclick="deleteCard('${res.id}','${res.section_id}')"
                                style="color: black;"><i class="material-icons"
                                    style="font-size: 15px;">&#xe872;</i></a>
                                                            </td>  </tr>`;

                    });
                    $('#' + $('#card_section_details').val() + '_card_container_body').html(html);
                    Swal.fire(data.message);
                },
                error: function(error) {
                    console.log(error);
                }
            });
            $('#card_img_preview').attr("src", "{{ asset('assets/dashboard/images/image_not_found.png') }}");
            $('#card_img').val("");
            $('#desc_card').val("");
            $('#Carddetailsmodel').modal('hide');
        }

        let saveSecondSectionDetails = () => {

            if ($('#card_img_1').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please choose image',
                });
                return false;
            }
            if ($('#card_img_2').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please choose image',
                });
                return false;
            }
            if ($('#desc_card_2').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please enter description',
                });
                return false;
            }

            $('#' + $('#card_section_details').val() + '_card_container').removeClass('disp-none');
            $.ajax({
                url: "{{ route('admin.content.about.card.create') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'card_img': $('#card_img_1').val(),
                    'card_img_2': $('#card_img_2').val(),
                    'desc_card': $('#desc_card_2').val(),
                    'section_id': $('#card_section_details').val(),
                    'about_contents_id': "{{ $about_content_details->id }}",
                },
                success: function(data) {
                    html = '';
                    data.result.forEach(res => {
                        let img = '';
                        let img2 = '';
                        let alt_tag = '';
                        if (res.get_image_details != null) {
                            img = "{{ asset('') }}" + `${res.get_image_details.path}`;;
                        } else {
                            img = "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                        }

                        if (res.hover_image_details != null) {
                            img2 = "{{ asset('') }}" + `${res.hover_image_details.path}`;;
                        } else {
                            img2 = "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                        }
                        html +=
                            `<tr><td> <img src="${img}" height="50px" width="50px"> </td><td> <img src="${img2}" height="50px" width="50px"> </td><td> ${res.desc} </td><td>
                            <a onclick="editCard('${res.id}','${res.section_id}');"
                                href="javascript:void(0)" data-toggle="modal"
                                data-target="#Section2carddetailseditmodel"style="color: black;"><i
                                    class="material-icons"
                                    style="font-size: 15px;">&#xe3c9;</i></a>
                            <a href="javascript:void(0)"
                                onclick="deleteCard('${res.id}','${res.section_id}')"
                                style="color: black;"><i class="material-icons"
                                    style="font-size: 15px;">&#xe872;</i></a>
                                                            </td></tr>`;

                    });
                    $('#' + $('#card_section_details').val() + '_card_container_body').html(html);
                    Swal.fire(data.message);
                },
                error: function(error) {
                    console.log(error);
                }
            });
            $('#card_img_1_preview').attr("src", "{{ asset('assets/dashboard/images/image_not_found.png') }}");
            $('#card_img_2_preview').attr("src", "{{ asset('assets/dashboard/images/image_not_found.png') }}");
            $('#card_img_2').val("");
            $('#card_img_1').val("");
            $('#desc_card_2').val("");
            $('#Section2carddetailsmodel').modal('hide');
        }

        let validateForm = () => {
            let msg = '';
            if ($('#page_name').val() == '') {
                msg = 'Page name must not be empty';
            }
            if ($('#meta_title').val() == '') {
                msg = 'Meta title must not be empty';
            }
            if ($('#meta_keyword').val() == '') {
                msg = 'Meta keywords must not be empty';
            }
            if ($('#meta_description').val() == '') {
                msg = 'Meta description must not be empty';
            }
            if ($('#banner_title').val() == '') {
                msg = 'Banner title must not be empty';
            }
            if ($('#banner_image_web').val() == '') {
                msg = 'Please choose banner image for web';
            }
            if ($('#banner_image_tablet').val() == '') {
                msg = 'Please choose banner image for tablet';
            }
            if ($('#banner_image_mobile').val() == '') {
                msg = 'Please choose banner image for mobile';
            }
            if ($('#welcome_head').val() == '') {
                msg = 'welcome text must not be empty';
            }
            if (CKEDITOR.instances['welcome_desc'].getData() == '') {
                msg = 'welcome description must not be empty';
            }
            if ($('#section_2_head_1').val() == '') {
                msg = "Second section's first heading must not be empty";
            }
            if ($('#section_2_desc_1').val() == '') {
                msg = "Second section's first description must not be empty";
            }
            if ($('#section_2_head_2').val() == '') {
                msg = "Second section's second heading must not be empty";
            }
            if ($('#section_2_desc_2').val() == '') {
                msg = "Second section's second description must not be empty";
            }
            if ($('#section_2_head_3').val() == '') {
                msg = "Second section's third heading must not be empty";
            }
            if ($('#section_2_desc_3').val() == '') {
                msg = "Second section's third description must not be empty";
            }
            if ($('#section_2_img').val() == '') {
                msg = 'Please choose image for second section';
            }
            if ($('#objective_head').val() == '') {
                msg = "Third section's heading must not be empty";
            }
            // if ($('#objective_desc').val() == '') {
            //     msg = "Third section's description must not be empty";
            // }

            if ($('#section_1_card_container_body').children('tr').length < 4) {
                msg = "Please add minimum 4 card sections under section 1";
            }

            if ($('#section_3_card_container_body').children('tr').length < 5) {
                msg = "Please add minimum 5 card sections under section 3";
            }

            if (msg == '') {
                return true;
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: msg,
                })
                return false;
            }
        }
    </script>
@endpush
