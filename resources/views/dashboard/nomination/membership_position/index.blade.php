@extends('dashboard.layouts.master')
@section('title', __('Manage Nomination Membership Position'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Manage Nomination Membership Position') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home /
                    </a>
                    {{ __('Manage Nomination Membership Position') }}
                </small>
            </div>
            <div class="card mb-5">
                <div class="card-header" style="font-size: 18px;">
                    Create Membership Position for Nomination
                </div>
                <form action="{{ route('admin.nomination.membership.position.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ Str::uuid()->toString() }}">
                    <input type="hidden" name="type" value="0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="last_name">Membership Type<span
                                        id="danger">*</span></label>
                                <span class="pr-field"><select class="form-control custom_select"
                                        name="membership_type_uuid" id="membership_type_uuid" required>
                                        <option value="" selected>-Please select-</option>
                                        @if (count($memberhip_type))
                                            @foreach ($memberhip_type as $type)
                                                <option value="{{ $type->uuid }}">{{ $type->membership_type }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </span>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Membership Position<span id="danger">*</span></label>
                                <input type="text" class="form-control text-secondary"
                                    placeholder="Enter membership position" name="membership_position"
                                    id="membership_position" value="{{ old('membership_position') }}" required>
                            </div>
                        </div>
                    </div>
                    <div id="end-content">
                        <div class="col-md-12">
                            <div class="form-group row" style="margin-top: 10px;padding-bottom: 5px;">
                                <button class="btn btn-success" type="submit" id="submit_btn" style="margin-left:20px;">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <div class="card">
                <div class="card-header" style="font-size: 18px;">
                    Membership Type List
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered m-a-0" id="nomination_membership_type">
                            <thead class="dker">
                                <tr>
                                    <th class="custom-th">{{ __('Membership Type Name') }}</th>
                                    <th class="custom-th">{{ __('Membership Postion Name') }}</th>
                                    <th class="custom-th">{{ __('Created Date') }}</th>
                                    <th class="custom-th">{{ __('Status') }}</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($memberhip_position))
                                    @foreach ($memberhip_position as $position)
                                        <tr>
                                            <td>{{ $position->getMembershipType->membership_type }}</td>
                                            <td>{{ $position->membership_position }}</td>
                                            <td> {{ Carbon\Carbon::parse($position->created_at)->format('d F Y') }}</td>
                                            <td>
                                                @if ($position->status == '0')
                                                    In Active
                                                @else
                                                    Active
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown float-right mt-2 mb-2">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item @if (!Auth::user()->hasPermission('nomination_management-update')) disabled @endif"
                                                            href="{{ route('admin.nomination.membership.position.edit', $position->uuid) }}"><i
                                                                class="material-icons" style="font-size: 15px;">edit</i>
                                                            Edit </a>
                                                        <form
                                                            action="{{ route('admin.nomination.membership.position.delete') }}"
                                                            method="POST"
                                                            id="delete_membership_position_form_{{ $position->id }}">
                                                            @method('delete')
                                                            @csrf
                                                            <input type="hidden" name="uuid" id="uuid"
                                                                value="{{ $position->uuid }}">
                                                            <a class="dropdown-item @if (!Auth::user()->hasPermission('nomination_management-delete')) disabled @endif" href="javascript::void();"
                                                                onclick="deleteFunction('{{ $position->id }}')"><i
                                                                    class="material-icons"
                                                                    style="font-size: 15px;">delete</i> Delete
                                                            </a>
                                                        </form>
                                                    </div>
                                                </div>
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
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#nomination_membership_type').DataTable({
                responsive: false,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                },
                bInfo: false,
            });
        });
        const deleteFunction = (id) => {
            Swal.fire({
                title: 'Are you sure to delete?',
                text: "You won't be able to revert this! This membership position will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete_membership_position_form_' + id).submit();
                }
            })
        }
    </script>
@endpush
