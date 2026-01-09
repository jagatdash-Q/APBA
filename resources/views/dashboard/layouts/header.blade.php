@php
    function readMoreHelper($story_desc, $chars = 100)
    {
        if (strlen($story_desc) > $chars) {
            $story_desc = substr($story_desc, 0, $chars);
            $story_desc = $story_desc . ' ...';
        }
        return $story_desc;
    }
@endphp
<div class="app-header white box-shadow navbar-md" style="    margin-top: -25px;">

    <div class="navbar">

        <div class="navbar-item pull-left h5" ng-bind="$state.current.data.title" id="pageTitle"></div>

        <!-- navbar right -->
        {{-- <ul class="nav navbar-nav pull-right">
            <?php
            $alerts = count(Helper::webmailsAlerts()) + count(Helper::eventsAlerts());
            ?>
            @if ($alerts > 0)
                <li class="nav-item dropdown pos-stc-xs">
                    <a class="nav-link" href data-toggle="dropdown">
                        <i class="material-icons">&#xe7f5;</i>
                        @if ($alerts > 0)
                            <span class="label label-sm up warn">{{ $alerts }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu pull-right w-xl animated fadeInUp no-bg no-border no-shadow">
                        <div class="box dark">
                            <div class="box p-a scrollable maxHeight320">
                                <ul class="list-group list-group-gap m-a-0">
                                    @foreach (Helper::webmailsAlerts() as $webmailsAlert)
                                        <li class="list-group-item lt box-shadow-z0 b">
                                            <span class="clear block">
                                                <small>{{ $webmailsAlert->from_name }}</small><br>
                                                <a href="{{ route('webmailsEdit', ['id' => $webmailsAlert->id]) }}"
                                                    class="text-primary">{{ $webmailsAlert->title }}</a>
                                                <br>
                                                <small class="text-muted">
                                                    {{ date('d M Y  h:i A', strtotime($webmailsAlert->date)) }}
                                                </small>
                                            </span>
                                        </li>
                                    @endforeach
                                    @foreach (Helper::eventsAlerts() as $eventsAlert)
                                        <li class="list-group-item lt box-shadow-z0 b">
                                            <span class="clear block">
                                                <a href="{{ route('calendarEdit', ['id' => $eventsAlert->id]) }}"
                                                    class="text-primary">{{ $eventsAlert->title }}</a>
                                                <br>
                                                <small class="text-muted">
                                                    @if ($eventsAlert->type == 3 || $eventsAlert->type == 2)
                                                        {{ date('d M Y  h:i A', strtotime($eventsAlert->start_date)) }}
                                                    @else
                                                        {{ date('d M Y', strtotime($eventsAlert->start_date)) }}
                                                    @endif
                                                </small>
                                            </span>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            @endif
            <li class="nav-item dropdown" style="width: 50px">
            <a class="nav-link clear" href data-toggle="dropdown" style="width:50px; text-align:center;">
                    <span class="avatar w-24">
                        @if (Auth::user()->photo != '')
                        <img src="{{ url('').'/uploads/media/'. Helper::GetMediaDetails(Auth::user()->photo) }}"
                                alt="{{ Auth::user()->name }}" title="{{ Auth::user()->name }}">
                        @else
                            <img src="{{ asset('uploads/contacts/profile.jpg') }}" alt="{{ Auth::user()->name }}"
                                title="{{ Auth::user()->name }}">
                        @endif
                        <i class="on b-white bottom"></i>
                    </span>
                    <span style="position: absolute; right:5px; top: 18px; font-weight: bold;">{{ (Auth::user()->permissions_id != 3)? 'Admin' : 'Editor' }}</span>
                </a>
                <div class="dropdown-menu pull-right dropdown-menu-scale">
                    @if (Helper::GeneralWebmasterSettings('inbox_status'))
                        @if (@Auth::user()->permissionsGroup->inbox_status)
                            <a class="dropdown-item"
                                href="{{ route('webmails') }}"><span>{{ __('backend.siteInbox') }}</span>
                                @if (Helper::webmailsNewCount() > 0)
                                    <span class="label warn m-l-xs">{{ Helper::webmailsNewCount() }}</span>
                                @endif
                            </a>
                        @endif
                    @endif
                    @if (Auth::user()->permissions == 0 || Auth::user()->permissions == 1)
                        <a class="dropdown-item"
                            href="{{ route('usersEdit', Auth::user()->id) }}"><span>{{ __('backend.profile') }}</span></a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                        class="dropdown-item" href="{{ url('/logout') }}">{{ __('backend.logout') }}</a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>

            <li class="nav-item hidden-md-up">
                <a class="nav-link" data-toggle="collapse" data-target="#collapse">
                    <i class="material-icons">&#xe5d4;</i>
                </a>
            </li>
        </ul> --}}
        <!-- / navbar right -->

        <!-- navbar collapse -->
        {{-- <div class="collapse navbar-toggleable-sm nav-collapse" id="collapse"> --}}
        {{-- <div class="" id="collapse">
            
            <div class="dropdown notification-dropdown">
                <span class="notification-count">
                    @if (@Auth::user()->permissions_id == 3)
                        {{count($notification_list)}}
                    @else

                        @php
                            $sum = count($notification_list);
                            if(isset($notification_cron_list) && count($notification_cron_list) > 0) {
                                $sum +=  count($notification_cron_list) ;
                            }

                        @endphp

                        {{ $sum }}

                    @endif
                </span>
                <i class="fa fa-bell bellbtn"></i>
                <div class="dropdown-content-notification">
                    @if (count($notification_list) > 0)
                        @foreach ($notification_list as $notification)
                            <a class="content" href="{{ $notification->content_url }}">

                                <div class="notification-item">
                                    <p class="item-title">{{ $notification->message }}</p>
                                    @if ($notification->notification_type == 'reject')
                                        <p class="item-reject-msg">Reject reason  : {{ $notification->reject_remarks ? readMoreHelper($notification->reject_remarks,50) : '' }} </p>
                                    @endif
                                </div>

                            </a>
                            <hr style="margin-top: 0rem; margin-bottom: 0rem;">
                        @endforeach
                    @endif


                    @if (isset($notification_cron_list) && count($notification_cron_list) > 0)
                        @foreach ($notification_cron_list as $notification)
                            <a class="content" href="{{ $notification->content_url . '?data_model=noti_cron' }}">

                                <div class="notification-item">
                                    <p class="item-title">{{ $notification->message }}</p>
                                </div>

                            </a>
                            <hr style="margin-top: 0rem; margin-bottom: 0rem;">
                        @endforeach
                    @endif


                    <a class="btn btn-secondary btn-md" href="<?php echo url('/'); ?>/admin/notification/index"> View all
                    </a>

                </div>
            </div>
        </div> --}}
        <!-- / navbar collapse -->
        {{-- @if (Auth::user()->permissions_id == 3)
        <div style="position: absolute;right: 13%;top: 18%;"><button class="btn btn-primary ">{{  Helper::countryName(Auth::user()->region_id) }}</button></div>
        @endif --}}
    </div>
</div>

@push('after-scripts')
    <script>
        $(".notification-dropdown").click(function() {
            $(".dropdown-content-notification").css("display", "block");
            event.stopPropagation();
            // $(".dropdown-content-notification").toggle();
        });

        $('body').click(function() {
            $(".dropdown-content-notification").css("display", "none");
        });
    </script>
@endpush
