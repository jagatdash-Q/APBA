@extends('frontend.layouts.master')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/frontend/phonecode/css/intlTelInput.css') }}">
<div class="inner_page_banner bg-animation">
    <div class="banner_content_wrapper">
        <h2 class="static_inner_Page_banner_title">{!! App\Helpers\Helper::getSuperScript($event_details->event_name)
            !!}</h2>
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

    .td_bold_value {
        margin-top: 7px;
    }
</style>

<div class="page_container">

    <div class="small_nav">
        <a href="{{ url('') }}"><img src="{{ asset('assets/frontend/images/home_icon.svg') }}" alt="..."></a>
        <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
        <a href="{{ route('frontend.news.events') }}" class="small_nav_text">News & Events</a>
        <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
        <a href="{{ route('frontend.event.details', $event_details->event_slug) }}" class="small_nav_text">{!!
            App\Helpers\Helper::getSuperScript($event_details->event_name) !!}</a>
        <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
        <span class="small_nav_text">Event Programs</span>
    </div>


    <div class="step_div">
        <input type="hidden" id="auth_check" value="@if (Auth::guard('customer')->check()) 1 @else 0 @endif">

        @if (!Auth::guard('customer')->check())
        <div class="step" id="event_login_step">
            <div class="d-flex overflow-hidden">
                <div class="step_round mr-2">
                    <span id="step_1_span">1</span>
                    <img id="step_1_img" style="display: none;padding:7px;" src='{{ asset('assets/frontend/images/done.png') }}' alt='...'>
                </div>
                <h3 class="step_title_heading"><span>Membership</span></h3>
            </div>

            <div class="step_content px-2" id="">
                <h4 class="site_heading_h4 my-3">Existing Member</h4>
                <p>Please <a href="javascript:void(0)" class="site_links" id="login_cd_popup_open">login</a> to
                    enjoy
                    member rate.
                </p>
                <h4 class="site_heading_h4 mt-5">Guest/Non-member</h4>
                <label class="checkbox mb-5 mt-4" for="guest">
                    <input type="checkbox" name="guest" value="guest" id="guest">
                    <span class="checkmark"></span>I would like to participate as guest.
                </label>
                <div class="event_participate_div d-none">
                    <h4 class="site_heading_h4 mb-4">Participant Details:</h4>
                    <form id="event_reg_form">

                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                <label class="form-label">First Name *</label>
                                <input type="text" required class="form-control custom_input"
                                    placeholder="Your first name" name="first_name" id="first_name">
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="form-label">Last Name *</label>
                                <input type="text" required class="form-control custom_input"
                                    placeholder="Your last name" name="last_name" id="last_name">
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="form-label">Email *</label>
                                <input type="email" required class="form-control custom_input"
                                    placeholder="Your email address" name="email" id="email">
                                <p class="input_feedback">Note: Order
                                    confirmation will email to your PayPal payment email.</p>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="form-label">Contact No *</label>
                                <input type="tel" required class="form-control custom_input" placeholder="Your contact"
                                    name="contact_no" id="contact_no">
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="form-label">Organisation *</label>
                                <input type="text" required class="form-control custom_input"
                                    placeholder="Your organisation" name="organisation" id="organisation">
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="form-label">Organisation's Address *</label>
                                <input type="text" required class="form-control custom_input"
                                    placeholder="Your organisation's address" name="organisations_address"
                                    id="organisations_address">
                            </div>
                        </div>

                        <a class="next-btn arrow_hover_link mt-4" id="program_submit" style="min-width: 130px;"
                            href="javascript:void(0)">Next</a>
                    </form>
                </div>
            </div>
        </div>
        @else
        <div class="step" style="pointer-events: none;">
            <div class="d-flex overflow-hidden">
                <div class="step_round mr-2">
                    <img id="step_1_img" style="padding:7px;" src='{{ asset('assets/frontend/images/done.png') }}'
                        alt='...'>
                </div>
                <h3 class="step_title_heading"><span>Membership</span></h3>
            </div>
        </div>
        @endif
        <div class="step @if (!Auth::guard('customer')->check()) minimized @endif" id="event_program_step">
            {{-- <div class="step minimized"> --}}
                <div class="d-flex overflow-hidden">
                    <div class="step_round mr-2" id="step_2">
                        {{-- @if (Auth::guard('customer')->check())
                        1
                        @else
                        2
                        @endif --}}
                        2
                    </div>
                    <h3 class="step_title_heading"><span>Select Workshop</span></h3>
                </div>

                <div class="step_content px-2">

                    @if (count($event_details->GetEventWorkshops))
                    @php
                    $count = 0;
                    @endphp
                    @foreach ($event_details->GetEventWorkshops as $workshop_details)
                    @if (count($workshop_details->getWorkshopProgramsOrderly) > 0)
                    <h3 class="site_heading_h3 my-4">{{ $workshop_details->workshop_name }}</h3>

                    @php
                    $date = $workshop_details->getWorkshopProgramsOrderly[0]->program_date;
                    $table_counter = 0;
                    $temp_program_data = [];
                    @endphp
                    @foreach ($workshop_details->getWorkshopProgramsOrderly as $program)
                    @php
                    if ($date == $program->program_date) {
                    $temp_program_data[$date][$table_counter] = $program;
                    } else {
                    $table_counter = 0;
                    $date = $program->program_date;
                    $temp_program_data[$date][$table_counter] = $program;
                    }
                    $table_counter++;
                    @endphp
                    @endforeach
                    @foreach ($temp_program_data as $program_details)
                    <h4 class="site_heading_h4 mb-3">Day {{ ++$count }}:
                        {{ Carbon\Carbon::parse($program_details[0]->program_date)->format('l, d M Y') }}
                    </h4>
                    <div class="table_div">
                        <table class="table site_table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;">Venue/Time</th>
                                    <th scope="col">Program</th>
                                    <th scope="col">Trainers</th>
                                    <th scope="col">Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($program_details as $program)
                                @php
                                if (!Auth::guard('customer')->check()) {
                                $price = $program->price_guest;
                                } else {
                                $price = $program->price_member;
                                }
                                @endphp

                                <tr id="disable_checkbox_field_{{ $program->id }}" @if ($event_details->
                                    activities_status == '0' || $program->status == '0')
                                    style="cursor:not-allowed;opacity: 0.5" @endif>
                                    <td style="max-width: 12rem;">
                                        <div class="d-flex align-items-start">
                                            <label class="checkbox mr-4 pl-2">
                                                <input type="checkbox" @if ($event_details->activities_status == '0' ||
                                                $program->status == '0') disabled @endif
                                                onclick="checkboxHandler('{{ $program->id }}','{{ $program->room_no
                                                }}','{{ $count }}','{{ $price }}')"
                                                value="{{ $program->id }}"
                                                name="program_val_{{ $program->id }}"
                                                id="program_val_{{ $program->id }}">
                                                <span class="checkmark"></span>
                                            </label>
                                            <h4 class="td_bold_value">
                                                {{ $program->room_no != null ? 'Room ' . $program->room_no : '' }}
                                                {{ Carbon\Carbon::parse($program->start_time)->format('g:i A') }}-{{
                                                Carbon\Carbon::parse($program->end_time)->format('g:i A') }}
                                                {{ $program->workshop_number != null ? 'WS ' . $program->workshop_number
                                                : '' }}
                                            </h4>
                                        </div>
                                    </td>
                                    <td style="max-width: 30rem;">
                                        {!! $program->program_desc !!}
                                    </td>
                                    <td style="max-width: 16rem;">
                                        {!! $program->program_trainers !!}
                                    </td>
                                    <td>
                                        <h4 class="td_bold_value">S$ {{ $price }}
                                        </h4>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                    @endif
                    {{-- @if ($workshop_details->conference_registration_fee != null)
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <label class="checkbox mr-4">
                                <input type="checkbox" @if (count($workshop_details->getWorkshopProgramsOrderly) == 0)
                                disabled @endif
                                onclick="conferenceCheckBox('{{ $workshop_details->id }}','{{
                                $workshop_details->conference_registration_fee }}','{{ $workshop_details->workshop_name
                                }}',@if ($workshop_details->conference_registration_fee_international == null) 'true'
                                @else 'false' @endif)"
                                name="conference_registration_fee_{{ $workshop_details->id }}"
                                id="conference_registration_fee_{{ $workshop_details->id }}"
                                value="{{ $workshop_details->conference_registration_fee }}">
                                <span class="checkmark"></span>
                            </label>
                            <h4 class="event_payment_details_value_left mb-0">
                                @if ($workshop_details->conference_registration_fee_international == null)
                                Conference Registration Fee
                                (optional: S$ {{ $workshop_details->conference_registration_fee }})
                                @else
                                Conference Registration Fee for Local Participant
                                (optional: S$ {{ $workshop_details->conference_registration_fee }})
                                @endif

                            </h4>
                        </div>
                    </div>
                    @endif
                    @if ($workshop_details->conference_registration_fee_international != null)
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <label class="checkbox mr-4">
                                <input type="checkbox" @if (count($workshop_details->getWorkshopProgramsOrderly) == 0)
                                disabled @endif
                                onclick="conferenceInterCheckBox('{{ $workshop_details->id }}','{{
                                $workshop_details->conference_registration_fee_international }}','{{
                                $workshop_details->workshop_name }}')"
                                name="conference_registration_fee_international_{{ $workshop_details->id }}"
                                id="conference_registration_fee_international_{{ $workshop_details->id }}"
                                value="{{ $workshop_details->conference_registration_fee_international }}">
                                <span class="checkmark"></span>
                            </label>
                            <h4 class="event_payment_details_value_left mb-0">
                                Conference Registration Fee for International Participant
                                (optional: S$
                                {{ $workshop_details->conference_registration_fee_international }})
                            </h4>
                        </div>
                    </div>
                    @endif
                    @if ($workshop_details->networking_dinner_fee != null)
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <label class="checkbox mr-4">
                                <input type="checkbox" @if (count($workshop_details->getWorkshopProgramsOrderly) == 0)
                                disabled @endif
                                onclick="networkCheckBox('{{ $workshop_details->id }}','{{
                                $workshop_details->networking_dinner_fee }}','{{ $workshop_details->workshop_name }}')"
                                name="networking_dinner_fee_{{ $workshop_details->id }}"
                                id="networking_dinner_fee_{{ $workshop_details->id }}"
                                value="{{ $workshop_details->networking_dinner_fee }}">
                                <span class="checkmark"></span>
                            </label>
                            <h4 class="event_payment_details_value_left mb-0">Networking Dinner (optional:
                                S${{ $workshop_details->networking_dinner_fee }})
                            </h4>
                        </div>
                    </div>
                    @endif --}}
                    @endforeach
                    @endif

                    <div class="event_payment_div">
                        <h3 class="site_heading_h4">Payment Details</h3>
                        <table class="table workshop_append_table" id="append_workshop"></table>
                        <table class="table workshop_optinal_table" style="margin-top: -15px">
                            @if (count($event_details->getEventWorkshopOptional))
                            @foreach ($event_details->getEventWorkshopOptional as $item)
                            @php
                            if (!Auth::guard('customer')->check()) {
                            $optional_price = $item->price_guest;
                            } else {
                            $optional_price = $item->price_member;
                            }
                            @endphp
                            {{-- <div class="final_price_check_top">
                                <div class="final_price_check">
                                    <label class="checkbox mr-4">
                                        <input type="checkbox"
                                            onclick="optionalCheckBox('{{ $item->id }}','{{ $optional_price }}')"
                                            name="optional_check_box_{{ $item->id }}"
                                            id="optional_check_box_{{ $item->id }}" value="{{ $optional_price }}">
                                        <span class="checkmark"></span>
                                    </label>
                                    <h4 class="event_payment_details_value_left mb-0">
                                        {{ $item->activity_optional_name }}
                                        (S$
                                        {{ $optional_price }})
                                    </h4>
                                </div>
                                <p class="event_payment_details_value" id="append_optional_fee_{{ $item->id }}">-
                                </p>
                            </div> --}}
                            <tr>
                                <td style="padding: 0rem; border-top: none;">
                                    <div class="final_price_check">
                                        <label class="checkbox mr-3">
                                            <input type="checkbox"
                                                onclick="optionalCheckBox('{{ $item->id }}','{{ $optional_price }}')"
                                                name="optional_check_box_{{ $item->id }}"
                                                id="optional_check_box_{{ $item->id }}" value="{{ $optional_price }}">
                                            <span class="checkmark"></span>
                                        </label>
                                        <h4 class="event_payment_details_value_left">
                                            {{ $item->activity_optional_name }}
                                            (S$
                                            {{ $optional_price }})
                                        </h4>
                                    </div>
                                </td>
                                <td style="padding: 0rem; border-top: none; text-align: right;">
                                    <p class="event_payment_details_value" id="append_optional_fee_{{ $item->id }}">-
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </table>

                        <hr style="margin-top: 3rem;">
                        <div class="d-flex justify-content-between">
                            <p class="event_payment_details_value">Final Price:</p>
                            <p class="event_payment_details_value">S$ <span id="final_price">0.00</span></p>
                        </div>
                        <p class="mt-5">*Topics and speakers may be subject to changes</p>
                        @if ($event_details->activities_status == '0')
                        <p class="mt-5 input_feedback">Registration Closed.</p>
                        @endif
                        <div class="event_payment_details_bottom_div">
                            <div class="event_payment_details_bottom_div_link">

                                <form action="{{ route('frontend.event.registration') }}" method="POST" id="event_reg">
                                    @csrf
                                    <input type="hidden" name="event_id" id="event_id" value="{{ $event_details->id }}">
                                    <input type="hidden" name="temp_first_name" id="temp_first_name">
                                    <input type="hidden" name="temp_last_name" id="temp_last_name">
                                    <input type="hidden" name="temp_email" id="temp_email">
                                    <input type="hidden" name="temp_contact_no" id="temp_contact_no">
                                    <input type="hidden" name="country_tel_code" id="country_tel_code" />
                                    <input type="hidden" name="temp_organisation" id="temp_organisation">
                                    <input type="hidden" name="temp_organisations_address"
                                        id="temp_organisations_address">
                                    <input type="hidden" name="total_amount" id="total_amount">
                                    {{-- <input type="hidden" name="temp_conference_registration_fee"
                                        id="temp_conference_registration_fee"> --}}
                                    {{-- <input type="hidden" name="temp_networking_dinner_fee"
                                        id="temp_networking_dinner_fee"> --}}
                                    <input type="hidden" name="program_id" id="program_id">
                                    <input type="hidden" name="optional_id" id="optional_id">

                                    {{-- <input type="hidden" name="conference_registration_id"
                                        id="conference_registration_id">
                                    <input type="hidden" name="networking_dinner_fee_id" id="networking_dinner_fee_id">
                                    --}}

                                    {{-- <button type="submit" class="arrow_hover_link login-btn mt-3 mb-5"
                                        style="border-color:transparent;">Confirm and
                                        Pay</button> --}}
                                </form>
                                <p class="input_feedback" id="error_message" style="display: none">Please choose any of
                                    the
                                    above program.</p>
                                @if ($event_details->activities_status == '1')
                                <a class="arrow_hover_link" href="javascript:void(0)" id="submit_event_reg">Confirm
                                    and
                                    Pay</a>
                                @endif
                            </div>
                            <div class="event_payment_details_thumb">
                                <img src="{{ asset('assets/frontend/images/payment_methods.png') }}" alt="...">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('page-scripts')
