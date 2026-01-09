@extends('frontend.layouts.master')
@section('content')
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h2 class="innerPage_banner_title">A-PBA Members Election</h2>
        </div>
    </div>

    <style>
        .inner_page_banner {
            background-image: url("{{ asset('assets/frontend/images/my_profile_banner.png') }}");
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

        td {
            font-weight: 500;
        }

        .step {
            cursor: pointer;
        }

        .nominee_action_btn:hover circle {
            fill: #02b0b5;
        }

        .nominee_action_btn:hover .nominee_check {
            fill: #02b0b5;
        }

        .nominee_action_btn {
            cursor: pointer;
            position: relative;
        }

        .nominee_action_tooltip {
            background-color: #005599;
            padding: 5px 10px;
            font-size: 16px;
            line-height: 28px;
            display: none;
            position: absolute;
            top: -50px;
            color: #ffffff;
            border-radius: 6px;
            left: 50%;
            transform: translateX(-50%);
            width: max-content;
        }

        .nominee_action_tooltip::after {
            border-left: solid transparent 6px;
            border-right: solid transparent 6px;
            border-top: solid #005599 9px;
            bottom: -8px;
            content: " ";
            height: 0;
            left: 50%;
            position: absolute;
            transform: translateX(-50%);
        }

        .nominee_action_btn:hover .nominee_action_tooltip {
            display: block;
        }

        .newletter_btn .subscribe::after {
            top: 35%;
        }

        .newletter_btn .subscribe_arrow::after {
            top: 35%;
        }

        .nomination_list_div.active {
            background-color: #02B0B5;
            color: #ffffff;
        }

        .nomination_list_div.active .nomination_name {
            color: #ffffff;
            font-weight: 400;
        }

        .nomination_list_div.active .nomination_type {
            color: #ffffff;

        }
    </style>

    <div class="page_container">

        <div class="small_nav">
            <a href="{{ url('') }}"><img src="{{ asset('assets/frontend/images/home_icon.svg') }}" alt="..."></a>
            <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
            <span class="small_nav_text">A-PBA Members Election</span>
        </div>
        <div class="row nomination_voting_row_div">
            <div class="col-sm-3">
                @if (count($elections))
                    @foreach ($elections as $key => $position)
                        <div class="step">
                            <h4 class="site_heading_h4">
                                {{ $membership_type[$key] }}
                            </h4>
                            <div class="step_content">
                                <div class="mt-3 mb-5">
                                    @if (count($position))
                                        @foreach ($position as $data)
                                            @if ($data->getNominationPositionDetails != null)
                                                @if ($data->getNominationPositionDetails->getPosition != null)
                                                    @if ($data->getVotedMemberDetails != null)
                                                        <div class="nomination_list_div" style="pointer-events: none;">
                                                            <div>
                                                                <p class="nomination_type">
                                                                    {{ $data->getNominationPositionDetails->getPosition->membership_position }}
                                                                </p>
                                                                <p class="nomination_name">
                                                                    @if ($data->getVotedMemberDetails->getVotedMemberDetails != null)
                                                                        {{ $data->getVotedMemberDetails->getVotedMemberDetails->user_name }}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                    height="25" viewBox="0 0 25 25">
                                                                    <path id="Exclusion_20" data-name="Exclusion 20"
                                                                        d="M-15694.5,8473a12.425,12.425,0,0,1-8.839-3.661,12.425,12.425,0,0,1-3.661-8.839,12.424,12.424,0,0,1,3.661-8.84,12.419,12.419,0,0,1,8.839-3.66,12.419,12.419,0,0,1,8.839,3.66,12.424,12.424,0,0,1,3.661,8.84,12.425,12.425,0,0,1-3.661,8.839A12.425,12.425,0,0,1-15694.5,8473Zm-2.1-6.844h0a.5.5,0,0,0,.078,0,.861.861,0,0,0,.615-.288l2.788-2.788,1.395-1.395,4.226-4.225.016-.019.009-.009a1.271,1.271,0,0,0,.086-.1.955.955,0,0,0,.134-.862.9.9,0,0,0-.591-.588.937.937,0,0,0-.292-.048h-.031a1.048,1.048,0,0,0-.745.359c-1.3,1.3-2.613,2.619-3.743,3.749-1.228,1.228-2.5,2.5-3.743,3.748-.087.09-.146.126-.205.126s-.119-.036-.208-.126c-1.018-1.03-2.073-2.088-3.323-3.331a1.006,1.006,0,0,0-.708-.3.935.935,0,0,0-.66.272.954.954,0,0,0-.28.646v.023a1.013,1.013,0,0,0,.308.694c.7.7,1.406,1.407,2.1,2.1l.686.685,1.395,1.394a.867.867,0,0,0,.622.278l.072,0Z"
                                                                        transform="translate(15707.001 -8448.002)"
                                                                        fill="#02b0b5" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    @else
                                                        @if ($election_details->getNominationDetails != null)
                                                            <div class="nomination_list_div"
                                                                onclick="select_election('{{ $election_details->getNominationDetails->uuid }}','{{ $data->getNominationPositionDetails->uuid }}','{{ $data->getNominationPositionDetails->getPosition->uuid }}','{{ $election_details->uuid }}','{{ $data->uuid }}')">
                                                                <div>
                                                                    <p class="nomination_type">
                                                                        {{ $data->getNominationPositionDetails->getPosition->membership_position }}
                                                                    </p>
                                                                    <p class="nomination_name">Click and select</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif

                                    {{-- @if (count($position->getVotingPositions))
                                        @foreach ($position->getVotingPositions as $data)
                                            @if ($data->getNominationPositionDetails != null)
                                                @if ($data->getNominationPositionDetails->getPosition != null)
                                                    @if ($data->getVotedMemberDetails != null)
                                                        <div class="nomination_list_div" style="pointer-events: none;">
                                                            <div>
                                                                <p class="nomination_type">
                                                                    {{ $data->getNominationPositionDetails->getPosition->membership_position }}
                                                                </p>
                                                                <p class="nomination_name">
                                                                    @if ($data->getVotedMemberDetails->getVotedMemberDetails != null)
                                                                        {{ $data->getVotedMemberDetails->getVotedMemberDetails->user_name }}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                    height="25" viewBox="0 0 25 25">
                                                                    <path id="Exclusion_20" data-name="Exclusion 20"
                                                                        d="M-15694.5,8473a12.425,12.425,0,0,1-8.839-3.661,12.425,12.425,0,0,1-3.661-8.839,12.424,12.424,0,0,1,3.661-8.84,12.419,12.419,0,0,1,8.839-3.66,12.419,12.419,0,0,1,8.839,3.66,12.424,12.424,0,0,1,3.661,8.84,12.425,12.425,0,0,1-3.661,8.839A12.425,12.425,0,0,1-15694.5,8473Zm-2.1-6.844h0a.5.5,0,0,0,.078,0,.861.861,0,0,0,.615-.288l2.788-2.788,1.395-1.395,4.226-4.225.016-.019.009-.009a1.271,1.271,0,0,0,.086-.1.955.955,0,0,0,.134-.862.9.9,0,0,0-.591-.588.937.937,0,0,0-.292-.048h-.031a1.048,1.048,0,0,0-.745.359c-1.3,1.3-2.613,2.619-3.743,3.749-1.228,1.228-2.5,2.5-3.743,3.748-.087.09-.146.126-.205.126s-.119-.036-.208-.126c-1.018-1.03-2.073-2.088-3.323-3.331a1.006,1.006,0,0,0-.708-.3.935.935,0,0,0-.66.272.954.954,0,0,0-.28.646v.023a1.013,1.013,0,0,0,.308.694c.7.7,1.406,1.407,2.1,2.1l.686.685,1.395,1.394a.867.867,0,0,0,.622.278l.072,0Z"
                                                                        transform="translate(15707.001 -8448.002)" fill="#02b0b5" />
                                                                </svg>
                                                            </div>
                                                        </div>

                                                    @else
                                                        <div class="nomination_list_div"
                                                            onclick="select_election('{{ $position->getNominationDetails->uuid }}','{{ $data->getNominationPositionDetails->uuid }}','{{ $data->getNominationPositionDetails->getPosition->uuid }}','{{ $position->uuid }}','{{ $data->uuid }}')">
                                                            <div>
                                                                <p class="nomination_type">
                                                                    {{ $data->getNominationPositionDetails->getPosition->membership_position }}
                                                                </p>
                                                                <p class="nomination_name">Click and select</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-sm-9">
                @if ($election_content != null)
                    {!! $election_content->content_description_data !!}
                @endif
                <div class="d-flex justify-content-between nomination_filter">
                    <div class="sortby_nav_div mt-3">
                        <div class="sort_by_dropdown_label">Sort By</div>
                        <div class="sort_by_dropdown">
                            <span class="sort_by_dropdown_val" id="ordering_id">A to Z<img class="ml-2"
                                    src="{{ asset('assets/frontend/images/down_arrow.svg') }}" alt=""></span>
                            <ul class="sort_by_dropdown_content" id="get_alphabatic_data">
                                <li id="A to Z" data-value="asc"><a href="javascript:void(0)">A to Z</a></li>
                                <li id="Z to A" data-value="desc"><a href="javascript:void(0)">Z to A</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="w-50 namination_search_div">

                        <input type="text" class="namination_search_input" id="search_member_name" placeholder="Search">
                        <button type="button" id="search_member"><img class="namination_search_icon"
                                src="{{ asset('assets/frontend/images/search_icon.svg') }}" alt=""></button>

                    </div>
                </div>
                <div id="election_members_sec">
                    @include('frontend.customer.election.election_members')
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}


    <div class="cd_popup" role="alert" id="election_cd_popup">

    </div>



    <input type="hidden" value="" name="search" id="search">
    <input type="hidden" value="" name="order" id="order">
    <input type="hidden" value="" name="temp_election_uuid" id="temp_election_uuid">
    <input type="hidden" value="" name="temp_position_uuid" id="temp_position_uuid">
    <input type="hidden" value="" name="temp_nomination_position_uuid" id="temp_nomination_position_uuid">
    <input type="hidden" value="" name="temp_voting_uuid" id="temp_voting_uuid">
    <input type="hidden" value="" name="temp_voting_position_uuid" id="temp_voting_position_uuid">

@section('page-scripts')
    <script>
        var image_url = "{{ asset('') }}";

        // Stepper Scripts Strts
        let curOpen;
        curOpen = $('.step')[0];
        // $('.next-btn').on('click', function () {
        //     let cur = $(this).closest('.step');
        //     let next = $(cur).next();
        //     $(cur).addClass('minimized');
        //     setTimeout(function () {
        //         $(next).removeClass('minimized');
        //         curOpen = $(next);
        //     }, 400);
        //     $('#step_1_span').toggle();
        //     $('#step_1_img').toggle();
        // });
        $('.step .step_content').on('click', function(e) {
            e.stopPropagation();
        });
        $('.step').on('click', function() {
            if (!$(this).hasClass("minimized")) {
                curOpen = null;
                $(this).addClass('minimized');
            } else {
                let next = $(this);
                if (curOpen === null) {
                    curOpen = next;
                    $(curOpen).removeClass('minimized');
                } else {
                    $(curOpen).addClass('minimized');
                    setTimeout(function() {
                        $(next).removeClass('minimized');
                        curOpen = $(next);
                    }, 200);
                }
            }
        });
        // Stepper Scripts Ends
        $(document).ready(function() {

            $('#member_message').html('Please click on any position to see the memberes list.');

            $(document).on('click', '.pagination-container a', function(event) {

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                event.preventDefault();

                var myurl = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];
                var search = $('#search').val();
                var order = $('#order').val();

                getMembersData(page, search, order);
            });
        });
        $("#search_member").click(function() {
            var search_member_name = $('#search_member_name').val();
            $('#search').val(search_member_name);
            var order = $('#order').val();
            getMembersData(1, search_member_name, order);
        });

        $("#get_alphabatic_data li").click(function() {
            $("#ordering_id").html('');
            var order = document.getElementById(this.id).getAttribute('data-value');
            $("#ordering_id").html(document.getElementById(this.id).getAttribute('id') + `<img class="ml-2"
                                    src="{{ asset('assets/frontend/images/down_arrow.svg') }}" alt="">`);
            var search = $('#search').val();
            $("#order").val(order);
            getMembersData(1, search, order);

        });

        function getMembersData(page, search, order) {
            let nomination_uuid = $('#temp_election_uuid').val();
            let position_uuid = $('#temp_position_uuid').val();
            $('#temp_position_uuid').val(position_uuid);
            let url = "{{ route('get-customers-for-voting') }}?search=" + search + "&nomination_uuid=" + nomination_uuid +
                "&position_uuid=" + position_uuid + "&order=" + order + "&page=" + page;
            $("#loader").css('display', 'block');
            $.ajax({
                url: url,
                type: "get",
                datatype: "html",
                processData: false,
                success: function(data) {
                    console.log(data);
                    $("#election_members_sec").empty().html(data);
                    // location.hash = page;
                    $('html, body').animate({
                        scrollTop: $("#election_members_sec").offset().top - 100
                    });
                    $("#loader").css('display', 'none');
                },
                error: function() {
                    $("#loader").css('display', 'none');
                }

            });
        }

        $('.nomination_list_div').click(function(e) {
            $('.nomination_list_div').removeClass("active");
            $(this).addClass("active");
        });
        const select_election = (nomination_uuid, nomination_position, position_uuid, voting_uuid,
            voting_position_uuid) => {
            let order = $('#order').val();
            let search = $('#search').val();
            $("#loader").css('display', 'block');
            $('#temp_election_uuid').val(nomination_uuid);
            $('#temp_position_uuid').val(position_uuid);
            $('#temp_nomination_position_uuid').val(nomination_position);
            $('#temp_voting_uuid').val(voting_uuid);
            $('#temp_voting_position_uuid').val(voting_position_uuid);
            // $("#loader").css('display', 'none');
            console.log(nomination_uuid);
            console.log(position_uuid);
            let url = "{{ route('get-customers-for-voting') }}?search=" + search + "&nomination_uuid=" +
                nomination_uuid + "&position_uuid=" + position_uuid + "&order=" + order;
            $.ajax({
                // url: "{{ route('get-customers-for-voting') }}",
                url: url,
                type: "get",
                datatype: "html",
                processData: false,
                success: function(data) {
                    $("#election_members_sec").empty().html(data);
                    $('html, body').animate({
                        scrollTop: $("#election_members_sec").offset().top - 100
                    });
                    $("#loader").css('display', 'none');
                },
                error: function() {
                    $("#loader").css('display', 'none');
                }
            });
        }
        const get_member_details = (name, photo, id) => {
            $("#loader").css('display', 'block');
            var fieldHTML = ``;
            $('#election_cd_popup').html('');
            var profile_pic = '';
            console.log(photo);
            if (photo == '') {
                profile_pic = `{{ asset('assets/frontend/images/user_thumb.jpg') }}`;
            } else {
                profile_pic = image_url + `uploads/profile_pic/` + photo;
            }

            fieldHTML = `<div class="cd_popup_container" style="max-width: 750px">
            <img class="cd_popup_close close_modal" src="{{ asset('assets/frontend/images/nav_toggle_close.svg') }}"
                alt="...">
            <div class="row nominee_modal_row_div px-3 pt-5 pb-4">
                <div class="col-sm-4 mb-4">
                    <div class="nominee_modal_thumb">
                        <img src="${profile_pic}" alt="...">
                    </div>
                </div>
                <div class="col-sm-8">
                    <h3 class="site_heading_h3">Are You Sure to Elect ${name}</h3>
                    <p>Note: Once you have confirmed, no changes are allowed.</p>
                    <div class="d-flex">
                        <button type="submit" class="arrow_hover_link aft_35 mr-2"
                            style="border:none; background-color: #B70000;" onclick="submit_election('${name}','${id}')">Yes</button>
                        <button type="submit" class="arrow_hover_link aft_35 close_modal"
                            style="border:none;">Cancel</button>
                        {{-- <a href="javascript:void(0)" class="arrow_hover_link mr-2" style="background-color: #B70000;">Yes</a>
                    <a href="javascript:void(0)" class="arrow_hover_link close_modal">Cancel</a> --}}
                    </div>
                </div>
            </div>
        </div>`;
            $('#election_cd_popup').append(fieldHTML);

            $('#election_cd_popup').addClass('is-visible');
            $('body').addClass('modal-open');
            $('#cd_popup_backdrop').addClass('cd_popup_backdrop');
            $('.home_container').addClass('blur_bg');
            $('header').addClass('blur_bg');

            $("#loader").css('display', 'none');
        }


        let submit_election = (name, member_id) => {
            let nomination_uuid = $('#temp_election_uuid').val();
            let position_uuid = $('#temp_position_uuid').val();
            let nomination_position_uuid = $('#temp_nomination_position_uuid').val();
            let temp_voting_uuid = $('#temp_voting_uuid').val();
            let voting_position_uuid = $('#temp_voting_position_uuid').val();
            $("#loader").css('display', 'block');
            $.ajax({
                url: "{{ route('customer-elect-vote') }}",
                type: "post",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'nomination_uuid': nomination_uuid,
                    'position_uuid': position_uuid,
                    'nomination_position_uuid': nomination_position_uuid,
                    'voting_uuid': temp_voting_uuid,
                    'member_id': member_id,
                    'voting_position_uuid': voting_position_uuid
                },
                success: function(data) {
                    $("#loader").css('display', 'none');
                    if (data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Congratulations!',
                            text: data.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Sorry!',
                            text: data.message,
                        });
                    }
                    window.setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function() {
                    $("#loader").css('display', 'none');
                }
            });

        }
    </script>
@endsection
