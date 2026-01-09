@extends('dashboard.layouts.master')
@section('title', __('Dashboard'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Dashboard') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    {{ __('Survey Certificate Dashboard') }}
                </small>
            </div>
            <form action="{{ route('admin.survey.certificate.dashboard') }}" method="GET">
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Survey Name:</label>
                            <select name="uuid" class="form-control form-control-user" id="uuid">
                                <option value="" selected>-Choose Survey-</option>
                                @if (count($all_survey_list))
                                    @foreach ($all_survey_list as $data)
                                        <option value="{{ $data->uuid }}">{{ $data->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-1 d-flex">
                        <button type="submit" class="btn btn-info btn-circle btn-sm ml-1" name="filter"
                            style="margin-top: 33px;">
                            <i class="fas fa-filter"></i>
                        </button>
                        <button type="submit" name="restore" class="btn btn-danger btn-circle btn-sm ml-1"
                            style="margin-top: 33px;">
                            <i class="fas fa-undo"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div class="card">
                <div class="card-header" style="font-size: 18px;">
                    <div class="row">
                        <div class="col-6">

                            <span class="icon text-red-50 mr-2" style="color: blue;">
                                <i class="fas fa-poll-h"></i>
                            </span>Survey List
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered m-a-0" id="survey_table">
                            <thead class="dker">
                                <tr>
                                    <th class="custom-th">{{ __('Event Name') }}</th>
                                    <th class="custom-th">{{ __('Activity Name') }}</th>
                                    <th class="custom-th">{{ __('Survey Name') }}</th>
                                    <th class="custom-th">{{ __('Survey Link for non member') }}</th>
                                    <th class="custom-th">{{ __('No. of Survey Submited') }}</th>
                                    <th class="custom-th">{{ __('Date') }}</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($survey_list))
                                    @foreach ($survey_list as $data)
                                    @php
                                     $eventname= isset($data->getEventOptional->getEvent->event_name) ? $data->getEventOptional->getEvent->event_name : '' ;
                                    @endphp
                                        <tr>
                                            <td>
                                                {{ isset($data->getEventProgram->getEventDetails->event_name) ? $data->getEventProgram->getEventDetails->event_name : $eventname }}
                                            </td>
                                            <td>
                                                {{ isset($data->getEventProgram->getEventWorkshopDetails->workshop_name) ? $data->getEventProgram->getEventWorkshopDetails->workshop_name : '' }}
                                            </td>
                                            <td>
                                                {{ $data->name }}
                                            </td>
                                            <td>
                                                {{ url('/') . '/non-member-survey/' . $data->uuid }}
                                            </td>
                                            <td>
                                                <a href="javascript:void();" style="pointer-events: none;"
                                                    class="btn btn-success btn-icon-split btn-sm">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-poll"></i>
                                                    </span>
                                                    <span
                                                        class="text">{{ isset($data->getSurveyRegistration) ? count($data->getSurveyRegistration) : 0 }}</span>
                                                </a>
                                            </td>
                                            <td>
                                                {{ Carbon\Carbon::parse($data->created_at)->format('d F Y') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.survey.certificate.view', $data->uuid) }}"
                                                    class="btn btn-primary btn-circle btn-sm mr-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
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
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#survey_table').DataTable({
                responsive: false,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                },
                bInfo: false,
            });
        });
    </script>
@endpush
