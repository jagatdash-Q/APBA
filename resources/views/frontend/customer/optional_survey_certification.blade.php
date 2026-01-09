<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Asia-Pacific Biosafety Association
    </title>
    <meta name="description" content="Asia-Pacific Biosafety Association">
    <meta name="keywords" content="Asia-Pacific Biosafety Association">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/frontend/images/favicon-apba.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/font_montserrat.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/apba_styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/owl_carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/owl_carousel/owl.theme.css') }}">
</head>
@include('frontend.layouts.loader')
<style>
    .survey_home {
        background-image: url("{{ asset('assets/frontend/images/certificate_design_bg_desktop.svg') }}");
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
        min-height: 100vh;
        overflow: hidden;
    }

    .survey_page_container {
        max-width: 1150px;
        margin: 0 auto;
        text-align: center;
    }

    .logo_container {
        width: 300px;
        height: auto;
        margin: 0 auto;
        padding-bottom: 15px;
    }

    .logo_container img {
        width: 100%;
        height: auto;
    }

    .survey_canvas {
        overflow: hidden;
        height: 150px;
        position: absolute;
        bottom: 0;
        width: 100%;
        z-index: 0;
    }

    #welcome_container {
        padding-top: 80px;
        width: 850px;
        position: relative;
        z-index: 999;
    }

    .survey_heading_h1 {
        font-size: 42px;
        line-height: 52px;
        color: #03355d;
        font-weight: 700;
    }

    .survey_heading_h3 {
        font-size: 25px;
        line-height: 35px;
        color: #03355d;
        font-weight: 600;
    }

    .survey_heading_h3_2 {
        font-size: 25px;
        line-height: 35px;
        color: #03355d;
        font-weight: 600;
    }

    .survey_start_btn {
        display: inline-block;
        color: #ffffff !important;
        font-size: 27px;
        line-height: 44px;
        font-weight: 600;
        text-decoration: none !important;
        position: relative;
        background-color: #005599;
        padding: 15px 52px 15px 33px;
        height: 74px;
        width: 220px;
        border-radius: 37px;
        overflow: hidden;
        transition: 0.5s ease-in-out;
        z-index: 0;
        cursor: pointer;
    }

    .survey_start_btn:hover {
        padding: 15px 68px 15px 25px;
    }

    .survey_start_btn:before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: #02B0B5;
        transform: translateX(-100%);
        transition: 0.5s ease-in-out;
        z-index: -1;
    }

    .survey_start_btn:hover:before {
        transform: translateX(0);
    }

    .survey_start_btn::after {
        content: url("{{ asset('assets/frontend/images/right_arrow_white.svg') }}");
        display: inline-block;
        position: absolute;
        margin-left: 20px;
        transition: all 1s;
        top: 45%;
        transform: translateY(-45%);
    }

    .survey_start_btn:hover::after {
        content: url("{{ asset('assets/frontend/images/right_arrow_white_long.svg') }}");
        margin-left: 18px;
        transition: all 1s;
    }

    .question_div {
        padding-top: 50px !important;
        position: relative;
        z-index: 999;
    }

    .task_progress_section {
        width: 100%;
        text-align: center;
    }

    .task_status {
        font-size: 18px;
        line-height: 28px;
        margin: 0 auto;
        font-weight: 500;
    }

    .task_progress {
        height: 17px;
        width: 500px;
        background-color: transparent !important;
        border: 0;
    }

    .task_progress::-webkit-progress-bar {
        background-color: #BAC0C9;
    }

    .task_progress::-webkit-progress-bar,
    .task_progress::-webkit-progress-value {
        border-radius: 100px;
        padding: 1px;
    }

    .task_progress_section .task_progress::-webkit-progress-value {
        background: #02B0B5;
    }

    .animated::-webkit-progress-value {
        transition: width 1s;
    }

    .survey_input {
        height: 50px;
        max-width: 480px;
        width: 100%;
        padding: 10px 20px;
        border: 1px solid #BAC0C9;
        border-radius: 6px;
        background-color: #FFFFFF;
    }

    .survey_input:focus-visible {
        outline: none;
    }

    .survey_input::placeholder {
        color: #BAC0C9;
    }

    .survey_input_type_2 {
        width: 100%;
        border: none;
        border-bottom: 1px solid #BAC0C9;
        background-color: #FFFFFF;
    }

    .survey_input_type_2:focus-visible {
        outline: none;
    }

    .survey_input_type_2::placeholder {
        color: #BAC0C9;
    }

    .survey_input_outer {
        border: 1px solid #BAC0C9;
        padding: 20px;
        min-height: 70px;
        width: 600px;
        margin: 0 auto;
        border-radius: 10px;
        background-color: #FFFFFF;
    }

    .survey_paragraph {
        font-size: 18px;
        line-height: 28px;
        color: #03355D;
        font-weight: 600;
        text-align: center;
        margin-bottom: 2rem;
    }

    .survey_button_div {
        display: flex;
        justify-content: space-between;
        margin: 0 auto;
        padding-top: 3rem;
        max-width: 500px;
        padding-bottom: 2rem;
    }

    .qstn_previous_button {
        display: inline-block;
        color: #ffffff !important;
        font-size: 20px;
        line-height: 28px;
        font-weight: 600;
        text-decoration: none !important;
        position: relative;
        background-color: #005599;
        padding: 15px 52px 15px 33px;
        height: 60px;
        min-width: 200px;
        border-radius: 30px;
        overflow: hidden;
        transition: 0.5s ease-in-out;
        z-index: 0;
        cursor: pointer;
    }

    .qstn_previous_button:hover {
        padding: 15px 68px 15px 25px;
    }

    .qstn_previous_button:before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: #02B0B5;
        transform: translateX(-100%);
        transition: 0.5s ease-in-out;
        z-index: -1;
    }

    .qstn_previous_button:hover:before {
        transform: translateX(0);
    }

    .qstn_previous_button::after {
        content: url("{{ asset('assets/frontend/images/right_arrow_white.svg') }}");
        display: inline-block;
        position: absolute;
        margin-left: 20px;
        transition: all 1s;
        top: 50%;
        transform: translateY(-50%);
    }

    .qstn_previous_button:hover::after {
        content: url("{{ asset('assets/frontend/images/right_arrow_white_long.svg') }}");
        margin-left: 18px;
        transition: all 1s;
    }

    .qstn_next_button {
        display: inline-block;
        color: #ffffff !important;
        font-size: 20px;
        line-height: 28px;
        font-weight: 600;
        text-decoration: none !important;
        position: relative;
        background-color: #B70000;
        padding: 15px 52px 15px 33px;
        height: 60px;
        width: 200px;
        border-radius: 30px;
        overflow: hidden;
        transition: 0.5s ease-in-out;
        z-index: 0;
        cursor: pointer;
    }

    .qstn_next_button:hover {
        padding: 15px 68px 15px 25px;
    }

    .qstn_next_button:before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: #B70000;
        transform: translateX(-100%);
        transition: 0.5s ease-in-out;
        z-index: -1;
    }

    .qstn_next_button:hover:before {
        transform: translateX(0);
    }

    .qstn_next_button::after {
        content: url("{{ asset('assets/frontend/images/right_arrow_white.svg') }}");
        display: inline-block;
        position: absolute;
        margin-left: 20px;
        transition: all 1s;
        top: 50%;
        transform: translateY(-50%);
    }

    .qstn_next_button:hover::after {
        content: url("{{ asset('assets/frontend/images/right_arrow_white_long.svg') }}");
        margin-left: 18px;
        transition: all 1s;
    }





    .site_table tbody {
        display: block;
        max-height: 300px;
        overflow: auto;
        background-color: #FFFFFF;
    }

    .site_table thead,
    .site_table tbody tr {
        display: table;
        width: 100%;
    }




    .site_table tbody tr td:first-child {
        width: 210px;
        text-align: left;
        padding: 15px 25px !important;
    }

    .site_table thead tr th:first-child {
        width: 210px;
        text-align: left;
    }

    .site_table tbody tr td {
        vertical-align: baseline;
    }

    .site_table thead th {
        vertical-align: middle;
    }

    .site_table th,
    .site_table td {
        padding-left: 0px;
    }






    .survey_radio_container {
        display: block;
        position: relative;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .survey_radio_container .survey_radio_input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        top: 6px;
        left: 2px;
        width: 22px;
        z-index: 999;
        height: 22px;
        display: block;
    }

    .survey_radio_checkmark {
        position: absolute;
        top: 5px;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #fff;
        border-radius: 50%;
        border: 1px solid #DFDFDF;
    }

    .survey_radio_container .survey_radio_input:checked~.survey_radio_checkmark {
        background-color: #02b0b5;
    }

    .survey_radio_checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .survey_radio_container .survey_radio_input:checked~.survey_radio_checkmark:after {
        display: block;
    }

    .survey_radio_container .survey_radio_checkmark:after {
        left: 8px;
        top: 4px;
        width: 7px;
        height: 12px;
        border: solid white;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }


    #thank_you_container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }



    @media (max-width: 850px) {

        .survey_page_container {
            padding: 0px 20px;
        }

        .survey_home {
            background-image: url("{{ asset('assets/frontend/images/certificate_design_bg_mobile.svg') }}");
        }

        .logo_container {
            width: 200px;
        }

        #welcome_container {
            width: 100%;
            padding-top: 55px;
        }

        .survey_heading_h1 {
            font-size: 26px;
            line-height: 36px;
        }

        .survey_heading_h3 {
            font-size: 22px;
            line-height: 32px;
        }

        .survey_start_btn {
            font-size: 20px;
            padding: 3px 52px 3px 33px;
            height: 50px;
            width: 200px;
            border-radius: 25px;
        }

        .survey_start_btn:hover {
            padding: 3px 68px 3px 25px;
        }

        .survey_canvas {
            display: none;
        }

        .task_progress {
            width: 100%;
            height: 11px;
        }

        .task_status {
            font-size: 14px;
        }

        .question_div {
            padding-top: 40px !important;
        }

        .qstn_previous_button {
            border-radius: 25px;
            font-size: 16px;
            line-height: 26px;
            height: 50px;
            min-width: 150px;
            padding: 12px 50px 12px 25px;
        }

        .qstn_previous_button:hover {
            padding: 12px 60px 12px 17px;
        }

        .qstn_next_button {
            border-radius: 25px;
            font-size: 16px;
            line-height: 26px;
            height: 50px;
            width: 150px;
            padding: 12px 50px 12px 25px;
        }

        .qstn_next_button:hover {
            padding: 12px 60px 12px 17px;
        }

        .survey_paragraph {
            font-size: 16px;
            line-height: 26px;
        }

        .survey_input_outer {
            padding: 15px;
            min-height: 60px;
            width: 100%;
        }

        .survey_heading_h3_2 {
            font-size: 20px;
            line-height: 30px;
        }

        #thank_you_container {
            top: 25%;
            left: unset;
            transform: unset;
        }

        .site_table tbody tr td {
            vertical-align: top;
        }

        #survey_desktop_table {
            display: none;
        }

        #survey_mobile_table {
            display: block !important;
        }

        .survey_list_items {
            height: auto;
            border-radius: 6px;
        }

        .survey_list_header {
            background-color: #02B0B5;
            color: #FFFFFF;
            padding: 5px 25px;
            font-size: 19px;
            line-height: 29px;
            font-weight: 600;
            text-align: center;
            border-radius: 6px 6px 0px 0px;
            min-height: 70px;
        }

        .survey_list_radio_option {
            font-size: 18px;
            line-height: 28px;
            color: #03355D;
            text-align: left;
            font-weight: 600;
            margin-bottom: 0rem;
            padding-left: 20px;
        }

        .survey_list_ul {
            background-color: #ffffff;
            padding-left: 0rem !important;
            max-height: 200px;
            overflow-y: auto;

        }

        .survey_list_ul li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 50px;
            position: relative;
        }

        .survey_list_ul li:nth-child(odd) {
            background: #ffffff;
        }

        .survey_list_ul li:nth-child(even) {
            background: #f2fbfb;
        }

        .survey_radio_container {
            height: auto;
            top: unset;
            left: unset;
        }

        .survey_radio_container_outer {
            position: absolute;
            right: 40px;
            top: 10px;
        }

        .survey_button_div {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .owl-nav,
        .owl-dots {
            display: block;
        }

        #survey_mobile_table .owl-prev {
            position: absolute;
            left: 0;
            bottom: -3px;
        }

        #survey_mobile_table .owl-next {
            position: absolute;
            right: 0;
            bottom: -3px;
        }

        .question_page_4 {
            /* max-height: 300px; */
            overflow: hidden;
            padding: 0px 20px;
        }


    }


    #survey_mobile_table {
        display: none;
    }
