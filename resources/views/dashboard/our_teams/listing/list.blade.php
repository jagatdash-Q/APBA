@extends('dashboard.layouts.master')
@section('title', __('Our Teams Listing'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
    @include('dashboard.common.index')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('OurTeamsListing Page') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    <a href="{{ route('admin.our_teams') }}">{{ __('Our Teams Listing') }}</a>
                        @if (count($our_teams) == 0)
                            <a class="btn btn-fw primary btn-sm @if (!Auth::user()->hasPermission('our_team-create')) disabled @endif" href="javascript:function() { return false; }"
                                onclick="Swal.fire('','No Published Our Teams Page. Please Create Our Teams Page First.','warning')">
                                <i class="material-icons">&#xe145;</i>
                                &nbsp; {{ __('Add Our Teams Page') }}
                            </a>
                        @else
                            <a class="btn btn-primary float-right mt-2 mb-2 @if (!Auth::user()->hasPermission('our_team-create')) disabled @endif"
                                href="{{ route('admin.our_teams.list.create') }}">
                                <i class="material-icons">&#xe145;</i>
                                &nbsp; {{ __('Add Our Teams Listing Page') }}
                            </a>
                        @endif

                </small>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered m-a-0" id="our_team_listing_page">
                    <thead class="dker">
                        <tr>
                            <th class="custom-th"></th>
                            <th class="custom-th">{{ __('Page Name') }}</th>
                            <th class="custom-th">{{ __('Slug') }}</th>
                            <th class="custom-th">{{ __('Status') }}</th>
                            <th class="custom-th">{{ __(' Modified On') }}</th>
                            <th class="text-center" style="width:200px;">Action</th>
                        </tr>
                    </thead>
                    <tbody class="accordion-sort">
                        @foreach ($our_teams_list as $key => $teams_list)
                            @if ($teams_list != null)
                                <tr id="{{ $teams_list->id }}">
                                    <td class="custom-td">
                                        <img src="{{ asset('assets/dashboard/images/up-down-left-right-solid.svg') }}"
                                            height="20" width="20" alt="Image not avalible" />

                                    </td>
                                    <td class="custom-td">
                                        @if ($teams_list->ourTeamListingContent != null && count($teams_list->ourTeamListingContent) > 0)
                                            {{ strlen($teams_list->ourTeamListingContent[0]->page_name) > 22 ? substr($teams_list->ourTeamListingContent[0]->page_name, 0, 22) . '..' : $teams_list->ourTeamListingContent[0]->page_name }}
                                        @endif
                                    </td>
                                    <td class="custom-td">
                                        @if ($teams_list->ourTeamListingContent != null && count($teams_list->ourTeamListingContent) > 0)
                                            {{ $teams_list->ourTeamListingContent[0]->page_slug }}
                                        @endif
                                    </td>
                                    <td class="custom-td" class="text-center">
                                        @if ($teams_list->content_status == 1)
                                            <a href="javascript:void();" style="pointer-events: none;"
                                                class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Publish</span>
                                            @else
                                                <a href="javascript:void();" class="btn btn-warning btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </span>
                                                    <span class="text">Draft</span>
                                                </a>
                                        @endif
                                    </td>
                                    <td class="custom-td">
                                        @if ($teams_list != null)
                                            {{ Carbon\Carbon::parse($teams_list->updated_at)->format('d F Y') }}
                                        @endif
                                    </td>

                                    <td class="custom-td action-td">
                                        @php
                                            $url = url('') . '/admin/our-teams/list/edit/' . $teams_list->uid;
                                        @endphp

                                        <a href="{{ $url }}"
                                            class="btn btn-info btn-circle btn-sm mr-2 float-right  @if (!Auth::user()->hasPermission('our_team-update')) disabled @endif"><i
                                                class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="deleteListingDetailsPage('{{ $teams_list->id }}')"
                                            class="btn btn-danger btn-circle btn-sm  @if (!Auth::user()->hasPermission('our_team-delete')) disabled @endif">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- <div class="row">
                <div class="col-md-12 text-center">
                    <small class="text-muted inline m-t-sm m-b-sm">{{ __('Showing') }}
                        {{ $our_teams_list->firstItem() }}
                        -{{ $our_teams_list->lastItem() }} {{ __('Of') }}
                        <strong>{{ $our_teams_list->total() }}</strong> {{ __('records') }}</small>
                </div>
            </div> --}}
            {{-- <div style="margin-top:10px;">
                <div class="row">
                    <div class="col-md-12 text-center">
                        {{ $our_teams_list->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#our_team_listing_page').DataTable({
                responsive: false,
                paging: false,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                },
                bInfo: false,
            });
        });
    </script>
    <script type="text/javascript">
        // $("#checkAll").click(function() {
        //     $('input:checkbox').not(this).prop('checked', this.checked);
        // });
        $("#action").change(function() {
            if (this.value == "delete") {
                $("#submit_all").css("display", "none");
                $("#submit_show_msg").css("display", "inline-block");
            } else {
                $("#submit_all").css("display", "inline-block");
                $("#submit_show_msg").css("display", "none");
            }
        });

        let deleteListingDetailsPage = (id) => {
            Swal.fire({
                title: 'Do you want to delete the listing details page?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.our_teams.list.delete') }}",
                        type: 'post',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': id
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

        $(function() {
            // $("#our_team_listing_page").sortable({
            //     items: 'tr:not(tr:first-child)',
            //     cursor: 'pointer',
            //     axis: 'y',
            //     dropOnEmpty: false,
            //     start: function(e, ui) {
            //         ui.item.addClass("selected");
            //     },
            //     update: function(event, ui) {
            //         var content = $("#our_team_listing_page").sortable("toArray");
            //         const base_url = $('#base_url').val();
            //         var fd = new FormData();
            //         fd.append('data', JSON.stringify(content));

            //         $.ajax({
            //             url: "{{ route('admin.our_teams.sort') }}",
            //             contentType: false,
            //             processData: false,
            //             type: "post",
            //             data: fd,
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //             success: function(data) {
            //                 console.log('success');
            //             },
            //             error: function(data) {
            //                 console.log('error');
            //             },
            //         });
            //     },
            //     stop: function(e, ui) {
            //         const base_url = $('#base_url').val();
            //         ui.item.removeClass("selected");
            //         $(this).find("tr").each(function(index) {
            //             let html =
            //                 ` <img src="${base_url}/assets/dashboard/img/up-down-left-right-solid.svg" height="20" width="20" alt="Image not avalible" /> ` +
            //                 index;

            //             if (index > 0) {
            //                 if (index != 1) {
            //                     $(this).find("td").eq(0).html(html);
            //                 }
            //             }
            //         });
            //     }
            // });

            $(".accordion-sort").sortable({
                revert: true,
                items: 'tr',
                cursor: 'pointer',
                axis: 'y',
                dropOnEmpty: false,
                start: function(e, ui) {
                    ui.item.addClass("selected");
                },
            });

            $(".accordion-sort").on("sortstop", function(event, ui) {
                var content = $(".accordion-sort").sortable("toArray");
                const base_url = $('#base_url').val();
                var fd = new FormData();
                fd.append('data', JSON.stringify(content));
                console.log(content);
                $.ajax({
                    url: "{{ route('admin.our_teams.sort') }}",
                    contentType: false,
                    processData: false,
                    type: "post",
                    data: fd,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(data) {
                        console.log(data);
                    },
                });
            });

        });
    </script>
@endpush
