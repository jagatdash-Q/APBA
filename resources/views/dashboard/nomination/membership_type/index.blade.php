@extends('dashboard.layouts.master')
@section('title', __('Manage Nomination Membership Type'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Manage Nomination Membership Type') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    {{ __('Manage Nomination Membership Type') }}
                </small>
            </div>
            <div class="card mb-5">
                <div class="card-header" style="font-size: 18px;">
                    Create Membership Type for Nomination
                </div>
                <form action="{{ route('admin.nomination.membership.type.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ Str::uuid()->toString() }}">
                    <input type="hidden" name="type" value="0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Membership Type<span id="danger">*</span></label>
                                <input type="text" class="form-control text-secondary"
                                    placeholder="Enter membership type" name="membership_type" id="membership_type"
                                    value="{{ old('membership_type') }}" required>
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
                                    <th class="custom-th">{{ __('Name') }}</th>
                                    <th class="custom-th">{{ __('Created Date') }}</th>
                                    <th class="custom-th">{{ __('Status') }}</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            @if (count($memberhip_type))
                                <tbody>
                                    @foreach ($memberhip_type as $type)
                                        <tr>
                                            <td>{{ $type->membership_type }}</td>
                                            <td> {{ Carbon\Carbon::parse($type->created_at)->format('d F Y') }}</td>
                                            <td>
                                                @if ($type->status == '0')
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
                                                            href="{{ route('admin.nomination.membership.type.edit', $type->uuid) }}"><i
                                                                class="material-icons" style="font-size: 15px;">edit</i>
                                                            Edit </a>
                                                        <form
                                                            action="{{ route('admin.nomination.membership.type.delete') }}"
                                                            method="POST"
                                                            id="delete_membership_type_form_{{ $type->id }}">
                                                            @method('delete')
                                                            @csrf
                                                            <input type="hidden" name="uuid" id="uuid"
                                                                value="{{ $type->uuid }}">
                                                            <a class="dropdown-item @if (!Auth::user()->hasPermission('nomination_management-delete')) disabled @endif"
                                                                href="javascript::void();"
                                                                onclick="deleteFunction('{{ $type->id }}')"><i
                                                                    class="material-icons"
                                                                    style="font-size: 15px;">delete</i> Delete
                                                            </a>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
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
                text: "You won't be able to revert this! This membership type will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete_membership_type_form_' + id).submit();
                }
            })
        }
    </script>
@endpush