<script src="{{ asset('assets/frontend/phonecode/js/intlTelInput-jquery.min.js') }}"></script>
<script src="{{ asset('assets/frontend/phonecode/js/intlTelInput.js') }}"></script>
<script>
    var final_price = 0;
        const program_id = [];
        const workshop_optional = [];
        // const workshop_conf_inter = [];
        // const workshop_net = [];
        $(document).ready(function() {
            console.log($('#auth_check').val());
            var input = document.querySelector("#contact_no");
            let instance = window.intlTelInput(input,({
                localizedCountries:null,
                separateDialCode:true,
                preferredCountries: []
            }));
            let selected_country_data = instance.getSelectedCountryData();
            $('#country_tel_code').val(selected_country_data.dialCode);
            input.addEventListener("countrychange",function() {
                let selected_country_data = instance.getSelectedCountryData();
                $('#country_tel_code').val(selected_country_data.dialCode);
            });
           

            // $("#contact_no").intlTelInput({
                
            // });


            if ($('#auth_check').val() == 0) {
                $("#event_program_step").css({
                    'pointer-events': 'none'
                });
            } else {
                $("#event_program_step").css({
                    'pointer-events': 'all'
                });
            }
            $('#event_reg_form').validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    contact_no: {
                        required: true,
                        number: true
                    },
                    organisation: {
                        required: true,
                    },
                    organisations_address: {
                        required: true,
                    },
                },
                messages: {
                    first_name: {
                        required: "",
                    },
                    last_name: {
                        required: "",
                    },
                    email: {
                        required: "",
                    },
                    contact_no: {
                        required: "",
                    },
                    organisation: {
                        required: "",
                    },
                    organisations_address: {
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
                },

            });

            $('#program_submit').click(function() {
                $("#event_reg_form").valid();
                if ($("#event_reg_form").valid()) {
                    $('#first_name').attr('readonly', true);
                    $('#last_name').attr('readonly', true);
                    $('#email').attr('readonly', true);
                    $('#contact_no').attr('readonly', true);
                    $('#organisation').attr('readonly', true);
                    $('#organisations_address').attr('readonly', true);
                    $("#event_program_step").removeClass('minimized');
                    $("#event_program_step").css({
                        'pointer-events': 'all'
                    });
                    $("#step_1_img").css({
                        'display': 'block'
                    });
                    $("#step_1_span").css({
                        'display': 'none'
                    });
                    $("#event_login_step").addClass('minimized');
                    $("#event_login_step").css({
                        'pointer-events': 'none'
                    });
                } else {
                    // $("#event_program_step").addClass('minimized');
                    // $("#event_program_step").css({
                    //     'pointer-events': 'none'
                    // });
                    // $("#event_login_step").removeClass('minimized');
                    // $("#event_login_step").css({
                    //     'pointer-events': 'none'
                    // });
                    // $("#step_1_img").css({
                    //     'display': 'none'
                    // });
                    // $("#step_1_span").css({
                    //     'display': 'block'
                    // });
                }
            });
        });
        

        const checkboxHandler = (id, room_no, day, price) => {
            $("#loader").css('display', 'block');

            var program_details = {!! json_encode($event_details->GetEventWorkshops) !!};

            var check = $('input:checkbox[name=program_val_' + id + ']').is(':checked');
            $.ajax({
                    url: "{{ route('frontend.check.program') }}",
                    type: "get",
                    data: {
                        program_id: id,
                    }
                })
                .done(function(response) {
                    if (response != null) {
                        if (response.length > 0) {
                            response.forEach(record => {
                                if (check == true) {
                                    $(`#disable_checkbox_field_${record}`).css({
                                        'cursor': 'not-allowed',
                                        'opacity': '0.5'
                                    });
                                    $(`#program_val_${record}`).prop('disabled', true);
                                } else {
                                    $(`#disable_checkbox_field_${record}`).css({
                                        'cursor': 'auto',
                                        'opacity': '1'
                                    });
                                    $(`#program_val_${record}`).prop('disabled', false);
                                }
                            });
                        }
                    }
                    $("#loader").css('display', 'none');
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    $("#loader").css('display', 'none');

                    alert('No response from server');
                });
            $('#final_price').html('');

            if (check == true) {
                program_id.push(id);
                $('#append_workshop').append(`<tr id="remove_workshop_${id}"><td style="padding: 0rem; border-top: none;">
                    <div class="final_price_check">
                                <label class="checkbox mr-3">
                                    <input type="checkbox" checked name="color" value="${id}">
                                    <span class="disable"></span>
                                </label>
                                <h4 class="event_payment_details_value_left">Day ${day} - Room ${room_no}</h4>
                                </div>
                            </td>
                            <td style="padding: 0rem; border-top: none; text-align: right;">
                            <p class="event_payment_details_value">S$ ${price}</p>
                                </td>
                            </tr>`);
                final_price += Number(price);
                $('#final_price').html(final_price);
            } else {
                var index = program_id.indexOf(id);
                if (index !== -1) {
                    program_id.splice(index, 1);
                }
                $(`#remove_workshop_${id}`).remove();
                final_price -= Number(price);
                $('#final_price').html(final_price);
            }
        }

        const optionalCheckBox = (id, price) => {

            $('#append_optional_fee_' + id).html('');
            var optional_check = $('input:checkbox[name=optional_check_box_' + id + ']').is(':checked');
            if (optional_check == true) {
                workshop_optional.push(id);
                $('#append_optional_fee_' + id).html('S$ ' + price);
                final_price += Number(price);
                $('#final_price').html(final_price);
            } else {
                var index = workshop_optional.indexOf(id);
                if (index !== -1) {
                    workshop_optional.splice(index, 1);
                }
                $('#append_optional_fee_' + id).html('-');
                final_price -= Number(price);
                $('#final_price').html(final_price);
            }
        }

        // const conferenceInterCheckBox = (workshop_id, price, workshop_name) => {
        //     var conf_inter_check = $('input:checkbox[name=conference_registration_fee_international_' + workshop_id +
        //         ']').is(':checked');
        //     if (conf_inter_check == true) {
        //         workshop_conf_inter.push(workshop_id);
        //         $('#append_workshop').append(` <div class="d-flex justify-content-between align-items-center" id="remove_workshop_conference_inter_${workshop_id}">
    //                     <div class="d-flex align-items-center">
    //                         <label class="checkbox mr-4">
    //                             <input type="checkbox" checked name="color" value="${workshop_id}">
    //                             <span class="disable"></span>
    //                         </label>
    //                         <h4 class="event_payment_details_value_left mb-0">${workshop_name} - Conference Registration Fee for International Participant</h4>
    //                     </div>
    //                     <p class="event_payment_details_value">S$ ${price}</p>
    //                 </div>`);
        //         final_price += Number(price);
        //         $('#final_price').html(final_price);
        //     } else {
        //         var index = workshop_conf_inter.indexOf(workshop_id);
        //         if (index !== -1) {
        //             workshop_conf_inter.splice(index, 1);
        //         }
        //         $(`#remove_workshop_conference_inter_${workshop_id}`).remove();
        //         final_price -= Number(price);
        //         $('#final_price').html(final_price);
        //     }
        // }

        // const networkCheckBox = (workshop_id, price, workshop_name) => {

        //     var net_check = $('input:checkbox[name=networking_dinner_fee_' + workshop_id + ']').is(':checked');
        //     if (net_check == true) {
        //         workshop_net.push(workshop_id);
        //         $('#append_workshop').append(` <div class="d-flex justify-content-between align-items-center" id="remove_workshop_network_${workshop_id}">
    //                     <div class="d-flex align-items-center">
    //                         <label class="checkbox mr-4">
    //                             <input type="checkbox" checked name="color" value="${workshop_id}">
    //                             <span class="disable"></span>
    //                         </label>
    //                         <h4 class="event_payment_details_value_left mb-0">${workshop_name} - Networking Dinner Fee</h4>
    //                     </div>
    //                     <p class="event_payment_details_value">S$ ${price}</p>
    //                 </div>`);
        //         final_price += Number(price);
        //         $('#final_price').html(final_price);
        //     } else {
        //         var index = workshop_net.indexOf(workshop_id);
        //         if (index !== -1) {
        //             workshop_net.splice(index, 1);
        //         }
        //         $(`#remove_workshop_network_${workshop_id}`).remove();
        //         final_price -= Number(price);
        //         $('#final_price').html(final_price);
        //     }
        // }


        // $('input[name="conference_registration_fee"]').change(function() {
        //     $('#append_conference_registration_fee').html('');
        //     if (this.checked) {
        //         var conference_registration_fee = $('#conference_registration_fee').val();
        //         $('#append_conference_registration_fee').html('S$ ' + conference_registration_fee);
        //         final_price += Number(conference_registration_fee);
        //         $('#final_price').html(final_price);
        //     } else {
        //         var conference_registration_fee = $('#conference_registration_fee').val();
        //         $('#append_conference_registration_fee').html('-');
        //         final_price -= Number(conference_registration_fee);
        //         $('#final_price').html(final_price);
        //     }
        // });

        // $('input[name="networking_dinner_fee"]').change(function() {
        //     $('#append_networking_dinner_fee').html('');
        //     if (this.checked) {
        //         var networking_dinner_fee = $('#networking_dinner_fee').val();
        //         $('#append_networking_dinner_fee').html('S$ ' + networking_dinner_fee);
        //         final_price += Number(networking_dinner_fee);
        //         $('#final_price').html(final_price);
        //     } else {
        //         var networking_dinner_fee = $('#networking_dinner_fee').val();
        //         $('#append_networking_dinner_fee').html('-');
        //         final_price -= Number(networking_dinner_fee);
        //         $('#final_price').html(final_price);
        //     }
        // });

        $('#submit_event_reg').click(function() {

            // if (program_id.length == 0) {
            //     $('#error_message').css('display', 'block');
            //     return false;
            // } else {
            //     $('#error_message').css('display', 'none');
            // }

            $('#temp_first_name').val($('#first_name').val());
            $('#temp_last_name').val($('#last_name').val());
            $('#temp_email').val($('#email').val());
            $('#temp_contact_no').val($('#contact_no').val());
            $('#temp_organisations_address').val($('#organisations_address').val());
            $('#temp_organisation').val($('#organisation').val());
            $('#total_amount').val(final_price);

            // if ($('#conference_registration_fee').is(":checked")) {
            //     $('#temp_conference_registration_fee').val($('#conference_registration_fee').val());
            // } else {
            //     $('#temp_conference_registration_fee').val(0);
            // }
            // if ($('#networking_dinner_fee').is(":checked")) {
            //     $('#temp_networking_dinner_fee').val($('#networking_dinner_fee').val());
            // } else {
            //     $('#temp_networking_dinner_fee').val(0);
            // }

            $('#program_id').val(program_id);
            // $('#conference_registration_id').val(workshop_conf);
            // $('#networking_dinner_fee_id').val(workshop_net);
            $('#optional_id').val(workshop_optional);
            $("#event_reg").submit();
        });
</script>
@endsection