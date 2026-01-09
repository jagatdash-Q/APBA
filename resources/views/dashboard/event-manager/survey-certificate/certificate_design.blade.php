<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @font-face {
            font-family: 'PinyonScript';
            src: url("{{ storage_path('fonts/PinyonScript-Regular.ttf') }}") format("truetype");
            font-style: normal;
        }
        @font-face {
            font-family: 'Charm';
            src: url("{{ storage_path('fonts/Charm-Regular.ttf') }}") format("truetype");
            font-style: normal;
        }

        @font-face {
            font-family: 'Montserrat-Regular';
            src: url("{{ storage_path('fonts/Montserrat-Regular.ttf') }}") format("truetype");
        }

        @font-face {
            font-family: 'Montserrat-Bold';
            src: url("{{ storage_path('fonts/Montserrat-Bold.ttf') }}") format("truetype");
        }

        @font-face {
            font-family: 'Montserrat-SemiBold';
            src: url("{{ storage_path('fonts/Montserrat-SemiBold.ttf') }}") format("truetype");
        }

        @font-face {
            font-family: 'Montserrat-SemiBoldItalic';
            src: url("{{ storage_path('fonts/Montserrat-SemiBoldItalic.ttf') }}") format("truetype");
        }

        @page {
            margin: 0 !important;
        }

        body {
            background-image: url("{{ $image_path }}/{{ $certificate_attribute->background_image }}");
            background-size: cover;
            color: #03355d;
            text-align: center;
            padding: 50px 0px;
            /* padding: 0px; */
            margin: 0px;
            font-family: 'Montserrat-Regular';
            font-size: 18px;
            line-height: 28px;
        }

        .cert_name {
            /* margin: 2rem; */
            /* font-size: 62px; */
            font-size: 60pt;
            font-weight: 400;
            font-family: 'Charm' !important;
            margin-bottom: 1rem;
        }

        .cert_member_sign {
            width: 180px;
            height: 70px;
            margin: 10px auto;
            /* margin: 0 auto; */
            display: flex;
            align-items: center;
        }

        .cert_member_sign img {
            width: 100%;
            height: auto;
        }

        .const_letter {
            font-size: 12pt;
        }

        .container {
            display: block;
            width: 100%;
        }

        .column {
            width: 50%;
            float: left;
        }

        .cert_member_logo {
            width: 180px;
            height: 70px;
            margin: 0 auto;
        }

        .cert_member_logo img {
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    @php
        $eventname = isset($survey_reg->getSurveyActivity->getEventOptional->getEvent->event_name) ? $survey_reg->getSurveyActivity->getEventOptional->getEvent->event_name : '';
        $programdate = isset($survey_reg->getSurveyActivity->getEventOptional->getEvent->start_date) ? Carbon\Carbon::parse($survey_reg->getSurveyActivity->getEventOptional->getEvent->start_date)->format('d F Y') . ' - ' . Carbon\Carbon::parse($survey_reg->getSurveyActivity->getEventOptional->getEvent->end_date)->format('d F Y') : '';
        $location = isset($survey_reg->getSurveyActivity->getEventOptional->getEvent->event_location) ? $survey_reg->getSurveyActivity->getEventOptional->getEvent->event_location : '';
    @endphp
    <p style="margin: 0; font-size: 36pt;font-family: 'Montserrat-Bold';">
        CERTIFICATE</p>
    <p class="const_letter" style="margin: 0;">of Participation</p>
    <hr style="border: 1px solid #02b0b5; width: 50%;">
    <p class="const_letter" style="margin: 0;">This certificate presented to</p>
    <h1 class="cert_name">{{ $survey_reg->fullname }}</h1>
    <p class="const_letter" style="margin: 0;">for participating in</p>
    <p
        style="font-size: 16pt; margin: 0 auto; padding: 10px;max-width:850px;font-family: 'Montserrat-SemiBoldItalic';line-height:15pt;text-align:center;">
        {{ isset($survey_reg->getSurveyActivity->getEventProgram->getEventDetails->event_name) ? $survey_reg->getSurveyActivity->getEventProgram->getEventDetails->event_name : $eventname }}<br>
        {{ isset($survey_reg->getSurveyActivity->getEventProgram->program_name) ? $survey_reg->getSurveyActivity->getEventProgram->program_name : 'Conference' }}
    </p>
    <p class="const_letter" style="margin-top:0px;line-height:20px;">
        {{ isset($survey_reg->getSurveyActivity->getEventProgram->program_date) ? Carbon\Carbon::parse($survey_reg->getSurveyActivity->getEventProgram->program_date)->format('jS F Y') : $programdate }}<br>
        {{ isset($survey_reg->getSurveyActivity->getEventProgram->getEventDetails->event_location) ? 'at ' . $survey_reg->getSurveyActivity->getEventProgram->getEventDetails->event_location : $location }}
    </p>

    <div class="container">
        <div class="column">
            <div class="content">
                <div class="cert_member_logo">
                    <img src="{{ $image_path . $certificate_attribute->logo_1 }}" alt="">
                </div>

                <div class="cert_member_sign">
                    <img src="{{ $image_path . $certificate_attribute->signature_1 }}" alt="...">
                </div>
                <p class="const_letter" style="margin: 0;line-height:15px;">
                    {{ $certificate_attribute->introducer_name_1 }} <br>
                    {{ $certificate_attribute->introducer_company_1 }}</p>
            </div>
        </div>
        <div class="column">
            <div class="content">
                <div class="cert_member_logo">

                    <img src="{{ $image_path . $certificate_attribute->logo_2 }}" alt="">
                </div>
                <div class="cert_member_sign">

                    <img src="{{ $image_path . $certificate_attribute->signature_2 }}" alt="...">
                </div>
                <p class="const_letter" style="margin: 0;line-height: 15px;">
                    {{ $certificate_attribute->introducer_name_2 }} <br>
                    {{ $certificate_attribute->introducer_company_2 }}</p>
            </div>
        </div>
    </div>
</body>

</html>
