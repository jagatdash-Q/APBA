@extends('frontend.layouts.master')
@section('content')
    <style>
        @media only screen and (min-width: 769px) {
            .home_banner {
                background-image: url("{{ asset('') }}{{ $home->getBannerImageWeb->path }}");
            }
        }

        @media only screen and (min-width: 577px) and (max-width:768px) {

            .home_banner {
                background-image: url("{{ asset('') }}{{ $home->getBannerImageTab->path }}");
            }
        }

        @media only screen and (max-width: 576px) {

            .home_banner {
                background-image: url("{{ asset('') }}{{ $home->getBannerImageMobile->path }}");
            }
        }
    </style>
    <div class="home_banner bg-animation">
        <div id="siteHomeCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
            @if (count($home->getSliders))
                <div class="carousel-inner">
                    <div class="home_banner_content_wrapper">
                        @foreach ($home->getSliders as $key => $val)
                            @php
                                $class = '';
                            @endphp
                            @if ($key == 0)
                                @php $class='active'; @endphp
                            @endif
                            <div class="carousel-item {{ $class }}">
                                <h1 class="home_banner_title">{{ $val->slider_heading }}
                                </h1>
                                <p class="home_banner_desc">{{ $val->slider_desc }}</p>
                                <span class="home_banner_link">
                                    <a class="arrow_hover_link" href="{{ $val->slider_button_link }}" target="_blank">
                                        {{ $val->slider_button_text }}
                                    </a>
                                </span>
                            </div>
                        @endforeach
                        <div class="carousel-indicators">
                            @foreach ($home->getSliders as $key => $val)
                                @php
                                    $class = '';
                                @endphp
                                @if ($key == 0)
                                    @php $class='active'; @endphp
                                @endif
                                <button type="button" data-target="#siteHomeCarousel" data-slide-to="{{ $key }}"
                                    class="{{ $class }}" aria-current="true" aria-label="Slide {{ $key }}"></button>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="home_banner_overlay"></div>
    </div>




    <div class="page_container">
        <div class="row home_section_1">
            <div class="col-sm-7 home_section_1_img_div">
                @if ($home->getfirstSectionfirstImage != null)
                    <img src="{{ asset('') }}{{ $home->getfirstSectionfirstImage->path }}"
                        class="col-6 home_section_1_img_1" alt="{{ $home->getfirstSectionfirstImage->alt_tag }}" />
                @else
                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                        class="col-6 home_section_1_img_1" alt="..." />
                @endif
                @if ($home->getfirstSectionsecondImage != null)
                    <img src="{{ asset('') }}{{ $home->getfirstSectionsecondImage->path }}"
                        class="col-6 col-6 home_section_1_img_2" alt="{{ $home->getfirstSectionsecondImage->alt_tag }}" />
                @else
                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                        class="col-6 home_section_1_img_2" alt="..." />
                @endif
            </div>
            <div class="col-sm-5 home_section_1_content_div">
                <h2 class="site_heading_h2 mb-3">{{ $home->section_1_heading }}</h2>
                <div class="home_section_1_content_div_desc">
                    {{ $home->section_1_desc }}
                </div>
                <a class="arrow_hover_link" href="{{ $home->section_1_button_link }}" target="_blank">
                    {{ $home->section_1_button_text }}
                </a>
            </div>
        </div>
    </div>


    <div class="position-relative">

        <div class="page_container">
            <div class="row home_section_2">
                @if (count($home->getFirstSectionCards))
                    @foreach ($home->getFirstSectionCards as $key => $val)
                        @php
                            ++$key;
                            $class = '';
                        @endphp
                        @if ($key % 2 == 0)
                            @php $class='pl-4' ; @endphp
                        @endif
                        <div class="col-md-6 {{ $class }}">
                            <div class="home_section_2_div">
                                @if ($val->getCardImage != null)
                                    <img src="{{ asset('') }}{{ $val->getCardImage->path }}" class="home_section_img"
                                        alt="{{ $val->getCardImage->alt_tag }}" />
                                @else
                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                        class="home_section_img" alt="..." />
                                @endif
                                <div class="home_section_content">
                                    <a href="{{ $val->view_more_link }}" target="_blank"
                                        class="home_section_2_heading">{{ $val->heading }}</a>
                                    <p class="home_section_2_desc mt-3">
                                        {{ $val->description }}</p>
                                    <a href="{{ $val->view_more_link }}" target="_blank"
                                        class="home_section_2_link">{{ $val->view_more_text }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="home_canvas">
            <canvas id="home_canvas" class="particles"></canvas>
        </div>
    </div>
    @if (count($lattest_news_and_event))
        <div class="page_container">
            <div class="home_section_3">
                <h2 class="site_heading_h2 home_news_events_haedings mb-4">News & Events</h2>
                <div class="row">
                    @foreach ($lattest_news_and_event as $val)
                        <div class="col-sm-4">
                            <p class="news_event_small_title">
                                @if ($val->is_news==1)
                                    News
                                @else
                                    Events
                                @endif
                            </p>
                            <a href="@if ($val->is_news == 0) {{ route('frontend.event.details', $val->event_slug) }} @else 
                                {{ route('frontend.news.details', $val->event_slug) }} @endif" class="news_event_div">
                                @if ($val->getFeaturedImage != null)
                                    <img class="news_event_div_img"
                                        src="{{ asset('') }}{{ $val->getFeaturedImage->path }}" alt="...">
                                @else
                                    <img class="news_event_div_img"
                                        src="{{ asset('assets/dashboard/images/image_not_found.png') }}" alt="...">
                                @endif

                                <div class="news_event_div_content">
                                    <p class="news_event_div_date">
                                        @if ($val->start_date != null && $val->end_date != null)
                                            {{ App\Helpers\Helper::getDateFormat($val->start_date, $val->end_date) }}
                                        @else
                                            {{ Carbon\Carbon::parse($val->created_at)->format('d F Y') }}
                                        @endif
                                    </p>
                                    <h4 class="news_event_div_desc">{!! App\Helpers\Helper::getSuperScript($val->event_name) !!}</h4>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="news_event_arrow_div">
                    <a class="arrow_hover_link" href="{{ route('frontend.news.events') }}">
                        View More
                    </a>
                </div>
            </div>
        </div>
    @endif
    <div class="page_container">
        <div class="home_section_4">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h2 class="site_heading_h2 mb-3">{{ $home->section_2_heading }}</h2>
                    <p>
                        {{ $home->section_2_desc }}
                    </p>
                </div>
                <div class="col-sm-6">
                    @if (count($home->getPartners))
                        @foreach ($home->getPartners as $key => $val)
                        <div class="partners_div_outer">
                            <div class="partners_div">
                                @if ($val->getPartnerImage != null)
                                    <img class="partners_img" src="{{ asset('') }}{{ $val->getPartnerImage->path }}"
                                        alt="{{ $val->getPartnerImage->alt_tag }}">
                                @else
                                    <img class="partners_img"
                                        src="{{ asset('assets/dashboard/images/image_not_found.png') }}" alt="...">
                                @endif
                                <div class="partners_overlay">
                                    <a href="{{ $val->hover_link }}" target="_blank">
                                        <span>{{ $val->hover_text }}</span>
                                        <img src="{{ asset('assets/frontend/images/right_arrow_white.svg') }}"
                                            alt="...">
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="page_container">
        <div class="home_section_5 row mx-0">

            @if (count($home->getFinalSectionCards))
                @foreach ($home->getFinalSectionCards as $key => $val)
                    <div class="col-sm-3">
                        @if ($val->getCardImage != null)
                            <img src="{{ asset('') }}{{ $val->getCardImage->path }}" class="home_section_5_thumb"
                                alt="{{ $val->getCardImage->alt_tag }}" />
                        @else
                            <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                class="home_section_5_thumb" />
                        @endif
                    </div>
                    <div class="col-sm-9 pl-5">
                        <h2 class="site_heading_h2 mb-4">{{ $val->heading }}</h2>
                        <p class="mb-5">{{ $val->description }}</p>
                        <a class="arrow_hover_link" target="_blank" href="{{ $val->read_more_link }}">
                            {{ $val->read_more_button_text }}
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
@section('page-scripts')
    <script>
        $(document).ready(function() {
            
        });
    </script>
@endsection
