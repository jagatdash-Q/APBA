@extends('dashboard.layouts.master')
@section('title', __('View Member'))
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
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('View Member') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    @if ($nomination == null)
                        <a href="{{ route('admin.member.dashboard') }}">Member Dashboard</a> /
                    @else
                        @if ($type == 'election')
                        <a href="{{ route('admin.election.dashboard') }}">{{ __('Election Dashboard') }}</a> /
                            @if (isset($nomination->getNominationPositionDetails))
                                @if (isset($nomination->getNominationPositionDetails->getPosition))
                                    <a
                                        href="{{ route('admin.election.details', ['uuid' => $nomination->uuid]) }}">{{ $nomination->getNominationPositionDetails->getPosition->membership_position }}</a>
                                    /
                                @endif
                            @endif
                        @else
                        <a href="{{ route('admin.nomination.dashboard') }}">{{ __('Nomination Dashboard') }}</a> /
                            @if (isset($nomination->getPosition))
                                <a
                                    href="{{ route('admin.nomination.position.details', $nomination->uuid) }}">{{ $nomination->getPosition->membership_position }}</a>
                                /
                            @endif
                        @endif
                        @if ($type == 'election')
                            @if ($customer_nomination != null)
                                @if (isset($customer_nomination->getVotedMemberDetails))
                                    <a
                                        href="{{ route('admin.election.get.choosed.member.list', ['uuid' => $customer_nomination->voting_position_uuid, 'member_id' => $customer_nomination->member_id]) }}">
                                        {{ $customer_nomination->getVotedMemberDetails->user_name }}</a> /
                                @endif
                            @endif
                        @else
                            @if ($customer_nomination != null)
                                @if (isset($customer_nomination->getMemberName))
                                    <a
                                        href="{{ route('customer.nomination.list', [$nomination->uuid, $customer_nomination->getMemberName->id]) }}">
                                        {{ $customer_nomination->getMemberName->user_name }}</a> /
                                @endif
                            @endif
                        @endif
                    @endif
                    {{ $member_details->user_name }}
                </small>
            </div>
            <div id="accordion" class="accordion-sort">
                {{-- member info --}}
                <div class="card mb-2 main-container">
                    <div class="d-flex align-items-center">
                        <div class="card-header w-100 mr-3 collapsed" id="headingTwo" data-toggle="collapse"
                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <h4 class="m-0"><span id="member_info" name="member_info">Member Info</span></h4>
                        </div>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label for="member_name"> Full Name : <b>{{ $member_details->user_name }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> First Name : <b>{{ $member_details->first_name }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Last Name : <b>{{ $member_details->last_name }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Email : <b>{{ $member_details->email }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Country : <b>{{ $member_details->country }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Email Verification Status :
                                        <b>{{ $member_details->is_verify_email == '0' ? 'Not Verified' : 'Verified' }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Registered On :
                                        <b>
                                            {{ Carbon\Carbon::parse($member_details->created_at)->format('d F Y') }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Registered From :
                                        <b>
                                            {{ $member_details->register_by == 'i' ? 'Excel sheet' : 'Registration' }}</b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Subscription Type :
                                        <b>
                                            @if (isset($member_details->getActiveSubscriptionDetails))
                                                {{ $member_details->getActiveSubscriptionDetails->membership_name }}
                                            @endif
                                        </b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Subscription Expire On :
                                        <b>
                                            @if (isset($member_details->getActiveSubscriptionDetails))
                                                @if ($member_details->getActiveSubscriptionDetails->membership_plan != 'lifetime')
                                                    @if ($member_details->active_subscription_expired_on != null)
                                                        {{ Carbon\Carbon::parse($member_details->active_subscription_expired_on)->format('d F Y') }}
                                                    @endif
                                                @else
                                                    LifeTime
                                                @endif
                                            @endif
                                        </b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Nomination :
                                        <b>
                                            {{ ucfirst($member_details->nomination) }}
                                        </b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Social Media Link :
                                        <b><a href="{{ $member_details->social_media_link }}"
                                                target="_blank">{{ $member_details->social_media_link }}</a></b></label>
                                </div>
                                <div class="col-4">
                                    <label for="member_name"> Subscription Status :

                                        @if ($member_details->current_subscription_status == 'a')
                                            <a href="javascript:void();" style="pointer-events: none;"
                                                class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Active</span>
                                            </a>
                                        @elseif($member_details->current_subscription_status == 'p')
                                            <a href="javascript:void();" style="pointer-events: none;"
                                                class="btn btn-warning btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">Pending</span>
                                            </a>
                                        @elseif($member_details->current_subscription_status == 'e')
                                            <a href="javascript:void();" style="pointer-events: none;"
                                                class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                </span>
                                                <span class="text">Expire</span>
                                            </a>
                                        @endif
                                    </label>
                                </div>
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <img src="{{ $member_details->profile_pic == null ? asset('assets/frontend/images/avatar_white.gif') : asset('uploads/profile_pic/' . $member_details->profile_pic) }}"
                                        height="100px" width="auto"
                                        @if ($member_details->profile_pic == null) style="background:grey;" @endif>
                                </div>
                                @if ($member_details->is_verify_email == '0')
                                    <div class="col-4">
                                        <form action="{{ route('admin.resend.email') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="customer_id" value="{{ $member_details->id }}">
                                            <button class="btn btn-success btn-icon-split" type="submit">
                                                <span class="icon text-white-50">
                                                    <i class="fab fa-telegram-plane"></i>
                                                </span>
                                                <span class="text">Resend Verification Email</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Subscription --}}
                <div class="card mb-2 main-container">
                    <div class="d-flex align-items-center">
                        <div class="card-header w-100 mr-3 collapsed" id="headingTwo" data-toggle="collapse"
                            data-target="#collapseSubscription" aria-expanded="false" aria-controls="collapseSubscription">
                            <h4 class="m-0"><span id="member_info" name="member_info">Subscription History</span></h4>
                        </div>
                    </div>
                    <div id="collapseSubscription" class="collapse" aria-labelledby="headingTwo"
                        data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Subscription Type</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Subscription Get From</th>
                                                <th scope="col">Expired On</th>
                                                <th scope="col">Created On</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($member_details->getSubscriptionHistory))
                                                @php
                                                    $count = 1;
                                                @endphp
                                                @if (count($member_details->getSubscriptionHistory))
                                                    @foreach ($member_details->getSubscriptionHistory as $subscription)
                                                        <tr>
                                                            <th scope="row">{{ $count }}</th>
                                                            <td>
                                                                @if (isset($subscription->getMembershipDetails))
                                                                    {{ $subscription->getMembershipDetails->membership_name }}
                                                                @endif
                                                            </td>
                                                            <td>S$ {{ $subscription->amount }}</td>
                                                            <td>{{ ucwords($subscription->subscription_in) }}</td>
                                                            <td>
                                                                @if ($subscription->subscription_expired_on != null)
                                                                    {{ Carbon\Carbon::parse($subscription->subscription_expired_on)->format('d F Y') }}
                                                                @endif

                                                            </td>
                                                            <td>{{ Carbon\Carbon::parse($subscription->created_at)->format('d F Y') }}
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $count++;
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
                {{-- Payment History --}}
                <div class="card mb-2 main-container">
                    <div class="d-flex align-items-center">
                        <div class="card-header w-100 mr-3 collapsed" id="headingTwo" data-toggle="collapse"
                            data-target="#collapsePaymentHistory" aria-expanded="false"
                            aria-controls="collapsePaymentHistory">
                            <h4 class="m-0"><span id="member_info" name="member_info">Payment History</span></h4>
                        </div>
                    </div>
                    <div id="collapsePaymentHistory" class="collapse" aria-labelledby="headingTwo"
                        data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Subscription Type</th>
                                                <th scope="col">Payment Status</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Payment In</th>
                                                <th scope="col">Payment Mode</th>
                                                <th scope="col">Created On</th>
                                                <th scope="col">Payment Response</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($member_details->getPaymentHistory))
                                                @php
                                                    $sl = 1;
                                                @endphp
                                                @if (count($member_details->getPaymentHistory))
                                                    @foreach ($member_details->getPaymentHistory as $payment)
                                                        <tr>
                                                            <th scope="row">{{ $sl }}</th>
                                                            <td>
                                                                @if (isset($payment->getMembershipDetails))
                                                                    {{ $payment->getMembershipDetails->membership_name }}
                                                                @endif
                                                            </td>
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

                                                            <td>{{ Carbon\Carbon::parse($payment->created_at)->format('d F Y') }}
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
