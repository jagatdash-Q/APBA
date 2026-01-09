@extends('frontend.layouts.master')
@section('content')
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h2 class="static_inner_Page_banner_title">Our Team</h2>
        </div>
    </div>

    <style>
        .inner_page_banner {
            background-image: url("{{ asset('assets/frontend/images/our_team_banner.png') }}");
        }
        .banner_content_wrapper {
            display: flex;
            align-items: center;
        }

        .static_inner_Page_banner_title {
            font-size: 42px;
            line-height: 52px;
            font-weight: 700;
            color: #ffffff;
            padding-top: 112px;
        }

        @media (min-width: 576px) and (max-width: 768px) {
                .static_inner_Page_banner_title {
                    font-size: 30px;
                    line-height: 40px;
                    width: auto;
                    padding-top: 100px;
                    padding-left: 20px;
                    padding-right: 20px;
                    padding-bottom: 40px;
            }
        }

        @media only screen and (max-width: 576px) {
            .static_inner_Page_banner_title {
                font-size: 30px;
                line-height: 40px;
                width: auto;
                padding-top: 100px;
                padding-left: 20px;
                padding-right: 20px;
                padding-bottom: 40px;
            }
        }
    </style>

    <div class="page_container">

        <div class="small_nav">
            <a href="{{ url('') }}"><img src="{{ asset('assets/frontend/images/home_icon.svg') }}" alt="..."></a>
            <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
            <a href="{{ route('frontend.our.team') }}" class="small_nav_text">Our Team</a>
            <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
            <span class="small_nav_text">{{ $is_listing_exist->name }}</span>
        </div>

        <div class="row our_team_details_row_div">

            <div class="col-sm-3">
                <div class="our_team_details_side_panel">
                    <div class="content_wrapper">
                        <div class="our_team_details_thumb">
                            @if ($is_listing_exist->image_details != null)
                                <img src="{{ asset('') }}{{ $is_listing_exist->image_details->path }}"
                                    alt="{{ $is_listing_exist->image_details->alt_tag }}" />
                            @else
                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}">
                            @endif
                        </div>
                        <div class="our_team_details_content">
                            <h3 class="our_team_details_name">{{ $is_listing_exist->name }}</h3>
                            <span class="our_team_details_desg">{{ $is_listing_exist->designation }} </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-9">
                <h2 class="site_heading_h2">About {{ $is_listing_exist->name }}</h2>
                {{-- <div class="social_icons_div my-3">
                    @if ($is_listing_exist->facebook != '')
                        <a href="{{ $is_listing_exist->facebook }}" target="_blank" style="padding: 10px 16px;"
                            class="social_icons fa fa-facebook"></a>
                    @endif
                    @if ($is_listing_exist->twitter != '')
                        <a href="{{ $is_listing_exist->twitter }}" target="_blank" class="social_icons fa fa-twitter"></a>
                    @endif
                    @if ($is_listing_exist->google_plus != '')
                        <a href="{{ $is_listing_exist->google_plus }}" target="_blank" style="padding: 11px 9px;"
                            class="social_icons fa fa-google-plus"></a>
                    @endif
                    @if ($is_listing_exist->linkedin != '')
                        <a href="{{ $is_listing_exist->linkedin }}" target="_blank"
                            class="social_icons fa fa-linkedin"></a>
                    @endif
                    @if ($is_listing_exist->youtube != '')
                        <a href="{{ $is_listing_exist->youtube }}" target="_blank"
                            class="social_icons fa fa-youtube-play"></a>
                    @endif
                    @if ($is_listing_exist->instagram != '')
                        <a href="{{ $is_listing_exist->instagram }}" target="_blank"
                            class="social_icons fa fa-instagram"></a>
                    @endif
                    @if ($is_listing_exist->printrest != '')
                        <a href="{{ $is_listing_exist->printrest }}" target="_blank"
                            class="social_icons fa fa-pinterest"></a>
                    @endif
                    @if ($is_listing_exist->tumblr != '')
                        <a href="{{ $is_listing_exist->tumblr }}" target="_blank" style="padding: 10px 15px;"
                            class="social_icons fa fa-tumblr"></a>
                    @endif
                    @if ($is_listing_exist->snapchat != '')
                        <a href="{{ $is_listing_exist->snapchat }}" target="_blank"
                            class="social_icons fa fa-snapchat"></a>
                    @endif
                    @if ($is_listing_exist->whatsapp != '')
                        <a href="{{ $is_listing_exist->whatsapp }}" target="_blank"
                            class="social_icons fa fa-whatsapp"></a>
                    @endif
                </div> --}}
                <div class="social_icons_div my-3">
                    @if ($is_listing_exist->facebook != '')
                        <a href="{{ $is_listing_exist->facebook }}" target="_blank" class="social_icons_svg">
                            <img src="{{ asset('assets/frontend/images/facebook_blue.svg') }}" alt="...">
                        </a>
                    @endif
                    @if ($is_listing_exist->linkedin != '')
                        <a href="{{ $is_listing_exist->linkedin }}" target="_blank" class="social_icons_svg">
                            <img src="{{ asset('assets/frontend/images/linkedin_blue.svg') }}" alt="...">
                        </a>
                    @endif
                    @if ($is_listing_exist->youtube != '')
                        <a href="{{ $is_listing_exist->youtube }}" target="_blank" class="social_icons_svg">
                            <img src="{{ asset('assets/frontend/images/youtube_blue.svg') }}" alt="...">
                        </a>
                    @endif
                    @if ($is_listing_exist->instagram != '')
                        <a href="{{ $is_listing_exist->instagram }}" target="_blank" class="social_icons_svg">
                            <img src="{{ asset('assets/frontend/images/instagram_blue.svg') }}" alt="...">
                        </a>
                    @endif
                    @if ($is_listing_exist->twitter != '')
                        <a href="{{ $is_listing_exist->twitter }}" target="_blank" class="social_icons fa fa-twitter"></a>
                    @endif
                    @if ($is_listing_exist->google_plus != '')
                        <a href="{{ $is_listing_exist->google_plus }}" target="_blank" style="padding: 11px 9px;"
                            class="social_icons fa fa-google-plus"></a>
                    @endif
                    @if ($is_listing_exist->printrest != '')
                        <a href="{{ $is_listing_exist->printrest }}" target="_blank"
                            class="social_icons fa fa-pinterest"></a>
                    @endif
                    @if ($is_listing_exist->tumblr != '')
                        <a href="{{ $is_listing_exist->tumblr }}" target="_blank" style="padding: 10px 15px;"
                            class="social_icons fa fa-tumblr"></a>
                    @endif
                    @if ($is_listing_exist->snapchat != '')
                        <a href="{{ $is_listing_exist->snapchat }}" target="_blank"
                            class="social_icons fa fa-snapchat"></a>
                    @endif
                    @if ($is_listing_exist->whatsapp != '')
                        <a href="{{ $is_listing_exist->whatsapp }}" target="_blank"
                            class="social_icons fa fa-whatsapp"></a>
                    @endif
                </div>

                <div class="our_team_details_div mt-4">
                    {!! $is_listing_exist->description_data !!}
                </div>

                {{-- <div class="our_team_details_div my-5">
                    Elementum nisi quis eleifend quam adipiscing. Non quam lacus suspendisse faucibus
                    interdum posuere lorem ipsum dolor. Aliquet enim tortor at auctor urna. Aliquam vestibulum
                    morbi blandit cursus risus at ultrices mi tempus. Accumsan sit amet nulla facilisi morbi
                    tempus. Ullamcorper morbi tincidunt ornare massa eget egestas. Volutpat sed cras ornare
                    arcu. Facilisis gravida neque convallis a cras semper.
                    <br><br>
                    Nulla aliquet enim tortor at auctor. Id volutpat lacus laoreet non. Pretium fusce id velit ut
                    tortor pretium viverra suspendisse potenti. Nulla pharetra diam sit amet. Aliquet bibendum
                    enim facilisis gravida neque convallis. Nec tincidunt praesent semper feugiat nibh sed
                    pulvinar. Aliquam vestibulum morbi blandit cursus risus at ultrices mi tempus. Accumsan sit
                    amet nulla facilisi morbi tempus. Ullamcorper morbi tincidunt ornare massa eget egestas.
                    <br><br>
                    <p class="font-weight-bold">
                        Commissioner of Infectious Disease Prevention, <br>
                        Ministry of Health and Welfare, Taiwan <br>
                        Biocontainment Expertise Commisioner of IFBA <br>
                        President, Intelligent-Bio Co., Ltd.
                    </p>
                </div>
                <h2 class="site_heading_h2 mb-5">Certificate & Achievement</h2>
                <div class="certificate_div">
                    <div class="certificate_items">
                        <img class="certificate_thumb" src="{{ asset('assets/frontend/images/certificate.jpg') }}" alt="...">
                        <p class="certificate_title">Certificate of Achievement</p>
                    </div>
                    <div class="certificate_items">
                        <img class="certificate_thumb" src="{{ asset('assets/frontend/images/certificate.jpg') }}" alt="...">
                        <p class="certificate_title">Certificate of Achievement</p>
                    </div>
                    <div class="certificate_items">
                        <img class="certificate_thumb" src="{{ asset('assets/frontend/images/certificate.jpg') }}" alt="...">
                        <p class="certificate_title">Certificate of Achievement</p>
                    </div>
                    <div class="certificate_items">
                        <img class="certificate_thumb" src="{{ asset('assets/frontend/images/certificate.jpg') }}" alt="...">
                        <p class="certificate_title">Certificate of Achievement</p>
                    </div>
                </div> --}}
            </div>

        </div>

    </div>
@endsection