</style>
<body>
    <div class="survey_home">
        <div class="survey_page_container" id="welcome_container">
            <div class="logo_container">
                <img src="{{ asset('assets/frontend/images/logo.png') }}" alt="apba_logo">
            </div>
            @if ($survey_reg == null)
                <input type="hidden" name="type" id="type" value="0">
            @else
                <input type="hidden" name="type" id="type" value="1">
            @endif
            <input type="hidden" name="event_registration_optional_uuid" id="event_registration_optional_uuid"
                value="{{ $optional_program->uuid }}">
            <input type="hidden" name="survey_activity_uuid" id="survey_activity_uuid"
                value="{{ $optional_program->getOptionalDetails->survey_activity_uuid }}">
            <h1 class="survey_heading_h1 mb-3">
                {{ isset($optional_program->getEventRegDetails->getEventDetails->event_name) ? $optional_program->getEventRegDetails->getEventDetails->event_name : '' }}
            </h1>
            <h3 class="survey_heading_h3">
                {{ isset($optional_program->getEventRegDetails->getEventDetails->start_date) ? Carbon\Carbon::parse($optional_program->getEventRegDetails->getEventDetails->start_date)->format('d F Y')." - ".Carbon\Carbon::parse($optional_program->getEventRegDetails->getEventDetails->end_date)->format('d F Y') : '' }}
                |
                Conference
            </h3>
            <br>
            <a class="survey_start_btn" id="start_survey" style="font-weight:0;">Start</a>
        </div>

        <div class="survey_page_container question_div" style="display: none">

            <div class="task_progress_section mb-5">
                <p class="task_status" id="task_status">1 of 7</p>
                <progress class="task_progress animated" min="0" max="7" value="1"
                    id="progress_id"></progress>
            </div>

            <div id="question_page_1" class="question_page_1">
                <h1 class="survey_heading_h1 mb-3">Personal Info</h1>
                <p class="survey_paragraph">*Please ensure that the provided information is accurate. <br> Kindly ensure
                    you complete this survey to
                    receive certificate.</p>
                <input type="text" class="survey_input" placeholder="Salutation and Full Name *" name=""
                    id="question_1" value="{{ isset($survey_reg->fullname) ? $survey_reg->fullname : '' }}">
            </div>

            <div id="question_page_2" class="question_page_2 d-none">
                <h1 class="survey_heading_h1 mb-3">Personal Info</h1>
                <p class="survey_paragraph">
                    *Please ensure that the provided information is accurate.<br>
                    Kindly ensure you complete this survey to receive certificate.</p>
                <input type="text" class="survey_input" placeholder="Organization *" name="" id="question_2"
                    value="{{ isset($survey_reg->organization) ? $survey_reg->organization : '' }}">
            </div>

            <div id="question_page_3" class="question_page_3 d-none">
                <h1 class="survey_heading_h1 mb-3">Personal Info</h1>
                <p class="survey_paragraph">*Please ensure that the provided information is accurate.<br>
                    Kindly ensure you complete this survey to receive certificate.</p>
                <input type="email" class="survey_input" placeholder="Email *" name="" id="question_3"
                    value="{{ isset($survey_reg->email) ? $survey_reg->email : '' }}">
                <p id="mail_error" style="color: red;display:none;">Provide Valid Mail Id!</p>
            </div>

            <div id="question_page_4" class="question_page_4 d-none">
                <h1 class="survey_heading_h1 mb-3">Overall Evaluation</h1>
                <p class="survey_paragraph mb-3">*Please select the appropriate rating for the following training
                    elements. <br> Kindly select “0 - Not Relevant” for questions not related to you.</p>
                <form>
                    <table id="survey_desktop_table" class="table site_table w-100 table-borderless">
                        <thead>
                            <tr>
                                <th></th>
                                <th>9 <br>
                                    Excellent</th>
                                <th>8<br>
                                    Excellent</th>
                                <th>7<br>
                                    Good</th>
                                <th>6<br>
                                    Good</th>
                                <th>5<br>
                                    Satisfactory</th>
                                <th>4<br>
                                    Satisfactory</th>
                                <th>3<br>
                                    Poor</th>
                                <th>2<br>
                                    Poor</th>
                                <th>1<br>
                                    Poor</th>
                                <th>0<br>
                                    Not Relevant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Course content and material
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input"
                                            {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '9' ? 'checked' : '') : '' }}
                                            type="radio" name="content_material" id="content_material"
                                            value="9">
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="content_material"
                                            id="content_material" value="8"
                                            {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '8' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="content_material"
                                            id="content_material" value="7"
                                            {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '7' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="content_material"
                                            id="content_material" value="6"
                                            {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '6' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="content_material"
                                            id="content_material" value="5"
                                            {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '5' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="content_material"
                                            id="content_material" value="4"
                                            {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '4' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="content_material"
                                            id="content_material" value="3"
                                            {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '3' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="content_material"
                                            id="content_material" value="2"
                                            {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '2' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="content_material"
                                            id="content_material" value="1"
                                            {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '1' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="content_material"
                                            id="content_material" value="0"
                                            {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '0' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Speakers' knowledge and competency
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="speaker_knowledge"
                                            id="speaker_knowledge" value="9"
                                            {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '9' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="speaker_knowledge"
                                            id="speaker_knowledge" value="8"
                                            {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '8' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="speaker_knowledge"
                                            id="speaker_knowledge" value="7"
                                            {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '7' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="speaker_knowledge"
                                            id="speaker_knowledge" value="6"
                                            {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '6' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="speaker_knowledge"
                                            id="speaker_knowledge" value="5"
                                            {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '5' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="speaker_knowledge"
                                            id="speaker_knowledge" value="4"
                                            {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '4' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="speaker_knowledge"
                                            id="speaker_knowledge" value="3"
                                            {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '3' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="speaker_knowledge"
                                            id="speaker_knowledge" value="2"
                                            {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '2' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="speaker_knowledge"
                                            id="speaker_knowledge" value="1"
                                            {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '1' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="speaker_knowledge"
                                            id="speaker_knowledge" value="0"
                                            {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '0' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Trainer's presentation skill
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="trainer_presentation"
                                            id="trainer_presentation" value="9"
                                            {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '9' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="trainer_presentation"
                                            id="trainer_presentation" value="8"
                                            {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '8' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="trainer_presentation"
                                            id="trainer_presentation" value="7"
                                            {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '7' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="trainer_presentation"
                                            id="trainer_presentation" value="6"
                                            {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '6' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="trainer_presentation"
                                            id="trainer_presentation" value="5"
                                            {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '5' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="trainer_presentation"
                                            id="trainer_presentation" value="4"
                                            {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '4' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="trainer_presentation"
                                            id="trainer_presentation" value="3"
                                            {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '3' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="trainer_presentation"
                                            id="trainer_presentation" value="2"
                                            {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '2' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="trainer_presentation"
                                            id="trainer_presentation" value="1"
                                            {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '1' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="trainer_presentation"
                                            id="trainer_presentation" value="0"
                                            {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '0' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Q&A session - Effectiveness
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="q_a_session"
                                            id="q_a_session" value="9"
                                            {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '9' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="q_a_session"
                                            id="q_a_session" value="8"
                                            {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '8' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="q_a_session"
                                            id="q_a_session" value="7"
                                            {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '7' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="q_a_session"
                                            id="q_a_session" value="6"
                                            {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '6' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="q_a_session"
                                            id="q_a_session" value="5"
                                            {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '5' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="q_a_session"
                                            id="q_a_session" value="4"
                                            {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '4' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="q_a_session"
                                            id="q_a_session" value="3"
                                            {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '3' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="q_a_session"
                                            id="q_a_session" value="2"
                                            {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '2' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="q_a_session"
                                            id="q_a_session" value="1"
                                            {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '1' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="q_a_session"
                                            id="q_a_session" value="0"
                                            {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '0' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Overall delivery and effectiveness
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="overall_delivery"
                                            id="overall_delivery" value="9"
                                            {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '9' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="overall_delivery"
                                            id="overall_delivery" value="8"
                                            {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '8' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="overall_delivery"
                                            id="overall_delivery" value="7"
                                            {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '7' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="overall_delivery"
                                            id="overall_delivery" value="6"
                                            {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '6' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="overall_delivery"
                                            id="overall_delivery" value="5"
                                            {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '5' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="overall_delivery"
                                            id="overall_delivery" value="4"
                                            {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '4' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="overall_delivery"
                                            id="overall_delivery" value="3"
                                            {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '3' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="overall_delivery"
                                            id="overall_delivery" value="2"
                                            {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '2' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="overall_delivery"
                                            id="overall_delivery" value="1"
                                            {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '1' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="overall_delivery"
                                            id="overall_delivery" value="0"
                                            {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '0' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Conference content and material
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="conference_content"
                                            name="conference_content" value="9"
                                            {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '9' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="conference_content"
                                            name="conference_content" value="8"
                                            {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '8' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="conference_content"
                                            name="conference_content" value="7"
                                            {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '7' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="conference_content"
                                            name="conference_content" value="6"
                                            {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '6' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="conference_content"
                                            name="conference_content" value="5"
                                            {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '5' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="conference_content"
                                            name="conference_content" value="4"
                                            {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '4' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="conference_content"
                                            name="conference_content" value="3"
                                            {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '3' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="conference_content"
                                            name="conference_content" value="2"
                                            {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '2' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="conference_content"
                                            name="conference_content" value="1"
                                            {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '1' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="survey_radio_container">
                                        <input class="survey_radio_input" type="radio" name="conference_content"
                                            name="conference_content" value="0"
                                            {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '0' ? 'checked' : '') : '' }}>
                                        <span class="survey_radio_checkmark"></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>

                <form action="">
                    <div class="owl-carousel owl-theme" id="survey_mobile_table">
                        <div class="items">
                            <div class="survey_list_items">
                                <div class="survey_list_header">
                                    Course content and material
                                </div>
                                <ul class="survey_list_ul">
                                    <li>
                                        <h4 class="survey_list_radio_option">9 Excellent</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="content_material" id="content_material" value="9"
                                                    {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '9' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">8 Excellent</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="content_material" id="content_material" value="8"
                                                    {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '8' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">7 Good</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="content_material" id="content_material" value="7"
                                                    {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '7' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">6 Good</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="content_material" id="content_material" value="6"
                                                    {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '6' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">5 Satisfactory</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="content_material" id="content_material" value="5"
                                                    {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '5' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">4 Satisfactory</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="content_material" id="content_material" value="4"
                                                    {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '4' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">3 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="content_material" id="content_material" value="3"
                                                    {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '3' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">2 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="content_material" id="content_material" value="2"
                                                    {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '2' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">1 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="content_material" id="content_material" value="1"
                                                    {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '1' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">0 Not Relevant</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="content_material" id="content_material" value="0"
                                                    {{ isset($survey_reg->content_material) ? ($survey_reg->content_material == '0' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="items">
                            <div class="survey_list_items">
                                <div class="survey_list_header">
                                    Speakers' knowledge and competency
                                </div>
                                <ul class="survey_list_ul">
                                    <li>
                                        <h4 class="survey_list_radio_option">9 Excellent</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="speaker_knowledge" id="speaker_knowledge" value="9"
                                                    {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '9' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">8 Excellent</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="speaker_knowledge" id="speaker_knowledge" value="8"
                                                    {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '8' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">7 Good</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="speaker_knowledge" id="speaker_knowledge" value="7"
                                                    {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '7' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">6 Good</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="speaker_knowledge" id="speaker_knowledge" value="6"
                                                    {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '6' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">5 Satisfactory</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="speaker_knowledge" id="speaker_knowledge" value="5"
                                                    {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '5' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">4 Satisfactory</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="speaker_knowledge" id="speaker_knowledge" value="4"
                                                    {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '4' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">3 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="speaker_knowledge" id="speaker_knowledge" value="3"
                                                    {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '3' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">2 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="speaker_knowledge" id="speaker_knowledge" value="2"
                                                    {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '2' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">1 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="speaker_knowledge" id="speaker_knowledge" value="1"
                                                    {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '1' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">0 Not Relevant</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="speaker_knowledge" id="speaker_knowledge" value="0"
                                                    {{ isset($survey_reg->speaker_knowledge) ? ($survey_reg->speaker_knowledge == '0' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="items">
                            <div class="survey_list_items">
                                <div class="survey_list_header">
                                    Trainer's presentation skill
                                </div>
                                <ul class="survey_list_ul">
                                    <li>
                                        <h4 class="survey_list_radio_option">9 Excellent</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="trainer_presentation" id="trainer_presentation"
                                                    value="9"
                                                    {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '9' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">8 Excellent</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="trainer_presentation" id="trainer_presentation"
                                                    value="8"
                                                    {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '8' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">7 Good</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="trainer_presentation" id="trainer_presentation"
                                                    value="7"
                                                    {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '7' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">6 Good</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="trainer_presentation" id="trainer_presentation"
                                                    value="6"
                                                    {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '6' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">5 Satisfactory</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="trainer_presentation" id="trainer_presentation"
                                                    value="5"
                                                    {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '5' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">4 Satisfactory</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="trainer_presentation" id="trainer_presentation"
                                                    value="4"
                                                    {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '4' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">3 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="trainer_presentation" id="trainer_presentation"
                                                    value="3"
                                                    {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '3' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">2 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="trainer_presentation" id="trainer_presentation"
                                                    value="2"
                                                    {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '2' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">1 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="trainer_presentation" id="trainer_presentation"
                                                    value="1"
                                                    {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '1' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">0 Not Relevant</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="trainer_presentation" id="trainer_presentation"
                                                    value="0"
                                                    {{ isset($survey_reg->trainer_presentation) ? ($survey_reg->trainer_presentation == '0' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="items">
                            <div class="survey_list_items">
                                <div class="survey_list_header">
                                    Q&A session - Effectiveness
                                </div>
                                <ul class="survey_list_ul">
                                    <li>
                                        <h4 class="survey_list_radio_option">9 Excellent</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio" name="q_a_session"
                                                    id="q_a_session" value="9"
                                                    {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '9' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">8 Excellent</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio" name="q_a_session"
                                                    id="q_a_session" value="8"
                                                    {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '8' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">7 Good</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio" name="q_a_session"
                                                    id="q_a_session" value="7"
                                                    {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '7' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">6 Good</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio" name="q_a_session"
                                                    id="q_a_session" value="6"
                                                    {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '6' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">5 Satisfactory</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio" name="q_a_session"
                                                    id="q_a_session" value="5"
                                                    {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '5' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">4 Satisfactory</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio" name="q_a_session"
                                                    id="q_a_session" value="4"
                                                    {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '4' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">3 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio" name="q_a_session"
                                                    id="q_a_session" value="3"
                                                    {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '3' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">2 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio" name="q_a_session"
                                                    id="q_a_session" value="2"
                                                    {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '2' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">1 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio" name="q_a_session"
                                                    id="q_a_session" value="1"
                                                    {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '1' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">0 Not Relevant</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio" name="q_a_session"
                                                    id="q_a_session" value="0"
                                                    {{ isset($survey_reg->q_a_session) ? ($survey_reg->q_a_session == '0' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="items">
                            <div class="survey_list_items">
                                <div class="survey_list_header">
                                    Overall delivery and effectiveness
                                </div>
                                <ul class="survey_list_ul">
                                    <li>
                                        <h4 class="survey_list_radio_option">9 Excellent</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="overall_delivery" id="overall_delivery" value="9"
                                                    {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '9' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">8 Excellent</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="overall_delivery" id="overall_delivery" value="8"
                                                    {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '8' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">7 Good</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="overall_delivery" id="overall_delivery" value="7"
                                                    {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '7' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">6 Good</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="overall_delivery" id="overall_delivery" value="6"
                                                    {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '6' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">5 Satisfactory</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="overall_delivery" id="overall_delivery" value="5"
                                                    {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '5' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">4 Satisfactory</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="overall_delivery" id="overall_delivery" value="4"
                                                    {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '4' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">3 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="overall_delivery" id="overall_delivery" value="3"
                                                    {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '3' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">2 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="overall_delivery" id="overall_delivery" value="2"
                                                    {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '2' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">1 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="overall_delivery" id="overall_delivery" value="1"
                                                    {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '1' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">0 Not Relevant</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="overall_delivery" id="overall_delivery" value="0"
                                                    {{ isset($survey_reg->overall_delivery) ? ($survey_reg->overall_delivery == '0' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="items">
                            <div class="survey_list_items">
                                <div class="survey_list_header">
                                    Conference content and material
                                </div>
                                <ul class="survey_list_ul">
                                    <li>
                                        <h4 class="survey_list_radio_option">9 Excellent</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="conference_content" name="conference_content"
                                                    value="9"
                                                    {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '9' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">8 Excellent</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="conference_content" name="conference_content"
                                                    value="8"
                                                    {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '8' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">7 Good</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="conference_content" name="conference_content"
                                                    value="7"
                                                    {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '7' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">6 Good</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="conference_content" name="conference_content"
                                                    value="6"
                                                    {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '6' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">5 Satisfactory</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="conference_content" name="conference_content"
                                                    value="5"
                                                    {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '5' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">4 Satisfactory</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="conference_content" name="conference_content"
                                                    value="4"
                                                    {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '4' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">3 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="conference_content" name="conference_content"
                                                    value="3"
                                                    {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '3' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">2 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="conference_content" name="conference_content"
                                                    value="2"
                                                    {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '2' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">1 Poor</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="conference_content" name="conference_content"
                                                    value="1"
                                                    {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '1' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <h4 class="survey_list_radio_option">0 Not Relevant</h4>
                                        <div class="survey_radio_container_outer">
                                            <div class="survey_radio_container">
                                                <input class="survey_radio_input" type="radio"
                                                    name="conference_content" name="conference_content"
                                                    value="0"
                                                    {{ isset($survey_reg->conference_content) ? ($survey_reg->conference_content == '0' ? 'checked' : '') : '' }}>
                                                <span class="survey_radio_checkmark"></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <div id="question_page_5" class="question_page_5 d-none">
                <h1 class="survey_heading_h1 mb-3">Other Comments</h1>
                <h3 class="survey_heading_h3_2 mb-5">1. Is the content of the Conference/Workshop relevant to your
                    area(s)
                    of
                    work? Why?</h3>
                <div class="survey_input_outer">
                    <input type="text" class="survey_input_type_2" placeholder="Type here..."
                        name="conference_relevant" id="question_5"
                        value="{{ isset($survey_reg->conference_relevant) ? $survey_reg->conference_relevant : '' }}">
                </div>
            </div>

            <div id="question_page_6" class="question_page_6 d-none">
                <h1 class="survey_heading_h1 mb-3">Other Comments</h1>
                <h3 class="survey_heading_h3_2 mb-5">2. What other area(s) or topic(s) would you like to see being
                    included in
                    future Conference/Workshop?</h3>
                <div class="survey_input_outer">
                    <input type="text" class="survey_input_type_2" placeholder="Type here..."
                        name="future_conference" id="question_6"
                        value="{{ isset($survey_reg->future_conference) ? $survey_reg->future_conference : '' }}">
                </div>
            </div>

            <div id="question_page_7" class="question_page_7 d-none">
                <h1 class="survey_heading_h1 mb-3">Other Comments</h1>
                <h3 class="survey_heading_h3_2 mb-5">3. Any additional comments or feedback on the Conference/Workshop
                    or
                    speakers?</h3>
                <div class="survey_input_outer">
                    <input type="text" class="survey_input_type_2" placeholder="Type here..." name="feedback"
                        id="question_7" value="{{ isset($survey_reg->feedback) ? $survey_reg->feedback : '' }}">
                </div>
            </div>

            <div class="survey_button_div">
                {{-- <a class="qstn_previous_button" id="previous_button_home">Previous</a> --}}
                <a class="qstn_previous_button" onclick="handleDivChange('previous')"
                    id="previous_button">Previous</a>
                <a class="qstn_next_button" onclick="handleDivChange('next')" id="next_button">Next</a>
            </div>

        </div>

        <div class="survey_page_container d-none" id="thank_you_container">
            <h1 class="survey_heading_h1 mb-3">Thank You!</h1>
            <p class="survey_paragraph mb-5">Thank you for your submission! A certificate will sent to the email
                address
                you provided.<br>
                Looking forward to seeing you at the next event!</p>
            <a class="qstn_previous_button" href="{{ route('frontend.home') }}" id="start_survey"
                style="font-weight:0;">Back to Homepage</a>
        </div>


        <div class="survey_canvas">
            <canvas id="survey_canvas" class="particles"></canvas>
        </div>

    </div>


    <script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/validation.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/validate_jquery.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/apba_script.js') }}"></script>
    <script src="{{ asset('assets/frontend/owl_carousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/frontend/fancybox/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/sweetalert/sweetalert-dev.js') }}"></script>
    <script src="{{ asset('assets/dashboard/sweetalert/sweetalert.min.js') }}"></script>

    <script src="{{ asset('assets/frontend/js/particles_common.js') }}"></script>

    <script>
        $('#start_survey').click(function() {
            $('#welcome_container').css('display', 'none');
            $('.question_div').css('display', 'block');
            $('#question_page_1').removeClass('d-none');
        });
    </script>

    <script>
        var validmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    localStorage.setItem('currentDiv', 'question_page_1');
    localStorage.setItem('maxDivID', 7);
    const $progressText = $('#task_status');
    const $progressData = $('#progress_id');

    const handleDivChange = (action) => {
        let currentDiv = localStorage.getItem('currentDiv');

        if (currentDiv != null) {
            let divID = currentDiv.substr(14, currentDiv.length);
            divID = parseInt(divID);

            if (Number.isInteger(divID)) {
                switch (action) {
                    case 'previous':

                        if (divID == 1) {
                            $('#welcome_container').css('display', 'block');
                            $('.question_div').css('display', 'none');
                        }

                        if (divID != 1) {
                            let tempID = divID - 1;
                            finalDIvID = 'question_page_' + tempID;
                            if (tempID == 0) {
                                $('#previous_button').addClass('d-none');
                                $('#previous_button_home').removeClass('d-none');
                            }

                            $progressText.text(`${tempID} of ${localStorage.getItem('maxDivID')}`)
                            $progressData.val(tempID);
                        }
                        break;

                    case 'next':
                        if (divID == 4) {
                            var content_material = $('input[name=content_material]:checked').val();
                            var speaker_knowledge = $('input[name=speaker_knowledge]:checked').val();
                            var trainer_presentation = $('input[name=trainer_presentation]:checked').val();
                            var q_a_session = $('input[name=q_a_session]:checked').val();
                            var overall_delivery = $('input[name=overall_delivery]:checked').val();
                            var conference_content = $('input[name=conference_content]:checked').val();

                            if (content_material == undefined || speaker_knowledge == undefined ||
                                trainer_presentation == undefined || q_a_session == undefined || overall_delivery ==
                                undefined || conference_content == undefined) {
                                Swal.fire({
                                    icon: 'warning',
                                    text: 'Please select the appropriate rating for the following training elements',
                                });
                                return false;
                            }
                        } else {
                            question = $('#question_' + divID).val();
                            if (question == '') {
                                document.getElementById('question_' + divID)
                                    .style
                                    .borderColor =
                                    "red";
                                document.getElementById('question_' + divID)
                                    .focus();
                                return false;
                            } else {
                                document.getElementById('question_' + divID)
                                    .style
                                    .borderColor =
                                    "#BAC0C9";
                            }
                            if (divID == 3) {
                                question = $('#question_' + divID).val();
                                if (!question.match(validmail)) {
                                    $("#mail_error").css('display', 'block');
                                    document.getElementById('question_' + divID)
                                        .style
                                        .borderColor =
                                        "red";
                                    document.getElementById('question_' + divID)
                                        .focus();
                                    return false;
                                } else {
                                    $("#mail_error").css('display', 'none');
                                    document.getElementById('question_' + divID)
                                        .style
                                        .borderColor =
                                        "#BAC0C9";
                                }
                            }
                        }

                        if (divID == 7) {
                            $("#loader").css('display', 'block');
                            $.ajax({
                                url: "{{ route('customer.optional.submit.survey') }}",
                                type: "POST",
                                data: {
                                    '_token': "{{ csrf_token() }}",
                                    "event_registration_optional_uuid": $(
                                            '#event_registration_optional_uuid')
                                        .val(),
                                    "survey_activity_uuid": $('#survey_activity_uuid')
                                        .val(),
                                    "fullname": $('#question_1').val(),
                                    "organization": $('#question_2').val(),
                                    "email": $('#question_3').val(),
                                    "content_material": $('input[name=content_material]:checked').val(),
                                    "speaker_knowledge": $('input[name=speaker_knowledge]:checked').val(),
                                    "trainer_presentation": $('input[name=trainer_presentation]:checked')
                                        .val(),
                                    "q_a_session": $('input[name=q_a_session]:checked').val(),
                                    "overall_delivery": $('input[name=overall_delivery]:checked').val(),
                                    "conference_content": $('input[name=conference_content]:checked').val(),
                                    "conference_relevant": $('#question_5').val(),
                                    "future_conference": $('#question_6').val(),
                                    "feedback": $('#question_7').val(),
                                    "type": $('#type').val(),
                                },
                                datatype: 'json',
                                success: function(response) {
                                    $("#loader").css('display', 'none');
                                    if (response[0] == "success") {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: response[1],
                                        });
                                        return true;
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: response[1],
                                        });
                                        return false;
                                    }
                                },
                                error: function() {
                                    $("#loader").css('display', 'none');
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: "Something went wrong! Please try again.",
                                    });
                                    return false;
                                }
                            });
                        }
                        if (divID == localStorage.getItem('maxDivID')) {
                            $('#thank_you_container').removeClass('d-none');
                            $('.question_div').css('display', 'none');
                        } else {
                            let tempID = divID + 1;
                            $progressText.text(`${tempID} of ${localStorage.getItem('maxDivID')}`)
                            $progressData.val(tempID);
                            finalDIvID = 'question_page_' + tempID;
                        }
                        $('#previous_button_home').addClass('d-none');
                        $('#previous_button').removeClass('d-none');
                        break;
                }
                $(`#${currentDiv}`).addClass('d-none');
                $(`#${finalDIvID}`).removeClass('d-none');
                    localStorage.setItem('currentDiv', finalDIvID);
                }
            }
        }
    </script>
</body>

</html>
