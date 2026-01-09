  <!-- Page Wrapper -->
  <div id="wrapper">
      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

          <!-- Sidebar - Brand -->
          <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('adminHome') }}">
              <div class="sidebar-brand-icon rotate-n-15">
                  <i class="fas fa-laugh-wink"></i>
              </div>
              <div class="sidebar-brand-text mx-3">APBA Admin</div>
          </a>

          <!-- Divider -->
          <hr class="sidebar-divider my-0">

          <!-- Nav Item - Dashboard -->
          {{-- <li class="nav-item {{ Nav::isRoute('adminHome') }}">
              <a class="nav-link" href="{{ route('adminHome') }}">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>{{ __('Dashboard') }}</span></a>
          </li> --}}

          <!-- Divider -->
          <hr class="sidebar-divider">

          @if (Auth::user()->hasPermission('users-create') || Auth::user()->hasPermission('users-read') || Auth::user()->hasPermission('users-update')|| Auth::user()->hasPermission('users-delete'))
              <li class="nav-item {{ Nav::isRoute('admin.users.manage') }}">
                  <a class="nav-link" href="{{ route('admin.users.manage') }}">
                      <i class="fas fa-fw fa-user"></i>
                      <span>{{ __('User Management') }}</span>
                  </a>
              </li>
          @endif
          @if (Auth::user()->hasPermission('role-create') || Auth::user()->hasPermission('role-read') || Auth::user()->hasPermission('role-update')|| Auth::user()->hasPermission('role-delete'))
              <li class="nav-item {{ Nav::isRoute('admin.roles.manage') }}">
                  <a class="nav-link" href="{{ route('admin.roles.manage') }}">
                      <i class="fas fa-fw fa-wrench"></i>
                      <span>{{ __('Role Management') }}</span>
                  </a>
              </li>
          @endif
          @if (Auth::user()->hasPermission('content_management-create') || Auth::user()->hasPermission('content_management-read') || Auth::user()->hasPermission('content_management-update')|| Auth::user()->hasPermission('content_management-delete'))
              <li class="nav-item {{ Nav::isRoute('admin.contents.manage') }}">
                  <a class="nav-link" href="{{ route('admin.contents.manage') }}">
                      <i class="fas fa-folder"></i>
                      <span>{{ __('Content Management') }}</span>
                  </a>
              </li>
          @endif
          @if (Auth::user()->hasPermission('media_managers-create') || Auth::user()->hasPermission('media_managers-read') || Auth::user()->hasPermission('media_managers-update')|| Auth::user()->hasPermission('media_managers-delete'))
              <li class="nav-item {{ Nav::isRoute('admin.media-manager') }}">
                  <a class="nav-link" href="{{ route('admin.media-manager') }}"
                      onclick="location.href='{{ route('admin.media-manager') }}'">
                      <span class="nav-icon">
                          <i class="material-icons">perm_media</i>
                      </span>
                      <span class="nav-text">{{ __('Media Manager') }}</span>
                  </a>
              </li>
          @endif
          @if (Auth::user()->hasPermission('member_management-create') || Auth::user()->hasPermission('member_management-read') || Auth::user()->hasPermission('member_management-update')|| Auth::user()->hasPermission('member_management-delete'))
              <li class="nav-item {{ Nav::isRoute('admin.member.dashboard') }}">
                  <a class="nav-link" href="{{ route('admin.member.dashboard') }}">
                      <i class="fas fa-fw fa-users"></i>
                      <span>{{ __('Members Dashboard') }}</span>
                  </a>
              </li>
          @endif
          @if (Auth::user()->hasPermission('our_team-create') || Auth::user()->hasPermission('our_team-read') || Auth::user()->hasPermission('our_team-update')|| Auth::user()->hasPermission('our_team-delete'))
              <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                      aria-expanded="true" aria-controls="collapsePages">
                      <i class="fas fa-user-friends"></i>
                      <span>Our Teams</span>
                  </a>
                  <div id="collapsePages" class="collapse" aria-labelledby="headingPages"
                      data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                          <h6 class="collapse-header">Our Teams Screens:</h6>
                          <a class="collapse-item {{ Nav::isRoute('admin.our_teams') }}"
                              href="{{ route('admin.our_teams') }}">Our Teams</a>
                          <a class="collapse-item {{ Nav::isRoute('admin.our_teams.category') }}"
                              href="{{ route('admin.our_teams.category') }}">Our Teams Categories</a>
                          <a class="collapse-item {{ Nav::isRoute('admin.our_teams.list') }}"
                              href="{{ route('admin.our_teams.list') }}">Our Teams Listing</a>
                      </div>
                  </div>
              </li>
          @endif
          @if (Auth::user()->hasPermission('event_management-create') || Auth::user()->hasPermission('event_management-read') || Auth::user()->hasPermission('event_management-update')|| Auth::user()->hasPermission('event_management-delete'))
              <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEvents"
                      aria-expanded="true" aria-controls="collapseEvents">
                      <i class="fas fa-calendar-alt"></i>
                      <span>Manage Events</span>
                  </a>
                  <div id="collapseEvents" class="collapse" aria-labelledby="headingPages"
                      data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                          <h6 class="collapse-header">Events:</h6>
                          <a class="collapse-item {{ Nav::isRoute('admin.manage.event.dashboard') }}"
                              href="{{ route('admin.manage.event.dashboard') }}">Dashboard</a>
                          <a class="collapse-item {{ Nav::isRoute('admin.manage.events') }}"
                              href="{{ route('admin.manage.events') }}">Manage Events</a>
                          <a class="collapse-item {{ Nav::isRoute('admin.manage.event.workshops') }}"
                              href="{{ route('admin.manage.event.workshops') }}">Manage Event Workshops</a>
                          <a class="collapse-item {{ Nav::isRoute('admin.survey.certificate.dashboard') }}"
                              href="{{ route('admin.survey.certificate.dashboard') }}">Survey Dashboard</a>
                          <a class="collapse-item {{ Nav::isRoute('admin.certificate.attributes') }}"
                              href="{{ route('admin.certificate.attributes') }}">Certificate Attributes</a>
                      </div>
                  </div>
              </li>
          @endif
          @if (Auth::user()->hasPermission('news_management-create') || Auth::user()->hasPermission('news_management-read') || Auth::user()->hasPermission('news_management-update')|| Auth::user()->hasPermission('news_management-delete'))
              <li class="nav-item {{ Nav::isRoute('admin.manage.news') }}">
                  <a class="nav-link" href="{{ route('admin.manage.news') }}">
                      <i class="fas fa-newspaper"></i>
                      <span>{{ __('Manage News') }}</span>
                  </a>
              </li>
          @endif
          @if (Auth::user()->hasPermission('nomination_management-create') || Auth::user()->hasPermission('nomination_management-read') || Auth::user()->hasPermission('nomination_management-update')|| Auth::user()->hasPermission('nomination_management-delete'))
              <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNomination"
                      aria-expanded="true" aria-controls="collapseNomination">
                      <i class="fas fa-person-booth"></i>
                      <span>Manage Nomination</span>
                  </a>
                  <div id="collapseNomination" class="collapse" aria-labelledby="headingPages"
                      data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                          <h6 class="collapse-header">Nomination:</h6>
                          <a class="collapse-item {{ Nav::isRoute('admin.nomination.dashboard') }}"
                              href="{{ route('admin.nomination.dashboard') }}">Dashboard</a>
                          <a class="collapse-item {{ Nav::isRoute('admin.nomination.membership.type') }}"
                              href="{{ route('admin.nomination.membership.type') }}">Membership Type</a>
                          <a class="collapse-item {{ Nav::isRoute('admin.nomination.membership.position') }}"
                              href="{{ route('admin.nomination.membership.position') }}">Membership Positions</a>
                          <a class="collapse-item {{ Nav::isRoute('admin.nomination.content.manage') }}"
                              href="{{ route('admin.nomination.content.manage') }}">Nomination Content</a>
                      </div>
                  </div>
              </li>
          @endif
          @if (Auth::user()->hasPermission('election_management-create') || Auth::user()->hasPermission('election_management-read') || Auth::user()->hasPermission('election_management-update')|| Auth::user()->hasPermission('election_management-delete'))
              <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse"
                      data-target="#collapseElection" aria-expanded="true" aria-controls="collapseElection">
                      <i class="fas fa-vote-yea"></i>
                      <span>Manage Election</span>
                  </a>
                  <div id="collapseElection" class="collapse" aria-labelledby="headingPages"
                      data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                          <h6 class="collapse-header">Election:</h6>
                          <a class="collapse-item {{ Nav::isRoute('admin.election.dashboard') }}"
                              href="{{ route('admin.election.dashboard') }}">Dashboard</a>
                          {{-- <a class="collapse-item {{ Nav::isRoute('admin.nomination.membership.type') }}"
                        href="{{ route('admin.nomination.membership.type') }}">Membership Type</a>
                    <a class="collapse-item {{ Nav::isRoute('admin.nomination.membership.position') }}"
                        href="{{ route('admin.nomination.membership.position') }}">Membership Positions</a> --}}
                          <a class="collapse-item {{ Nav::isRoute('admin.election.content.manage') }}"
                              href="{{ route('admin.election.content.manage') }}">Election Content</a>
                      </div>
                  </div>
              </li>
          @endif
          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">

          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
              <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>

      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

          <!-- Main Content -->
          <div id="content">

              <!-- Topbar -->
              <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                  <!-- Sidebar Toggle (Topbar) -->
                  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                      <i class="fa fa-bars"></i>
                  </button>



                  <!-- Topbar Navbar -->
                  <ul class="navbar-nav ml-auto">

                      <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                      <li class="nav-item dropdown no-arrow d-sm-none">
                          <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-search fa-fw"></i>
                          </a>

                      </li>

                      <div class="topbar-divider d-none d-sm-block"></div>

                      <!-- Nav Item - User Information -->
                      <li class="nav-item dropdown no-arrow">
                          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span
                                  class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                              <figure class="img-profile rounded-circle avatar font-weight-bold"
                                  data-initial="{{ Auth::user()->name[0] }}"></figure>
                          </a>
                          <!-- Dropdown - User Information -->
                          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                              aria-labelledby="userDropdown">
                              {{-- <a class="dropdown-item" href="{{ route('websetting.index') }}">
                                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                  {{ __('Settings') }}
                              </a> --}}
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="#" data-toggle="modal"
                                  data-target="#logoutModal">
                                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                  {{ __('Logout') }}
                              </a>
                          </div>
                      </li>

                  </ul>

              </nav>
              <!-- End of Topbar -->

              <!-- Begin Page Content -->
              <div class="container">

                  @yield('main-content')
