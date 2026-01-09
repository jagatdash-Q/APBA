@extends('dashboard.layouts.master')
@section('title', __('Member Dashboard'))
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
                <h3>{{ __('Members Dashboard') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    {{ __('Members Dashboard') }}
                </small>

            </div>
            @if (Auth::user()->hasPermission('member_management-create'))
                <div id="accordion" class="mb-2">
                    <div class="card border-left-primary shadow h-100">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-secondary" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    Upload Members Excel File
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <form action="{{ route('admin.customer.upload') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="file" accept=".xls,.xlsx" required class="form-control-file"
                                            id="userlistfile" name="file">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <form action="{{ route('admin.member.dashboard') }}" method="GET">
                <div class="row mb-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="subscription_status">Subscription Status:</label>
                            <select name="subscription_status" class="form-control form-control-user"
                                id="subscription_status">
                                <option value="" selected>-Choose Subscription Status-</option>
                                <option value="a">Active</option>
                                <option value="p">Pending</option>
                                <option value="e">Expire</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="subscription_status">Year:</label>
                            <select name="year" class="form-control form-control-user" id="year">
                                <option value="">-Choose Year-</option>
                                @if (count($years) > 0)
                                    @foreach ($years as $year)
                                        @if ($year != 2219)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-1">
                        <button type="submit" class="btn btn-info float-right" name="filter" style="margin-top: 30px;">
                            {{ __('Filter') }}
                        </button>
                    </div>
                    <div class="col-1 pl-0">
                        <button type="submit" name="restore" class="btn btn-danger btn-circle btn-sm mr-1"
                            style="margin-top: 33px;">
                            <i class="fas fa-undo"></i>
                        </button>
                    </div>
                    <div class="col-2 pr-0">
                        <button type="submit" class="btn float-right" name="export" style="margin-top: 27px;">
                            <i class="fas fa-file-excel text-right" style="font-size:30px;color:green;"
                                title="Download data in Excel"></i>
                        </button>
                    </div>

                    <div class="col-2">
                        <a href="{{ route('admin.create.member') }}"
                            class="btn btn-primary float-left @if (!Auth::user()->hasPermission('member_management-create')) disabled @endif"
                            style="margin-top: 30px;">
                            {{ __('+ Create Member') }}
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="javascript:void();" style="pointer-events: none; background-color:purple;"
                            class="btn btn-secondary btn-icon-split">
                            <span class="text"> Total Subscription Amount: <b>S$ {{ $total_amount }}</b>
                            </span>
                        </a>
                    </div>

                </div>
            </form>
            <div class="row">
                <div class="col-md-12 my-2 d-flex justify-content-end">
                    <div style="display:flex;align-items:center; margin-right: 10px;">
                        <label class="mb-0 pr-1">Search:</label><input type="search" class="form-control" id="search"
                            placeholder="Search..." oninput="search(this.value)" aria-controls="user_datatable">
                    </div>
                </div>
            </div>
            <div class="table-responsive" id="append_data">
                @include('dashboard/customer-manager/member-card')
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
            // $('#member_table').DataTable({
            //     "bPaginate": false,
            //     "bInfo": false,
            //     "searching": false,
            //     "columnDefs": [{
            //         "width": "5%",
            //         "targets": 9
            //     }, {
            //         "width": "20%",
            //         "targets": 1
            //     }]
            // });

            $(document).on('click', '.pagination li a', function(event) {

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                event.preventDefault();

                var myurl = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];
                var search = $('#search').val();
                getMemberData(page, search);
            });
        });

        function search(value) {
            getMemberData(1, value);
        }

        function getMemberData(page, search) {
            $("#loader").css('display', 'block');
            $("body").addClass('disable-loader');

            $.ajax({
                    url: 'member/dashboard?page=' + page,
                    type: "get",
                    datatype: "html",
                    data: {
                        search: search
                    }
                })
                .done(function(data) {
                    $("#append_data").empty().html(data);
                    location.hash = page;
                    // $('html, body').animate({
                    //     scrollTop: $("#append_data").offset().top - 100
                    // });
                    $("#loader").css('display', 'none');
                    $("body").removeClass('disable-loader');
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    $("#loader").css('display', 'none');
                    $("body").removeClass('disable-loader');
                    alert('No response from server');
                });
        }

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
