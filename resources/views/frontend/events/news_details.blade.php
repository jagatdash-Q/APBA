@extends('frontend.layouts.master')
@section('content')
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h2 class="static_inner_Page_banner_title">{!! App\Helpers\Helper::getSuperScript($news_details->event_name) !!}</h2>
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
            <span class="small_nav_text">{!! App\Helpers\Helper::getSuperScript($news_details->event_name) !!}</span>
        </div>

        <div class="news_details_div">

            {!! $news_details->news_desc !!}
        </div>
    </div>

    

@endsection
@section('page-scripts')
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