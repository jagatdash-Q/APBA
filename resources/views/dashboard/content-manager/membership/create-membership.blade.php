@extends('dashboard.layouts.master')
@section('title', __('Create Membership Page Content'))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}">
    <style>

    </style>
@endpush
@section('content')
    @include('dashboard.common.index')
    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Create Membership Page Content') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    <a href="{{ route('admin.contents.manage') }}">{{ __('Content Manager') }}</a>
                </small>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.create.membership') }}" method="POST" id="membership_form"
                            onsubmit="return validateForm();">
                            @csrf
                            <input type="hidden" name="base_url" id="base_url" value="{{ url('') }}">
                            <input type="hidden" name="content_id" id="content_id" value="{{ $content_details->id }}">
                            <input type="hidden" name="membership_sec_len" id="membership_sec_len" value="0">
                            <fieldset>
                                <legend>Page Info :</legend>
                                <div class="form-group row">
                                    <div class="col-md-2"> <label class=" form-control-label"> Page Name
                                        </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="page_name" id="page_name" type="text"
                                                oninput="generatePageSlug(this.value,'page_slug','membership','draft_btn','submit_btn')"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Page Slug </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="page_slug" id="page_slug" type="text" value=""
                                                readonly></span>
                                        <span id="page_slug_error"> </span>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Meta Title </label>
                                    </div>
                                    <div class="col-sm-10"> <span class="pr-field"><input placeholder=""
                                                class="form-control" dir="ltr" name="meta_title" id="meta_title"
                                                type="text"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Meta Keyword </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="meta_keyword" id="meta_keyword" type="text"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2"> <label class=" form-control-label"> Meta
                                            Description
                                        </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="pr-field"><input placeholder="" class="form-control" dir="ltr"
                                                name="meta_description" id="meta_description" type="text"></span>
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
                                                oninput="text_change('banner_title','draggable_web_', 'draggable_tablet_','draggable_mobile_')"></span>
                                    </div>
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Banner Description</label>
                                        <span class="pr-field"><input type="text" class="form-control text-secondary"
                                                name="banner_desc" id="banner_desc" placeholder="Banner Description"
                                                oninput="text_change('banner_desc','draggable2_web_', 'draggable2_tablet_','draggable2_mobile_')"></span>
                                    </div>
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Button Link</label>
                                        <span class="pr-field"><input type="url" class="form-control text-secondary"
                                                name="button_link" id="button_link" placeholder="Button Link"></span>
                                    </div>
                                    <div class="" style="padding:10px">
                                        <label class="form-label" for="title">Button Name</label>
                                        <span class="pr-field"><input type="text" class="form-control text-secondary"
                                                name="button_name" id="button_name" placeholder="Banner text"
                                                oninput="text_change('button_name','draggable3_web_', 'draggable3_tablet_','draggable3_mobile_')"></span>
                                    </div>
                                    <div class="mb-3" style="padding:10px">

                                        <div class="col-md-2">
                                            <label class="form-label" for="banner_image_web">Desktop Banner Image:(1339px
                                                x 300px)</label>
                                        </div>

                                        <div class="row col-md-10" style="margin-left:0px">
                                            <div style="width:80%;float:left"><input type="text" id="banner_image_web"
                                                    name="banner_image_web" class="form-control" readonly
                                                    style="margin-bottom:15px" value="">
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('banner_image_web'),document.getElementById('parent_div_web_image_'),'','' )">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 18%;float:right;    margin-left: 15px;">
                                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="banner_image_web_preview" height="100px" width="auto" />
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
                                            <div style="width:80%;float:left"><input type="text"
                                                    id="banner_image_tablet" name="banner_image_tablet"
                                                    class="form-control" readonly style="margin-bottom:15px"
                                                    value="">
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('banner_image_tablet'),document.getElementById('parent_div_tablet_image_'),'','' )">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 18%;float:right;    margin-left: 15px;">
                                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                    id="banner_image_tablet_preview" height="100px" width="auto" />
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
                                            <div style="width:80%;float:left"><input type="text"
                                                    id="banner_image_mobile" name="banner_image_mobile"
                                                    class="form-control" readonly style="margin-bottom:15px"
                                                    value="">
                                                <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                    class="lib" data-target="#showsModal" data-toggle="modal"
                                                    onclick="setModalClickBtnId(document.getElementById('banner_image_mobile'),document.getElementById('parent_div_mobile_image_'),'','' )">
                                                    Select or upload Image </div>
                                            </div>
                                            <div style="width: 18%;float:right;    margin-left: 15px;">
                                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
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
                                                        name="banner_title_left_pos_web_" value="">
                                                    <input type="hidden" id="banner_title_top_pos_web_"
                                                        name="banner_title_top_pos_web_" value="">
                                                    <input type="hidden" id="banner_desc_left_pos_web_"
                                                        name="banner_desc_left_pos_web_" value="">
                                                    <input type="hidden" id="banner_desc_top_pos_web_"
                                                        name="banner_desc_top_pos_web_" value="">
                                                    <input type="hidden" id="button_name_left_pos_web_"
                                                        name="button_name_left_pos_web_" value="">
                                                    <input type="hidden" id="button_name_top_pos_web_"
                                                        name="button_name_top_pos_web_" value="">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        alt="image not found"
                                                        style="position: absolute; height: 300px; width: 100%; "
                                                        id="parent_div_web_image_">
                                                    <span id="draggable_web_" class="banner-text-lg draggable_text1"
                                                        onclick="showPosition('draggable_web_','parent_div_web_image_','banner_title_left_pos_web_','banner_title_top_pos_web_','')"
                                                        style="position:absolute;color:white; cursor: move;left:0%"> Banner
                                                        Title </span>
                                                    <br><br>
                                                    <span id="draggable2_web_"
                                                        class="banner-description-lg draggable_text2"
                                                        onclick="showPosition('draggable2_web_','parent_div_web_image_','banner_desc_left_pos_web_', 'banner_desc_top_pos_web_','')"
                                                        style="position:absolute;color:white; cursor: move;left:0%"> Banner
                                                        Description </span>
                                                    <br><br>
                                                    <a id="draggable3_web_" class="trasparent-btn-white draggable_text3"
                                                        onclick="showPosition('draggable3_web_','parent_div_web_image_','button_name_left_pos_web_','button_name_top_pos_web_','')"
                                                        style="position:absolute;color:white; cursor: move;left:0%">
                                                        Button
                                                    </a>
                                                </div>
                                            </div>

                                            {{-- Tablet  --}}
                                            <div class="tab-pane" id="img_prev_tab__tablet_" aria-expanded="true">
                                                <div id="parent_div_tablet_"
                                                    style="position: relative; overflow: hidden;  height: 300px;width: 768px; ">
                                                    <input type="hidden" id="banner_title_left_pos_tablet_"
                                                        name="banner_title_left_pos_tablet_" value="0">
                                                    <input type="hidden" id="banner_title_top_pos_tablet_"
                                                        name="banner_title_top_pos_tablet_" value="0">
                                                    <input type="hidden" id="banner_desc_left_pos_tablet_"
                                                        name="banner_desc_left_pos_tablet_" value="0">
                                                    <input type="hidden" id="banner_desc_top_pos_tablet_"
                                                        name="banner_desc_top_pos_tablet_" value="0">
                                                    <input type="hidden" id="button_name_left_pos_tablet_"
                                                        name="button_name_left_pos_tablet_" value="0">
                                                    <input type="hidden" id="button_name_top_pos_tablet_"
                                                        name="button_name_top_pos_tablet_" value="0">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        style="position: absolute; height: 300px; width: 768px; object-fit: cover; "
                                                        id="parent_div_tablet_image_">
                                                    <span id="draggable_tablet_" class="banner-text-md draggable_text1"
                                                        onclick="showPosition('draggable_tablet_','parent_div_tablet_image_','banner_title_left_pos_tablet_','banner_title_top_pos_tablet_','')"
                                                        style="position:absolute;color:white; cursor: move;left:0%;top:0%">
                                                        Banner Title </span>
                                                    <br><br>
                                                    <span id="draggable2_tablet_"
                                                        class="banner-description-md draggable_text2"
                                                        onclick="showPosition('draggable2_tablet_','parent_div_tablet_image_','banner_desc_left_pos_tablet_','banner_desc_top_pos_tablet_','')"
                                                        style="position:absolute;color:white; cursor: move;left:0%;top:0%">
                                                        Banner Description</span>
                                                    <br><br>
                                                    <a id="draggable3_tablet_"
                                                        class="trasparent-btn-white draggable_text3"
                                                        onclick="showPosition('draggable3_tablet_','parent_div_tablet_image_','button_name_left_pos_tablet_','button_name_top_pos_tablet_','')"
                                                        style="position:absolute;color:white; cursor: move;left:0%;top:0%">
                                                        Button
                                                    </a>
                                                </div>
                                            </div>
                                            {{-- End of Tablet --}}

                                            {{-- Mobile  --}}
                                            <div class="tab-pane " id="img_prev_tab__mobile_" aria-expanded="true">
                                                <div id="parent_div_mobile_"
                                                    style="position: relative;overflow: hidden;  height: 300px; width: 375px;">
                                                    <input type="hidden" id="banner_title_left_pos_mobile_"
                                                        name="banner_title_left_pos_mobile_" value="0">
                                                    <input type="hidden" id="banner_title_top_pos_mobile_"
                                                        name="banner_title_top_pos_mobile_" value="0">
                                                    <input type="hidden" id="banner_desc_left_pos_mobile_"
                                                        name="banner_desc_left_pos_mobile_" value="0">
                                                    <input type="hidden" id="banner_desc_top_pos_mobile_"
                                                        name="banner_desc_top_pos_mobile_" value="0">
                                                    <input type="hidden" id="button_name_left_pos_mobile_"
                                                        name="button_name_left_pos_mobile_" value="">
                                                    <input type="hidden" id="button_name_top_pos_mobile_"
                                                        name="button_name_top_pos_mobile_" value="">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        style="position: absolute;height: 300px; width: 375px; object-fit: cover; "
                                                        id="parent_div_mobile_image_">
                                                    <span id="draggable_mobile_" class="banner-text-sm draggable_text1"
                                                        onclick="showPosition('draggable_mobile_','parent_div_mobile_image_','banner_title_left_pos_mobile_','banner_title_top_pos_mobile_','')"
                                                        style="position:absolute;color:white; cursor: move;left:0%;top:0%">
                                                        Banner Title </span>
                                                    <br><br>
                                                    <span id="draggable2_mobile_"
                                                        class="banner-description-sm draggable_text2"
                                                        onclick="showPosition('draggable2_mobile_','parent_div_mobile_image_','banner_desc_left_pos_mobile_','banner_desc_top_pos_mobile_','')"
                                                        style="position:absolute;color:white; cursor: move;left:0%;top:0%">
                                                        Banner Description </span>
                                                    <br><br>
                                                    <a id="draggable3_mobile_"
                                                        class="trasparent-btn-white draggable_text3"
                                                        onclick="showPosition('draggable3_mobile_','parent_div_mobile_image_','button_name_left_pos_mobile_','button_name_top_pos_mobile_','')"
                                                        style="position:absolute;color:white; cursor: move;left:0%;top:0%">
                                                        Button
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
                                            placeholder="Section heading" name="welcome_head">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="welcome_desc" class="form-control" id="welcome_desc"></textarea>
                                    </div>
                                </div>

                                <div class="row col-md-10" style="margin-left:0px">
                                    <div style="width:80%;float:left">
                                        <input type="text" id="section_1_image" name="section_1_image"
                                            class="form-control" readonly style="margin-bottom:15px" value="">
                                        <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                            data-target="#showsModal" data-toggle="modal"
                                            onclick="setModalClickBtnId(document.getElementById('section_1_image'),'','','' )">
                                            Select or upload Image
                                        </div>
                                    </div>
                                    <div style="width: 18%;float:right;    margin-left: 15px;">
                                        <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                            id="section_1_image_preview" height="100px" width="auto" />
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Membership :</legend>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user"
                                            id="section_2_heading" placeholder="Membership Heading"
                                            name="section_2_heading">
                                    </div>
                                </div>
                                <div class="col-md-12" style="min-height:50px;">
                                    <button class="btn btn-success float-right" onclick="addSection()"
                                        style="margin-top: 10px;" type="button">
                                        Create Membership</button>
                                </div>
                                <div id="section_2_membership_container">

                                </div>
                            </fieldset>
                            <button type="submit" class="btn btn-success" style="margin-left: 20px;margin-bottom:20px"
                                id="submit_btn">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')



