@extends('frontend.layouts.master')
@section('content')
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h2 class="innerPage_banner_title">My Account</h2>
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

        .login-btn:hover {
            border-color: transparent !important;
            border: none;
        }

        .profile-user-img img {
            width: 100%;
            height: 100%;
            object-fit: fill;
        }

        .profile-user-img {
            width: 150px;
            height: auto;
            margin: 0 auto;
            border: 5px solid #a7a7a7;
            border-radius: 50%;
            overflow: hidden;
        }
    </style>

    <div class="page_container">

        <div class="small_nav">
            <a href="{{ url('') }}"><img src="{{ asset('assets/frontend/images/home_icon.svg') }}" alt="..."></a>
            <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
            <span class="small_nav_text">My Account</span>
        </div>

        <div class="row profile_div">
            <div class="col-sm-3">
                <div class="nav flex-column nav-pills side_nav_tab" id="v-pills-tab" role="tablist"
                    aria-orientation="vertical">
                    <span class="side_nav_tab_items active" id="overview_tab" data-toggle="pill"
                        data-target="#overview_tab_content" role="tab" aria-controls="overview_tab_content"
                        aria-selected="true">Overview</span>
                    <span class="side_nav_tab_items" id="details_tab" data-toggle="pill" data-target="#details_tab_content"
                        type="button" role="tab" aria-controls="details_tab_content"
                        aria-selected="false">Profile</span>
                    <span class="side_nav_tab_items" id="subscription_tab" data-toggle="pill"
                        data-target="#subscription_tab_content" type="button" role="tab"
                        aria-controls="subscription_tab_content" aria-selected="false">Subscription</span>
                    <span class="side_nav_tab_items" id="booking_tab" data-toggle="pill" data-target="#booking_tab_content"
                        type="button" role="tab" aria-controls="booking_tab_content"
                        aria-selected="false">Bookings</span>
                    {{-- <span class="side_nav_tab_items" id="nomination_tab" data-toggle="pill"
                        data-target="#nomination_tab_content" type="button" role="tab"
                        aria-controls="nomination_tab_content" aria-selected="false">Nomination</span> --}}
                    {{-- <span class="side_nav_tab_items" id="voting_tab" data-toggle="pill" data-target="#voting_tab_content"
                        type="button" role="tab" aria-controls="voting_tab_content" aria-selected="false">Voting</span>  --}}
                    @if ($customer_details->nomination == 'yes' && Auth::guard('customer')->user()->current_subscription_status == 'a')
                        @if ($check_nomination != null)
                            <span class="side_nav_tab_items" id="nomination_election_tab" data-toggle="pill"
                                data-target="#nomination_election_tab_content" type="button" role="tab"
                                aria-controls="nomination_election_tab_content" aria-selected="false">Nomination</span>
                        @endif
                        @if ($check_election != null)
                            <span class="side_nav_tab_items" id="election_tab" data-toggle="pill"
                                data-target="#election_tab_content" type="button" role="tab"
                                aria-controls="election_tab_content" aria-selected="false">Election</span>
                        @endif
                    @endif

                    <span class="side_nav_tab_items" type="button" onclick="userLogout()">Log Out</span>
                </div>
            </div>

            <div class="col-sm-9 pl-4">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="overview_tab_content" role="tabpanel"
                        aria-labelledby="overview_tab_content">
                        <div class="row">
                            <div class="col-6">
                                <h2 class="site_heading_h2 mb-3">Overview</h2>
                                <h4 class="site_heading_h4">Hello {{ Auth::guard('customer')->user()->first_name }}
                                    {{ Auth::guard('customer')->user()->last_name }} ,</h4>
                                <div class="profile_welcome_msg">
                                    <p>You're logged as</p>
                                    <p style="font-weight: 600;">{{ Auth::guard('customer')->user()->email }}</p>
                                </div>
                            </div>
                            <div class="col-6 text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    @if (Auth::guard('customer')->user()->profile_pic == null) style="background: grey; @endif"
                                    src="{{ Auth::guard('customer')->user()->profile_pic == null ? asset('assets/frontend/images/avatar_white.gif') : asset('uploads/profile_pic/' . Auth::guard('customer')->user()->profile_pic) }}"
                                    alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="details_tab_content" role="tabpanel"
                        aria-labelledby="details_tab_content">

                        <h2 class="site_heading_h2 mb-3">Profile</h2>
                        <div>
                            <form class="my-5" action="{{ route('customer.profile.update') }}" method="POST"
                                onsubmit="return checkConfirmPass()" id="customer_form" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label">Full Name*</label>
                                    <input type="text" class="form-control custom_input" placeholder="Your full name"
                                        name="full_name" id="full_name"
                                        value="{{ Auth::guard('customer')->user()->user_name }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Social Media Link</label>
                                    <input type="url" class="form-control custom_input"
                                        placeholder="Your social media link" name="social_media_link"
                                        id="social_media_link"
                                        value="{{ Auth::guard('customer')->user()->social_media_link }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control custom_input"
                                        placeholder="Your email address" name="email"
                                        value="{{ Auth::guard('customer')->user()->email }}" id="email" readonly>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">First Name*</label>
                                    <input type="text" required class="form-control custom_input"
                                        placeholder="Your first name" name="first_name"
                                        value="{{ Auth::guard('customer')->user()->first_name }}" id="first_name">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Last Name*</label>
                                    <input type="text" required class="form-control custom_input"
                                        placeholder="Your last name" name="last_name"
                                        value="{{ Auth::guard('customer')->user()->last_name }}" id="last_name">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Password </label>
                                    <input type="password" class="form-control custom_input" placeholder="Your password"
                                        name="password" id="password">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Confirm Password <span id="conf_pass"></span></label>
                                    <input type="password" class="form-control custom_input"
                                        placeholder="Re-type your password" name="confirm_password"
                                        id="confirm_password">
                                    <span id="error_check" style="display: none;"></span>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Country *</label>
                                    <select class="form-control custom_select" name="country" id="country" required>
                                        @foreach ($country as $con)
                                            @if ($con->name == Auth::guard('customer')->user()->country)
                                                <option value="{{ $con->name }}" selected>{{ $con->name }}</option>
                                            @else
                                                <option value="{{ $con->name }}">{{ $con->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Profile Picture(max 200kb) *</label>
                                    <input type="file" class="form-control custom_input" accept="image/*"
                                        name="profile_pic" id="profile_pic"
                                        value="{{ Auth::guard('customer')->user()->profile_pic }}">
                                </div>
                                <div class="mb-4">
                                    <div id="imagePreview">
                                        <img src="{{ Auth::guard('customer')->user()->profile_pic == null ? asset('assets/frontend/images/avatar_white.gif') : asset('uploads/profile_pic/' . Auth::guard('customer')->user()->profile_pic) }}"
                                            height="100px" width="auto"
                                            @if (Auth::guard('customer')->user()->profile_pic == null) style="background:grey;" @endif>
                                    </div>
                                </div>
                                <button type="submit" class="arrow_hover_link login-btn mt-5"
                                    style="border-color:transparent;">Save Changes</button>
                            </form>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="subscription_tab_content" role="tabpanel"
                        aria-labelledby="subscription_tab_content">
                        @if ($customer_details->getActiveSubscriptionDetails != null)
                            <h2 class="site_heading_h2 mb-3">Subscription</h2>
                            {{-- <p>Please renew/ upgrade to Individual Membership in order to be eligible for Nomination and
                                Voting
                                rights.</p> --}}
                            <div class="table_div my-5">
                                <table class="table site_table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Membership</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Expires On</th>
                                            <th scope="col">Amount (S$)</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align: middle">
                                                @if (isset($customer_details->getActiveSubscriptionDetails->membership_name))
                                                    {{ $customer_details->getActiveSubscriptionDetails->membership_name }}
                                                @endif
                                            </td>

                                            <td style="vertical-align: middle">
                                                {{-- @php
                                                    $end_date = Carbon\Carbon::now();
                                                    $start_date = Carbon\Carbon::parse($customer_details->active_subscription_expired_on);
                                                    if ($start_date->gte($end_date)) {
                                                        echo 'Active';
                                                    } else {
                                                        echo 'Expired';
                                                    }
                                                @endphp --}}
                                                @if ($customer_details->current_subscription_status == 'a')
                                                    Active
                                                @elseif($customer_details->current_subscription_status == 'e')
                                                    Expired
                                                @elseif($customer_details->current_subscription_status == 'p')
                                                    Pending
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle">
                                                @if ($customer_details->getActiveSubscriptionDetails->membership_plan == 'lifetime')
                                                    -
                                                @else
                                                    @if (isset($customer_details->active_subscription_expired_on))
                                                        {{ Carbon\Carbon::parse($customer_details->active_subscription_expired_on)->format('l m d,Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                @endif

                                            </td>
                                            <td style="vertical-align: middle">
                                                @if (isset($customer_details->getActiveSubscriptionDetails->membership_price))
                                                    {{ $customer_details->getActiveSubscriptionDetails->membership_price }}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle">
                                                @if ($customer_details->current_subscription_status == 'a')
                                                    @if ($customer_details->getActiveSubscriptionDetails->membership_plan == 'lifetime')
                                                        -
                                                    @elseif(
                                                        $customer_details->getActiveSubscriptionDetails->membership_plan == 'yearly' &&
                                                            $customer_details->getActiveSubscriptionDetails->subscription_type == 'sub')
                                                        <button type="button" onclick="choosePackage('upgrade')"
                                                            class="btn btn-success">Upgrade</button>
                                                    @else
                                                        -
                                                    @endif
                                                @elseif($customer_details->current_subscription_status == 'e')
                                                    @if (
                                                        $customer_details->getActiveSubscriptionDetails->membership_plan == 'yearly' &&
                                                            $customer_details->getActiveSubscriptionDetails->subscription_type == 'sub')
                                                        <form action="{{ route('upgradePayment') }}" method="POST"
                                                            class="mb-0">
                                                            @csrf
                                                            <input type="hidden" name="subscription_id"
                                                                value="{{ $customer_details->active_subscription }}">

                                                            <input type="hidden" name="payment_for" value="renew">

                                                            <button type="submit" class="table_btn">Renew
                                                            </button>
                                                        </form>
                                                    @else
                                                        -
                                                    @endif
                                                @elseif($customer_details->current_subscription_status == 'p')
                                                    <form action="{{ route('upgradePayment') }}" method="POST"
                                                        class="mb-0">
                                                        @csrf
                                                        <input type="hidden" name="subscription_id"
                                                            value="{{ $customer_details->active_subscription }}">
                                                        <input type="hidden" name="payment_for" value="pay now">
                                                        <button type="submit" class="table_btn">Pay
                                                            Now</button>
                                                    </form>
                                                @endif


                                                {{-- @if ($customer_details->current_subscription_status == 'a')
                                                    -
                                                @elseif($customer_details->current_subscription_status == 'e')
                                                    <form action="{{ route('upgradePayment') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="payment_for" value="renew">
                                                        <button type="submit" class="btn btn-success">Renew</button>
                                                    </form>
                                                @elseif($customer_details->current_subscription_status == 'p')
                                                    <form action="{{ route('upgradePayment') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="payment_for" value="pay now">
                                                        <button type="submit" class="btn btn-warning">Pay Now</button>
                                                    </form>
                                                @else
                                                    -
                                                @endif --}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- <h3 class="site_heading_h3">Nomination rules</h3> --}}
                            {{-- <ol class="site_list">
                                <li>A member will nominate only unique member for different posts (e.g A cannot nominate B
                                    for
                                    both president and vice president)</li>
                                <li>The same nominee can be nominated by a different member for different post (i.e A
                                    nominate B
                                    for president, and C nominated B for vice president. B can give consent to both posts of
                                    president & vice president)</li>
                                <li>A member cannot second the same nominee for more than one post. (e.g if B being
                                    nominated
                                    for both president & vice president, D only second B for either president or vice
                                    president
                                    and not for both).</li>
                            </ol> --}}

                            {{-- <h3 class="site_heading_h3 mt-5">Voting rules</h3>
                            <ol class="site_list">
                                <li>A member can vote only once. i.e only one on-line voting submission for each post.</li>
                            </ol> --}}
                        @endif
                    </div>

                    <div class="tab-pane fade" id="booking_tab_content" role="tabpanel"
                        aria-labelledby="booking_tab_content">
                        @if ($customer_details->getEventRegistration != null)

                            <h2 class="site_heading_h2 mb-3">Booking</h2>
                            {{-- <p>Please renew/ upgrade to Individual Membership in order to be eligible for Nomination and
                            Voting
                            rights.</p> --}}
                            <div class="table_div my-5">
                                <table class="table site_table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            {{-- <th>Workshop</th>
                                            <th>Program</th>
                                            <th>Date</th>
                                            <th>Time</th> --}}
                                            <th>View Details</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($customer_details->getEventRegistration) > 0)
                                            @foreach ($customer_details->getEventRegistration as $event_reg)
                                                <tr>
                                                    <td style="vertical-align: middle">
                                                        @if (isset($event_reg->getEventDetails->event_name))
                                                            {{ $event_reg->getEventDetails->event_name }}
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle">
                                                        <a class="table_btn" href="javascript:void(0)"
                                                            id="booking_view_trigger"
                                                            onclick="bookingDetails({{ $event_reg }})">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                    <td style="vertical-align: middle">
                                                        {{ ucfirst($event_reg->payment_status) }}</td>
                                                    <td style="vertical-align: middle">
                                                        @if ($event_reg->payment_status != 'success')
                                                            <form
                                                                action="{{ route('frontend.retry.event.registration') }}"
                                                                method="POST" class="mb-0">
                                                                @csrf
                                                                <input type="hidden" name="event_reg_id"
                                                                    value="{{ $event_reg->id }}">
                                                                <input type="hidden" name="total_amount"
                                                                    value="{{ $event_reg->total_amount }}">
                                                                <input type="hidden" name="payment_for"
                                                                    value="retry event registartion">
                                                                <button type="submit" class="table_btn">Retry</button>
                                                            </form>
                                                        @else
                                                            @if (isset($event_reg->getEventProgram) || isset($event_reg->getEventRegistrationOptional))
                                                                @if (count($event_reg->getEventProgram))
                                                                    @php
                                                                        $check_survey = 0;
                                                                    @endphp
                                                                    @foreach ($event_reg->getEventProgram as $workshop)
                                                                        @if (isset($workshop->getProgramDetails))
                                                                            @if ($workshop->getProgramDetails->survey == 'yes' && $workshop->getProgramDetails->survey_activity_uuid != null)
                                                                                @php
                                                                                    $check_survey = 1;
                                                                                @endphp
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                    {{-- @php
                                                                        $current_date = Carbon\Carbon::now()->startOfDay();
                                                                        $end_date = Carbon\Carbon::parse($event_reg->getEventDetails->end_date)->startOfDay();
                                                                        if ($current_date->lt($end_date)) {
                                                                            $check_survey = 0;
                                                                        }
                                                                    @endphp --}}
                                                                    @if ($event_reg->survey == 'yes')
                                                                        @php
                                                                            $check_survey = 0;
                                                                        @endphp
                                                                    @endif
                                                                    @if ($check_survey == 1)
                                                                        {{-- <a href="{{ route('customer.survey', $event_reg->uuid) }}"
                                                                            class="table_btn" target="_blank">Survey</a> --}}
                                                                        <a href="javascript:void(0);" class="table_btn"
                                                                            onclick="surveyDetails('{{ $event_reg->uuid }}','program')">Survey</a>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                @else
                                                                    @if (count($event_reg->getEventRegistrationOptional))
                                                                        @php
                                                                            $check_survey = 0;
                                                                        @endphp
                                                                        @foreach ($event_reg->getEventRegistrationOptional as $optional)
                                                                            @if (isset($optional->getOptionalDetails))
                                                                                @if ($optional->getOptionalDetails->survey == 'yes' && $optional->getOptionalDetails->survey_activity_uuid != null)
                                                                                    @php
                                                                                        $check_survey = 1;
                                                                                    @endphp
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                        {{-- @php
                                                                        $current_date = Carbon\Carbon::now()->startOfDay();
                                                                        $end_date = Carbon\Carbon::parse($event_reg->getEventDetails->end_date)->startOfDay();
                                                                        if ($current_date->lt($end_date)) {
                                                                            $check_survey = 0;
                                                                        }
                                                                    @endphp --}}
                                                                        @if ($event_reg->survey == 'yes')
                                                                            @php
                                                                                $check_survey = 0;
                                                                            @endphp
                                                                        @endif
                                                                        @if ($check_survey == 1)
                                                                            <a href="javascript:void(0);"
                                                                                class="table_btn"
                                                                                onclick="surveyDetails('{{ $event_reg->id }}','optional')">Survey</a>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="nomination_election_tab_content" role="tabpanel"
                        aria-labelledby="nomination_election_tab_content">
                        <h2 class="site_heading_h2 mb-4">
                            @if ($nomination_content != null)
                                {{ $nomination_content->heading }}
                            @endif
                        </h2>
                        <div>
                            @if ($nomination_content != null)
                                {!! $nomination_content->description_data !!}
                            @endif
                        </div>
                        <a class="arrow_hover_link" href="{{ route('frontend.nomination') }}">
                            Proceed
                        </a>
                    </div>
                    <div class="tab-pane fade" id="election_tab_content" role="tabpanel"
                        aria-labelledby="election_tab_content">
                        <h2 class="site_heading_h2 mb-4">
                            @if ($election_content != null)
                                {{ $election_content->heading }}
                            @endif
                        </h2>
                        <div>
                            @if ($election_content != null)
                                {!! $election_content->description_data !!}
                            @endif
                        </div>
                        <a class="arrow_hover_link" href="{{ route('frontend.election') }}">
                            Proceed
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="cd_popup" role="alert" id="bookings_cd_popup">
        <div class="cd_popup_container"
            style="height: 100%; max-width: 100%; overflow-y: scroll;    padding-bottom: 0px; padding-top: 30px;">
            <h3 class="site_heading_h3 cd_popup_alingment" id="heading_details"></h3>
            <img class="cd_popup_close close_modal" src="{{ asset('assets/frontend/images/nav_toggle_close.svg') }}"
                alt="...">
            <div id="append_booking_data">

            </div>
        </div>
    </div> --}}


    <script>
        let userLogout = () => {
            window.location.href = "{{ route('customer.logout') }}";
        }
    </script>
