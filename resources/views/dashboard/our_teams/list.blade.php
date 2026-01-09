@extends('dashboard.layouts.master')
@section('title', __('Our Teams'))
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
    </style>
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Our Teams Page') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    <a href="{{ route('admin.our_teams') }}">{{ __('Our Teams') }}</a>
                </small>
                    <a href="{{ route('admin.our_teams.create') }}" class="btn btn-primary float-right mt-2 mb-2 @if (!Auth::user()->hasPermission('our_team-create')) disabled @endif">
                        {{ __('Add Our Teams') }}
                    </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered m-a-0 mt-5" id="our_team_table">
                    <thead class="dker">
                        <tr>
                            <th class="custom-th">{{ __('Page Name') }}</th>
                            <th class="custom-th">{{ __('Slug') }}</th>
                            <th class="custom-th">{{ __('Status') }}</th>
                            <th class="custom-th">{{ __(' Modified On') }}</th>
                            <th class="text-center" style="width:200px;">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    @if (count($OurTeams) > 0)
                        <tbody>

                            @foreach ($OurTeams as $OurTeam)
                                @if ($OurTeam != null)
                                    @php
                                        $our_team_id = $our_team_title = $page_name = $page_slug = $status = $modified_by = '';
                                        $modification_on = '';
                                        $our_team_id = $OurTeam->id;

                                        if ($OurTeam->teamContent != null) {
                                            $page_name = $OurTeam->teamContent->page_name;
                                            $page_slug = $OurTeam->teamContent->page_slug;
                                        }
                                        if ($OurTeam->userDetails != null) {
                                            $modified_by = $OurTeam->userDetails->name;
                                        }

                                        if ($OurTeam->language != null) {
                                            $OurTeam_language = $OurTeam->language->title;
                                        }

                                    @endphp
                                    <tr>
                                        <td class="custom-td">
                                            {{ strlen($page_name) > 22 ? substr($page_name, 0, 22) . '..' : $page_name }}
                                        </td>
                                        <td class="custom-td">
                                            {{ $page_slug }}
                                        </td>
                                        <td class="custom-td">
                                            @php
                                                if ($OurTeam->content_status == '1') {
                                                    echo '<a href="javascript:void();" style="pointer-events: none;" class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Active</span>
                                            </a>';
                                                } else {
                                                    echo '<a href="javascript:void();" class="btn btn-warning btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                        <span class="text">Draft</span>
                                    </a>';
                                                }
                                            @endphp
                                        </td>
                                        <td class="custom-td">
                                            @if ($OurTeam != null)
                                                {!! Carbon\Carbon::parse($OurTeam->updated_at)->format('d F Y') !!}
                                            @endif
                                        </td>
                                        <td class="custom-td action-td">
                                            @php
                                                $url = url('') . '/admin/our-teams/edit/' . $OurTeam->uid;
                                            @endphp
                                            <a href="{{ $url }}"
                                                class="btn btn-info btn-circle btn-sm mr-2 float-right  @if (!Auth::user()->hasPermission('our_team-update')) disabled @endif"><i
                                                    class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                onclick="deleteOurTeamsPage('{{ $OurTeam->uid }}')"
                                                class="btn btn-danger btn-circle btn-sm  @if (!Auth::user()->hasPermission('our_team-delete')) disabled @endif">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- .modal -->
                                    <div id="m-{{ $OurTeam->uid }}" class="modal fade" data-backdrop="true">
                                        <div class="modal-dialog" id="animate">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.our_teams.delete') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="uid" value="{{ $OurTeam->uid }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ __('backend.confirmation') }}</h5>
                                                    </div>
                                                    <div class="modal-body  p-lg">
                                                        <div>
                                                            {{ __('backend.confirmationDeleteMsg') }}
                                                        </div>
                                                        <div class="confirmation_content_design">
                                                            <strong>[
                                                                {{ strlen($page_name) > 22 ? substr($page_name, 0, 22) . '..' : $page_name }}
                                                                Page
                                                                ] </strong>
                                                        </div>

                                                        @if ($OurTeam->status == 1)
                                                            <ul class="warning-text-design">
                                                                <li>
                                                                    Deleting a publish page will be permanently deleted
                                                                    from
                                                                    our
                                                                    system , you can not recover it.
                                                                </li>
                                                                <li>
                                                                    The published page url may show 404 error.

                                                                </li>
                                                                <li>
                                                                    You may not able to access this page in frontend
                                                                    anymore.
                                                                </li>
                                                            </ul>
                                                        @else
                                                            <ul class="warning-text-design">
                                                                <li>
                                                                    This page will be permanently deleted from our
                                                                    system,
                                                                    you
                                                                    can not recover it.
                                                                </li>

                                                            </ul>
                                                        @endif

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn p-x-md dismiss-btn-design"
                                                            data-dismiss="modal">{{ __('backend.no') }}</button>
                                                        <button type="submit"
                                                            class="btn danger p-x-md">{{ __('backend.yes') }}</button>
                                                    </div>
                                                </form>
                                            </div><!-- /.modal-content -->
                                        </div>
                                    </div>
                                    <div id="m-DeleteWarning-{{ $OurTeam->uid }}" class="modal fade" data-backdrop="true">
                                        <div class="modal-dialog" id="animate">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ __('backend.confirmation') }}</h5>
                                                </div>
                                                <div class="modal-body p-lg">
                                                    <div>

                                                    </div>
                                                    <div class="confirmation_content_design">
                                                        <strong class="confirmation_content_design"> You would not be allow
                                                            to delete until you delete all our teams listing of country
                                                            !!</strong>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn  p-x-md dismiss-btn-design"
                                                        data-dismiss="modal">okay</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div>
                                    </div>
                                    <!-- / .modal -->
                                @endif
                            @endforeach

                        </tbody>
                    @endif
                </table>

            </div>
            @if (count($OurTeams) > 0)
                <footer class="dker p-a">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 text-right">
                            <small class="text-muted inline m-t-sm m-b-sm">Showing
                                {{ $OurTeams->firstItem() }}
                                -{{ $OurTeams->lastItem() }} of
                                <strong>{{ $OurTeams->total() }}</strong> records </small>
                        </div>
                        <div class="col-md-6 col-sm-6 text-right">
                            {!! $OurTeams->links() !!}
                        </div>
                    </div>
                </footer>
            @endif

            {{-- {{ Form::close() }} --}}


        </div>
    </div>
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#our_team_table').DataTable();
        });

        let deleteOurTeamsPage = (uid) => {
            Swal.fire({
                title: 'Do you want to delete the our teams page?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.our_teams.delete') }}",
                        type: 'post',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'uid': uid
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.status == 'success') {
                                Swal.fire('Success!', data.message, 'success');
                            } else {
                                Swal.fire('Error!', data.message, 'info')
                            }

                            setTimeout(function() {
                                location.reload(true);
                            }, 3000);


                        },
                        error: function(res) {
                            Swal.fire('Error!', 'Something went wrong please try after sometime',
                                'error');
                            setTimeout(function() {
                                location.reload(true);
                            }, 3000);
                        }
                    });
                }
            })
        }
    </script>
@endpush
