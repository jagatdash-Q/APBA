@extends('dashboard.layouts.master')
@section('title', __('Events Dashboard'))
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
    </style>

    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Events Dashboard') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    {{ __('Events Dashboard') }}
                </small>

            </div>

            <div class="card mb-5">
                {{-- <div class="card-header" style="font-size: 18px;">
                    <span class="icon text-red-50 mr-2" style="color: red;">
                        <i class="fas fa-calendar-alt"></i>
                    </span>Event Registration Summary
                </div> --}}
                <div class="table-responsive mt-3">
                    <table class="table table-bordered m-a-0" id="summery_table">
                        <thead>
                            <tr>
                                <th><span class="icon text-red-50 mr-2" style="color: red;">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>Event Registration Summary</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($reg_summery))
                                @foreach ($reg_summery as $summery)
                                    <tr>
                                        <td>
                                            <div class="avatar avatar-md mr-3 mt-2 float-left">
                                                <img src="{{ asset('') }}{{ $summery['event_image'] }}" alt="">
                                            </div>
                                            <div class="mt-0">
                                                <div>
                                                    <strong>{{ $summery['event_name'] }}</strong>
                                                </div>
                                                <small class="sub-title-color mr-3"><i
                                                        class="fas fa-map-marker-alt mr-2"></i>{{ $summery['event_location'] }}</small>
                                                <small class="sub-title-color mr-3"><i
                                                        class="fas fa-clock mr-2"></i>{{ Carbon\Carbon::parse($summery['event_start_date'])->format('d F Y') }}
                                                    -
                                                    {{ Carbon\Carbon::parse($summery['event_end_date'])->format('d F Y') }}</small>
                                                <small class="sub-title-color mr-3"><i
                                                        class="fas fa-fw fa-user mr-2"></i><span
                                                        style="color: red;">{{ $summery['total_reg'] }}</span> Total Number
                                                    of
                                                    Registers</small>
                                                <small class="sub-title-color mr-3"><i
                                                        class="fas fa-sort-amount-up-alt mr-2"></i><span
                                                        style="color: red;">{{ $summery['total_amount'] }}</span> Total
                                                    Amount
                                                    Received</small>
                                                    <form action="{{ route('admin.export.event.details') }}" method="GET">
                                                    <input type="hidden" name="event_id" value="{{ $summery['event_id'] }}">
                                                    <button type="submit" style="margin-top:-25px;"
                                                        class="btn float-right">
                                                        <i class="fas fa-file-excel text-right"
                                                            style="font-size:30px;color:green;"
                                                            title="Download data in Excel"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                {{-- @else
                            <center>No record found</center> --}}
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card">
                <form action="{{ route('admin.manage.event.dashboard') }}" method="GET">
                    <div class="card-header" style="font-size: 18px;">
                        <div class="row">
                            <div class="col-4">
                                <span class="icon text-red-50 mr-2" style="color: blue;">
                                    <i class="fas fa-user-friends"></i>
                                </span>Event Registration User List
                            </div>
                            <div class="col-1 text-right mt-1" style="font-size: 14px;">
                                <label for="subscription_status">Filter by:</label>
                            </div>
                            <div class="col-3">
                                <select name="event" class="form-control form-control-user" id="event"
                                    style="padding: 0.25rem 0.75rem;height:30px;">
                                    <option value="" selected disabled>-- Event Name --</option>
                                    @if (count($all_events) > 0)
                                        @foreach ($all_events as $event)
                                            <option value="{{ $event->id }}">{{ $event->event_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-2">
                                <select name="month" class="form-control form-control-user" id="month"
                                    style="padding: 0.25rem 0.75rem;height:30px;">
                                    <option value="" selected disabled>Month</option>
                                    @if (count($month) > 0)
                                        @foreach ($month as $month_data)
                                            <option value="{{ $month_data }}">
                                                @if ($month_data == 1)
                                                    Jaunary
                                                @elseif($month_data == 2)
                                                    February
                                                @elseif($month_data == 3)
                                                    March
                                                @elseif($month_data == 4)
                                                    April
                                                @elseif($month_data == 5)
                                                    May
                                                @elseif($month_data == 6)
                                                    June
                                                @elseif($month_data == 7)
                                                    July
                                                @elseif($month_data == 8)
                                                    August
                                                @elseif($month_data == 9)
                                                    September
                                                @elseif($month_data == 10)
                                                    Octuber
                                                @elseif($month_data == 11)
                                                    November
                                                @elseif($month_data == 12)
                                                    December
                                                @endif
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-1">
                                <select name="year" class="form-control form-control-user" id="year"
                                    style="padding: 0.25rem 0.75rem;height:30px;width:90px;">
                                    <option value="" selected disabled>Year</option>
                                    @if (count($years) > 0)
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-1 d-flex">
                                <button type="submit" class="btn btn-info btn-circle btn-sm ml-1" name="filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                                <button type="submit" name="restore" class="btn btn-danger btn-circle btn-sm ml-1">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered m-a-0 mt-5" id="event_table">
                        <thead class="dker">
                            <tr>
                                <th class="custom-th">{{ __('Customer Name') }}</th>
                                <th class="custom-th">{{ __('Event Name') }}</th>
                                <th class="custom-th">{{ __('Location') }}</th>
                                <th class="custom-th">{{ __('Event Start & End Date') }}</th>
                                <th class="custom-th">{{ __('Payment Status') }}</th>
                                <th class="text-center" style="width:200px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (count($user_workshop))

                                @foreach ($user_workshop as $user_event)
                                    <tr>
                                        <td class="custom-td">
                                            <div class="avatar avatar-md mr-3 mt-1 float-left">
                                                @if (isset($user_event->getCustomerDetails))
                                                    <img src="{{ $user_event->getCustomerDetails->profile_pic == null ? asset('/assets/frontend/images/avatar_white.gif') : asset('uploads/profile_pic/' . $user_event->getCustomerDetails->profile_pic) }}"
                                                        alt="">
                                                @else
                                                    <img src="{{ asset('/assets/frontend/images/avatar_white.gif') }}"
                                                        alt="">
                                                @endif
                                            </div>
                                            <div class="mt-3">
                                                <strong>{{ $user_event->first_name }}
                                                    {{ $user_event->last_name }}</strong>
                                            </div>
                                        </td>
                                        <td class="custom-td">
                                            {{ $user_event->getEventDetails->event_name }}
                                        </td>
                                        <td class="custom-td">
                                            {{ $user_event->getEventDetails->event_location }}
                                        </td>
                                        <td class="custom-td">
                                            {{ Carbon\Carbon::parse($user_event->getEventDetails->start_date)->format('d F Y') }}
                                            to
                                            {{ Carbon\Carbon::parse($user_event->getEventDetails->end_date)->format('d F Y') }}
                                        </td>

                                        <td class="custom-td">
                                            <a href="javascript:void();" style="pointer-events: none;border-radius:20px"
                                                class="
                                                @if ($user_event->payment_status == 'success') btn btn-success
                                                @elseif($user_event->payment_status == 'pending')
                                                btn btn-warning
                                                @elseif($user_event->payment_status == 'cancel')
                                                btn btn-danger
                                                @elseif($user_event->payment_status == 'failed')
                                                btn btn-danger @endif 
                                                btn-icon-split">
                                                <span class="text">{{ ucfirst($user_event->payment_status) }}</span>
                                            </a>
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="{{ route('admin.event.details', $user_event->uuid) }}"
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
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#event').select2();
            $('#year').select2();
            $('#month').select2();
            $('#event_table').DataTable({
                "columnDefs": [{
                    "width": "5%",
                    "targets": 5
                }, {
                    "width": "20%",
                    "targets": 0
                }, {
                    "width": "10%",
                    "targets": 3
                }],
            });
            $('#summery_table').DataTable({
                searching: false,
                ordering: false,
            });
        });
    </script>
@endpush
