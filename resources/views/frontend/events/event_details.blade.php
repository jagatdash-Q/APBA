@extends('frontend.layouts.master')
@section('content')
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h2 class="static_inner_Page_banner_title">{!! App\Helpers\Helper::getSuperScript($event_details->event_name) !!}</h2>
        </div>
    </div>

    <style>
        .inner_page_banner {
            background-image: url("{{ asset('assets/frontend/images/news_events_banner.png') }}");
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
            <span class="small_nav_text">{!! App\Helpers\Helper::getSuperScript($event_details->event_name) !!}</span>
        </div>


        <div class="event_nav">
            <div class="event_nav_container">
                <div class="row event_nav_row mx-0">
                    <div class="event_nav_item col-sm-3">
                        <img class="mr-3" src="{{ asset('assets/frontend/images/clock.png') }}" alt="...">
                        <p class="mb-0">
                            {{ App\Helpers\Helper::getDateFormat($event_details->start_date, $event_details->end_date) }}
                        </p>
                    </div>
                    <div class="event_nav_item col-sm-6">
                        <img class="mr-3" src="{{ asset('assets/frontend/images/location.png') }}" alt="...">
                        <p class="mb-0">{{ $event_details->event_location }}</p>
                    </div>
                    @if (count($event_details->GetEventWorkshops) > 0)
                        @if ($is_reg_valid)
                            <div class="event_nav_item col-sm-3">
                                <a class="arrow_link_simple"
                                    href="{{ route('frontend.event.register', $event_details->uid) }}">
                                    Register Now
                                </a>
                            </div>
                        @else
                            <div class="event_nav_item col-sm-3" style="cursor: not-allowed;">
                                <p class="mb-0 py-3">Registration Closed</p>
                            </div>
                        @endif
                    @else
                        <div class="event_nav_item col-sm-3" style="cursor: not-allowed;">
                            <p class="mb-0 py-3">Registration Closed</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if (count($event_details->GetEventWorkshops) > 0)
        @if ($is_reg_valid)
            <div class="event_nav_register_float" style="cursor: not-allowed;">
                <a class="arrow_link_simple" href="{{ route('frontend.event.register', $event_details->uid) }}">
                    Register Now
                </a>
            </div>
        @else
            <div class="event_nav_register_float" style="cursor: not-allowed;">
                <p class="mb-0">Registration Closed</p>
            </div>
        @endif
    @else
        <div class="event_nav_register_float" style="cursor: not-allowed;">
            <p class="mb-0">Registration Closed</p>
        </div>
    @endif
    <div class="page_container">
        <div class="row event_detail_div">
            <div class="col-sm-3">
                @if (count($event_details->getEventTabs) > 0)
                    <div class="side_nav_outer">
                        <div class="side_nav">
                            @foreach ($event_details->getEventTabs as $tab_data)
                                @if ($tab_data->tab_type == 'gallery')
                                    @if (count($event_details->getEventgallery))
                                        <a class="side_nav_items" href="javascript:void(0)"
                                            id="{{ $tab_data->tab_slug }}">{{ $tab_data->tab_name }}</a>
                                    @endif
                                @elseif($tab_data->tab_type == 'speaker')
                                    @if (count($event_speakers))
                                        <a class="side_nav_items" href="javascript:void(0)"
                                            id="{{ $tab_data->tab_slug }}">{{ $tab_data->tab_name }}</a>
                                    @endif
                                @else
                                    <a class="side_nav_items" href="javascript:void(0)"
                                        id="{{ $tab_data->tab_slug }}">{{ $tab_data->tab_name }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-sm-9 pl-4 event_detail_section_content">
                <h2 class="site_heading_h2 mb-3">{!! App\Helpers\Helper::getSuperScript($event_details->event_name) !!}</h2>

                <div class="event_intro_thumb">
                    <img src="{{ asset('') }}{{ $event_details->getFeaturedImage->path }}" alt="...">
                </div>

                @if (count($event_details->getEventTabs) > 0)
                    @foreach ($event_details->getEventTabs as $tab_details)
                        @if ($tab_details->tab_type == 'gallery')
                            @if (count($event_details->getEventgallery))
                                <section class="event_section" id="{{ $tab_details->tab_slug }}_section">
                                    <h3 class="event_section_heading mb-3"><span>{{ $tab_details->tab_name }}</span></h3>
                            @endif
                        @elseif($tab_details->tab_type == 'speaker')
                            @if (count($event_speakers))
                                <section class="event_section" id="{{ $tab_details->tab_slug }}_section">
                                    <h3 class="event_section_heading mb-3"><span>{{ $tab_details->tab_name }}</span></h3>
                            @endif
                        @else
                            <section class="event_section" id="{{ $tab_details->tab_slug }}_section">
                                <h3 class="event_section_heading mb-3"><span>{{ $tab_details->tab_name }}</span></h3>
                        @endif

                        {{-- <section class="event_section" id="{{ $tab_details->tab_slug }}_section">
                            <h3 class="event_section_heading mb-3"><span>{{ $tab_details->tab_name }}</span></h3> --}}
                        @if ($tab_details->tab_type == 'speaker')
                            @if (count($event_speakers) > 0)
                                <div class="row my-5" id="event_speaker_data">
                                    @foreach ($event_speakers as $event_speaker_details)
                                        <a href="{{ route('frontend.featured.speaker.details', $event_speaker_details->id) }}"
                                            class="col-sm-4 event_section_speakers_thumb_div">
                                            <div class="event_section_speakers_thumb_img">
                                                @if (isset($event_speaker_details->getSpeakerImage))
                                                    <img src="{{ asset('') }}{{ $event_speaker_details->getSpeakerImage->path }}"
                                                        alt="...">
                                                @endif
                                            </div>
                                            <div class="event_section_speakers_content">
                                                <p class="event_section_speakers_name">
                                                    {{ $event_speaker_details->speaker_name }}</p>
                                                <span
                                                    class="event_section_speakers_desg">{{ $event_speaker_details->speaker_designation }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                                @if ($total_speaker_count > 6)
                                    <a class="arrow_hover_link" id="load_more_speaker" href="javascript:void(0)">Load
                                        More</a>
                                @endif
                                <div class="auto-load text-center" style="display: none;">
                                    <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0"
                                        xml:space="preserve">
                                        <path fill="#000"
                                            d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                            <animateTransform attributeName="transform" attributeType="XML"
                                                type="rotate" dur="1s" from="0 50 50" to="360 50 50"
                                                repeatCount="indefinite" />
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        @elseif($tab_details->tab_type == 'gallery')
                            @if (count($event_details->getEventgallery) > 0)
                                <div class="photo_gallery_outer">
                                    <div class="photo_gallery owl-carousel owl-theme" id="photo_gallery_slider">
                                        @foreach ($event_details->getEventgallery as $event_gallery_details)
                                            <div class="item">
                                                <a href="{{ asset('dropzone') }}/{{ $event_gallery_details->image }}"
                                                    data-fancybox="group" data-caption="">
                                                    <img src="{{ asset('dropzone') }}/{{ $event_gallery_details->image }}"
                                                        alt="...">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            </section>
                        @else
                            {!! $tab_details->tab_desc_data !!}
                        @endif
                        </section>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script>
        $(document).ready(function() {

            var page = 1;
            var site_url = "{{ route('frontend.event.details', $event_details->event_slug) }}";

            var tabData = {!! json_encode($event_details->getEventTabs) !!}
            if (tabData != null) {
                tabData.forEach(element => {
                    if ((screen.width >= 576)) {
                        $(`#${element['tab_slug']}`).click(function() {
                            $('html, body').animate({
                                scrollTop: $(`#${element['tab_slug']}_section`).offset()
                                    .top - 200
                            }, 900);
                        });
                    }
                    if ((screen.width <= 576)) {
                        $(`#${element['tab_slug']}`).click(function() {
                            $('html, body').animate({
                                scrollTop: $(`#${element['tab_slug']}_section`).offset()
                                    .top - 100
                            }, 900);
                        });
                    }
                });
            }

            $("#load_more_speaker").click(function() {
                $(".auto-load").css('display', 'block');
                page++;
                $.ajax({
                        url: site_url + '?page=' + page,
                        type: "get",
                        datatype: "html",

                    })
                    .done(function(data) {
                        console.log(data);
                        $("#event_speaker_data").append(data.data);
                        if ((data.current_page_data < 6) || (data.has_new_page == false)) {
                            // $('#load_more_speaker').css({
                            //     'opacity': 0.5,
                            //     'pointer-events': 'none'
                            // });
                            $(".auto-load").css('display', 'none');
                            $("#load_more_speaker").css('display', 'none');
                            return;
                        } else {
                            $('#load_more_speaker').css({
                                'opacity': 1,
                                'pointer-events': 'all'
                            });
                            $(".auto-load").css('display', 'none');
                        }

                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError) {
                        $(".auto-load").css('display', 'none');
                        alert('No response from server');
                    });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            if(document.body.clientWidth<= 576){
                if($('.static_inner_Page_banner_title').html().length>50){
                    let text = $('.static_inner_Page_banner_title').html();
                    $('.static_inner_Page_banner_title').html(text.substring(0, 50)+ ' ....')
                    
                }
            }
        });
    </script>
@endsection
