@extends('dashboard.layouts.master')

@section('title', __('Website Setting'))
@section('content')


    <!-- Favicon -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Website Setting') }}</h1>
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">



        <div class="col-lg-12 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Site Details</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('websetting.update', 1) }}" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">

                        <div class="pl-lg-4">

                            <div class="row form-group" style="margin-bottom: 10px;">
                                <div class="col-md-2">
                                    <label class="form-control-label"> Site Logo</label>
                                </div>
                                <div class="row col-md-10" style="margin-left:0px">
                                    <div style="width:80%;float:left;padding-right: 10px;"><input type="text"
                                            id="site_logo" name="site_logo" class="form-control" readonly
                                            style="margin-bottom:15px" 
                                            value="{{ \App\Helpers\Helper::getMediaName($WebSetting->site_logo)  }}"
                                            >
                                        <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                            data-target="#showsModal" data-toggle="modal"
                                            onclick="setModalClickBtnId(document.getElementById('site_logo'));">
                                            Select or upload Image </div>
                                    </div>
                                    <div style="width: 18%;float:right">
                                        @php
                                            $logo_img_src = isset($WebSetting->site_logo) ? url('') .'/uploads/media/'.App\Helpers\Helper::getMediaName($WebSetting->site_logo) : url('') . '/assets/dashboard/images/image_not_found.jpg';
                                        @endphp

                                        <img src="{{ $logo_img_src }}" id="site_logo_preview" height="100px"
                                            width="100" />
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-2">
                                    <label class="form-control-label"> Fav Icon</label>
                                </div>
                                <div class="row col-md-10" style="margin-left:0px">
                                    <div style="width:80%;float:left;padding-right: 10px;"><input type="text"
                                            id="fav_icon" name="fav_icon" class="form-control" readonly
                                            style="margin-bottom:15px" 
                                            {{-- value="{{ isset($TabContent[$i]->banner_image_web) ? $TabContent[$i]->banner_image_web : '' }}" --}}
                                            value="{{ App\Helpers\Helper::getMediaName($WebSetting->fav_icon) }}"
                                            >
                                        <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib"
                                            data-target="#showsModal" data-toggle="modal"
                                            onclick="setModalClickBtnId(document.getElementById('fav_icon'));">
                                            Select or upload Image </div>
                                    </div>
                                    <div style="width: 18%;float:right">
                                        @php
                                            $fav_img_src = isset($WebSetting->fav_icon) ? url('') .'/uploads/media/'.App\Helpers\Helper::getMediaName($WebSetting->fav_icon) : url('') . '/assets/dashboard/images/image_not_found.jpg';
                                        @endphp

                                        <img src="{{ $fav_img_src }}" id="fav_icon_preview" height="100px"
                                            width="100" />
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Facebook</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" id="facebook" class="form-control" name="fb_link" placeholder=""
                                        value="{{ $WebSetting->fb_link }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Instagram</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" id="instagram" class="form-control" name="insta_link"
                                        placeholder="" value="{{ $WebSetting->insta_link }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Linkedln</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" id="linkedln" class="form-control" name="linkdn_link"
                                        placeholder="" value="{{ $WebSetting->linkdn_link }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Youtube</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" id="youtube" class="form-control" name="youtube_link"
                                        placeholder="" value="{{ $WebSetting->youtube_link }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Website name</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" id="websitename" class="form-control" name="site_name"
                                        placeholder="" value="{{ $WebSetting->site_name }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Email address</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="email" id="email" class="form-control" name="site_email"
                                        placeholder=""
                                        value="{{ $WebSetting->site_email }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Footer Title</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" id="site_title" class="form-control" name="site_title"
                                        placeholder=""
                                        value="{{ $WebSetting->site_title }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Address</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" id="site_address" class="form-control" name="site_address"
                                        placeholder=""
                                        value="{{ $WebSetting->site_address }}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label class="form-control-label">Copyright</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" id="copyright" class="form-control" name="site_copyrights"
                                        placeholder=""
                                        value="{{ $WebSetting->site_copyrights }}">
                                </div>
                            </div>

                        </div>


                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>
    @include('dashboard.common.index')
    <script src="{{ asset('assets/dashboard/js/custom/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
@endsection
