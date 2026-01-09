@extends('dashboard.layouts.master')
@section('title', __('Edit Home Page Content'))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}">
@endpush
@section('content')
    @include('dashboard.common.index')
    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Edit Home Page Content') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    <a href="{{ route('admin.contents.manage') }}">{{ __('Content Manager') }}</a>
                </small>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.content.home.page.update') }}" method="POST" id="homepage_form" onsubmit="return validateForm();">
                            @csrf
                            <input type="hidden" name="base_url" id="base_url" value="{{ url('') }}">
                            <input type="hidden" name="content_id" id="content_id" value="{{ $home->content_id }}">
                            <input type="hidden" name="home_content_uuid" id="home_content_uuid"
                                value="{{ $home->uuid }}">
                            <fieldset>
                                <legend>Page Info :</legend>
                                <div class="form-group row">
                                    <div class="col-md-2"> <label class="form-control-label"> Page Name<span
                                                class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="page_name" id="page_name" type="text"
                                                oninput="generatePageSlug(this.value,'page_slug','home','draft_btn','submit_btn','{{ $home->page_name }}')"
                                                value="{{ $home->page_name }}"></span>
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
                                                value="{{ $home->page_slug }}" readonly></span>
                                        <span id="page_slug_error"> </span>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Meta Title<span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-sm-10"> <span class="pr-field"><input placeholder=""
                                                class="form-control" dir="ltr" name="meta_title" id="meta_title"
                                                type="text" value="{{ $home->meta_title }}"></span>
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
                                                value="{{ $home->meta_keyword }}"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2"> <label class=" form-control-label"> Meta
                                            Description
                                            <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="meta_description" id="meta_description" type="text"
                                                value="{{ $home->meta_description }}"></span>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Banner Section :</legend>
                                <div class="card-body" style="padding:10px">
                                    <div class="mb-3" style="padding:10px">

                                        <div class="col-md-2">
                                            <label class="form-label" for="banner_image_web">Desktop Banner Image:(1339px
                                                x 300px)</label>
                                        </div>

                                        <div class="row col-md-10" style="margin-left:0px">
                                            <div style="width:80%;float:left">
                                                @if ($home->getBannerImageWeb != null)
                                                    <input type="text" id="banner_image_web" name="banner_image_web"
                                                        class="form-control" readonly style="margin-bottom:15px"
                                                        value="{{ $home->getBannerImageWeb->file_name }}">
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
                                            <div style="width: 18%;float:right;    margin-left: 15px;">
                                                @if ($home->getBannerImageWeb != null)
                                                    @if (in_array($home->getBannerImageWeb->file_ext, ['mp4', 'webm', 'ogg']))
                                                        <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                            id="banner_image_web_preview" height="100px"
                                                            width="auto" />
                                                    @else
                                                        <img src="{{ asset('') }}{{ $home->getBannerImageWeb->path }}"
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
                                                @if ($home->getBannerImageTab != null)
                                                    <input type="text" id="banner_image_tablet"
                                                        name="banner_image_tablet" class="form-control" readonly
                                                        style="margin-bottom:15px"
                                                        value="{{ $home->getBannerImageTab->file_name }}">
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
                                                @if ($home->getBannerImageTab != null)
                                                    @if (in_array($home->getBannerImageTab->file_ext, ['mp4', 'webm', 'ogg']))
                                                        <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                            id="banner_image_tablet_preview" height="100px"
                                                            width="auto" />
                                                    @else
                                                        <img src="{{ asset('') }}{{ $home->getBannerImageTab->path }}"
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
                                                @if ($home->getBannerImageMobile != null)
                                                    <input type="text" id="banner_image_mobile"
                                                        name="banner_image_mobile" class="form-control" readonly
                                                        style="margin-bottom:15px"
                                                        value="{{ $home->getBannerImageMobile->file_name }}">
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
                                            <div style="width: 18%;float:right;margin-left: 15px;">
                                                @if ($home->getBannerImageMobile != null)
                                                    @if (in_array($home->getBannerImageMobile->file_ext, ['mp4', 'webm', 'ogg']))
                                                        <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                            id="banner_image_mobile_preview" height="100px"
                                                            width="auto" />
                                                    @else
                                                        <img src="{{ asset('') }}{{ $home->getBannerImageMobile->path }}"
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
                            </fieldset>
                            <fieldset>
                                <legend>Home slider :</legend>
                                <div class="slider-content-main-container" id="slider-content-main-container">
                                    <div class="col-md-12" style="min-height:50px;">
                                        <button type="button" class="btn btn-success float-right" data-toggle="modal"
                                            data-target="#Homeslidermodel" style="margin-top: 10px;">
                                            Add Slider Content </button>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-bordered m-a-0" id="slider-content-table">
                                                <thead class="dker">
                                                    <tr>
                                                        <th class="custom-th">{{ __('Sl') }}</th>
                                                        <th class="custom-th">{{ __('Heading') }}</th>
                                                        <th class="custom-th">{{ __('Description') }}</th>
                                                        <th class="custom-th">{{ __('Button Text') }}</th>
                                                        <th class="custom-th">{{ __('Button Link') }}</th>
                                                        <th class="text-center" style="width:200px;">
                                                            {{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="slider-content-container">
                                                    @if (count($home->getSliders))
                                                        @foreach ($home->getSliders as $key => $val)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $val->slider_heading }}</td>
                                                                <td>{{ $val->slider_desc }}</td>
                                                                <td>{{ $val->slider_button_text }}</td>
                                                                <td>{{ $val->slider_button_link }}</td>
                                                                <td class="action_table_data">
                                                                    <a href="javascript:void(0)"
                                                                        onclick="editHomeSection('{{ $val->id }}','home_slider')"
                                                                        class="btn btn-info btn-circle btn-sm mr-2">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <a onclick="deleteHomeSection('{{ $val->id }}','home_slider')"
                                                                        class="btn btn-danger btn-circle btn-sm">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Welcome Section :</legend>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="heading"> Heading <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-user"
                                            id="section_1_heading" name="section_1_heading"
                                            value="{{ $home->section_1_heading }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="section_1_desc"> Description <span
                                                class="text-danger">*</span></label>
                                        <textarea name="section_1_desc" class="form-control" id="section_1_desc">{{ $home->section_1_desc }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="section_1_button_text"> Button Text<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="section_1_button_text"
                                            name="section_1_button_text" value="{{ $home->section_1_button_text }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="section_1_button_link"> Button Link<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="section_1_button_link"
                                            name="section_1_button_link" value="{{ $home->section_1_button_link }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <label class="form-label" for="section_1_img_1">First Image:<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="row col-md-10" style="margin-left:0px">
                                        <div style="width:80%;float:left">
                                            @if ($home->getfirstSectionfirstImage!= null)
                                                <input type="text" id="section_1_img_1" name="section_1_img_1"
                                                    class="form-control" readonly style="margin-bottom:15px"
                                                    value="{{ $home->getfirstSectionfirstImage->file_name }}">
                                            @else
                                                <input type="text" id="section_1_img_1" name="section_1_img_1"
                                                    class="form-control" readonly style="margin-bottom:15px"
                                                    value="">
                                            @endif
                                            <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                class="lib" data-target="#showsModal" data-toggle="modal"
                                                onclick="setModalClickBtnId(document.getElementById('section_1_img_1'),'','','' )">
                                                Select or upload Image </div>
                                        </div>
                                        <div style="width: 18%;float:right;margin-left: 15px;">
                                            @if ($home->getfirstSectionfirstImage != null)
                                                @if (in_array($home->getfirstSectionfirstImage->file_ext, ['mp4', 'webm', 'ogg']))
                                                    <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                        id="section_1_img_1_preview" height="100px" width="auto" />
                                                @else
                                                    <img src="{{ asset('') }}{{ $home->getfirstSectionfirstImage->path }}"
                                                        id="section_1_img_1_preview" height="100px" width="auto" />
                                                @endif
                                            @else
                                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="section_1_img_1_preview" height="100px" width="auto" />
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <label class="form-label" for="section_1_img_2">Second Image:<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="row col-md-10" style="margin-left:0px">
                                        <div style="width:80%;float:left">
                                            @if ($home->getfirstSectionsecondImage != null)
                                                <input type="text" id="section_1_img_2" name="section_1_img_2"
                                                    class="form-control" readonly style="margin-bottom:15px"
                                                    value="{{ $home->getfirstSectionsecondImage->file_name }}">
                                            @else
                                                <input type="text" id="section_1_img_2" name="section_1_img_2"
                                                    class="form-control" readonly style="margin-bottom:15px"
                                                    value="">
                                            @endif
                                            <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                class="lib" data-target="#showsModal" data-toggle="modal"
                                                onclick="setModalClickBtnId(document.getElementById('section_1_img_2'),'','','' )">
                                                Select or upload Image </div>
                                        </div>
                                        <div style="width: 18%;float:right;margin-left: 15px;">
                                            @if ($home->getfirstSectionsecondImage != null)
                                                @if (in_array($home->getfirstSectionsecondImage->file_ext, ['mp4', 'webm', 'ogg']))
                                                    <img src="{{ asset('assets/dashboard/images/demo_img.jpg') }}"
                                                        id="section_1_img_2_preview" height="100px" width="auto" />
                                                @else
                                                    <img src="{{ asset('') }}{{ $home->getfirstSectionsecondImage->path }}"
                                                        id="section_1_img_2_preview" height="100px" width="auto" />
                                                @endif
                                            @else
                                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="section_1_img_2_preview" height="100px" width="auto" />
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Home Cards :</legend>
                                <div class="card-content-main-container" id="card-content-main-container">
                                    <div class="col-md-12" style="min-height:50px;">
                                        <button type="button" class="btn btn-success float-right" data-toggle="modal"
                                            data-target="#Homecardmodel" style="margin-top: 10px;">
                                            Add Card Content </button>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-bordered m-a-0" id="card-content-table">
                                                <thead class="dker">
                                                    <tr>
                                                        <th class="custom-th">{{ __('Sl') }}</th>
                                                        <th class="custom-th">{{ __('Heading') }}</th>
                                                        <th class="custom-th">{{ __('Description') }}</th>
                                                        <th class="custom-th">{{ __('Button Text') }}</th>
                                                        <th class="custom-th">{{ __('Button Link') }}</th>
                                                        <th class="custom-th">{{ __('Image') }}</th>
                                                        <th class="text-center" style="width:200px;">
                                                            {{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="card-content-container">
                                                    @if (count($home->getFirstSectionCards))
                                                        @foreach ($home->getFirstSectionCards as $key => $val)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $val->heading }}</td>
                                                                <td>{{ $val->description }}</td>
                                                                <td>{{ $val->view_more_text }}</td>
                                                                <td>{{ $val->view_more_link }}</td>
                                                                <td>
                                                                    @if ($val->getCardImage != null)
                                                                        <img src="{{ asset('') }}{{ $val->getCardImage->path }}"
                                                                            height="auto" width="100" />
                                                                    @else
                                                                        <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                                            height="auto" width="100" />
                                                                    @endif
                                                                </td>
                                                                <td class="action_table_data">
                                                                    <a href="javascript:void(0)"
                                                                        onclick="editHomeSection('{{ $val->id }}','home_card')"
                                                                        class="btn btn-info btn-circle btn-sm mr-2">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <a onclick="deleteHomeSection('{{ $val->id }}','home_card')"
                                                                        class="btn btn-danger btn-circle btn-sm">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Partners :</legend>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="heading"> Heading <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-user"
                                            id="section_2_heading" name="section_2_heading"
                                            value="{{ $home->section_2_heading }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="section_2_desc"> Description <span
                                                class="text-danger">*</span></label>
                                        <textarea name="section_2_desc" class="form-control" id="section_2_desc">{{ $home->section_2_desc }}</textarea>
                                    </div>
                                </div>
                                <div class="partner-content-main-container" id="partner-content-main-container">
                                    <div class="col-md-12" style="min-height:50px;">
                                        <button type="button" class="btn btn-success float-right" data-toggle="modal"
                                            data-target="#Homepartnermodel" style="margin-top: 10px;">
                                            Add Partners </button>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-bordered m-a-0" id="partner-content-table">
                                                <thead class="dker">
                                                    <tr>
                                                        <th class="custom-th">{{ __('Sl') }}</th>
                                                        <th class="custom-th">{{ __('Name') }}</th>
                                                        <th class="custom-th">{{ __('Link') }}</th>
                                                        <th class="custom-th">{{ __('Image') }}</th>
                                                        <th class="text-center" style="width:200px;">
                                                            {{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="partner-content-container">
                                                    @if (count($home->getPartners))
                                                        @foreach ($home->getPartners as $key => $val)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $val->hover_text }}</td>
                                                                <td>{{ $val->hover_link }}</td>
                                                                <td>
                                                                    @if ($val->getPartnerImage != null)
                                                                        <img src="{{ asset('') }}{{ $val->getPartnerImage->path }}"
                                                                            height="auto" width="100" />
                                                                    @else
                                                                        <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                                            height="auto" width="100" />
                                                                    @endif
                                                                </td>
                                                                <td class="action_table_data">
                                                                    <a href="javascript:void(0)"
                                                                        onclick="editHomeSection('{{ $val->id }}','home_partner')"
                                                                        class="btn btn-info btn-circle btn-sm mr-2">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <a onclick="deleteHomeSection('{{ $val->id }}','home_partner')"
                                                                        class="btn btn-danger btn-circle btn-sm">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Home Bottom Cards :</legend>
                                <div class="final-card-content-main-container" id="final-card-content-main-container">
                                    <div class="col-md-12" style="min-height:50px;">
                                        <button type="button" class="btn btn-success float-right" data-toggle="modal"
                                            data-target="#Homefinalcardmodel" style="margin-top: 10px;">
                                            Add Card Content </button>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-bordered m-a-0" id="final-card-content-table">
                                                <thead class="dker">
                                                    <tr>
                                                        <th class="custom-th">{{ __('Sl') }}</th>
                                                        <th class="custom-th">{{ __('Heading') }}</th>
                                                        <th class="custom-th">{{ __('Description') }}</th>
                                                        <th class="custom-th">{{ __('Button Text') }}</th>
                                                        <th class="custom-th">{{ __('Button Link') }}</th>
                                                        <th class="custom-th">{{ __('Image') }}</th>
                                                        <th class="text-center" style="width:200px;">
                                                            {{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="final-card-content-container">
                                                    @if (count($home->getFinalSectionCards))
                                                        @foreach ($home->getFinalSectionCards as $key => $val)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $val->heading }}</td>
                                                                <td>{{ $val->description }}</td>
                                                                <td>{{ $val->read_more_button_text }}</td>
                                                                <td>{{ $val->read_more_link }}</td>
                                                                <td>
                                                                    @if ($val->getCardImage != null)
                                                                        <img src="{{ asset('') }}{{ $val->getCardImage->path }}"
                                                                            height="auto" width="100" />
                                                                    @else
                                                                        <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                                            height="auto" width="100" />
                                                                    @endif
                                                                </td>
                                                                <td class="action_table_data">
                                                                    <a href="javascript:void(0)"
                                                                        onclick="editHomeSection('{{ $val->id }}','home_final_card')"
                                                                        class="btn btn-info btn-circle btn-sm mr-2">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <a onclick="deleteHomeSection('{{ $val->id }}','home_final_card')"
                                                                        class="btn btn-danger btn-circle btn-sm">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
    {{-- Home slider modal --}}
    <div class="modal fade" id="Homeslidermodel" tabindex="-1" role="dialog" aria-labelledby="HomeslidermodelLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="HomeslidermodelLabel">Slider details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="slider_unique" id="slider_unique" value="" />
                    <div class="form-group">
                        <label for="slider_heading">Slider Heading</label>
                        <textarea name="slider_heading" class="form-control" id="slider_heading"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="slider_desc">Slider Description</label>
                        <textarea name="slider_desc" class="form-control" id="slider_desc"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="slider_button_text">Slider Button Text</label>
                        <input type="text" class="form-control" id="slider_button_text"
                            placeholder="Slider Button text" name="slider_button_text">
                    </div>
                    <div class="form-group">
                        <label for="slider_button_link">Slider Button Link</label>
                        <input type="text" class="form-control" id="slider_button_link"
                            placeholder="Slider Button link" name="slider_button_link">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveHomeSlider();">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Home first section card modal --}}
    <div class="modal fade" id="Homecardmodel" tabindex="-1" role="dialog" aria-labelledby="HomecardmodelLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="HomecardmodelLabel">Card details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="card_unique" id="card_unique" value="" />
                    <div class="form-group">
                        <label for="card_heading">Card Heading</label>
                        <textarea name="card_heading" class="form-control" id="card_heading"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="card_desc">Card Description</label>
                        <textarea name="card_desc" class="form-control" id="card_desc"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="card_link_text">Card Link Text</label>
                        <input type="text" class="form-control" id="card_link_text" name="card_link_text">
                    </div>
                    <div class="form-group">
                        <label for="card_link">Card Link</label>
                        <input type="text" class="form-control" id="card_link" name="card_link">
                    </div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveHomeCard();">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Home partner section modal --}}
    <div class="modal fade" id="Homepartnermodel" tabindex="-1" role="dialog" aria-labelledby="HomepartnermodelLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="HomepartnermodelLabel">Partner details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="partner_unique" id="partner_unique" value="" />
                    <div class="form-group">
                        <label for="partner_name">Partner Name</label>
                        <textarea name="partner_name" class="form-control" id="partner_name"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="partner_link">Partner Link</label>
                        <input type="text" class="form-control" id="partner_link" name="partner_link">
                    </div>
                    <div class="form-group">
                        <div class="col-md-2">
                            <label class="form-label" for="partner_img">Image:</label>
                        </div>
                        <div class="row col-md-10" style="margin-left:0px">
                            <div style="width:79%;float:left">
                                <input type="text" id="partner_img" name="partner_img" class="form-control" readonly
                                    style="margin-bottom:15px" value="">
                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                    data-target="#showsModal" data-toggle="modal"
                                    onclick="setModalClickBtnId(document.getElementById('partner_img'),'','','' )">
                                    Select or upload Image </div>
                            </div>
                            <div style="width: 18%;float:right;margin-left: 15px;">
                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                    id="partner_img_preview" height="auto" width="200px" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveHomePartner();">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Home final card section modal --}}
    <div class="modal fade" id="Homefinalcardmodel" tabindex="-1" role="dialog"
        aria-labelledby="HomefinalcardmodelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="HomefinalcardmodelLabel">Card details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="final_card_unique" id="final_card_unique" value="" />
                    <div class="form-group">
                        <label for="final_card_heading">Card Heading</label>
                        <textarea name="final_card_heading" class="form-control" id="final_card_heading"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="final_card_desc">Card Description</label>
                        <textarea name="final_card_desc" class="form-control" id="final_card_desc"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="final_card_link_text">Card Link Text</label>
                        <input type="text" class="form-control" id="final_card_link_text"
                            name="final_card_link_text">
                    </div>
                    <div class="form-group">
                        <label for="final_card_link">Card Link</label>
                        <input type="text" class="form-control" id="final_card_link" name="final_card_link">
                    </div>
                    <div class="form-group">
                        <div class="col-md-2">
                            <label class="form-label" for="final_card_img">Image:</label>
                        </div>
                        <div class="row col-md-10" style="margin-left:0px">
                            <div style="width:79%;float:left">
                                <input type="text" id="final_card_img" name="final_card_img" class="form-control"
                                    readonly style="margin-bottom:15px" value="">
                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                    data-target="#showsModal" data-toggle="modal"
                                    onclick="setModalClickBtnId(document.getElementById('final_card_img'),'','','' )">
                                    Select or upload Image </div>
                            </div>
                            <div style="width: 18%;float:right;margin-left: 15px;">
                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                    id="final_card_img_preview" height="100px" width="auto" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveHomeFinalSectionCard();">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/validation.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/menu_banner_image_pos.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#slider-content-table').DataTable({
                "searching": false,
                "paging": false
            });
            $('#card-content-table').DataTable({
                "searching": false,
                "paging": false
            });
            $('#partner-content-table').DataTable({
                "searching": false,
                "paging": false
            });
            $('#final-card-content-table').DataTable({
                "searching": false,
                "paging": false
            });
        });


        // Save or update dynamic slider section
        let saveHomeSlider = () => {
            let link_url = '';
            let validate_arr = [
                'slider_heading',
                'slider_desc',
                'slider_button_text',
                'slider_button_link'
            ];
            let is_validated = validate(validate_arr);
            if (is_validated > 0) {
                return false;
            }
            if ($('#slider_unique').val() == '') {
                link_url = "{{ route('admin.content.home.slider.create') }}";
            } else {
                link_url = "{{ route('admin.content.home.slider.update') }}";
            }
            $.ajax({
                url: link_url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'slider_heading': $('#slider_heading').val(),
                    'slider_desc': $('#slider_desc').val(),
                    'slider_button_text': $('#slider_button_text').val(),
                    'slider_button_link': $('#slider_button_link').val(),
                    'slider_unique': $('#slider_unique').val(),
                    'content_id': "{{ $home->content_id }}",
                    'home_content_uuid' : "{{ $home->uuid }}"
                },
                success: function(data) {
                    $('#slider_unique').val('');
                    clearValues(validate_arr);
                    if (data.status == 'success') {
                        if (data.result.length) {
                            let home_slider_content = '';
                            let index = 0;
                            data.result.forEach(element => {
                                index++;
                                home_slider_content += `
                                    <tr>
                                        <td>${index}</td>
                                        <td>${element.slider_heading}</td>
                                        <td>${element.slider_desc}</td>
                                        <td>${element.slider_button_text}</td>
                                        <td>${element.slider_button_link}</td>
                                        <td class="action_table_data">
                                            <a href="javascript:void(0)" onclick="editHomeSection('${element.id}','home_slider')" class="btn btn-info btn-circle btn-sm mr-2">
                                            <i class="fas fa-edit"></i>
                                            </a>
                                            <a onclick="deleteHomeSection('${element.id}','home_slider')" class="btn btn-danger btn-circle btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                                </a>
                                        </td>
                                    </tr>
                                `;
                            });
                            $('#slider-content-container').html(home_slider_content);
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: data.message,
                        });
                    }
                    $('#Homeslidermodel').modal('hide');
                },
                error: function(error) {
                    $('#slider_unique').val('');
                    clearValues(validate_arr);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Something went wrong please try after some time',
                    });
                    $('#Homeslidermodel').modal('hide');
                }
            });

        }

        // Save or update first section card section
        let saveHomeCard = () => {
            $('#card_img_preview').attr('src', "{{ asset('assets/dashboard/images/image_not_found.png') }}");
            let link_url = '';
            let validate_arr = [
                'card_heading',
                'card_desc',
                'card_link_text',
                'card_link',
                'card_img',
            ];
            let is_validated = validate(validate_arr);
            if (is_validated > 0) {
                return false;
            }
            if ($('#card_unique').val() == '') {
                link_url = "{{ route('admin.content.home.first.card.create') }}";
            } else {
                link_url = "{{ route('admin.content.home.first.card.update') }}";
            }
            $.ajax({
                url: link_url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'card_heading': $('#card_heading').val(),
                    'card_desc': $('#card_desc').val(),
                    'card_link_text': $('#card_link_text').val(),
                    'card_img': $('#card_img').val(),
                    'card_link': $('#card_link').val(),
                    'card_unique': $('#card_unique').val(),
                    'content_id': "{{ $home->content_id }}",
                    'home_content_uuid' : "{{ $home->uuid }}"
                },
                success: function(data) {
                    $('#card_unique').val('');
                    clearValues(validate_arr);
                    if (data.status == 'success') {
                        if (data.result.length) {
                            let home_card_content = '';
                            let image = "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                            let index = 0;
                            data.result.forEach(element => {
                                if (element.get_card_image != null) {
                                    image = "{{ asset('') }}" +
                                        `${element.get_card_image.path}`;
                                }
                                index++;
                                home_card_content += `
                                    <tr>
                                        <td>${index}</td>
                                        <td>${element.heading}</td>
                                        <td>${element.description}</td>
                                        <td>${element.view_more_text}</td>
                                        <td>${element.view_more_link}</td>
                                        <td><img src="${image}" height="auto" width="100px"/></td>
                                        <td class="action_table_data">
                                            <a href="javascript:void(0)" onclick="editHomeSection('${element.id}','home_card')" class="btn btn-info btn-circle btn-sm mr-2">
                                            <i class="fas fa-edit"></i>
                                            </a>
                                            <a onclick="deleteHomeSection('${element.id}','home_card')" class="btn btn-danger btn-circle btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                                </a>
                                        </td>
                                    </tr>
                                `;
                            });
                            $('#card-content-container').html(home_card_content);
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: data.message,
                        });
                    }
                    $('#Homecardmodel').modal('hide');
                },
                error: function(error) {
                    $('#card_unique').val('');
                    clearValues(validate_arr);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Something went wrong please try after some time',
                    });
                    $('#Homecardmodel').modal('hide');
                }
            });
        }

        // Save or update partner card section
        let saveHomePartner = () => {
            $('#partner_img_preview').attr('src', "{{ asset('assets/dashboard/images/image_not_found.png') }}");
            let link_url = '';
            let validate_arr = [
                'partner_name',
                'partner_link',
                'partner_img',
            ];
            let is_validated = validate(validate_arr);
            if (is_validated > 0) {
                return false;
            }
            console.log($('#partner_unique').val());
            if ($('#partner_unique').val() == '') {
                link_url = "{{ route('admin.content.home.partner.create') }}";
            } else {
                link_url = "{{ route('admin.content.home.partner.update') }}";
            }
            $.ajax({
                url: link_url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'partner_name': $('#partner_name').val(),
                    'partner_link': $('#partner_link').val(),
                    'partner_img': $('#partner_img').val(),
                    'partner_unique': $('#partner_unique').val(),
                    'content_id': "{{ $home->content_id }}",
                    'home_content_uuid' : "{{ $home->uuid }}"
                },
                success: function(data) {
                    $('#partner_unique').val('');
                    clearValues(validate_arr);
                    if (data.status == 'success') {
                        if (data.result.length) {
                            let home_partner_content = '';
                            let image = "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                            let index = 0;
                            data.result.forEach(element => {
                                if (element.get_partner_image != null) {
                                    image = "{{ asset('') }}" +
                                        `${element.get_partner_image.path}`;
                                }
                                index++;
                                home_partner_content += `
                                    <tr>
                                        <td>${index}</td>
                                        <td>${element.hover_text}</td>
                                        <td>${element.hover_link}</td>
                                        <td><img src="${image}" height="auto" width="100px"/></td>
                                        <td class="action_table_data">
                                            <a href="javascript:void(0)" onclick="editHomeSection('${element.id}','home_partner')" class="btn btn-info btn-circle btn-sm mr-2">
                                            <i class="fas fa-edit"></i>
                                            </a>
                                            <a onclick="deleteHomeSection('${element.id}','home_partner')" class="btn btn-danger btn-circle btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                                </a>
                                        </td>
                                    </tr>
                                `;
                            });
                            $('#partner-content-container').html(home_partner_content);
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: data.message,
                        });
                    }
                    $('#Homepartnermodel').modal('hide');
                },
                error: function(error) {
                    $('#partner_unique').val('');
                    clearValues(validate_arr);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Something went wrong please try after some time',
                    });
                    $('#Homepartnermodel').modal('hide');
                }
            });
        }

        // Save or update final section card section
        let saveHomeFinalSectionCard = () => {
            $('#final_card_img_preview').attr('src', "{{ asset('assets/dashboard/images/image_not_found.png') }}");
            let link_url = '';
            let validate_arr = [
                'final_card_heading',
                'final_card_desc',
                'final_card_link_text',
                'final_card_link',
                'final_card_img',
            ];
            let is_validated = validate(validate_arr);
            if (is_validated > 0) {
                return false;
            }
            if ($('#final_card_unique').val() == '') {
                link_url = "{{ route('admin.content.home.final.card.create') }}";
            } else {
                link_url = "{{ route('admin.content.home.final.card.update') }}";
            }
            $.ajax({
                url: link_url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'card_heading': $('#final_card_heading').val(),
                    'card_desc': $('#final_card_desc').val(),
                    'card_link_text': $('#final_card_link_text').val(),
                    'card_img': $('#final_card_img').val(),
                    'card_link': $('#final_card_link').val(),
                    'card_unique': $('#final_card_unique').val(),
                    'content_id': "{{ $home->content_id }}",
                    'home_content_uuid' : "{{ $home->uuid }}"
                },
                success: function(data) {
                    $('#final_card_unique').val('');
                    clearValues(validate_arr);
                    if (data.status == 'success') {
                        if (data.result.length) {
                            let home_final_card_content = '';
                            let image = "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                            let index = 0;
                            data.result.forEach(element => {
                                if (element.get_card_image != null) {
                                    image = "{{ asset('') }}" +
                                        `${element.get_card_image.path}`;
                                }
                                index++;
                                home_final_card_content += `
                                    <tr>
                                        <td>${index}</td>
                                        <td>${element.heading}</td>
                                        <td>${element.description}</td>
                                        <td>${element.read_more_button_text}</td>
                                        <td>${element.read_more_link}</td>
                                        <td><img src="${image}" height="auto" width="100px"/></td>
                                        <td class="action_table_data">
                                            <a href="javascript:void(0)" onclick="editHomeSection('${element.id}','home_final_card')" class="btn btn-info btn-circle btn-sm mr-2">
                                            <i class="fas fa-edit"></i>
                                            </a>
                                            <a onclick="deleteHomeSection('${element.id}','home_final_card')" class="btn btn-danger btn-circle btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                                </a>
                                        </td>
                                    </tr>
                                `;
                            });
                            $('#final-card-content-container').html(home_final_card_content);
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: data.message,
                        });
                    }
                    $('#Homefinalcardmodel').modal('hide');
                },
                error: function(error) {
                    $('#final_card_unique').val('');
                    clearValues(validate_arr);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Something went wrong please try after some time',
                    });
                    $('#Homefinalcardmodel').modal('hide');
                }
            });
        }

        // Edit function for every dynamic card section
        let editHomeSection = (id, section) => {
            $.ajax({
                url: "{{ route('admin.content.home.sections.edit') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': id,
                    'section': section
                },
                success: function(data) {
                    if (data.status == 'success') {
                        if (section == 'home_slider') {
                            $('#slider_unique').val(data.result.id);
                            $('#slider_heading').val(data.result.slider_heading);
                            $('#slider_desc').val(data.result.slider_desc);
                            $('#slider_button_text').val(data.result.slider_button_text);
                            $('#slider_button_link').val(data.result.slider_button_link);
                            $('#Homeslidermodel').modal('show');
                        }
                        if (section == 'home_card') {
                            $('#card_unique').val(data.result.id);
                            $('#card_heading').val(data.result.heading);
                            $('#card_desc').val(data.result.description);
                            $('#card_link_text').val(data.result.view_more_text);
                            $('#card_link').val(data.result.view_more_link);
                            if (data.result.get_card_image != null) {
                                $('#card_img_preview').attr('src', "{{ asset('') }}" +
                                    `${data.result.get_card_image.path}`);
                                $('#card_img').val(data.result.get_card_image.file_name);
                            }
                            $('#Homecardmodel').modal('show');
                        }
                        if (section == 'home_partner') {
                            $('#partner_unique').val(data.result.id);
                            $('#partner_name').val(data.result.hover_text);
                            $('#partner_link').val(data.result.hover_link);
                            if (data.result.get_partner_image != null) {
                                $('#partner_img_preview').attr('src', "{{ asset('') }}" +
                                    `${data.result.get_partner_image.path}`);
                                $('#partner_img').val(data.result.get_partner_image.file_name);
                            }
                            $('#Homepartnermodel').modal('show');
                        }
                        if (section == 'home_final_card') {
                            $('#final_card_unique').val(data.result.id);
                            $('#final_card_unique').val(data.result.id);
                            $('#final_card_heading').val(data.result.heading);
                            $('#final_card_desc').val(data.result.description);
                            $('#final_card_link_text').val(data.result.read_more_button_text);
                            $('#final_card_link').val(data.result.read_more_link);
                            if (data.result.get_card_image != null) {
                                $('#final_card_img_preview').attr('src', "{{ asset('') }}" +
                                    `${data.result.get_card_image.path}`);
                                $('#final_card_img').val(data.result.get_card_image.file_name);
                            }
                            $('#Homefinalcardmodel').modal('show');
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: data.message,
                        });
                    }

                },
                error: function(error) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Something went wrong please try after some time',
                    });
                }
            });
        }

        // Delete function for every dynamic card section
        let deleteHomeSection = (id, section) => {
            let title = '';
            if (section == 'home_slider') {
                title = 'Home slider'
            }
            if (section == 'home_card') {
                title = 'Card'
            }
            Swal.fire({
                title: `Do you want to delete this ${title} ?`,
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.content.home.sections.delete') }}",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': id,
                            'section': section,
                            'content_id': "{{ $home->content_id }}",
                            'home_content_uuid' : "{{ $home->uuid }}"
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                if (section == 'home_slider') {
                                    $('#slider-content-container').html('');
                                    if (data.result.length) {
                                        let home_slider_content = '';
                                        let index = 0;
                                        data.result.forEach(element => {
                                            index++;
                                            home_slider_content += `
                                                <tr>
                                                    <td>${index}</td>
                                                    <td>${element.slider_heading}</td>
                                                    <td>${element.slider_desc}</td>
                                                    <td>${element.slider_button_text}</td>
                                                    <td>${element.slider_button_link}</td>
                                                    <td class="action_table_data">
                                                        <a href="javascript:void(0)" onclick="editHomeSection('${element.id}','home_slider')" class="btn btn-info btn-circle btn-sm mr-2">
                                                        <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a onclick="deleteHomeSection('${element.id}','home_slider')" class="btn btn-danger btn-circle btn-sm">
                                                            <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                    </td>
                                                </tr>
                                            `;
                                        });
                                        $('#slider-content-container').html(home_slider_content);
                                    }
                                }
                                if (section == 'home_card') {
                                    let home_card_content = '';
                                    let image =
                                        "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                                    let index = 0;
                                    data.result.forEach(element => {
                                        if (element.get_card_image != null) {
                                            image = "{{ asset('') }}" +
                                                `${element.get_card_image.path}`;
                                        }
                                        index++;
                                        home_card_content += `
                                    <tr>
                                        <td>${index}</td>
                                        <td>${element.heading}</td>
                                        <td>${element.description}</td>
                                        <td>${element.view_more_text}</td>
                                        <td>${element.view_more_link}</td>
                                        <td><img src="${image}" height="auto" width="100px"/></td>
                                        <td class="action_table_data">
                                            <a href="javascript:void(0)" onclick="editHomeSection('${element.id}','home_card')" class="btn btn-info btn-circle btn-sm mr-2">
                                            <i class="fas fa-edit"></i>
                                            </a>
                                            <a onclick="deleteHomeSection('${element.id}','home_card')" class="btn btn-danger btn-circle btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                                </a>
                                        </td>
                                    </tr>
                                `;
                                    });
                                    $('#card-content-container').html(home_card_content);
                                }
                                if (section == 'home_partner') {
                                    let home_partner_content = '';
                                    let image =
                                        "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                                    let index = 0;
                                    data.result.forEach(element => {
                                        if (element.get_partner_image != null) {
                                            image = "{{ asset('') }}" +
                                                `${element.get_partner_image.path}`;
                                        }
                                        index++;
                                        home_partner_content += `
                                    <tr>
                                        <td>${index}</td>
                                        <td>${element.hover_text}</td>
                                        <td>${element.hover_link}</td>
                                        <td><img src="${image}" height="auto" width="100px"/></td>
                                        <td class="action_table_data">
                                            <a href="javascript:void(0)" onclick="editHomeSection('${element.id}','home_partner')" class="btn btn-info btn-circle btn-sm mr-2">
                                            <i class="fas fa-edit"></i>
                                            </a>
                                            <a onclick="deleteHomeSection('${element.id}','home_partner')" class="btn btn-danger btn-circle btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                                </a>
                                        </td>
                                    </tr>
                                `;
                                    });
                                    $('#partner-content-container').html(home_partner_content);
                                }

                                if (section == 'home_final_card') {
                                    let home_final_card_content = '';
                                    let image =
                                        "{{ asset('assets/dashboard/images/image_not_found.png') }}";
                                    let index = 0;
                                    data.result.forEach(element => {
                                        if (element.get_card_image != null) {
                                            image = "{{ asset('') }}" +
                                                `${element.get_card_image.path}`;
                                        }
                                        index++;
                                        home_final_card_content += `
                                    <tr>
                                        <td>${index}</td>
                                        <td>${element.heading}</td>
                                        <td>${element.description}</td>
                                        <td>${element.read_more_button_text}</td>
                                        <td>${element.read_more_link}</td>
                                        <td><img src="${image}" height="auto" width="100px"/></td>
                                        <td class="action_table_data">
                                            <a href="javascript:void(0)" onclick="editHomeSection('${element.id}','home_final_card')" class="btn btn-info btn-circle btn-sm mr-2">
                                            <i class="fas fa-edit"></i>
                                            </a>
                                            <a onclick="deleteHomeSection('${element.id}','home_final_card')" class="btn btn-danger btn-circle btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                                </a>
                                        </td>
                                    </tr>
                                `;
                                    });
                                    $('#final-card-content-container').html(
                                        home_final_card_content);
                                }

                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: data.message,
                                });
                            }

                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Something went wrong please try after some time',
                            });
                        }
                    });
                }
            });
        }



        // Save and validation of the entire form

        let validateForm = () => {
            let res = false;
            let all_validation_keys = [
                'page_name',
                'meta_title',
                'meta_keyword',
                'meta_description',
                'banner_image_web',
                'banner_image_tablet',
                'banner_image_mobile',
                'section_1_heading',
                'section_1_desc',
                'section_1_button_text',
                'section_1_button_link',
                'section_1_img_1',
                'section_1_img_2',
                'section_2_heading',
                'section_2_desc',
            ];

            let is_validated = validate(all_validation_keys);
            if (is_validated > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please fill up the required fields',
                });
                return false;
            }

            // Validation for checking if total required card has been created or not ?

            $.ajax({
                url: "{{ route('admin.content.home.allsectioncard.required.validate') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'content_id': "{{ $home->content_id }}",
                    'home_content_uuid' : "{{ $home->uuid }}"
                },
                async: false,
                cache: false,
                timeout: 30000,
                fail: function() {
                    res = false;
                },
                success: function(data) {
                    if (data.status == 'success') {
                        res = true;
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: data.message,
                        });
                        res = false;

                    }
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Something went wrong please try after some time',
                    });

                }
            });
            return res;
        }
    </script>
@endpush
