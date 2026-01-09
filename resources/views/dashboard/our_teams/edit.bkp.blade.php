@extends('dashboard.layouts.master')
@section('title', __('Our Teams'))
@section('content')
@include('dashboard.common.index')
<style>
    .form-check-input{
            min-height: 0px !important;
        }
</style>
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
                    <form action="{{ route('admin.our_teams.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="base_url" id="base_url" value="{{ url('') }}">
                        <input type="hidden" name="csrf_token" id="csrf_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="uid" value="{{ $our_team->uid }}">
                        <input type="hidden" name="content_uid" value="{{ $our_team->getOurTeamContent->uid }}">
                        <fieldset class="fieldset-design">
                            <legend class="fieldset-legend">Page Info :</legend>
                            <div class="form-group row">
                                <div class="col-md-2"> <label class=" form-control-label"> Page Name
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required="" dir="ltr" name="page_name" id="page_name" type="text" oninput="generatePageSlug(this.value,'page_slug','our_teams','draft_btn','submit_btn')" value="{{$our_team->getOurTeamContent->page_name}}"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class=" form-control-label"> Page Slug </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required="" dir="ltr" name="page_slug" id="page_slug" type="text" value="{{$our_team->getOurTeamContent->page_slug}}" readonly></span>
                                    <span id="page_slug_error"> </span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class=" form-control-label"> Meta Title </label>
                                </div>
                                <div class="col-sm-10"> <span class="pr-field"><input placeholder="" class="form-control" required="" dir="ltr" name="meta_title" id="meta_title" type="text" value="{{$our_team->getOurTeamContent->meta_title}}"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class=" form-control-label"> Meta Keyword </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required="" dir="ltr" name="meta_keyword" id="meta_keyword" type="text" value="{{$our_team->getOurTeamContent->meta_keywoard}}"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2"> <label class=" form-control-label"> Meta
                                        Description
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control" required="" dir="ltr" name="meta_description" id="meta_description" type="text" value="{{$our_team->getOurTeamContent->meta_description}}"></span>
                                </div>
                            </div>
                        </fieldset>
                        <div class="card-body" style="padding:10px">
                            <div class="" style="padding:10px">
                                <label class="form-label" for="title">Title (H2)</label>
                                <span class="pr-field"><input type="text" class="form-control text-secondary" name="title" id="title" placeholder="Title" required="" value="{{$our_team->getOurTeamContent->title}}"></span>
                            </div>
                            <div class="mb-3" style="padding:10px">
                                <label class="form-label" for="inputDescription">Description</label>
                                <span class="pr-field"><textarea name="desc" id="desc" cols="30" rows="4" class="form-control " spellcheck="false">{{$our_team->getOurTeamContent->desc}}</textarea></span>
                            </div>
                        </div>
                        <div class="card-body" style="padding:10px">
                            <div class="" style="padding:10px">
                                <label class="form-label" for="banner_title">Banner Heading</label>
                                <span class="pr-field"><input type="text" class="form-control text-secondary" name="banner_head" id="banner_title" placeholder="Banner text" required="" value="{{$our_team->getOurTeamContent->banner_head}}" oninput="text_change('banner_title','draggable_web_', 'draggable_tablet_','draggable_mobile_')"></span>
                            </div>
                            <div class="" style="padding:10px">
                                <label class="form-label" for="banner_desc">Banner Description</label>
                                <span class="pr-field"><input type="text" class="form-control text-secondary"
                                        name="banner_desc" id="banner_desc" {{$our_team->getOurTeamContent->banner_desc}} placeholder="Banner Description"
                                        required=""
                                        oninput="text_change('banner_desc','draggable_web_', 'draggable_tablet_','draggable_mobile_')"></span>
                            </div>
                            <div class="" style="padding:10px">
                                <label class="form-label" for="title">Button Link</label>
                                <span class="pr-field"><input type="url" class="form-control text-secondary"
                                        name="button_link" id="button_link" placeholder="Button Link"
                                        required="" value="{{$our_team->getOurTeamContent->button_link}}"></span>
                            </div>
                            <div class="" style="padding:10px">
                                <label class="form-label" for="title">Button Name</label>
                                <span class="pr-field"><input type="text" class="form-control text-secondary" name="button_name" id="button_name" placeholder="Banner text" required="" oninput="text_change('button_name','draggable_web_', 'draggable_tablet_','draggable_mobile_')" value="{{$our_team->getOurTeamContent->button_name}}"></span>
                            </div>
                            <div class="" style="padding:10px">
                                <label class="form-label" for="title">Banner Description</label>
                                <span class="pr-field"><input type="text" class="form-control text-secondary"
                                        name="banner_desc" id="banner_desc" placeholder="Banner Description"
                                        required=""
                                        oninput="text_change('banner_desc','draggable_web_', 'draggable_tablet_','draggable_mobile_')" value="{{$our_team->getOurTeamContent->banner_desc}}"></span>
                            </div>
                            <div class="" style="padding:10px">
                                <label class="form-label" for="title">Button Link</label>
                                <span class="pr-field"><input type="url" class="form-control text-secondary"
                                        name="button_link" id="button_link" placeholder="Button Link"
                                        required="" value="{{$our_team->getOurTeamContent->button_link}}"></span>
                            </div>
                            <div class="" style="padding:10px">
                                <label class="form-label" for="title">Button Name</label>
                                <span class="pr-field"><input type="text" class="form-control text-secondary"
                                        name="button_name" id="button_name" placeholder="Banner text" required=""
                                        oninput="text_change('button_name','draggable_web_', 'draggable_tablet_','draggable_mobile_')" value="{{ $our_team->getOurTeamContent->button_name }}"></span>
                            </div>
                            <div class="mb-3" style="padding:10px">
                                <div class="row col-md-10" style="margin-left:0px">
                                    <div style="width:80%;float:left">
                                        @if ($our_team->getOurTeamContent->imageDetails!=null)
                                        <input type="text" id="banner_image"
                                        name="banner_image" class="form-control" readonly
                                        style="margin-bottom:15px" value="{{$our_team->getOurTeamContent->imageDetails->file_name}}">
                                        @else
                                        <input type="text" id="banner_image"
                                        name="banner_image" class="form-control" readonly
                                        style="margin-bottom:15px" value="">
                                        @endif
                                       
                                        <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                            class="lib" data-target="#showsModal" data-toggle="modal"
                                            onclick="setModalClickBtnId(document.getElementById('banner_image'))">
                                            Select or upload Image </div>
                                    </div>
                                    <div style="width: 18%;float:right;    margin-left: 15px;">
                                        @if ($our_team->getOurTeamContent->imageDetails!=null)
                                            <img src="{{ asset('') }}{{$our_team->getOurTeamContent->imageDetails->path}}"
                                            id="logo_preview" height="100px" width="auto" />
                                        @else
                                            <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                            id="logo_preview" height="100px" width="auto" />
                                        @endif
                                        
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
    </div>
