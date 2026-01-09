@extends('dashboard.layouts.master')
@section('title', __('Customer Election Details'))
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
                <h3>{{ __('Customer Election Details') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    <a href="{{ route('admin.election.dashboard') }}">{{ __('Election Dashboard') }}</a> /
                    <a href="{{ route('admin.election.details', ['uuid' => $position_uuid]) }}">
                        @if ($election_details->getVotingPositionDetails != null)
                            @if ($election_details->getVotingPositionDetails->getNominationPositionDetails != null)
                                @if ($election_details->getVotingPositionDetails->getNominationPositionDetails->getPosition != null)
                                    {{ $election_details->getVotingPositionDetails->getNominationPositionDetails->getPosition->membership_position }}
                                @endif
                            @endif
                        @endif
                    </a> /
                    @if ($customer_details != null)
                        {{ $customer_details->user_name }}
                    @endif
                </small>
            </div>

            <div class="card">
                <div class="card-header" style="font-size: 18px;">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="icon text-red-50 mr-2" style="color: blue;">
                                <i class="fas fa-fw fa-users"></i>
                            </span>Customer Election List

                        </div>
                        <div class="col-md-6 text-right">
                            <form action="{{ route('customer.election.export') }}" method="GET">
                                <input type="hidden" name="voting_position_uuid"
                                value="{{ $election_details->voting_position_uuid }}">
                                <input type="hidden" name="member_id" value="{{ $customer_details->id }}">
                                <button type="submit" class="btn">
                                    <i class="fas fa-file-excel text-right" style="font-size:30px;color:green;"
                                        title="Download data in Excel"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <ul>
                                <li>Nomination Start & End Date: <b>
                                        @if ($election_details->getNominationDetails != null)
                                            {{ Carbon\Carbon::parse($election_details->getNominationDetails->start_date)->format('d F Y') }}
                                    </b> to <b>
                                        {{ Carbon\Carbon::parse($election_details->getNominationDetails->end_date)->format('d F Y') }}</b>
                                    @endif
                                </li>
                                <li>Nomination Name: <b>
                                        @if ($election_details->getNominationDetails != null)
                                            {{ $election_details->getNominationDetails->name }}
                                        @endif
                                    </b></li>
                                    <li>Membership Type: <b>
                                        @if ($election_details != null)
                                            @if (isset($election_details->getVotingPositionDetails))
                                                @if (isset($election_details->getVotingPositionDetails->getNominationPositionDetails))
                                                    @if (isset($election_details->getVotingPositionDetails->getNominationPositionDetails->getPosition))
                                                        @if (isset($election_details->getVotingPositionDetails->getNominationPositionDetails->getPosition->getMembershipType))
                                                            {{ $election_details->getVotingPositionDetails->getNominationPositionDetails->getPosition->getMembershipType->membership_type }}
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </b>
                                </li>
                                <li>Position: <b>
                                        @if ($election_details->getVotingPositionDetails != null)
                                            @if ($election_details->getVotingPositionDetails->getNominationPositionDetails != null)
                                                @if ($election_details->getVotingPositionDetails->getNominationPositionDetails->getPosition != null)
                                                    {{ $election_details->getVotingPositionDetails->getNominationPositionDetails->getPosition->membership_position }}
                                                @endif
                                            @endif
                                        @endif
                                    </b>
                                </li>
                                <li>Member Name: <b>
                                        @if ($customer_details != null)
                                            {{ $customer_details->user_name }}
                                        @endif
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
                                    <th class="custom-th">{{ __('Member Name') }}</th>
                                    <th class="custom-th">{{ __('Email') }}</th>
                                    <th class="custom-th">{{ __('Email verification status') }}</th>
                                    <th class="custom-th">{{ __('Nomination') }}</th>
                                    <th class="custom-th">{{ __('Subscription Type') }}</th>
                                    <th class="custom-th">{{ __('Subscription Status') }}</th>
                                    <th class="custom-th">{{ __('Subscription Expire On') }}</th>
                                    <th class="text-center" style="width:200px;">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if (count($customer_list) > 0)
                                    @foreach ($customer_list as $member)
                                        @if ($member->getCustomerDetails != null)
                                            <tr>
                                                <td class="custom-td">
                                                    <div class="avatar avatar-md mr-3 mt-1 float-left">
                                                        @if ($member->getCustomerDetails->profile_pic != '')
                                                            <img src="{{ asset('uploads/profile_pic/' . $member->getCustomerDetails->profile_pic) }}"
                                                                alt="">
                                                        @else
                                                            <img src="{{ asset('/assets/frontend/images/avatar_white.gif') }}"
                                                                alt="">
                                                        @endif
                                                    </div>
                                                    <div class="mt-3">
                                                        <strong>{{ $member->getCustomerDetails->user_name }}</strong>
                                                    </div>
                                                </td>
                                                <td class="custom-td">
                                                    {{ $member->getCustomerDetails->email }}
                                                </td>
                                                <td class="custom-td">
                                                    {{ $member->getCustomerDetails->is_verify_email == '0' ? 'No' : 'Yes' }}
                                                </td>
                                                <td class="custom-td">
                                                    {{ $member->getCustomerDetails->nomination }}
                                                </td>
                                                <td class="custom-td">
                                                    @if ($member->getCustomerDetails->getActiveSubscriptionDetails != null)
                                                        {{ $member->getCustomerDetails->getActiveSubscriptionDetails->membership_name }}
                                                    @endif
                                                </td>
                                                <td class="custom-td">
                                                    @if ($member->getCustomerDetails->current_subscription_status == 'a')
                                                        <a href="javascript:void();" style="pointer-events: none;"
                                                            class="btn btn-success btn-icon-split">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-check"></i>
                                                            </span>
                                                            <span class="text">Active</span>
                                                        </a>
                                                    @elseif($member->getCustomerDetails->current_subscription_status == 'p')
                                                        <a href="javascript:void();" style="pointer-events: none;"
                                                            class="btn btn-warning btn-icon-split">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-info-circle"></i>
                                                            </span>
                                                            <span class="text">Pending</span>
                                                        </a>
                                                    @elseif($member->getCustomerDetails->current_subscription_status == 'e')
                                                        <a href="javascript:void();" style="pointer-events: none;"
                                                            class="btn btn-danger btn-icon-split">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                            </span>
                                                            <span class="text">Expire</span>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="custom-td">
                                                    @if ($member->getCustomerDetails->getActiveSubscriptionDetails != null)
                                                        @if ($member->getCustomerDetails->getActiveSubscriptionDetails->membership_plan != 'lifetime')
                                                            {{ Carbon\Carbon::parse($member->getCustomerDetails->active_subscription_expired_on)->format('d F Y') }}
                                                        @else
                                                            <a href="javascript:void();" style="pointer-events: none;"
                                                                class="btn btn-success btn-icon-split">
                                                                <span class="text"> LifeTime
                                                                </span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td style="text-align:center;display:flex;">
                                                    <a href="{{ route('admin.view.member',[ $member->getCustomerDetails->id, 'type' => 'election', 'position_uuid' => $position_uuid, 'member_id' => $member_id]) }}"
                                                        class="btn btn-primary btn-circle btn-sm mr-1">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
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
                    "targets": 7
                }, {
                    "width": "20%",
                    "targets": 0
                }]
            });
        });
    </script>
@endpush
