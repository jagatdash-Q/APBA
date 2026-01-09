@extends('dashboard.layouts.master')
@section('title', __('Our Teams'))
@section('content')
    @include('dashboard.common.index')
    <div class="padding">
        <div class="box m-b-0">
            <div class="box-header dker">
                <h3>{{ __('Add Our Team Content') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    {{ __('Add Our Team Content') }}
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        {{-- <a class="nav-link" href="{{ route('admin.our_teams.category') }}">
                            <i class="material-icons md-18">×</i>
                        </a> --}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <div class="card pt-2">
                    <form action="{{ route('admin.our_teams.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="base_url" id="base_url" value="{{ url('') }}">
                        <fieldset class="fieldset-design">
                            <legend class="fieldset-legend">Page Info :</legend>
                            <div class="form-group row">
                                <div class="col-md-2"> <label class=" form-control-label"> Page Name
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required=""
                                            dir="ltr" name="page_name" id="page_name" type="text"
                                            oninput="generatePageSlug(this.value,'page_slug','our_teams','draft_btn','submit_btn' )"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class=" form-control-label"> Page Slug </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required=""
                                            dir="ltr" name="page_slug" id="page_slug" type="text" value=""
                                            readonly></span>
                                    <span id="page_slug_error"> </span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class=" form-control-label"> Meta Title </label>
                                </div>
                                <div class="col-sm-10"> <span class="pr-field"><input placeholder="" class="form-control"
                                            required="" dir="ltr" name="meta_title" id="meta_title"
                                            type="text"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class=" form-control-label"> Meta Keyword </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required=""
                                            dir="ltr" name="meta_keyword" id="meta_keyword" type="text"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2"> <label class=" form-control-label"> Meta
                                        Description
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required=""
                                            dir="ltr" name="meta_description" id="meta_description"
                                            type="text"></span>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="fieldset-legend">Banner Section :</legend>
                            <div class="card-body" style="padding:10px">
                                <div class="" style="padding:10px">
                                    <label class="form-label" for="title">Banner Heading</label>
                                    <span class="pr-field"><input type="text" class="form-control text-secondary"
                                            name="banner_title" id="banner_title" placeholder="Banner Heading"
                                            required=""
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
                                            oninput="text_change('button_name','draggable2_web_', 'draggable2_tablet_','draggable2_mobile_')"></span>
                                </div>
                                <div class="mb-3" style="padding:10px">
    
                                    <div class="col-md-2">
                                        <label class="form-label" for="banner_image_web">Desktop Banner Image:(1339px x
                                            300px)</label>
                                    </div>
    
                                    <div class="row col-md-10" style="margin-left:0px">
                                        <div style="width:80%;float:left"><input type="text" id="banner_image_web"
                                                name="banner_image_web" class="form-control" readonly
                                                style="margin-bottom:15px" value="">
                                            <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                                data-target="#showsModal" data-toggle="modal"
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
                                        <label class="form-label" for="banner_image_web">Tablet Banner Image:(768px x
                                            300px)</label>
                                    </div>
                                    <div class="row col-md-10" style="margin-left:0px">
                                        <div style="width:80%;float:left"><input type="text" id="banner_image_tablet"
                                                name="banner_image_tablet" class="form-control" readonly
                                                style="margin-bottom:15px" value="">
                                            <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                                data-target="#showsModal" data-toggle="modal"
                                                onclick="setModalClickBtnId(document.getElementById('banner_image_tablet'),document.getElementById('parent_div_tablet_image_'),'','' )">
                                                Select or upload Image </div>
                                        </div>
                                        <div style="width: 18%;float:right;margin-left: 15px;">
                                            <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                id="banner_image_tablet_preview" height="100px" width="auto" />
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3" style="padding:10px">
                                    <div class="col-md-2">
                                        <label class="form-label" for="banner_image_web">Mobile Banner Image:(375px x
                                            300px)</label>
                                    </div>
                                    <div class="row col-md-10" style="margin-left:0px">
                                        <div style="width:80%;float:left"><input type="text" id="banner_image_mobile"
                                                name="banner_image_mobile" class="form-control" readonly
                                                style="margin-bottom:15px" value="">
                                            <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                                data-target="#showsModal" data-toggle="modal"
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
                                            <a class="nav-link active nav-img-prev" href="" id="webviewtabmenu"
                                                data-toggle="tab" data-target="#img_prev_tab__web_"
                                                style="padding: 0.2rem 0.75rem;">
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
                                        <li class="nav-item inline" style="border: 0px;display: none;" id="compress_icon">
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
                                            <button class="btn btn-primary btn-sm" type="button" name="left_align_content"
                                                id="left_align_content_" onclick="changeAllTextPosition('left')">Left</button>
                                        </li>
    
                                        <li class="nav-item inline" style="border: 0px; display:none"
                                            id="center_all_pos_list_item_">
                                            <button class="btn btn-primary btn-sm" type="button" name="center_align_content"
                                                id="left_align_content_"
                                                onclick="changeAllTextPosition('center')">Center</button>
                                        </li>
    
                                        <li class="nav-item inline" type="button" style="border: 0px; display:none"
                                            id="right_all_pos_list_item_">
                                            <button class="btn btn-primary btn-sm" type="button" name="right_align_content"
                                                id="left_align_content_"
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
                                                    style="position:absolute;color:white; cursor: move;left:0%"> Banner Title
                                                </span>
                                                <br><br>
                                                <span id="draggable2_web_" class="banner-description-lg draggable_text2"
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
                                                    style="position:absolute;color:white; cursor: move;left:0%;top:0%"> Banner
                                                    Title </span>
                                                <br><br>
                                                <span id="draggable2_tablet_" class="banner-description-md draggable_text2"
                                                    onclick="showPosition('draggable2_tablet_','parent_div_tablet_image_','banner_desc_left_pos_tablet_','banner_desc_top_pos_tablet_','')"
                                                    style="position:absolute;color:white; cursor: move;left:0%;top:0%"> Banner
                                                    Description</span>
                                                <br><br>
                                                <a id="draggable3_tablet_" class="trasparent-btn-white draggable_text3"
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
                                                    style="position:absolute;color:white; cursor: move;left:0%;top:0%"> Banner
                                                    Title </span>
                                                <br><br>
                                                <span id="draggable2_mobile_" class="banner-description-sm draggable_text2"
                                                    onclick="showPosition('draggable2_mobile_','parent_div_mobile_image_','banner_desc_left_pos_mobile_','banner_desc_top_pos_mobile_','')"
                                                    style="position:absolute;color:white; cursor: move;left:0%;top:0%"> Banner
                                                    Description </span>
                                                <br><br>
                                                <a id="draggable3_mobile_" class="trasparent-btn-white draggable_text3"
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
                            <legend>Header Section :</legend>
                            <div class="card-body" style="padding:10px">
                                <div class="" style="padding:10px">
                                    <label class="form-label" for="title">Title (H2)</label>
                                    <span class="pr-field"><input type="text" class="form-control text-secondary"
                                            name="title" id="title" placeholder="Title" required=""></span>
                                </div>
                                <div class="mb-3" style="padding:10px">
                                    <label class="form-label" for="inputDescription">Description</label>
                                    <span class="pr-field">
                                        <textarea name="desc" id="desc" cols="30" rows="4" class="form-control " spellcheck="false"></textarea>
                                    </span>
                                </div>
                            </div>
                        </fieldset>
                        
                        
                        



                        



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
    </div>
@endsection

@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/script.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/menu_banner_image_pos.js') }}"></script>
@endpush