@endsection

@section('page-scripts')
    <script>
        const choosePackage = (value) => {
            $('#payment_for').val(value);
            $('#package_cd_popup').addClass('is-visible');
            $('body').addClass('modal-open');
            $('#cd_popup_backdrop').addClass('cd_popup_backdrop');
            $('.home_container').addClass('blur_bg');
        }

        $("#password").keyup(function() {
            var password = $("#password").val();
            if (password != '') {
                $("#conf_pass").html('');
                $("#conf_pass").html('*');
            } else {
                $("#conf_pass").html('');
            }
        });

        $('#customer_form').validate({
            rules: {
                // email: {
                //     required: true,
                // },
                full_name: {
                    required: true,
                },
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                country: {
                    required: true,
                },
            },
            messages: {
                // email: {
                //     required: "",
                // },
                full_name: {
                    required: "",
                },
                first_name: {
                    required: "",
                },
                last_name: {
                    required: "",
                },
                country: {
                    required: "",
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        const checkConfirmPass = () => {
            var password = $("#password").val();
            if (password != '') {
                var confirm_password = $("#confirm_password").val();
                if (confirm_password == '') {
                    document.getElementById('confirm_password').style.borderColor = "red";
                    return false;
                } else {
                    document.getElementById('confirm_password').style.borderColor = "#e1e8ee";
                }

                if (password != confirm_password) {
                    $("#error_check").html('Password and confirm password must be same').css({
                        'display': 'block',
                        'color': '#dc3545'
                    });
                    return false;
                } else {
                    $("#error_check").css('display', 'none');
                }
            } else {
                document.getElementById('confirm_password').style.borderColor = "#e1e8ee";
                $("#error_check").css('display', 'none');
            }
        }

        $("#profile_pic").on("change", function(e) {
            var file = e.target.files[0];
            if (file) {
                $("#imagePreview").html('');
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageData = e.target.result;
                    $("#imagePreview").html('<img src="' + imageData +
                        '" alt="Image Preview" width="200" max-height="120" height="100" style="object-fit: contain;">'
                    );
                };
                reader.readAsDataURL(file);
            }
        });

        const bookingDetails = (data) => {

            $('body').addClass('modal-open');
            $('#cd_popup_backdrop').addClass('cd_popup_backdrop');
            $('.home_container').addClass('blur_bg');
            $('header').addClass('blur_bg');
            $('#bookings_cd_popup').addClass('is-visible');

            $('#heading_details').html('');
            $('#heading_details').html('Event Details');
            const timeoptions = {
                hour: 'numeric', // 'h' for 12-hour format
                minute: 'numeric', // 'm' for minutes
                hour12: true // Enable 12-hour format
            };
            const dateOptions = {
                weekday: 'long', // 'l' for full weekday name
                month: 'long', // 'm' for full month name
                day: 'numeric', // 'd' for day of the month
                year: 'numeric' // 'Y' for four-digit year
            };
            const capitalizeFirstLetter = str => `${str.charAt(0).toUpperCase()}${str.slice(1)}`;

            $("#append_booking_data").html('');
            var fieldHTML = '';
            fieldHTML = `<table class="table" style="color: #03355d;">
        <tr>
            <td><b>Event Title: </b></td>
            <td>
               ${data['get_event_details']['event_name']}
            </td>
        </tr>`;

            if (data['get_event_program'].length > 0) {

                data['get_event_program'].forEach(element => {

                    const programDate = new Date(element['get_program_details']['program_date']);
                    const startTimeString = element['get_program_details']['start_time'];
                    const endTimeString = element['get_program_details']['end_time'];
                    const [starthours, startminutes] = startTimeString.split(':');
                    const [endhours, endminutes] = endTimeString.split(':');
                    const startTime = new Date();
                    const endTime = new Date();
                    startTime.setHours(starthours);
                    startTime.setMinutes(startminutes);
                    endTime.setHours(endhours);
                    endTime.setMinutes(endminutes);
                    fieldHTML += `<tr>
            <td><b>Workshops Details: </b></td>
            <td>
                <p><b>${element['get_workshop_details']['workshop_name']}</b></p>

                <table class="table mt-2">
                    <tr>
                        <td><b>Program Name: </b></td>
                        <td>${element['get_program_details']['program_name']}</td>
                    </tr>
                    <tr>
                        <td><b>Date: </b></td>
                        <td>${programDate.toLocaleDateString('en-US', dateOptions)}</td>
                    </tr>
                    <tr>
                        <td><b>Room Number: </b></td>
                        <td> ${element['get_program_details']['room_no']!=null?element['get_program_details']['room_no']:''}</td>
                    </tr>
                    <tr>
                        <td><b>Workshop Number: </b></td>
                        <td> ${element['get_program_details']['workshop_number']!=null?element['get_program_details']['workshop_number']:''}</td>
                    </tr>
                    <tr>
                        <td><b>Time: </b></td>
                        <td>${startTime.toLocaleTimeString('en-US', timeoptions)} - ${endTime.toLocaleTimeString('en-US', timeoptions)}</td>
                    </tr>
                    <tr>
                        <td><b>Price: </b></td>
                        <td>S$ ${element['get_program_details']['price_member']}</td>
                    </tr>
                    <tr>
                        <td><b>Program: </b></td>
                        <td>
                           ${element['get_program_details']['program_desc']}
                        </td>
                    </tr>
                    <tr>
                        <td><b>Trainers: </b></td>
                        <td>
                            ${element['get_program_details']['program_trainers']}

                        </td>
                    </tr>
                </table>
            </td>
        </tr>`;
                });

            }


            fieldHTML += `<tr>
            <td><b>Status: </b></td>
            <td>${capitalizeFirstLetter(data['payment_status'])}</td>
        </tr>`;
            if (data['get_event_registration_optional'].length) {
                data['get_event_registration_optional'].forEach(optional => {
                    if (typeof optional['get_optional_details'] !== 'undefined') {
                        fieldHTML += `<tr>
            <td><b>${optional['get_optional_details']['activity_optional_name']}: </b></td>
            <td style="vertical-align: middle">S$ ${optional['get_optional_details']['price_member']}</td>
        </tr> `;
                    }
                });
            }

            fieldHTML += `<tr>
            <td><b>Total Price: </b></td>
            <td><b>S$ ${data['total_amount']}</b></td>
        </tr>
        </table>`;

            $("#append_booking_data").append(fieldHTML);
        }

        const surveyDetails = (reg_uuid, reg_type) => {

            var customer_survey_url = "{{ url('/') }}/customer-survey";
            var optional_survey_url = "{{ url('/') }}/customer-optional-survey";
            $("#loader").css('display', 'block');
            $('#heading_details').html('');
            $('#heading_details').html('Survey Details');
            $("#append_booking_data").html('');

            $.ajax({
                    url: 'survey-details',
                    type: "get",
                    datatype: "html",
                    data: {
                        reg_uuid: reg_uuid,
                        reg_type: reg_type,
                    }
                })
                .done(function(data) {
                    var fieldHTML = '';
                    fieldHTML = `<div class="table_div mt-4">
                <table class="table site_table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                    if (data.length > 0) {
                        data.forEach(element => {
                            if (reg_type == "program") {

                                if (element['get_program_details']['survey'] == 'yes') {

                                    fieldHTML += `<tr>
                                                    <td style="vertical-align: middle">
                                                        ${element['get_program_details']['get_event_details']['event_name']}
                                                        <br>
                                                        <h6 style="color:#02B0B5">${element['get_program_details']['get_event_workshop_details']['workshop_name']} | ${element['get_program_details']['program_name']}</h6>
                                                    </td>
                                                    <td style="vertical-align: middle">`;
                                    if (element['survey'] == 'no') {
                                        fieldHTML +=
                                            `<a href="${customer_survey_url}/${element['uuid']}"
                                                                            class="table_btn"  target="_blank">Survey</a>`;
                                    } else {

                                        fieldHTML +=
                                            `<a href="${customer_survey_url}/${element['uuid']}" class="table_btn">Review</a>`;
                                    }
                                    fieldHTML += `</td> </tr>`;
                                }
                            } else {
                                if (element['get_optional_details']['survey'] == 'yes') {

                                    fieldHTML += `<tr>
                    <td style="vertical-align: middle">
                        ${element['get_event_reg_details']['get_event_details']['event_name']}
                        <br>
                        <h6 style="color:#02B0B5">${element['get_optional_details']['activity_optional_name']}</h6>
                    </td>
                    <td style="vertical-align: middle">`;
                                    if (element['survey'] == 'no') {
                                        fieldHTML +=
                                            `<a href="${optional_survey_url}/${element['uuid']}"
                                                                            class="table_btn"  target="_blank">Survey</a>`;
                                    } else {

                                        fieldHTML +=
                                            `<a href="${optional_survey_url}/${element['uuid']}" class="table_btn">Review</a>`;
                                    }

                                    fieldHTML += `</td> </tr>`;
                                }
                            }

                        });

                    }
                    fieldHTML += `</tbody>
                                    </table>
                                </div>`;
                    $("#append_booking_data").append(fieldHTML);
                    $('#bookings_cd_popup').addClass('is-visible');
                    $('body').toggleClass('modal-open');
                    $('#nav_backdrop').toggleClass('modal_white_backdrop');
                    $("#loader").css('display', 'none');

                    $('#cd_popup_backdrop').addClass('cd_popup_backdrop');
                    $('.home_container').addClass('blur_bg');
                    $('header').addClass('blur_bg');
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    $("#loader").css('display', 'none');
                    alert('No response from server');
                });


        }
    </script>
@endsection
