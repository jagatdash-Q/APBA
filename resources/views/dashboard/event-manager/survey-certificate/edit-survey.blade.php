@extends('dashboard.layouts.master')
@section('title', __('Edit Survey'))
@section('content')
    <style>
        #danger {
            color: red;
        }

        table,
        th,
        td {
            text-align: center;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .form-check-inline {
            margin-right: 0px;
        }

        .form-check-inline .form-check-input {
            margin-right: 0px;
        }
    </style>
    @include('dashboard.common.index')
    <div class="padding">
        <div class="box m-b-0">
            <div class="box-header dker">
                <h3>{{ __('Edit Survey') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    <a href="{{ route('admin.survey.certificate.dashboard') }}">{{ __('Survey Dashboard') }}</a> /
                    <a
                        href="{{ route('admin.survey.certificate.view', $survey_reg->getSurveyActivity->uuid) }}">{{ $survey_reg->getSurveyActivity->name }}</a>
                    /
                    {{ $survey_reg->fullname }}
                </small>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <div class="card pt-2">
                    <form action="{{ route('admin.survey.certificate.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="uuid" value="{{ $survey_reg->uuid }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h3><b>A. Personal Information</b></h3>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Full Name and Salutations:<span
                                            id="danger">*</span></label>
                                    <input type="text" class="form-control text-secondary" name="fullname" id="fullname"
                                        value="{{ $survey_reg->fullname }}" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Organization:<span id="danger">*</span></label>
                                    <input type="text" class="form-control text-secondary" name="organization"
                                        id="organization" value="{{ $survey_reg->organization }}" required>
                                </div>
                                <div class="col-6 mt-2">
                                    <label class="form-label">Email:<span id="danger">*</span></label>
                                    <input type="text" class="form-control text-secondary" name="email" id="email"
                                        value="{{ $survey_reg->email }}" required>
                                </div>
                                <div class="col-12 mt-2">
                                    <h3><b>B. Overall Evaluation</b></h3>
                                </div>
                                <div class="col-12 mt-2">
                                    <table width="100%">
                                        <thead>
                                            <tr>
                                                <th style="border-bottom: 1px solid white"></th>
                                                <th colspan="2">Excellent</th>
                                                <th colspan="2">Good</th>
                                                <th colspan="2">Satisfactory</th>
                                                <th colspan="3">Poor</th>
                                                <th>Not Relevant</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th>9</th>
                                                <th>8</th>
                                                <th>7</th>
                                                <th>6</th>
                                                <th>5</th>
                                                <th>4</th>
                                                <th>3</th>
                                                <th>2</th>
                                                <th>1</th>
                                                <th>0</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <form>
                                                <tr>
                                                    <td>
                                                        Course content and material
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="content_material" id="content_material"
                                                                {{ $survey_reg->content_material == '9' ? 'checked' : '' }}
                                                                value="9">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="content_material" id="content_material"
                                                                {{ $survey_reg->content_material == '8' ? 'checked' : '' }}
                                                                value="8">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="content_material"
                                                                {{ $survey_reg->content_material == '7' ? 'checked' : '' }}
                                                                id="content_material" value="7">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->content_material == '6' ? 'checked' : '' }}
                                                                name="content_material" id="content_material"
                                                                value="6">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->content_material == '5' ? 'checked' : '' }}
                                                                name="content_material" id="content_material"
                                                                value="5">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->content_material == '4' ? 'checked' : '' }}
                                                                name="content_material" id="content_material"
                                                                value="4">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->content_material == '3' ? 'checked' : '' }}
                                                                name="content_material" id="content_material"
                                                                value="3">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->content_material == '2' ? 'checked' : '' }}
                                                                name="content_material" id="content_material"
                                                                value="2">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->content_material == '1' ? 'checked' : '' }}
                                                                name="content_material" id="content_material"
                                                                value="1">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->content_material == '0' ? 'checked' : '' }}
                                                                name="content_material" id="content_material"
                                                                value="0">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Speakers' knowledge and competency
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->speaker_knowledge == '9' ? 'checked' : '' }}
                                                                name="speaker_knowledge" id="speaker_knowledge"
                                                                value="9">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->speaker_knowledge == '8' ? 'checked' : '' }}
                                                                name="speaker_knowledge" id="speaker_knowledge"
                                                                value="8">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->speaker_knowledge == '7' ? 'checked' : '' }}
                                                                name="speaker_knowledge" id="speaker_knowledge"
                                                                value="7">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->speaker_knowledge == '6' ? 'checked' : '' }}
                                                                name="speaker_knowledge" id="speaker_knowledge"
                                                                value="6">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->speaker_knowledge == '5' ? 'checked' : '' }}
                                                                name="speaker_knowledge" id="speaker_knowledge"
                                                                value="5">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->speaker_knowledge == '4' ? 'checked' : '' }}
                                                                name="speaker_knowledge" id="speaker_knowledge"
                                                                value="4">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->speaker_knowledge == '3' ? 'checked' : '' }}
                                                                name="speaker_knowledge" id="speaker_knowledge"
                                                                value="3">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->speaker_knowledge == '2' ? 'checked' : '' }}
                                                                name="speaker_knowledge" id="speaker_knowledge"
                                                                value="2">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->speaker_knowledge == '1' ? 'checked' : '' }}
                                                                name="speaker_knowledge" id="speaker_knowledge"
                                                                value="1">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->speaker_knowledge == '0' ? 'checked' : '' }}
                                                                name="speaker_knowledge" id="speaker_knowledge"
                                                                value="0">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Trainer's presentation skill
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->trainer_presentation == '9' ? 'checked' : '' }}
                                                                name="trainer_presentation" id="trainer_presentation"
                                                                value="9">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->trainer_presentation == '8' ? 'checked' : '' }}
                                                                name="trainer_presentation" id="trainer_presentation"
                                                                value="8">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->trainer_presentation == '7' ? 'checked' : '' }}
                                                                name="trainer_presentation" id="trainer_presentation"
                                                                value="7">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->trainer_presentation == '6' ? 'checked' : '' }}
                                                                name="trainer_presentation" id="trainer_presentation"
                                                                value="6">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->trainer_presentation == '5' ? 'checked' : '' }}
                                                                name="trainer_presentation" id="trainer_presentation"
                                                                value="5">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->trainer_presentation == '4' ? 'checked' : '' }}
                                                                name="trainer_presentation" id="trainer_presentation"
                                                                value="4">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->trainer_presentation == '3' ? 'checked' : '' }}
                                                                name="trainer_presentation" id="trainer_presentation"
                                                                value="3">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->trainer_presentation == '2' ? 'checked' : '' }}
                                                                name="trainer_presentation" id="trainer_presentation"
                                                                value="2">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->trainer_presentation == '1' ? 'checked' : '' }}
                                                                name="trainer_presentation" id="trainer_presentation"
                                                                value="1">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->trainer_presentation == '0' ? 'checked' : '' }}
                                                                name="trainer_presentation" id="trainer_presentation"
                                                                value="0">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Q&A session - Effectiveness
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->q_a_session == '9' ? 'checked' : '' }}
                                                                name="q_a_session" id="q_a_session" value="9">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->q_a_session == '8' ? 'checked' : '' }}
                                                                name="q_a_session" id="q_a_session" value="8">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->q_a_session == '7' ? 'checked' : '' }}
                                                                name="q_a_session" id="q_a_session" value="7">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->q_a_session == '6' ? 'checked' : '' }}
                                                                name="q_a_session" id="q_a_session" value="6">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->q_a_session == '5' ? 'checked' : '' }}
                                                                name="q_a_session" id="q_a_session" value="5">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->q_a_session == '4' ? 'checked' : '' }}
                                                                name="q_a_session" id="q_a_session" value="4">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->q_a_session == '3' ? 'checked' : '' }}
                                                                name="q_a_session" id="q_a_session" value="3">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->q_a_session == '2' ? 'checked' : '' }}
                                                                name="q_a_session" id="q_a_session" value="2">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->q_a_session == '1' ? 'checked' : '' }}
                                                                name="q_a_session" id="q_a_session" value="1">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->q_a_session == '0' ? 'checked' : '' }}
                                                                name="q_a_session" id="q_a_session" value="0">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Overall delivery and effectiveness
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->overall_delivery == '9' ? 'checked' : '' }}
                                                                name="overall_delivery" id="overall_delivery"
                                                                value="9">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->overall_delivery == '8' ? 'checked' : '' }}
                                                                name="overall_delivery" id="overall_delivery"
                                                                value="8">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->overall_delivery == '7' ? 'checked' : '' }}
                                                                name="overall_delivery" id="overall_delivery"
                                                                value="7">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->overall_delivery == '6' ? 'checked' : '' }}
                                                                name="overall_delivery" id="overall_delivery"
                                                                value="6">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->overall_delivery == '5' ? 'checked' : '' }}
                                                                name="overall_delivery" id="overall_delivery"
                                                                value="5">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->overall_delivery == '4' ? 'checked' : '' }}
                                                                name="overall_delivery" id="overall_delivery"
                                                                value="4">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->overall_delivery == '3' ? 'checked' : '' }}
                                                                name="overall_delivery" id="overall_delivery"
                                                                value="3">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->overall_delivery == '2' ? 'checked' : '' }}
                                                                name="overall_delivery" id="overall_delivery"
                                                                value="2">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->overall_delivery == '1' ? 'checked' : '' }}
                                                                name="overall_delivery" id="overall_delivery"
                                                                value="1">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->overall_delivery == '0' ? 'checked' : '' }}
                                                                name="overall_delivery" id="overall_delivery"
                                                                value="0">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Conference content and material
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->conference_content == '9' ? 'checked' : '' }}
                                                                name="conference_content" id="conference_content"
                                                                value="9">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->conference_content == '8' ? 'checked' : '' }}
                                                                name="conference_content" id="conference_content"
                                                                value="8">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->conference_content == '7' ? 'checked' : '' }}
                                                                name="conference_content" id="conference_content"
                                                                value="7">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->conference_content == '6' ? 'checked' : '' }}
                                                                name="conference_content" id="conference_content"
                                                                value="6">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->conference_content == '5' ? 'checked' : '' }}
                                                                name="conference_content" id="conference_content"
                                                                value="5">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->conference_content == '4' ? 'checked' : '' }}
                                                                name="conference_content" id="conference_content"
                                                                value="4">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->conference_content == '3' ? 'checked' : '' }}
                                                                name="conference_content" id="conference_content"
                                                                value="3">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->conference_content == '2' ? 'checked' : '' }}
                                                                name="conference_content" id="conference_content"
                                                                value="2">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->conference_content == '1' ? 'checked' : '' }}
                                                                name="conference_content" id="conference_content"
                                                                value="1">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ $survey_reg->conference_content == '0' ? 'checked' : '' }}
                                                                name="conference_content" id="conference_content"
                                                                value="0">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </form>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 mt-2">
                                    <h3><b>C. Other Comments</b></h3>
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="form-label">1. Is the content of the Conference/Workshop relevant to your
                                        area(s)
                                        of
                                        work? Why?<span id="danger">*</span></label>
                                    <textarea type="text" name="conference_relevant" class="form-control text-secondary" required>{{ $survey_reg->conference_relevant }}</textarea>
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="form-label">2. What other area(s) or topic(s) would you like to see being
                                        included in
                                        future Conference/Workshop?<span id="danger">*</span></label>
                                    <textarea type="text" class="form-control text-secondary" name="future_conference" required>{{ $survey_reg->future_conference }}</textarea>
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="form-label">3. Any additional comments or feedback on the
                                        Conference/Workshop
                                        or
                                        speakers?<span id="danger">*</span></label>
                                    <textarea type="text" class="form-control text-secondary" name="feedback" required>{{ $survey_reg->feedback }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="end-content">
                            <div class="col-md-12">
                                <div class="form-group row" style="margin-top: 20px;padding-bottom: 5px;">
                                    <button class="btn btn-success" type="submit" id="submit_btn"
                                        style="margin-left:20px;">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/script.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/menu_banner_image_pos.js') }}"></script>
@endpush
