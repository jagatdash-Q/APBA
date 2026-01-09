@extends('frontend.layouts.master')
@section('content')


    <style>
        .inner_page_banner {
            background-image: url("{{ asset('assets/frontend/images/resources_banner.png') }}");
        }

        .innerPage_banner_title {
            top: 120px;
        }

        @media (min-width: 576px) and (max-width: 768px) {
            .innerPage_banner_title {
                top: 95px;
            }
        }

        @media only screen and (max-width: 576px) {
            .innerPage_banner_title {
                top: 95px;
            }
        }
    </style>
    <style>
        @media only screen and (min-width: 769px) {

            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $resource->getBannerImageWeb->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $resource->banner_title_left_pos_web; ?>%;
                top: <?php echo $resource->banner_title_top_pos_web; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $resource->banner_desc_left_pos_web; ?>%;
                top: <?php echo $resource->banner_desc_top_pos_web; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $resource->button_name_left_pos_web; ?>%;
                top: <?php echo $resource->button_name_top_pos_web; ?>%;
            }
        }

        @media only screen and (min-width: 577px) and (max-width:768px) {
            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $resource->getBannerImageTab->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $resource->banner_title_left_pos_tablet; ?>%;
                top: <?php echo $resource->banner_title_top_pos_tablet; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $resource->banner_desc_left_pos_tablet; ?>%;
                top: <?php echo $resource->banner_desc_top_pos_tablet; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $resource->button_name_left_pos_tablet; ?>%;
                top: <?php echo $resource->button_name_top_pos_tablet; ?>%;
            }
        }

        @media only screen and (max-width: 576px) {

            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $resource->getBannerImageMobile->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $resource->banner_title_left_pos_mobile; ?>%;
                top: <?php echo $resource->banner_title_top_pos_mobile; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $resource->banner_desc_left_pos_mobile; ?>%;
                top: <?php echo $resource->banner_desc_top_pos_mobile; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $resource->button_name_left_pos_mobile; ?>%;
                top: <?php echo $resource->button_name_top_pos_mobile; ?>%;
            }
        }
    </style>
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h1 class="innerPage_banner_title">
                {{ $resource->banner_title != null ? $resource->banner_title : '' }}
            </h1>
            <p class="innerPage_banner_desc">
                {{ $resource->banner_desc != null ? $resource->banner_desc : '' }}
            </p>
            @if ($resource->button_name != null && $resource->button_link != '')
                <span class="innerPage_banner_link">
                    <a class="arrow_hover_link"
                        href="{{ $resource->button_link }}">{{ $resource->button_name }}</a>
                </span>
            @endif
        </div>
    </div>
    <div class="page_container">
        {{-- @dd($resource->page_name) --}}
        <div class="small_nav">
            <a href="{{ url('') }}"><img src="{{ asset('assets/frontend/images/home_icon.svg') }}" alt="..."></a>
            <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
            <span class="small_nav_text">{{ $resource->banner_title }}</span>
        </div>

        <div class="resources_header_div">
            <h2 class="site_heading_h2 mb-5">{{ $resource->title }}</h2>
            <p>{{ $resource->description }}</p>
        </div>


        <div class="row resources_div">
            <div class="col-sm-3">
                <div class="nav flex-column nav-pills side_nav_tab" id="v-pills-tab" role="tablist"
                    aria-orientation="vertical">
                    @if (isset($resource->getResourceMenu))
                        @if (count($resource->getResourceMenu))
                            @foreach ($resource->getResourceMenu as $key => $menu)
                                <span onclick="getMenuId('{{ $menu->id }}')"
                                    class="side_nav_tab_items {{ $key == 0 ? 'active' : '' }}"
                                    id="tab_{{ $menu->id }}_triger" data-toggle="pill"
                                    data-target="#tab_{{ $menu->id }}_content" role="tab"
                                    aria-controls="tab_{{ $menu->id }}_content"
                                    aria-selected="true">{{ $menu->menu }}</span>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>

            <div class="col-sm-9 pl-4">

                <div class="resources_filter_mob">
                    <span>Filters</span>
                    <img class="resources_filter_mob_icon" src="{{ asset('assets/frontend/images/equilizer.png') }}"
                        alt="...">
                </div>

                <div class="resources_filter_div">
                    <div class="resources_filter_close"><img src="{{ asset('assets/frontend/images/close.svg') }}"
                            alt="close"></div>
                    <div class="sort_dropdown_div mb-5">
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


                    <div class="resources_filter_apply_btn">
                        <a class="arrow_hover_link" href="javascript:void(0)">Apply</a>
                    </div>

                </div>

                <div class="tab-content" id="v-pills-tabContent">
                    @include('frontend.resource-cards')
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="sorting_val" value="desc">
    <input type="hidden" id="timing_val" value="">
    @if (isset($resource->getResourceMenu))
        @if (count($resource->getResourceMenu))
            <input type="hidden" id="menu_id" value="{{ $resource->getResourceMenu[0]->id }}">
        @endif
    @endif
    @php
        $banner_img = '';
        $banner_tablet_img = '';
        $banner_mobile_img = '';
        
    @endphp
    @if ($resource->getBannerImageWeb != null)
        @php
            $banner_img = $resource->getBannerImageWeb->path;
        @endphp
    @endif
    @if ($resource->getBannerImageTab != null)
        @php
            $banner_tablet_img = $resource->getBannerImageTab->path;
        @endphp
    @endif
    @if ($resource->getBannerImageMobile != null)
        @php
            $banner_mobile_img = $resource->getBannerImageMobile->path;
        @endphp
    @endif