@endsection

@push('after-scripts')
<script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/custom/menu_banner_image_pos.js') }}"></script>
<script>
    const submitForm = () => {
        $('#our_teams_page_form').submit();
    }
    /* Change text on draggble window while typing */
    const text_change = (input_text_id, replace_text_web_id, replace_text_tablet_id, replace_text_mobile_id) => {
        let final_val = $(`#${input_text_id}`).val();
        // let web_text = final_val.length > 75 ? final_val.substring(0, 75) + " ..." : final_val;
        // let tab_text = final_val.length > 75 ? final_val.substring(0, 75) + " ..." : final_val;
        // let mob_text = final_val.length > 35 ? final_val.substring(0, 35) + " ..." : final_val;
        $(`#${replace_text_web_id}`).html(final_val);
        $(`#${replace_text_tablet_id}`).html(final_val);
        $(`#${replace_text_mobile_id}`).html(final_val);

    }


    $(document).ready(function() {
        $(`#draggable_web_,#draggable2_web_,#draggable3_web_`)
            .draggable({
                containment: $(`#parent_div_web_image_`)
            });
        $(`#draggable_tablet_,#draggable2_tablet_,#draggable3_tablet_`)
            .draggable({
                containment: $(`#parent_div_tablet_image_`)
            });
        $(`#draggable_mobile_,#draggable2_mobile_,#draggable3_mobile_`)
            .draggable({
                containment: $(`#parent_div_mobile_image_`)
            });

        document.getElementById('draggable_web_').onmouseup = function() {
            _drag_init(this, `banner_title_left_pos_web_`, `banner_title_top_pos_web_`, `parent_div_web_image_`);
            return false;
        };
        document.getElementById('draggable2_web_').onmouseup = function() {
            _drag_init(this, `banner_desc_left_pos_web_`, `banner_desc_top_pos_web_`, `parent_div_web_image_`);
            return false;
        };
        document.getElementById('draggable3_web_').onmouseup = function() {
            _drag_init(this, `button_name_left_pos_web_`, `button_name_top_pos_web_`, `parent_div_web_image_`);
            return false;
        };

        // Tablet
        document.getElementById('draggable_tablet_').onmouseup = function() {
            _drag_init(this, `banner_title_left_pos_tablet_`,
                `banner_title_top_pos_tablet_`,`parent_div_tablet_image_`);
            return false;
        };
        document.getElementById('draggable2_tablet_').onmouseup = function() {
            _drag_init(this, `banner_desc_left_pos_tablet_`,
                `banner_desc_top_pos_tablet_`, `parent_div_tablet_image_`);
            return false;
        };
        document.getElementById('draggable3_tablet_').onmouseup = function() {
            _drag_init(this, `button_name_left_pos_tablet_`,
                `button_name_top_pos_tablet_`, `parent_div_tablet_image_`);
            return false;
        };

        // Mobile

        document.getElementById('draggable_mobile_').onmouseup = function() {
            _drag_init(this, `banner_title_left_pos_mobile_`,
                `banner_title_top_pos_mobile_`, `parent_div_mobile_image_`);
            return false;
        };
        document.getElementById('draggable2_mobile_').onmouseup = function() {
            _drag_init(this, `banner_desc_left_pos_mobile_`,
                `banner_desc_top_pos_mobile_`,`parent_div_mobile_image_`);
            return false;
        };
        document.getElementById('draggable3_mobile_').onmouseup = function() {
            _drag_init(this, `button_name_left_pos_mobile_`,
                `button_name_top_pos_mobile_`,`parent_div_mobile_image_`);
            return false;
        };
    });


    // const changeTab = () => {
    //     console.log('tab change');
    //     const lang_code = getCookie('lang_code');
    //     const section_id = getCookie('section_id');


    //     $(`#top_position_list_item_${section_id}_${lang_code}`).css("display", "none");
    //     $(`#left_position_list_item_${section_id}_${lang_code}`).css("display", "none");
    //     $(`#left_all_pos_list_item_${section_id}_${lang_code}`).css("display", "none");
    //     $(`#center_all_pos_list_item_${section_id}_${lang_code}`).css("display", "none");
    //     $(`#right_all_pos_list_item_${section_id}_${lang_code}`).css("display", "none");
    // }

    /* End of Change text on draggble window while typing */

    function _drag_init(elem, input_left_id = null, input_top_id = null, parent_div = null) {
        // Store the object of the element which needs to be moved
        // console.log(elem.id + 'left id: ' + input_left_id + ' top id: ' + input_top_id + ' parent id: ' + parent_div);
        let elem_id = elem.id;
        let parent_div_height = $(`#${parent_div}`).height();
        let parent_div_width = $(`#${parent_div}`).width();
        let left_pos = $(`#${elem_id}`).css("left");
        let top_pos = $(`#${elem_id}`).css("top");
        let left_final_pos = parseInt(left_pos.substring(0, left_pos.length - 2));
        let top_final_pos = parseInt(top_pos.substring(0, top_pos.length - 2));
        let left_margin_percentage = parseFloat((left_final_pos / parent_div_width) * 100).toFixed(2);
        let top_margin_percentage = parseFloat((top_final_pos / parent_div_height) * 100).toFixed(2);
        // let button_final_id = elem_id.substr(0, elem_id.length - 3);
        let button_final_id = elem_id.substr(0, elem_id.length - 1);
        console.log(button_final_id);

        switch (button_final_id) {
            case 'draggable_web':
                // input_left_id = "banner_title_left_pos_web_" + elem.id.substr(elem.id.length - 2, 2);
                // input_top_id = "banner_title_top_pos_web_" + elem.id.substr(elem.id.length - 2, 2);
                input_left_id = "banner_title_left_pos_web_";
                input_top_id = "banner_title_top_pos_web_";
                $(`#${input_left_id}`).val(left_margin_percentage);
                $(`#${input_top_id}`).val(top_margin_percentage);
                break;

            case 'draggable2_web':
                // input_left_id = "banner_desc_left_pos_web_" + elem.id.substr(elem.id.length - 2,
                //     2);
                // input_top_id = "banner_desc_top_pos_web_" + elem.id.substr(elem.id.length - 2,
                //     2);
                input_left_id = "banner_desc_left_pos_web_";
                input_top_id = "banner_desc_top_pos_web_";
                $(`#${input_left_id}`).val(left_margin_percentage);
                $(`#${input_top_id}`).val(top_margin_percentage);

                break;
            case 'draggable3_web':
                // input_left_id = "button_name_left_pos_web_" + elem.id.substr(elem.id.length - 2, 2);
                // input_top_id = "button_name_top_pos_web_" + elem.id.substr(elem.id.length - 2, 2);
                input_left_id = "button_name_left_pos_web_";
                input_top_id = "button_name_top_pos_web_";
                $(`#${input_left_id}`).val(left_margin_percentage);
                $(`#${input_top_id}`).val(top_margin_percentage);
                break;

            case 'draggable_tablet':
                // input_left_id = "banner_title_left_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
                // input_top_id = "banner_title_top_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
                input_left_id = "banner_title_left_pos_tablet_";
                input_top_id = "banner_title_top_pos_tablet_";
                $(`#${input_left_id}`).val(left_margin_percentage);
                $(`#${input_top_id}`).val(top_margin_percentage);
                break;

            case 'draggable2_tablet':
                // input_left_id = "banner_desc_left_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
                // input_top_id = "banner_desc_top_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
                input_left_id = "banner_desc_left_pos_tablet_";
                input_top_id = "banner_desc_top_pos_tablet_";
                $(`#${input_left_id}`).val(left_margin_percentage);
                $(`#${input_top_id}`).val(top_margin_percentage);

                break;
            case 'draggable3_tablet':
                // input_left_id = "button_name_left_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
                // input_top_id = "button_name_top_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
                input_left_id = "button_name_left_pos_tablet_";
                input_top_id = "button_name_top_pos_tablet_";
                $(`#${input_left_id}`).val(left_margin_percentage);
                $(`#${input_top_id}`).val(top_margin_percentage);
                break;

            case 'draggable_mobile':
                // input_left_id = "banner_title_left_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
                // input_top_id = "banner_title_top_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
                input_left_id = "banner_title_left_pos_mobile_";
                input_top_id = "banner_title_top_pos_mobile_";
                $(`#${input_left_id}`).val(left_margin_percentage);
                $(`#${input_top_id}`).val(top_margin_percentage);
                break;

            case 'draggable2_mobile':
                // input_left_id = "banner_desc_left_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
                // input_top_id = "banner_desc_top_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
                input_left_id = "banner_desc_left_pos_mobile_";
                input_top_id = "banner_desc_top_pos_mobile_";
                $(`#${input_left_id}`).val(left_margin_percentage);
                $(`#${input_top_id}`).val(top_margin_percentage);

                break;
            case 'draggable3_mobile':
                // input_left_id = "button_name_left_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
                // input_top_id = "button_name_top_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
                input_left_id = "button_name_left_pos_mobile_";
                input_top_id = "button_name_top_pos_mobile_";
                $(`#${input_left_id}`).val(left_margin_percentage);
                $(`#${input_top_id}`).val(top_margin_percentage);
                break;
            default:
                console.log("No suitable final button id found");
        }
    }
    /* End of Initialize draggable using total tabs and total langs */
    function expandDiv() {
        $("#expand_icon").css("display", "none");
        $("#compress_icon").css("display", "");
        $('#image_preview_container').addClass('box_full');
        setTimeout(function() {
            $('#webviewtabmenu').addClass('active');
            $('#expand_icon a').removeClass('active');
        }, 500);
    }

    function compressDiv() {
        $("#expand_icon").css("display", "");
        $("#compress_icon").css("display", "none");
        $('#image_preview_container').removeClass('box_full');
        setTimeout(function() {
            $('#webviewtabmenu').addClass('active');
            $('#compress_icon a').removeClass('active');
        }, 500);
    }
</script>
@endpush