@endsection

@push('after-scripts')
<script src="{{ asset('assets/dashboard/js/script.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/menu_banner_image_pos.js') }}"></script>
    <script>
        let i = 0;
        $(document).ready(function() {
            CKEDITOR.replace('welcome_desc', {
                filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
        });

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
                msg = 'Banner heading must not be empty';
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
                msg = 'First section heading must not be empty';
            }
            if (CKEDITOR.instances['welcome_desc'].getData() == '') {
                msg = 'First section desc must not be empty';
            }
            if ($('#section_1_image').val() == '') {
                msg = "Please choose image for first section";
            }
            if ($('#section_2_heading').val() == '') {
                msg = "Membership section heading must not be empty";
            }
            if ($('#section_2_membership_container').children('.membership-sec').length == 0) {
                msg = "Please create atleast one membership";
            }




            // Membership package validation

            $('#section_2_membership_container').children('.membership-sec').each(function(indexInArray,
                valueOfElement) {
                if ($(valueOfElement).find('.membership_name').val() == '') {
                    msg = "Membership name must not be empty";
                }
                if ($(valueOfElement).find('.membership_srt_desc').val() == '') {
                    msg = "Membership short description must not be empty";
                }
                if ($(valueOfElement).find('.membership_image').val() == '') {
                    msg = "Please choose membership image";
                }
                if ($(valueOfElement).find('.membership_price').val() == '' || $(valueOfElement).find(
                        '.membership_price').val() == 0) {
                    msg = "Please enter valid membership price";
                }
                if ($(valueOfElement).find('.membership_button').val() == '') {
                    msg = "Membership button text must not be empty";
                }
                if ($(valueOfElement).find('.membership_button').val() == '') {
                    msg = "Membership button text must not be empty";
                }

                if ($(valueOfElement).find('.membership_button').val() == '') {
                    msg = "Membership button text must not be empty";
                }

            });

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

        let addSection = () => {
            Swal.fire({
                title: 'Do you want to add new membership?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `Don't`,
            }).then((result) => {
                if (result.isConfirmed) {
                    i++;
                    $('#section_2_membership_container').append(`
                    <div class="membership-sec">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="form-label" for="membership_name_${i}">Membership Name</label>
                                                <input type="text" class="form-control form-control-user membership_name"
                                                    id="membership_name_${i}" placeholder="Membership Name"
                                                    name="membership_name_${i}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="form-label" for="membership_srt_desc_${i}">Membership Short
                                                    Description</label>
                                                <input type="text" class="form-control form-control-user membership_srt_desc"
                                                    id="membership_srt_desc_${i}" placeholder="Membership Short Description"
                                                    name="membership_srt_desc_${i}">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-left:0!important">
                                            <label style="margin-right: 10px;margin-bottom:0px !important">Membership Type</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="membership_subscription_type_${i}" id="membership_subscription_type_${i}_1" value="sub" checked>
                                                <label class="form-check-label" for="membership_subscription_type_${i}_1">Subscribe</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="membership_subscription_type_${i}" id="membership_subscription_type_${i}_2" value="con" checked>
                                                <label class="form-check-label" for="membership_subscription_type_${i}_1">Contact </label>
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin-left:0!important">
                                            <label style="margin-right: 10px;margin-bottom:0px !important">Membership Plan</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="membership_plan_${i}" id="membership_plan_${i}_1" value="yearly" checked>
                                                <label class="form-check-label" for="membership_plan_${i}_1">Yearly</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="membership_plan_${i}" id="membership_plan_${i}_2" value="lifetime">
                                                <label class="form-check-label" for="membership_plan_${i}_1">Lifetime </label>
                                            </div>
                                        </div>
                                            
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label class="form-label" for="banner_image_web"> Membership Image:</label>
                                            </div>

                                            <div class="row col-md-10" style="margin-left:0px">
                                                <div style="width:80%;float:left"><input type="text" id="membership_image_${i}"
                                                        name="membership_image_${i}" class="form-control  membership_image" readonly
                                                        style="margin-bottom:15px" value="">
                                                    <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                        class="lib" data-target="#showsModal" data-toggle="modal"
                                                        onclick="setModalClickBtnId(document.getElementById('membership_image_${i}'),'','','' )">
                                                        Select or upload Image </div>
                                                </div>
                                                <div style="width: 18%;float:right;margin-left:5px;">
                                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                        id="membership_image_${i}_preview" height="100px" width="auto" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="form-label" for="membership_price_${i}">Membership Price</label>
                                                <input type="integer" class="form-control form-control-user membership_price"
                                                    id="membership_price_${i}" placeholder="Membership Price"
                                                    name="membership_price_${i}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="form-label" for="membership_button_${i}">Membership Button
                                                    Text</label>
                                                <input type="text" class="form-control form-control-user membership_button"
                                                    id="membership_button_${i}" placeholder="Membership Button Text"
                                                    name="membership_button_${i}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="form-label" for="membership_desc_${i}">Membership
                                                    Description</label>
                                                <textarea name="membership_desc_${i}" id="membership_desc_${i}"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-danger" onclick="$(this).closest('.membership-sec').remove();">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                    `);

                    CKEDITOR.replace(`membership_desc_${i}`, {
                        filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
                        filebrowserUploadMethod: 'form'
                    });

                    $('#membership_sec_len').val(i);
                }
            })
        }
    </script>
@endpush