@endsection

@section('page-scripts')
<script>
    $(document).ready(function() {
        var screen_width = document.body.clientWidth;
        var video = document.getElementById('video_elem');
        // console.log("<?php echo $banner_mobile_img; ?>");
        if (screen_width >= 768 && $(".innerPage_banner_img").length > 0) {
            @if (in_array(pathinfo($banner_img, PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png', 'gif', 'bmp']))
                document.querySelector(".innerPage_banner_img").src = "<?php echo $banner_img; ?>"
                $('#video_elem').remove();
                $('.innerPage_banner_img').css("display", "block");
            @elseif (in_array(pathinfo($banner_img, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                $('.innerPage_banner_img').css("display", "none");
                $('#video_elem').css("display", "block");
                let source = document.getElementById("video_src");
                source.setAttribute('src', '<?php echo $banner_img; ?>');
                source.setAttribute('type', 'video/<?php echo pathinfo($banner_img, PATHINFO_EXTENSION); ?>');
                video.load();
            @endif
        }
        if (screen.width <= 768 && screen.width >= 576 && $(".innerPage_banner_img").length > 0) {
            // console.log(screen_width);


            @if (in_array(pathinfo($banner_tablet_img, PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png', 'gif', 'bmp']))
                document.querySelector(".innerPage_banner_img").src = "<?php echo $banner_tablet_img; ?>"
                $('#video_elem').remove();
                $('.innerPage_banner_img').css("display", "block");
            @elseif (in_array(pathinfo($banner_tablet_img, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                $('.innerPage_banner_img').css("display", "none");
                $('#video_elem').css("display", "block");
                let source = document.getElementById("video_src");
                source.setAttribute('src', '<?php echo $banner_tablet_img; ?>');
                source.setAttribute('type', 'video/<?php echo pathinfo($banner_tablet_img, PATHINFO_EXTENSION); ?>');
                video.load();
            @endif
        }

        // document.querySelector(".innerPage_banner_img").src = "<?php echo $banner_tablet_img; ?>"

        if (screen.width <= 576 && $(".innerPage_banner_img").length > 0) {
            // console.log(screen_width);

            // console.log("{{ $banner_mobile_img }}");
            @if (in_array(pathinfo($banner_mobile_img, PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png', 'gif', 'bmp']))
                document.querySelector(".innerPage_banner_img").src = "<?php echo $banner_mobile_img; ?>"
                $('#video_elem').remove();
                $('.innerPage_banner_img').css("display", "block");
            @elseif (in_array(pathinfo($banner_mobile_img, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                $('.innerPage_banner_img').css("display", "none");
                $('#video_elem').css("display", "block");
                let source = document.getElementById("video_src");
                source.setAttribute('src', '<?php echo $banner_mobile_img; ?>');
                source.setAttribute('type', 'video/<?php echo pathinfo($banner_mobile_img, PATHINFO_EXTENSION); ?>');
                video.load();
            @endif
        }
    });
    $("#get_sort_data li").click(function() {
        $("#ordering_id").html('');
        var sort_by = document.getElementById(this.id).getAttribute('data-value');
        $("#ordering_id").html(document.getElementById(this.id).getAttribute('id') + `<img class="ml-2"
                                    src="{{ asset('assets/frontend/images/down_arrow.svg') }}" alt="">`);
        var timing = $("#timing_val").val();
        $("#sorting_val").val(sort_by);
        getResourceCard(sort_by, timing);
    });

    $("#get_time_data li").click(function() {
        $("#timing_id").html('');
        timing = document.getElementById(this.id).getAttribute('data-value');
        $("#timing_id").html(document.getElementById(this.id).getAttribute('id') + `<img class="ml-2"
                                    src="{{ asset('assets/frontend/images/down_arrow.svg') }}" alt="">`);
        $("#timing_val").val(timing);
        var sort = $("#sorting_val").val();
        getResourceCard(sort, timing);
    });
    const getMenuId = (id) => {
        $("#menu_id").val(id);
    }

    function getResourceCard(sort_by, timing) {
        var menuId = $("#menu_id").val();

        $("#loader").css('display', 'block');
        $.ajax({
                url: 'resources',
                type: "get",
                datatype: "html",
                data: {
                    sort: sort_by,
                    timing: timing,
                    menuId: menuId
                }
            })
            .done(function(data) {
                // console.log(data);
                $("#v-pills-tabContent").empty().html(data);
                $('html, body').animate({
                    scrollTop: $("#v-pills-tabContent").offset().top - 100
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
