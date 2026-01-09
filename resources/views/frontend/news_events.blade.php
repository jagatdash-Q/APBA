@extends('frontend.layouts.master')
@section('content')
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h2 class="static_inner_Page_banner_title">News & Events</h2>
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
            <span class="small_nav_text">News & Events</span>
        </div>

        <div class="news_event_filter_mob">
            <span>Filters</span>
            <img class="news_event_filter_mob_icon" src="{{ asset('assets/frontend/images/equilizer.png') }}"
                alt="...">
        </div>

        <div class="news_event_div_section">
            <div class="news_event_filter_close"><img src="{{ asset('assets/frontend/images/close.svg') }}" alt="close">
            </div>
            <h3 class="site_heading_h3 mb-4" style="font-weight: 600;">Select Category</h3>
            <div class="news_event_filter_div">
                <div class="news_event_filter_radio_buttons">
                    <div class="radio_div">
                        <input type="radio" id="all" checked name="news_event_filter_Options" value="" />
                        <label class="radio_label" for="all">All</label>
                    </div>

                    <div class="radio_div">
                        <input type="radio" id="news" name="news_event_filter_Options" value="1" />
                        <label class="radio_label" for="news">News</label>
                    </div>

                    <div class="radio_div">
                        <input type="radio" id="events" name="news_event_filter_Options" value="0" />
                        <label class="radio_label" for="events">Events</label>
                    </div>
                </div>

                <div class="sort_dropdown_div">
                    <div class="sortby_nav_div">
                        <div class="sort_by_dropdown_label">Sort By</div>
                        <div class="sort_by_dropdown">
                            <span class="sort_by_dropdown_val" id="timing_id">All Time<img class="ml-2"
                                    src="{{ asset('assets/frontend/images/down_arrow.svg') }}" alt=""></span>
                            <ul class="sort_by_dropdown_content" id="get_time_data">
                                <li id="All Time" data-value=""><a href="javascript:void(0)">All Time</a></li>
                                <li id="Monthly" data-value="{{ Carbon\Carbon::now()->month }}"><a
                                        href="javascript:void(0)">Monthly</a></li>
                                {{-- <li><a href="javascript:void(0)">Seasonal</a></li> --}}
                            </ul>
                        </div>
                    </div>
                    <div class="sortby_nav_div ml-5">
                        <div class="sort_by_dropdown_label">Sort By</div>
                        <div class="sort_by_dropdown">
                            <span class="sort_by_dropdown_val" id="ordering_id">Latest<img class="ml-2"
                                    src="{{ asset('assets/frontend/images/down_arrow.svg') }}" alt=""></span>
                            <ul class="sort_by_dropdown_content" id="get_sort_data" style="width: 140px;">
                                <li id="Latest" data-value="desc"><a href="javascript:void(0)">Latest</a></li>
                                <li id="Oldest" data-value="asc"><a href="javascript:void(0)">Oldest</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="news_event_filter_apply_btn">
                    <a class="arrow_hover_link" href="javascript:void(0)">Apply</a>
                </div>
            </div>
        </div>


        <div class="row my-5" id="news_events_sec">
            @include('frontend.events.event_cards')
        </div>
    </div>
    <input type="hidden" id="sorting_val" value="desc">
    <input type="hidden" id="timing_val" value="">
    <input type="hidden" id="radio_val" value="">
@endsection


@section('page-scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.pagination-container a', function(event) {

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                event.preventDefault();

                var myurl = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];
                var sort = $("#sorting_val").val();
                var timing = $("#timing_val").val();
                var radio_val = $("#radio_val").val();

                getEventData(page, sort, timing, radio_val);
            });
        });

        $("#get_sort_data li").click(function() {
            $("#ordering_id").html('');
            var sort_by = document.getElementById(this.id).getAttribute('data-value');
            $("#ordering_id").html(document.getElementById(this.id).getAttribute('id') + `<img class="ml-2"
                                    src="{{ asset('assets/frontend/images/down_arrow.svg') }}" alt="">`);
            var timing = $("#timing_val").val();
            $("#sorting_val").val(sort_by);
            var radio_val = $("#radio_val").val();

            getEventData(1, sort_by, timing, radio_val);
        });

        $("#get_time_data li").click(function() {
            $("#timing_id").html('');
            timing = document.getElementById(this.id).getAttribute('data-value');
            $("#timing_id").html(document.getElementById(this.id).getAttribute('id') + `<img class="ml-2"
                                    src="{{ asset('assets/frontend/images/down_arrow.svg') }}" alt="">`);
            $("#timing_val").val(timing);
            var sort = $("#sorting_val").val();
            var radio_val = $("#radio_val").val();
            getEventData(1, sort, timing, radio_val);
        });

        $('input:radio').change(function() {
            var radio_val = $("input[name='news_event_filter_Options']:checked").val();
            var timing = $("#timing_val").val();
            var sort = $("#sorting_val").val();
            $("#radio_val").val(radio_val);
            getEventData(1, sort, timing, radio_val);
        });

        function getEventData(page, sort_by, timing, radio_val) {
            $("#loader").css('display', 'block');

            $.ajax({
                    url: 'news-events?page=' + page,
                    type: "get",
                    datatype: "html",
                    data: {
                        sort: sort_by,
                        timing: timing,
                        radio_val: radio_val,
                    }
                })
                .done(function(data) {
                    $("#news_events_sec").empty().html(data);
                    location.hash = page;
                    $('html, body').animate({
                        scrollTop: $("#news_events_sec").offset().top - 100
                    });
                    $("#loader").css('display', 'none');
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    $("#loader").css('display', 'none');
                    alert('No response from server');
                });
        }
    </script>
@endsection
