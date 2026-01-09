@extends('dashboard.layouts.master')
@section('title', __('Customer Nomination Details'))
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
                <h3>{{ __('Customer Nomination Details') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    <a href="{{ route('admin.nomination.dashboard') }}">{{ __('Nomination Dashboard') }}</a> /
                    <a href="{{ route('admin.nomination.position.details', $check_details->uuid) }}">
                        @if (isset($check_details->getPosition))
                            {{ $check_details->getPosition->membership_position }}
                        @endif
                    </a> /
                    @if (count($customer_nomination))
                        {{ $customer_nomination[0]->getMemberName->user_name }}
                    @endif
                </small>
            </div>

            <div class="card">
                <div class="card-header" style="font-size: 18px;">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="icon text-red-50 mr-2" style="color: blue;">
                                <i class="fas fa-fw fa-users"></i>
                            </span>Customer Nomination List

                        </div>
                        <div class="col-md-6 text-right">
                            <form action="{{ route('customer.nomination.export') }}" method="GET">
                                <input type="hidden" name="nomination_position_uuid" value="{{ $check_details->uuid }}">
                                <input type="hidden" name="member_id"
                                    value="{{ $customer_nomination[0]->getMemberName->id }}">
                                <button type="submit" class="btn">
                                    <i class="fas fa-file-excel text-right" style="font-size:30px;color:green;"
                                        title="Download data in Excel"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <ul>
                                <li>Nomination Start & End Date: <b>
                                        {{ isset($check_details->getNomination) == true ? Carbon\Carbon::parse($check_details->getNomination->start_date)->format('d F Y') : '' }}</b>
                                    to <b>
                                        {{ isset($check_details->getNomination) == true ? Carbon\Carbon::parse($check_details->getNomination->end_date)->format('d F Y') : '' }}</b>
                                </li>
                                <li>Nomination Name: <b>
                                        @if (isset($check_details->getNomination))
                                            {{ $check_details->getNomination->name }}
                                        @endif
                                    </b></li>
                                <li>Membership Type:
                                    <b>
                                        @if (isset($check_details->getPosition))
                                            {{ $check_details->getPosition->getMembershipType->membership_type }}
                                        @endif
                                    </b>
                                </li>
                                <li>Position: <b>
                                        @if (isset($check_details->getPosition))
                                            {{ $check_details->getPosition->membership_position }}
                                        @endif
                                    </b>
                                </li>
                                <li>Member Name: <b>
                                        @if (count($customer_nomination))
                                            {{ $customer_nomination[0]->getMemberName->user_name }}
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
                                @if (count($customer_nomination) > 0)
                                    @foreach ($customer_nomination as $member)
                                        <tr>
                                            <td class="custom-td">
                                                <div class="avatar avatar-md mr-3 mt-1 float-left">
                                                    @if ($member->getCustomer->profile_pic != null)
                                                        <img src="{{ asset('uploads/profile_pic/' . $member->getCustomer->profile_pic) }}"
                                                            alt="">
                                                    @else
                                                        <img src="{{ asset('/assets/frontend/images/avatar_white.gif') }}"
                                                            alt="">
                                                    @endif
                                                </div>
                                                <div class="mt-3">
                                                    <strong>{{ $member->getCustomer->user_name }}</strong>
                                                </div>
                                            </td>
                                            <td class="custom-td">
                                                {{ $member->getCustomer->email }}
                                            </td>
                                            <td class="custom-td">
                                                {{ $member->getCustomer->is_verify_email == '0' ? 'No' : 'Yes' }}
                                            </td>
                                            <td class="custom-td">
                                                {{ $member->getCustomer->nomination }}
                                            </td>
                                            <td class="custom-td">
                                                @if (isset($member->getCustomer->getActiveSubscriptionDetails))
                                                    {{ $member->getCustomer->getActiveSubscriptionDetails->membership_name }}
                                                @endif
                                            </td>
                                            <td class="custom-td">
                                                @if ($member->getCustomer->current_subscription_status == 'a')
                                                    <a href="javascript:void();" style="pointer-events: none;"
                                                        class="btn btn-success btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                        <span class="text">Active</span>
                                                    </a>
                                                @elseif($member->getCustomer->current_subscription_status == 'p')
                                                    <a href="javascript:void();" style="pointer-events: none;"
                                                        class="btn btn-warning btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-info-circle"></i>
                                                        </span>
                                                        <span class="text">Pending</span>
                                                    </a>
                                                @elseif($member->getCustomer->current_subscription_status == 'e')
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
                                                @if (isset($member->getCustomer->getActiveSubscriptionDetails))
                                                    @if ($member->getCustomer->getActiveSubscriptionDetails->membership_plan != 'lifetime')
                                                        {{ Carbon\Carbon::parse($member->getCustomer->active_subscription_expired_on)->format('d F Y') }}
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
                                                <a href="{{ route('admin.view.member', [$member->getCustomer->id, 'type' => 'nomination', 'position_uuid' => $check_details->uuid, 'member_id' => $customer_nomination[0]->getMemberName->id]) }}"
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
