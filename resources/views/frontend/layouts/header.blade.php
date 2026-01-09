<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if (isset($title))
            {{ $title }}
        @else
            Asia-Pacific Biosafety Association
        @endif
    </title>
    <meta name="description"
        content="@if (isset($description)) {{ $description }} @else Asia-Pacific Biosafety Association @endif">
    <meta name="keywords"
        content="@if (isset($keywords)) {{ $keywords }} @else Asia-Pacific Biosafety Association @endif">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/frontend/images/favicon-apba.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/font_montserrat.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/apba_styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/apba_responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/owl_carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/owl_carousel/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/fancybox/jquery.fancybox.min.css') }}">
    {{-- Sweet alert include --}}

    <link rel="stylesheet" href="{{ asset('assets/dashboard/sweetalert/sweetalert.css') }}">
    {{-- End of Sweet alert include --}}
    {{-- Include common css --}}
</head>
<div class="home_container">
<body class="home">
    <header>
        <div class="page_container">
            <div class="header_top">
                <div class="header_search_box">
                    <form action="{{route('frontend.search.details')}}" id="search_page" class="mb-2">
                        <input class="header_search_input" name="search_text" id="search_text" type="text" autocomplete="off" required>
                        <img onclick="searchPage()" src="{{ asset('assets/frontend/images/search_icon.svg') }}" class="header_search_icon"
                            alt="...">
                    </form>
                </div>
                {{-- <div class="header_language_dropdown">
                    <div class="language_drpdwn">
                        <span>En<img src="{{ asset('assets/frontend/images/down_arrow.svg') }}" alt="..."
                                style="margin-left: 5px;"></span>
                        <ul class="language_drpdwn_content">
                            <li><a href="javascript:void(0)">Bahasa</a></li>
                            <li><a href="javascript:void(0)">Malay</a></li>
                        </ul>
                    </div>
                </div> --}}

                    @if (Auth::guard('customer')->check())
                        <div class="header_login_box">
                            <a href="{{ route('customer.home') }}">
                                <img src="{{ asset('assets/frontend/images/user_icon.svg') }}" alt="..."
                                    style="margin-right: 10px;">
                                @if (Auth::guard('customer')->check())
                                    <span>{{ Auth::guard('customer')->user()->first_name }}</span>
                                @else
                                    <span>{{ Auth::user()->name }}</span>
                                @endif
                            </a>
                        </div>
                    @else
                        <div class="header_login_box" id="login_cd_popup_trigger">
                            <a href="javascript:void(0)">
                                <img src="{{ asset('assets/frontend/images/user_icon.svg') }}" alt="..."
                                    style="margin-right: 10px;">
                                <span>Login</span>
                            </a>
                        </div>
                    @endif
                </div>

                <div class="header_bottom">
                    <div class="header_logo">
                        <a href="{{ url('') }}">
                            <img src="{{ asset('assets/frontend/images/logo.png') }}" alt="...">
                        </a>
                    </div>
                    <nav class="navbar navbar-expand-md navbar-light float-right site_navbar">
                        <a href="javascript:void(0)" class="menu-icon-toggle">
                            <img class="nav_toggle" src="{{ asset('assets/frontend/images/nav_toggle.svg') }}"
                                alt="...">
                            <img class="nav_toggle_close"
                                src="{{ asset('assets/frontend/images/nav_toggle_close.svg') }}" alt="...">
                        </a>
                        <div class="navbar-collapse-content">
                            <div class="navbar-nav">
                                <a class="nav-link {{ Nav::isRoute('frontend.about') }}"
                                    href="{{ route('frontend.about') }}">About A-PBA</a>
                                <a class="nav-link {{ Nav::isRoute('frontend.our.team') }}"
                                    href="{{ route('frontend.our.team') }}">Our Team</a>
                                <a class="nav-link {{ Nav::isRoute('frontend.resources') }}"
                                    href="{{ route('frontend.resources') }}">Resources</a>
                                <a class="nav-link {{ Nav::isRoute('frontend.news.events') }}"
                                    href="{{ route('frontend.news.events') }}">News & Events</a>
                                <a class="nav-link {{ Nav::isRoute('frontend.membership') }}"
                                    href="{{ route('frontend.membership') }}">Membership</a>
                                <a class="nav-link {{ Nav::isRoute('frontend.contact') }}"
                                    href="{{ route('frontend.contact') }}">Contact</a>
                            </div>
                        </div>
                    </nav>
                </div>

            </div>
        </header>

        @include('frontend.layouts.loader')

        @include('frontend.layouts.error')
