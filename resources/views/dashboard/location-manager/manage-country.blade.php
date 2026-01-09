@extends('dashboard.layouts.master')
@section('title', __('Manage Countries'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Manage Countries Page') }}</h3>
                <small>
                    <button type="button" class="btn btn-primary float-right mt-2 mb-2" data-toggle="modal"
                        data-target="#AddCountryModal">
                        <i class="material-icons">&#xe145;</i>
                        &nbsp; {{ __('Add New Country') }}
                    </button>
                </small>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered m-a-0" id="manage_countries_table">
                    <thead class="dker">
                        <tr>
                            <th class="custom-th">{{ __('Country Name') }}</th>
                            <th class="custom-th">{{ __('Country Slug') }}</th>
                            <th class="custom-th">{{ __('Active') }}</th>
                            <th class="custom-th">{{ __('Created By') }}</th>
                            <th class="custom-th">{{ __('Created On') }}</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($country as $val)
                            <tr>
                                <td> {{ $val->name }} </td>
                                <td> {{ $val->slug }} </td>
                                <td> {{ $val->status == '0' ? 'No' : 'Yes' }} </td>
                                <td> {{ $val->getCreaterDetails != null ? $val->getCreaterDetails->name : '' }} </td>
                                <td> {{ \Carbon\Carbon::parse($val->start_date)->format('d F Y') }}</td>

                                <td>
                                    <div class="dropdown float-right mt-2 mb-2">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            <a class="dropdown-item" data-toggle="modal" data-target="#EditCountryModal"
                                                href="#" onclick="editCountry('{{ $val->id }}')"><i
                                                    class="material-icons" style="font-size: 15px;">&#xe3c9;</i> Edit </a>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                onclick="deleteCountry('{{ $val->id }}');"><i
                                                    class="fas fa-times"></i> Delete </a>
                                            {{-- @if ($val->status == '0')
                                                <a class="dropdown-item" href="#"><i class="fa fa-check"
                                                        aria-hidden="true" style="font-size: 15px;"></i> Publish </a>
                                            @else
                                                <a class="dropdown-item" href="#"><i class="fa fa-times"
                                                        aria-hidden="true" style="font-size: 15px;"></i> Draft </a>
                                            @endif --}}
                                        </div>
                                    </div>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <small class="text-muted inline m-t-sm m-b-sm">{{ __('Showing') }}
                        {{ $country->firstItem() }}
                        -{{ $country->lastItem() }} {{ __('Of') }}
                        <strong>{{ $country->total() }}</strong> {{ __('records') }}</small>
                </div>
            </div>
            <div style="margin-top:10px;">
                <div class="row">
                    <div class="col-md-12 text-center">
                        {{ $country->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="AddCountryModal" tabindex="-1" aria-labelledby="AddCountryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddCountryModalLabel">Add new country</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.create.country') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label">Country Name:</label>
                            <input type="text" class="form-control" id="recipient-name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Status:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="active_country"
                                    value="1" checked>
                                <label class="form-check-label" for="active_country">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="in_active_country"
                                    value="0">
                                <label class="form-check-label" for="in_active_country">In active</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="EditCountryModal" tabindex="-1" aria-labelledby="EditCountryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditCountryModalLabel">Update country</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.update.country') }}" method="post">
                        <input type="hidden" name="country_id" value="" id="country_id" />
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label">Country Name:</label>
                            <input type="text" class="form-control" id="country_name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Status:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="country_status"
                                    id="edit_active_country" value="1">
                                <label class="form-check-label" for="edit_active_country">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="country_status"
                                    id="edit_in_active_country" value="0">
                                <label class="form-check-label" for="edit_in_active_country">In active</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
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
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#manage_countries_table').DataTable({
                responsive: false,
                paging: false,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                },
                bInfo: false,
            });
        });

        let deleteCountry = (id) => {
            Swal.fire({
                title: 'Do you want to delete this country ?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.country.delete') }}",
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
                            }, 2000);
                        },
                        error: function(res) {
                            Swal.fire('Error!', 'Something went wrong please try after sometime',
                                'error');
                            setTimeout(function() {
                                location.reload(true);
                            }, 2000);
                        }
                    });
                }
            })
        }

        let editCountry = (id) => {
            $.ajax({
                url: "{{ route('admin.country.edit') }}",
                type: 'post',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': id
                },
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('#country_id').val(data.result.id);
                        if(data.result.status=='1'){
                            $('#edit_active_country').attr('checked',true);
                            // $('#edit_in_active_country').removeAttr('checked');
                        }else{
                            $('#edit_in_active_country').attr('checked',true);
                            // $('#edit_active_country').removeAttr('checked');
                        }
                        $('#country_name').val(data.result.name);
                        
                    } else {
                        Swal.fire('Error!', data.message, 'info')
                    }
                    
                },
                error: function(res) {
                    Swal.fire('Error!', 'Something went wrong please try after sometime',
                        'error');
                    
                }
            });
        }
    </script>
@endpush
