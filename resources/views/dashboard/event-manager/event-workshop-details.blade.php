@extends('dashboard.layouts.master')
@section('title', __('Event Workshop Details'))
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

        #section_3_card_container table,
        #section_1_card_container table,
        th,
        td {
            border: 0px;
        }
    </style>
    {{-- @dd($event_reg_details) --}}
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Event Workshop Details') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    @if ($survey == null)
                        <a href="{{ route('admin.manage.event.dashboard') }}">Event Dashboard</a> /
                    @else
                        <a href="{{ route('admin.survey.certificate.dashboard') }}">{{ __('Survey Dashboard') }}</a> /
                        <a href="{{ route('admin.survey.certificate.view', $survey->uuid) }}">{{ $survey->name }}</a>/
                    @endif
                    {{ $event_reg_details->getEventDetails->event_name }}
                </small>
            </div>

            <div id="accordion" class="accordion-sort">
                {{-- Event info --}}
                <div class="card mb-2 mt-2 main-container">
                    <div class="d-flex align-items-center">
                        <div class="card-header w-100 mr-3 collapsed" id="headingTwo" data-toggle="collapse"
                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <h4 class="m-0"><span id="member_info" name="member_info">Event Info</span></h4>
                        </div>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="member_name">Event Name :
                                        <b>{{ $event_reg_details->getEventDetails->event_name }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name">Event Start & End Date :
                                        <b> {{ Carbon\Carbon::parse($event_reg_details->getEventDetails->start_date)->format('d F Y') }}
                                            -
                                            {{ Carbon\Carbon::parse($event_reg_details->getEventDetails->end_date)->format('d F Y') }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name">Event Location :
                                        <b>{{ $event_reg_details->getEventDetails->event_location }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name">Member Name : <b>{{ $event_reg_details->first_name }}
                                            {{ $event_reg_details->last_name }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name">Member Email : <b>{{ $event_reg_details->email }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name">Member Phone Number :
                                        <b>{{ $event_reg_details->contact_number == null ? 'Not Available' : '+' . $event_reg_details->phone_code . ' ' . $event_reg_details->contact_number }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name">Organisation Name :
                                        <b>{{ $event_reg_details->organisation_name == null ? 'Not Available' : $event_reg_details->organisation_name }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name">Organisation's Address :
                                        <b>{{ $event_reg_details->organisation_address == null ? 'Not Available' : $event_reg_details->organisation_address }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Member Type :
                                        <b>{{ $event_reg_details->customer_id == null ? 'Guest' : 'Registered Member' }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Total Amount :
                                        <b>S$ {{ $event_reg_details->total_amount }}</b></label>
                                </div>
                                @if (isset($event_reg_details->getEventRegistrationOptional))
                                    @if (count($event_reg_details->getEventRegistrationOptional) > 0)
                                        @foreach ($event_reg_details->getEventRegistrationOptional as $optional)
                                            @if (isset($optional->getOptionalDetails))
                                                <div class="col-4">
                                                    <label for="member_name">
                                                        {{ $optional->getOptionalDetails->activity_optional_name }} :
                                                        <b>S$
                                                            {{ $event_reg_details->customer_id == null ? $optional->getOptionalDetails->price_guest : $optional->getOptionalDetails->price_member }}</b></label>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                @endif

                                {{-- <div class="col-4">
                                    <label for="member_name"> Conference Registration Fee :
                                        <b>S$ {{ $event_reg_details->conference_registration_fee }}</b></label>
                                </div> --}}
                                {{-- <div class="col-4">
                                    <label for="member_name">Networking Dinner Fee :
                                        <b>S$ {{ $event_reg_details->networking_dinner_fee }}</b></label>
                                </div> --}}
                                <div class="col-4">
                                    <label for="member_name">Payment Status :
                                        <a href="javascript:void();" style="pointer-events: none;border-radius:20px"
                                            class="
                                                @if ($event_reg_details->payment_status == 'success') btn btn-success
                                                @elseif($event_reg_details->payment_status == 'pending')
                                                btn btn-warning
                                                @elseif($event_reg_details->payment_status == 'cancel')
                                                btn btn-danger
                                                @elseif($event_reg_details->payment_status == 'failed')
                                                btn btn-danger @endif 
                                                btn-icon-split">
                                            <span class="text">{{ ucfirst($event_reg_details->payment_status) }}</span>
                                        </a></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name">Mail Status :
                                        <a href="javascript:void();" style="pointer-events: none;border-radius:20px"
                                            class="@if (isset($event_reg_details->getEventRegMailStatus)) btn btn-success
                                            @else
                                            btn btn-danger @endif 
                                            btn-icon-split">
                                            <span class="text">
                                                @if (isset($event_reg_details->getEventRegMailStatus))
                                                    Sent
                                                @else
                                                    Not Sent
                                                @endif
                                            </span>
                                        </a></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Payment History --}}
                <div class="card mb-2 main-container">
                    <div class="d-flex align-items-center">
                        <div class="card-header w-100 mr-3 collapsed" id="headingTwo" data-toggle="collapse"
                            data-target="#collapsePaymentHistory" aria-expanded="false"
                            aria-controls="collapsePaymentHistory">
                            <h4 class="m-0"><span id="member_info" name="member_info">Payment History</span></h4>
                        </div>
                    </div>
                    <div id="collapsePaymentHistory" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Payment Status</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Payment In</th>
                                                <th scope="col">Payment Mode</th>
                                                <th scope="col">Created On</th>
                                                <th scope="col">Payment Response</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($event_reg_details->getPaymentHistory))
                                                @php
                                                    $sl = 1;
                                                @endphp
                                                @if (count($event_reg_details->getPaymentHistory))
                                                    @foreach ($event_reg_details->getPaymentHistory as $payment)
                                                        <tr>
                                                            <th scope="row">{{ $sl }}</th>
                                                            <td>
                                                                <a href="javascript:void();" style="pointer-events: none;"
                                                                    @if ($payment->payment_status == 'success') class="btn btn-success btn-icon-split"
                                                                    @elseif($payment->payment_status == 'pending')
                                                                    class="btn btn-warning btn-icon-split"
                                                                    @elseif($payment->payment_status == 'cancel')
                                                                    class="btn btn-danger btn-icon-split"
                                                                    @elseif($payment->payment_status == 'failed')
                                                                    class="btn btn-danger btn-icon-split" @endif>
                                                                    <span
                                                                        class="text">{{ ucfirst($payment->payment_status) }}</span>
                                                                </a>
                                                            </td>
                                                            <td>S$ {{ $payment->total_amount }}</td>
                                                            <td>{{ ucwords($payment->payment_for) }}</td>
                                                            <td>{{ ucwords($payment->payment_mode) }}</td>

                                                            <td>{{ Carbon\Carbon::parse($payment->created_at)->format('d F Y, h:i A') }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                @if ($payment->response == null)
                                                                    <a href="javascript:void();"
                                                                        style="pointer-events: none;"
                                                                        class="btn btn-light btn-icon-split">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                        <span class="text">Not Available</span>
                                                                    </a>
                                                                @else
                                                                    <a href="javascript:void(0);"
                                                                        onclick="paymentResponse({{ $payment->response }})"
                                                                        class="btn btn-primary btn-circle btn-sm">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $sl++;
                                                        @endphp
                                                    @endforeach

                                                @endif
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (isset($event_reg_details->getEventProgram))
                    @if (count($event_reg_details->getEventProgram) > 0)
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($event_reg_details->getEventProgram as $workshop_details)
                            {{-- Workshop info --}}
                            <div class="card mb-2 mt-2 main-container">
                                <div class="d-flex align-items-center">
                                    <div class="card-header w-100 mr-3 collapsed" id="headingTwo" data-toggle="collapse"
                                        data-target="#collapseWorkshop{{ $count }}" aria-expanded="false"
                                        aria-controls="collapseWorkshop{{ $count }}">
                                        <h4 class="m-0"><span id="member_info" name="member_info">Workshop Name :
                                                @if (isset($workshop_details->getWorkshopDetails->workshop_name))
                                                    {{ $workshop_details->getWorkshopDetails->workshop_name }}
                                                @endif
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                                <div id="collapseWorkshop{{ $count }}" class="collapse"
                                    aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label for="member_name">Program Name :
                                                    <b>
                                                        @if (isset($workshop_details->getWorkshopDetails))
                                                            {{ $workshop_details->getProgramDetails->program_name }}
                                                        @endif
                                                    </b></label>
                                            </div>
                                            <div class="col-4">
                                                <label for="member_name">Date :
                                                    <b>
                                                        @if (isset($workshop_details->getWorkshopDetails))
                                                            {{ Carbon\Carbon::parse($workshop_details->getProgramDetails->program_date)->format('d F Y') }}
                                                        @endif
                                                    </b></label>
                                            </div>
                                            <div class="col-2">
                                                <label for="member_name">Room :
                                                    <b>
                                                        @if (isset($workshop_details->getWorkshopDetails))
                                                            {{ $workshop_details->getProgramDetails->room_no }}
                                                        @endif
                                                    </b>
                                                </label>
                                            </div>
                                            <div class="col-2">
                                                <label for="member_name">Workshop :
                                                    <b>
                                                        @if (isset($workshop_details->getWorkshopDetails))
                                                            {{ $workshop_details->getProgramDetails->workshop_number }}
                                                        @endif
                                                    </b>
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <label for="member_name">Time :
                                                    <b>
                                                        @if (isset($workshop_details->getWorkshopDetails) && isset($workshop_details->getWorkshopDetails))
                                                            {{ Carbon\Carbon::parse($workshop_details->getProgramDetails->start_time)->format('h:i A') }}
                                                            -
                                                            {{ Carbon\Carbon::parse($workshop_details->getProgramDetails->end_time)->format('h:i A') }}
                                                        @endif
                                                    </b></label>
                                            </div>
                                            <div class="col-4">
                                                <label for="member_name">Price Member :
                                                    <b>
                                                        @if (isset($workshop_details->getWorkshopDetails))
                                                            S$
                                                            {{ $workshop_details->getProgramDetails->price_member }}
                                                        @endif
                                                    </b></label>
                                            </div>
                                            <div class="col-4">
                                                <label for="member_name">Price Guest :
                                                    <b>
                                                        @if (isset($workshop_details->getWorkshopDetails))
                                                            S$
                                                            {{ $workshop_details->getProgramDetails->price_guest }}
                                                        @endif
                                                    </b></label>
                                            </div>
                                            {{-- <div class="col-4">
                                                <label for="member_name"> Conference Registration Fee :
                                                    <b>S$ {{ $workshop_details->conference_registration_fee }}</b></label>
                                            </div>
                                            <div class="col-4">
                                                <label for="member_name">Networking Dinner Fee :
                                                    <b>S$ {{ $workshop_details->networking_dinner_fee }}</b></label>
                                            </div> --}}
                                            <div class="col-6">
                                                <label for="member_name">Program :
                                                    <b>
                                                        @if (isset($workshop_details->getWorkshopDetails))
                                                            {!! $workshop_details->getProgramDetails->program_desc !!}
                                                        @endif
                                                    </b></label>
                                            </div>
                                            <div class="col-6">
                                                <label for="member_name">Trainers :
                                                    <b>
                                                        @if (isset($workshop_details->getWorkshopDetails))
                                                            {!! $workshop_details->getProgramDetails->program_trainers !!}
                                                        @endif
                                                    </b></label>
                                            </div>
                                            @if (isset($workshop_details->getProgramDetails->survey))
                                                @if ($workshop_details->getProgramDetails->survey == 'yes')
                                                    <div class="col-4">
                                                        <label for="member_name">Survey Mail Status :
                                                            <a href="javascript:void();"
                                                                style="pointer-events: none;border-radius:20px"
                                                                class="@if (isset($workshop_details->getProgramDetails->getSurveyMailStatus)) btn btn-success
                                                        @else
                                                        btn btn-danger @endif 
                                                        btn-icon-split">
                                                                <span class="text">
                                                                    @if (isset($workshop_details->getProgramDetails->getSurveyMailStatus))
                                                                        Sent
                                                                    @else
                                                                        Not Sent
                                                                    @endif
                                                                </span>
                                                            </a></label>
                                                    </div>
                                                @else
                                                    <a href="javascript:void();"
                                                        style="pointer-events: none;border-radius:20px"
                                                        class="
                                                        btn btn-warning
                                                        btn-icon-split">
                                                        <span class="text">
                                                            Survey not created
                                                        </span>
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $count++;
                            @endphp
                        @endforeach
                    @endif
                @endif


            </div>
        </div>
    </div>

    <!-- payment response modal -->
    <div class="modal fade" id="paymentResModal" tabindex="-1" role="dialog" aria-labelledby="paymentResModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentResModalTitle">Payment Respose</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <pre id="append_res"></pre>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        const paymentResponse = (json) => {

            $('#append_res').html('');
            $('#paymentResModal').modal('show');

            if (typeof json != 'string') {
                json = JSON.stringify(json, undefined, 2);
            }
            json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            var data = json.replace(
                /("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g,
                function(match) {
                    var cls = 'number';
                    if (/^"/.test(match)) {
                        if (/:$/.test(match)) {
                            cls = 'key';
                        } else {
                            cls = 'string';
                        }
                    } else if (/true|false/.test(match)) {
                        cls = 'boolean';
                    } else if (/null/.test(match)) {
                        cls = 'null';
                    }
                    return '<span class="' + cls + '">' + match + '</span>';
                });
            $('#append_res').append(data);
        }
    </script>
@endpush
