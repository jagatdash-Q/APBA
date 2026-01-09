@extends('frontend.layouts.master')
@section('content')
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h2 class="static_inner_Page_banner_title">{{ $speaker_details->speaker_name }}</h2>
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
            <a href="{{ route('frontend.news.events') }}" class="small_nav_text">News & Events</a>
            <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
            <span class="small_nav_text">{{ $speaker_details->speaker_name }}</span>
        </div>

        <div class="row our_team_details_row_div">

            <div class="col-sm-3">
                <div class="our_team_details_side_panel">
                    <div class="content_wrapper">
                        <div class="our_team_details_thumb">
                            @if ($speaker_details->getSpeakerImage!=null)
                                <img src="{{ asset('') }}{{ $speaker_details->getSpeakerImage->path }}" />
                            @else
                                <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}" />
                            @endif
                            
                        </div>
                        <div class="our_team_details_content">
                            <h3 class="our_team_details_name">{{ $speaker_details->speaker_name }}</h3>
                            <span class="our_team_details_desg">{{ $speaker_details->speaker_designation }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-9">
                <h2 class="site_heading_h2">About {{ $speaker_details->speaker_name }}</h2>
                <div class="our_team_details_div mt-4">
                    {!! $speaker_details->speaker_details_data !!}
                </div>

            </div>

        </div>

    </div>
@endsection
