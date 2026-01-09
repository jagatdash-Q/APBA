@extends('dashboard.layouts.master')
@section('title', __('Survey Details'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
    <style>
        .custom-th {
            vertical-align: middle !important;
            padding: 8px !important;
            font-size: small !important;
            word-wrap: break-word !important;
        }

        .custom-td {
            vertical-align: middle !important;
            padding: 7px !important;
            font-size: small !important;
            word-wrap: break-word !important;
        }

        th,
        td {
            border: 0px;
        }

        .sub-title-color {
            color: gray;
        }

        #not-allowed {
            pointer-events: none;
            opacity: 0.5;

        }
    </style>
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Survey Details') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    <a href="{{ route('admin.survey.certificate.dashboard') }}">{{ __('Survey Dashboard') }}</a> /
                    {{ $survey_list->name }}
                </small>
            </div>
            @php
                $eventname = isset($survey_list->getEventOptional->getEvent->event_name) ? $survey_list->getEventOptional->getEvent->event_name : '';
                $programdate = isset($survey_list->getEventOptional->getEvent->start_date) ? Carbon\Carbon::parse($survey_list->getEventOptional->getEvent->start_date)->format('d F Y') . ' - ' . Carbon\Carbon::parse($survey_list->getEventOptional->getEvent->end_date)->format('d F Y') : '';
                $location = isset($survey_list->getEventOptional->getEvent->event_location) ? $survey_list->getEventOptional->getEvent->event_location : '';
            @endphp
            <div class="card">
                <div class="card-header" style="font-size: 18px;">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="icon text-red-50 mr-2" style="color: blue;">
                                <i class="fas fa-fw fa-users"></i>
                            </span>Customer Survey List

                        </div>
                        <div class="col-md-6 text-right">
                            <form action="{{ route('admin.survey.certificate.export') }}" method="GET">
                                <input type="hidden" name="survey_uuid" value="{{ $survey_list->uuid }}">
                                <button type="submit" class="btn">
                                    <i class="fas fa-file-excel text-right" style="font-size:30px;color:green;"
                                        title="Download data in Excel"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <ul>
                                <li>Event Name:
                                    <b>{{ isset($survey_list->getEventProgram->getEventDetails->event_name) ? $survey_list->getEventProgram->getEventDetails->event_name : $eventname }}</b>
                                </li>
                                <li>Survey Name: <b>
                                        {{ $survey_list->name }}
                                    </b></li>
                                <li>Date:
                                    <b>
                                        {{ isset($survey_list->getEventProgram->program_date) ? Carbon\Carbon::parse($survey_list->getEventProgram->program_date)->format('d F Y') : $programdate }}
                                    </b>
                                </li>
                                <li>Location:
                                    <b>
                                        {{ isset($survey_list->getEventProgram->getEventDetails->event_location) ? $survey_list->getEventProgram->getEventDetails->event_location : $location }}
                                    </b>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered m-a-0 mt-5" id="customer_table">
                            <thead class="dker">
                                <tr>
                                    <th class="custom-th">{{ __('Salutation with Full Name') }}</th>
                                    <th class="custom-th">{{ __('Email') }}</th>
                                    <th class="custom-th">{{ __('Organization') }}</th>
                                    <th class="custom-th">{{ __('Member Type') }}</th>
                                    <th class="custom-th">{{ __('Survey Submited Link') }}</th>
                                    <th class="custom-th">{{ __('Certificate Sent Status') }}</th>
                                    <th class="text-center" style="width:200px;">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($survey_list->getSurveyRegistration))
                                    @foreach ($survey_list->getSurveyRegistration as $survey_report)
                                        <tr>
                                            <td class="custom-td">
                                                <div class="avatar avatar-md mr-3 mt-1 float-left">
                                                    <img src="{{ asset('/assets/frontend/images/avatar_white.gif') }}"
                                                        alt="">
                                                </div>
                                                <div class="mt-3">
                                                    <strong>{{ $survey_report->fullname }}</strong>
                                                </div>
                                            </td>
                                            <td class="custom-td">
                                                {{ $survey_report->email }}
                                            </td>
                                            <td class="custom-td">
                                                {{ $survey_report->organization }}
                                            </td>

                                            <td class="custom-td">
                                                @if ($survey_report->type == 'Guest')
                                                    <a href="javascript:void();" style="pointer-events: none;"
                                                        class="btn btn-warning btn-icon-split">
                                                        <span class="text">Guest</span></a>
                                                @elseif($survey_report->type == 'Member')
                                                    <a href="javascript:void();" style="pointer-events: none;"
                                                        class="btn btn-success btn-icon-split">
                                                        <span class="text">Member</span>
                                                    </a>
                                                @elseif($survey_report->type == 'Non Member')
                                                    <a href="javascript:void();" style="pointer-events: none;"
                                                        class="btn btn-danger btn-icon-split">
                                                        <span class="text">Non Member</span>
                                                    </a>
                                                @endif

                                            </td>
                                            <td class="custom-td">
                                                <a target="_blank"
                                                    href="{{ $survey_report->survey_url }}">{{ $survey_report->survey_url }}</a>
                                            </td>
                                            <td class="custom-td">
                                                @if ($survey_report->certificate_sent == 'no')
                                                    <a href="javascript:void();" style="pointer-events: none;"
                                                        class="btn btn-warning btn-icon-split">
                                                        <span class="text">No</span></a>
                                                @else
                                                    <a href="javascript:void();" style="pointer-events: none;"
                                                        class="btn btn-success btn-icon-split">
                                                        <span class="text">Yes</span>
                                                    </a>
                                                @endif
                                            </td>
                                            <td style="display:flex;">
                                                @if (isset($survey_report->getEventProgram->getEventRegDetails->uuid))
                                                    <a href="{{ route('admin.event.details', [$survey_report->getEventProgram->getEventRegDetails->uuid, 'type' => 'survey', 'survey_uuid' => $survey_list->uuid]) }}"
                                                        class="btn btn-primary btn-circle btn-sm mr-1">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('admin.survey.certificate.edit', $survey_report->uuid) }}"
                                                    class="btn btn-info btn-circle btn-sm mr-1  @if (!Auth::user()->hasPermission('event_management-update')) disabled @endif">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="{{ route('admin.survey.certificate.sent', $survey_report->uuid) }}"
                                                    class="btn btn-secondary btn-circle btn-sm mr-1">
                                                    <i class="fab fa-telegram-plane"></i>
                                                </a>
                                                @if ($survey_report->certificate_sent == 'yes')
                                                    @if ($survey_report->certificate != null)
                                                        <a href="{{ url('/') . '/certificate/' . $survey_report->certificate }}"
                                                            target="_blank" class="btn btn-warning btn-circle btn-sm">
                                                            <i class="fas fa-clipboard-list"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#customer_table').DataTable({
                "columnDefs": [{
                    "width": "5%",
                    "targets": 6
                }, {
                    "width": "25%",
                    "targets": 0
                }]
            });
        });
    </script>
@endpush
