    <table class="table table-bordered m-a-0" id="member_table">
        <thead class="dker">
            <tr>
                <th class="custom-th">{{ __('#ID') }}</th>
                <th class="custom-th" style="width:35%">{{ __('Member Name') }}</th>
                {{-- <th class="custom-th">{{ __('Email') }}</th> --}}
                <th class="custom-th">{{ __('Email verification status') }}</th>
                <th class="custom-th">{{ __('Nomination') }}</th>
                <th class="custom-th">{{ __('Subscription Type') }}</th>
                <th class="custom-th">{{ __('Subscription Amount') }}</th>
                <th class="custom-th">{{ __('Subscription Status') }}</th>
                <th class="custom-th">{{ __('Subscription Expire On') }}</th>
                <th class="text-center" style="width:5%;">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @if (count($members) > 0)
                @php
                    // $count = 1;
                    $count = $members->perPage() * ($members->currentPage() - 1) + 1;
                @endphp
                @foreach ($members as $member)
                    <tr>
                        <td class="custom-td">
                            {{-- {{ $count }} --}}
                            {{ $member->id }}
                        
                        </td>


                        <td class="custom-td">
                            <div class="avatar avatar-md mr-3 mt-1 float-left">
                                @if ($member->profile_pic != null)
                                    <img src="{{ asset('uploads/profile_pic/' . $member->profile_pic) }}"
                                        alt="">
                                @else
                                    <img src="{{ asset('/assets/frontend/images/avatar_white.gif') }}" alt="">
                                @endif
                            </div>
                            <div class="mt-2">
                                <div>
                                    <strong>{{ $member->user_name }}
                                      </strong>
                                </div>
                                <small style="color:#2979ff !important;">{{ $member->email }}</small>
                            </div>
                        </td>
                        {{-- <td class="custom-td">
                            {{ $member->email }}
                        </td> --}}
                        <td class="custom-td">
                            {{ $member->is_verify_email == '0' ? 'No' : 'Yes' }}
                        </td>
                        <td class="custom-td">
                            {{ $member->nomination }}
                        </td>
                        <td class="custom-td">
                            @if (isset($member->getActiveSubscriptionDetails))
                                {{ $member->getActiveSubscriptionDetails->membership_name }}
                            @endif
                        </td>
                        <td class="custom-td">
                            @if ($member->amount != null)
                                S$
                            @endif{{ $member->amount }}
                        </td>
                        <td class="custom-td">
                            @if ($member->current_subscription_status == 'a')
                                <a href="javascript:void();" style="pointer-events: none;"
                                    class="btn btn-success btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <span class="text">Active</span>
                                </a>
                            @elseif($member->current_subscription_status == 'p')
                                <a href="javascript:void();" style="pointer-events: none;"
                                    class="btn btn-warning btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                    <span class="text">Pending</span>
                                </a>
                            @elseif($member->current_subscription_status == 'e')
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
                            @if (isset($member->getActiveSubscriptionDetails))
                                @if ($member->getActiveSubscriptionDetails->membership_plan != 'lifetime')
                                    @if ($member->active_subscription_expired_on != null)
                                        {{ Carbon\Carbon::parse($member->active_subscription_expired_on)->format('d F Y') }}
                                    @endif
                                @else
                                    <a href="javascript:void();" style="pointer-events: none;"
                                        class="btn btn-success btn-icon-split">
                                        <span class="text"> LifeTime
                                        </span>
                                    </a>
                                @endif
                            @endif
                        </td>
                        <td>
                            <div style="text-align:center;display:flex;">
                                <a href="{{ route('admin.view.member', $member->id) }}"
                                    class="btn btn-primary btn-circle btn-sm mr-1 @if (!Auth::user()->hasPermission('member_management-read')) disabled @endif">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.edit.member', $member->id) }}"
                                    class="btn btn-info btn-circle btn-sm @if (!Auth::user()->hasPermission('member_management-update')) disabled @endif">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @php
                        $count++;
                    @endphp
                @endforeach
                @else
                <tr>
                    <td colspan="9" style="color: red;text-align:center;">
                        No records found
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    {!! $members->links('vendor.pagination.bootstrap-5') !!}
