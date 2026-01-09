@extends('frontend.layouts.master')
@section('content')
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h2 class="static_inner_Page_banner_title">Search result</h2>
        </div>
    </div>

    <style>
        .inner_page_banner {
            background-image: url("{{ asset('assets/frontend/images/membership_banner.png') }}");
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
            <span class="small_nav_text">Search</span>
        </div>

        <div class="membership_header_div text-left">
            <h2 class="site_heading_h2 mb-1">Search result</h2>
            <span><b>{{ $count }}</b> search results for <b>{{ $search }}</b></span>
        </div>
        <div class="page_container">
            <div class="row search_row_div">
                <div class="col-sm-3">
                    <a class="side_nav_items pl-0" href="javascript:void(0)" id=""
                        onclick="openSection('all')">All({{ $count }})</a>
                    <a class="side_nav_items pl-0" href="javascript:void(0)" id=""
                        onclick="openSection('about-us')">About
                        Us({{ $result['about-us'] == 0 ? 0 : count($result['about-us']) }})</a>
                    <a class="side_nav_items pl-0" href="javascript:void(0)" id=""
                        onclick="openSection('our-team')">Our
                        Team({{ $result['our-team'] == 0 ? 0 : count($result['our-team']) }})</a>
                    <a class="side_nav_items pl-0" href="javascript:void(0)" id=""
                        onclick="openSection('resource')">Resources({{ isset($result['resource']) ? count($result['resource']) : 0 }})</a>
                    <a class="side_nav_items pl-0" href="javascript:void(0)" id=""
                        onclick="openSection('news-event')">News &
                        Event({{ isset($result['news-event']) ? count($result['news-event']) : 0 }})</a>
                    <a class="side_nav_items pl-0" href="javascript:void(0)" id=""
                        onclick="openSection('membership')">Membership({{ isset($result['membership']) ? count($result['membership']) : 0 }})</a>
                    <a class="side_nav_items pl-0" href="javascript:void(0)" id=""
                        onclick="openSection('home')">Home({{ isset($result['home']) ? count($result['home']) : 0 }})</a>
                </div>
                <div class="col-sm-9 pl-4 event_detail_section_content">
                    {{-- @dd($result) --}}
                    @if ($result['about-us'] != 0)
                        @php $divider_first = 'about-us'; @endphp
                    @elseif($result['our-team'] != 0)
                        @php $divider_first = 'our-team'; @endphp
                    @elseif(isset($result['news-event']))
                        @php $divider_first = 'news-event'; @endphp
                    @elseif(isset($result['membership']))
                        @php $divider_first = 'membership'; @endphp
                    @elseif(isset($result['resource']))
                        @php $divider_first = 'resource'; @endphp
                    @elseif(isset($result['home']))
                        @php $divider_first = 'home'; @endphp
                    @endif

                    @if ($result['about-us'] != 0)
                        <div id="about-us"
                            style="@if ($divider_first == 'about-us') @else border-top: 1px solid #ddd @endif">
                            @foreach ($result['about-us'] as $key => $about_data)
                                <a class="search_result_div" href="{{ route('frontend.about') }}" target="_blank"
                                    style="@if (++$key == count($result['about-us'])) border-bottom:none !important @endif">
                                    <p class="search_result_div_title">{{ $about_data->welcome_head }}</p>
                                    <p class="search_result_div_page_title">About Us</p>
                                    <p class="search_result_div_desc">
                                        {!! App\Helpers\Helper::removeStyleTag($about_data->welcome_desc) !!}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                    @if ($result['our-team'] != 0)
                        <div id="our-team"
                            style="@if ($divider_first == 'our-team') @else border-top: 1px solid #ddd @endif">
                            @foreach ($result['our-team'] as $key => $our_team_data)
                                <a class="search_result_div"
                                    href="{{ url('our-team/' . $our_team_data->uid . '/' . $our_team_data->page_slug) }}"
                                    target="_blank"
                                    style="@if (++$key == count($result['our-team'])) border-bottom:none !important @endif">
                                    <p class="search_result_div_title">{{ $our_team_data->page_name }}</p>
                                    <p class="search_result_div_page_title">Our Team</p>
                                    <p class="search_result_div_desc">
                                        {!! App\Helpers\Helper::removeStyleTag($our_team_data->description_data) !!}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                    @if (isset($result['news-event']))
                        <div id="news-event"
                            style="@if ($divider_first == 'news-event') @else border-top: 1px solid #ddd @endif">
                            @foreach ($result['news-event'] as $key => $news_event)
                                <a class="search_result_div" href="{{ $news_event['redirect_url'] }}" target="_blank"
                                    style="@if (++$key == count($result['news-event'])) border-bottom:none !important @endif">
                                    <p class="search_result_div_title">{{ $news_event['title'] }}</p>
                                    <p class="search_result_div_page_title">News and Event</p>
                                    <p class="search_result_div_desc">
                                        {!! App\Helpers\Helper::removeStyleTag($news_event['description']) !!}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                    @if (isset($result['membership']))
                        <div id="membership"
                            style="@if ($divider_first == 'membership') @else border-top: 1px solid #ddd @endif">
                            @foreach ($result['membership'] as $key => $member)
                                <a class="search_result_div" href="{{ $member['redirect_url'] }}" target="_blank"
                                    style="@if (++$key == count($result['membership'])) border-bottom:none !important @endif">
                                    <p class="search_result_div_title">{{ $member['title'] }}</p>
                                    <p class="search_result_div_page_title">Membership</p>
                                    <p class="search_result_div_desc">
                                        {!! App\Helpers\Helper::removeStyleTag($member['description']) !!}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                    @if (isset($result['resource']))
                        <div id="resource"
                            style="@if ($divider_first == 'resource') @else border-top: 1px solid #ddd @endif">
                            @foreach ($result['resource'] as $key => $resource)
                                <a class="search_result_div" href="{{ $resource['redirect_url'] }}" target="_blank"
                                    style="@if (++$key == count($result['resource'])) border-bottom:none !important @endif">
                                    <p class="search_result_div_title">{{ $resource['title'] }}</p>
                                    <p class="search_result_div_page_title">Resource</p>
                                    <p class="search_result_div_desc">
                                        {!! App\Helpers\Helper::removeStyleTag($resource['description']) !!}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                    @if (isset($result['home']) && count($result['home']))
                        <div id="home"
                            style="@if ($divider_first == 'home') @else border-top: 1px solid #ddd @endif">
                            @foreach ($result['home'] as $key => $home)
                                <a class="search_result_div" href="{{ $home['redirect_url'] }}" target="_blank"
                                    style="@if (++$key == count($result['home'])) border-bottom:none !important @endif">
                                    <p class="search_result_div_title">{{ $home['title'] }}</p>
                                    <p class="search_result_div_page_title">Home</p>
                                    <p class="search_result_div_desc">
                                        {!! App\Helpers\Helper::removeStyleTag($home['description']) !!}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script>
        const openSection = (value) => {
            switch (value) {
                case 'all':
                    $('#about-us').css('display', 'block');
                    $('#our-team').css('display', 'block');
                    $('#news-event').css('display', 'block');
                    $('#membership').css('display', 'block');
                    $('#resource').css('display', 'block');
                    $('#home').css('display', 'block');
                    break;
                case 'about-us':
                    $('#about-us').css('display', 'block');
                    $('#our-team').css('display', 'none');
                    $('#news-event').css('display', 'none');
                    $('#membership').css('display', 'none');
                    $('#resource').css('display', 'none');
                    $('#home').css('display', 'none');
                    break;
                case 'our-team':
                    $('#our-team').css('display', 'block');
                    $('#about-us').css('display', 'none');
                    $('#news-event').css('display', 'none');
                    $('#membership').css('display', 'none');
                    $('#resource').css('display', 'none');
                    $('#home').css('display', 'none');
                    break;
                case 'news-event':
                    $('#news-event').css('display', 'block');
                    $('#our-team').css('display', 'none');
                    $('#about-us').css('display', 'none');
                    $('#membership').css('display', 'none');
                    $('#resource').css('display', 'none');
                    $('#home').css('display', 'none');
                    break;
                case 'membership':
                    $('#news-event').css('display', 'none');
                    $('#our-team').css('display', 'none');
                    $('#about-us').css('display', 'none');
                    $('#membership').css('display', 'block');
                    $('#resource').css('display', 'none');
                    $('#home').css('display', 'none');
                    break;
                case 'resource':
                    $('#news-event').css('display', 'none');
                    $('#our-team').css('display', 'none');
                    $('#about-us').css('display', 'none');
                    $('#membership').css('display', 'none');
                    $('#resource').css('display', 'block');
                    $('#home').css('display', 'none');
                    break;
                case 'home':
                    $('#news-event').css('display', 'none');
                    $('#our-team').css('display', 'none');
                    $('#about-us').css('display', 'none');
                    $('#membership').css('display', 'none');
                    $('#resource').css('display', 'none');
                    $('#home').css('display', 'block');
                    break;
                default:
                    $('#our-team').css('display', 'block');
                    $('#about-us').css('display', 'block');
                    $('#news-event').css('display', 'block');
                    $('#membership').css('display', 'block');
                    $('#resource').css('display', 'block');
                    $('#home').css('display', 'block');
                    break;
            }

        }
    </script>
@endsection
