@extends('dashboard.layouts.master')
@section('title', __('Our Teams Create Listing'))
@section('content')
    @include('dashboard.common.index')
    <style>
        .form-check-input {
            min-height: 0px !important;
        }
    </style>
    <div class="padding">
        <div class="box m-b-0">
            <div class="box-header dker">
                <h3>{{ __('Add Our Team Listing Content') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    {{ __('Add Our Team Listing Content') }}
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
                    <form action="{{ route('admin.our_teams.list.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="page_type" id="page_type" value="our_teams">
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
                                            oninput="generatePageSlug(this.value,'page_slug','our_teams_listing','draft_btn','submit_btn',null)"></span>
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
                        
                        <fieldset class="fieldset-design">
                            <legend class="fieldset-legend">Basic Details :</legend>
                            <div class="form-group row" style="padding:10px">
                                <div class="col-md-2">
                                    <label class=" form-control-label" for="name">Name (H2)</label>
                                </div>
                                <div class="col-md-10">
                                    <span class="pr-field"><input type="text" class="form-control text-secondary"
                                            name="name" id="name" placeholder="Name" required=""></span>
                                </div>
                            </div>
                            <div class="form-group row" style="padding:10px">
                                <div class="col-md-2">
                                    <label class=" form-control-label" for="designation">Designation</label>
                                </div>
                                <div class="col-md-10">
                                    <span class="pr-field"><input type="text" name="designation" id="designation" class="form-control"></span>
                                </div>
                            </div>

                            <div class="form-group row" style="padding:10px">
                                <div class="col-12">
                                    <label class="form-control-label"> Image: (230 x 140) </label>
                                </div>
                                <div class="row" style="margin-left:0px">
                                    <div class="col-12">
                                        <div style="width:80%;float:left">
                                            <span class="pr-field"><input type="text" id="image"
                                                    name="image" class="form-control" value=""
                                                    readonly="" style="margin-bottom:15px"></span>
                                            <div class="btn btn-success mt-2 btn-sm btn-round" id="banner"
                                                data-target="#showsModal" data-toggle="modal"
                                                onclick="setModalClickBtnId(document.getElementById('image'));">
                                                Select or upload Image </div>
                                        </div>
                                        <div style="width: 18%;float:right">
                                            <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                                id="image_preview" height="100px" width="auto">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" style="padding:10px">
                                <div class="col-md-2">
                                    <label class=" form-control-label" for="about_title">About Title</label>
                                </div>
                                <div class="col-md-10">
                                    <span class="pr-field"><input type="text" name="about_title" id="about_title" class="form-control "></span>
                                </div>
                            </div>
                            <div class="form-group row our_teams_category">
                                <div class="col-sm-2"><label class=" form-control-label">
                                        Our Team Categories
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field">
                                        <select multiple=""
                                            class="form-control our_teams_category " id="our_team_category"
                                            name="our_team_category[]" required="" dir="ltr">
                                            @if (count($our_teams_category_list) > 0)
                                                @foreach ($our_teams_category_list as $category)
                                                    @if ($category->ourTeamCatContent!=null)
                                                        <option value="{{ $category->ourTeamCatContent->id }}">
                                                            {{ ucfirst($category->ourTeamCatContent->title) }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="fieldset-design">
                            <legend class="fieldset-legend">Social Media:</legend>
                            <div class="form-group row">
                                <div class="col-md-2"> <label class=" form-control-label"> Facebook
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control"
                                            dir="ltr" id="facebook" name="facebook"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2"> <label class=" form-control-label"> Twitter
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control"
                                            dir="ltr" id="twitter" name="twitter"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2"> <label class=" form-control-label"> Google<sup>+</sup>
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control"
                                            dir="ltr" id="google_plus" name="google_plus"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2"> <label class=" form-control-label"> Linkedin
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control"
                                            dir="ltr" id="linkedin" name="linkedin"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2"> <label class=" form-control-label"> Youtube
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control"
                                            dir="ltr" id="youtube" name="youtube"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2"> <label class=" form-control-label"> Instagram
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control"
                                            dir="ltr" id="instagram" name="instagram"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2"> <label class=" form-control-label"> Tumblr
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control"
                                            dir="ltr" id="tumblr" name="tumblr"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2"> <label class=" form-control-label"> Snapchat
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control"
                                            dir="ltr" id="snapchat" name="snapchat"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2"> <label class=" form-control-label"> Whatsapp
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <span class="pr-field"><input placeholder="" class="form-control"
                                            dir="ltr" id="whatsapp" name="whatsapp"></span>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="fieldset-design">
                            <legend class="fieldset-legend">Description :</legend>
                            <div>
                                <div class="form-group row">
                                    <div class="col-md-10 ">
                                        <input id="description"
                                            name="description" type="hidden" />
                                        <input id="description_data" type="hidden"
                                            name="description_data" />
                                    </div>
                                </div>
                                <div id="gjs"></div>
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
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script>
        const submitForm = () => {
            $('#our_teams_page_form').submit();
        }

        $(document).ready(function () {
            $('#our_team_category').select2({});
            grapejsInitialize('description','description_data','gjs');
        });


        
    </script>
@endpush
