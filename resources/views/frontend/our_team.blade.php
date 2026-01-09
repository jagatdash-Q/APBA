@extends('frontend.layouts.master')
@section('content')
    <style>
        @media only screen and (min-width: 769px) {

            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $is_our_team_page_exist->getOurTeamContent->imageDetails->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $is_our_team_page_exist->getOurTeamContent->banner_title_left_pos_web; ?>%;
                top: <?php echo $is_our_team_page_exist->getOurTeamContent->banner_title_top_pos_web; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $is_our_team_page_exist->getOurTeamContent->banner_desc_left_pos_web; ?>%;
                top: <?php echo $is_our_team_page_exist->getOurTeamContent->banner_desc_top_pos_web; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $is_our_team_page_exist->getOurTeamContent->button_name_left_pos_web; ?>%;
                top: <?php echo $is_our_team_page_exist->getOurTeamContent->button_name_top_pos_web; ?>%;
            }
        }

        @media only screen and (min-width: 577px) and (max-width:768px) {

            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $is_our_team_page_exist->getOurTeamContent->imageDetailsTab->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $is_our_team_page_exist->getOurTeamContent->banner_title_left_pos_tablet; ?>%;
                top: <?php echo $is_our_team_page_exist->getOurTeamContent->banner_title_top_pos_tablet; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $is_our_team_page_exist->getOurTeamContent->banner_desc_left_pos_tablet; ?>%;
                top: <?php echo $is_our_team_page_exist->getOurTeamContent->banner_desc_top_pos_tablet; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $is_our_team_page_exist->getOurTeamContent->button_name_left_pos_tablet; ?>%;
                top: <?php echo $is_our_team_page_exist->getOurTeamContent->button_name_top_pos_tablet; ?>%;
            }
        }

        @media only screen and (max-width: 576px) {

            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $is_our_team_page_exist->getOurTeamContent->imageDetailsMobile->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $is_our_team_page_exist->getOurTeamContent->banner_title_left_pos_mobile; ?>%;
                top: <?php echo $is_our_team_page_exist->getOurTeamContent->banner_title_top_pos_mobile; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $is_our_team_page_exist->getOurTeamContent->banner_desc_left_pos_mobile; ?>%;
                top: <?php echo $is_our_team_page_exist->getOurTeamContent->banner_desc_top_pos_mobile; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $is_our_team_page_exist->getOurTeamContent->button_name_left_pos_mobile; ?>%;
                top: <?php echo $is_our_team_page_exist->getOurTeamContent->button_name_top_pos_mobile; ?>%;
            }
        }
    </style>
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            {{-- @if ($is_our_team_page_exist->getOurTeamContent->imageDetails != null)
            @if (in_array($is_our_team_page_exist->getOurTeamContent->imageDetails->file_ext, ['mp4', 'webm', 'ogg']))
                <video autoplay muted loop playsinline class="d-block video_elem" style="display:none;width:100%"
                    id="video_elem">
                    <source src="{{ asset('') }}{{ $is_our_team_page_exist->getOurTeamContent->imageDetails->path }}"
                        type="video/{{ pathinfo($is_our_team_page_exist->getOurTeamContent->imageDetails->path, PATHINFO_EXTENSION) }}"
                        id="video_src">
                    Your browser does not support HTML video.
                </video>
                <img src="" class="innerPage_banner_img" style="display: none;" />
            @else
                <video autoplay muted loop playsinline class="video_elem" style="display:none;width:100%"
                    id="video_elem">
                    <source src="" type="" id="video_src">
                    Your browser does not support HTML video.
                </video>
                <img src="{{ asset('') }}{{ $is_our_team_page_exist->getOurTeamContent->imageDetails->path }}"
                    class="innerPage_banner_img" />
            @endif
        @endif --}}
            <h1 class="innerPage_banner_title">
                {{ $is_our_team_page_exist->getOurTeamContent->banner_head != null ? $is_our_team_page_exist->getOurTeamContent->banner_head : '' }}
            </h1>
            <p class="innerPage_banner_desc">
                {{ $is_our_team_page_exist->getOurTeamContent->banner_desc != null ? $is_our_team_page_exist->getOurTeamContent->banner_desc : '' }}
            </p>
            @if (
                $is_our_team_page_exist->getOurTeamContent->button_name != null &&
                    $is_our_team_page_exist->getOurTeamContent->button_link != '')
                <span class="innerPage_banner_link">
                    <a class="arrow_hover_link"
                        href="{{ $is_our_team_page_exist->getOurTeamContent->button_link }}">{{ $is_our_team_page_exist->getOurTeamContent->button_name }}</a>
                </span>
            @endif
        </div>
    </div>

    <div class="page_container">
        <input type="hidden" name="is_cat_click" value="0" id="is_cat_click" />
        <input type="hidden" name="cat_id" value="0" id="cat_id" />
        <div class="small_nav">
            <a href="{{ url('') }}"><img src="{{ asset('assets/frontend/images/home_icon.svg') }}"
                    alt="..."></a>
            <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
            <span class="small_nav_text">Our Team</span>
        </div>

        <div class="our_team_header_div">
            <h2 class="site_heading_h2 mb-5">{{ $is_our_team_page_exist->getOurTeamContent->title }}</h2>
            <p>{{ $is_our_team_page_exist->getOurTeamContent->desc }}</p>
        </div>

        @if (count($our_team_categories))
            <div class="our_team_div">
                <div class="team_filter_outer">
                    <div class="team_filter_li_active_value">
                        <span>All</span>
                        <img class="team_filter_dropdown_arrow" src="{{ asset('assets/frontend/images/down_arrow.svg') }}"
                            alt="...">
                    </div>
                    <ul class="team_filter mx-auto">
                        {{-- <li class="active" onclick="getCatListing('0')">All</li> --}}
                        @foreach ($our_team_categories as $key => $cat)
                            @if ($cat->ourTeamCatContent != null)
                                <li class="{{ $key == 0 ? 'active' : '' }}"
                                    onclick="getCatListing('{{ $cat->ourTeamCatContent->uid }}')">
                                    {{ $cat->ourTeamCatContent->title }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="our_team_div">
                <div class="row my-5 our_team_list" id="our_team_list">

                    @include('frontend.our_team_data')

                    {{-- @if (count($our_teams_list))
                        @foreach ($our_teams_list as $list)
                            @if ($list->getOurTeamListingContent != null)
                                <a href="{{ route('frontend.our.team.details', ['uid' => $list->getOurTeamListingContent->uid, 'slug' => $list->getOurTeamListingContent->page_slug]) }}"
                                    class="col-sm-4 mx-4 our_team_thumb">
                                    @if ($list->getOurTeamListingContent->image_details != null)
                                        <img class="our_team_thumb_img"
                                            src="{{ asset('') }}{{ $list->getOurTeamListingContent->image_details->path }}"
                                            alt="...">
                                    @else
                                        <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                            class="our_team_thumb_img">
                                    @endif
                                    <div class="our_team_content">
                                        <h3 class="our_team_name">{{ $list->getOurTeamListingContent->name }}</h3>
                                        <span
                                            class="our_team_desg">{{ $list->getOurTeamListingContent->designation }}</span>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    @endif --}}
                </div>
                @if ($our_teams_list_count > 9)
                    <div class="our_team_load_more">
                        <a class="arrow_hover_link load-more-data" id="load-more-data" href="javascript:void(0)">Load
                            More</a>
                    </div>
                @endif
                <div class="auto-load text-center" style="display: none;">
                    <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60" viewBox="0 0 100 100"
                        enable-background="new 0 0 0 0" xml:space="preserve">
                        <path fill="#000"
                            d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                                from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                        </path>
                    </svg>
                </div>



            </div>
        @endif
    </div>
    </div>

    @php
        $banner_img = '';
        $banner_tablet_img = '';
        $banner_mobile_img = '';
    @endphp
    @if ($is_our_team_page_exist->getOurTeamContent->imageDetails != null)
        @php
            $banner_img = $is_our_team_page_exist->getOurTeamContent->imageDetails->path;
        @endphp
    @endif
    @if ($is_our_team_page_exist->getOurTeamContent->imageDetailsTab != null)
        @php
            $banner_tablet_img = $is_our_team_page_exist->getOurTeamContent->imageDetailsTab->path;
        @endphp
    @endif
    @if ($is_our_team_page_exist->getOurTeamContent->imageDetailsMobile != null)
        @php
            $banner_mobile_img = $is_our_team_page_exist->getOurTeamContent->imageDetailsMobile->path;
        @endphp
    @endif

@endsection

@section('page-scripts')
    <script>
        $(document).ready(function() {
            getCatListing("{{$our_team_categories[0]['ourTeamCatContent']['uid']}}");
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
        let cat_page = 0;
        let getCatListing = (cat_uid) => {
            $('#is_cat_click').val('cat');
            $('#cat_id').val(cat_uid);
            cat_page = 1;
            $("#our_team_list").html('');

            $.ajax({
                    url: "{{ url('our-team/cat/listing') }}" + "?cat_uid=" + cat_uid + "&page=" + cat_page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function() {
                        $('.auto-load').show();
                    }
                })
                .done(function(response) {
                    $("#our_team_list").append(response.html);
                    if ((response.current_page_data < 9) || (response.has_new_page == false)) {
                        $(".auto-load").hide();
                        $("#load-more-data").css('display', 'none');
                        return;
                    } else {
                        $("#load-more-data").css('display', 'inline-block');
                        $(".auto-load").hide();
                    }

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }

        var ENDPOINT = "{{ route('frontend.our.team') }}";
        var page = 1;

        $(".load-more-data").click(function() {
            if ($('#is_cat_click').val() == '0') {
                page++;
                infinteLoadMore(page);
            } else {
                cat_page++;
                infinteLoadMoreCat(cat_page);
            }

        });

        function infinteLoadMore(page) {
            $.ajax({
                    url: ENDPOINT + "?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function() {
                        $('.auto-load').show();
                    }
                })
                .done(function(response) {
                    $("#our_team_list").append(response.html);
                    if ((response.current_page_data < 9) || (response.has_new_page == false)) {
                        $(".auto-load").hide();
                        $("#load-more-data").css('display', 'none');
                        return;
                    } else {
                        $("#load-more-data").css('display', 'inline-block');
                        $(".auto-load").hide();
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }

        function infinteLoadMoreCat(page) {
            let cat_id = $('#cat_id').val();
            $.ajax({
                    url: "{{ url('our-team/cat/listing') }}" + "?page=" + cat_page + "&cat_uid=" + cat_id,
                    datatype: "html",
                    type: "get",
                    beforeSend: function() {
                        $('.auto-load').show();
                    }
                })
                .done(function(response) {
                    $("#our_team_list").append(response.html);
                    if ((response.current_page_data < 9) || (response.has_new_page == false)) {
                        $(".auto-load").hide();
                        $("#load-more-data").css('display', 'none');
                        return;
                    } else {
                        $("#load-more-data").css('display', 'inline-block');
                        $(".auto-load").hide();
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }
    </script>
@endsection
