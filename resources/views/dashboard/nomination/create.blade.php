@extends('dashboard.layouts.master')
@section('title', __('Create Nomination'))
@section('content')
    @push('after-styles')
        <style>
            #nomination_list {
                display: none;
            }
        </style>
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Create Nomination') }}</h3>
            </div>
            <div class="card mb-4">
                <div class="card-header" style="font-size: 18px;">
                    <span class="icon text-red-50 mr-2" style="color: blue;">
                        <i class="fas fa-hourglass-start"></i>
                    </span>Nomination
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.nomination.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Nomination name<span id="danger">*</span></label>
                                            <input type="text" class="form-control text-secondary" name="nomination_name"
                                                id="nomination_name" value="{{ old('nomination_name') }}" required>
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label">Start Date<span id="danger">*</span></label>
                                            <input type="text" class="form-control text-secondary" name="start_date" onkeydown="event.preventDefault()" autocomplete="off"
                                                id="start_date" value="{{ old('start_date') }}" required>
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label">End Date<span id="danger">*</span></label>
                                            <input type="text" class="form-control text-secondary" name="end_date" onkeydown="event.preventDefault()" autocomplete="off"
                                                id="end_date" value="{{ old('end_date') }}" required>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label" for="last_name">Position (Multiple Select Option)<span
                                                    id="danger">*</span></label>
                                            <span class="pr-field"><select class="form-control custom_select"
                                                    name="membership_position_uuid[]" id="membership_position_uuid" multiple
                                                    required>
                                                    @if (count($memberhip_position))
                                                        @foreach ($memberhip_position as $position)
                                                            <option value="{{ $position->uuid }}">
                                                                {{ $position->membership_position }}</option>
                                                        @endforeach
                                                    @endif
                                                </select></span>
                                        </div>
                                    </div>
                                </div>
                                <div id="end-content">
                                    <div class="col-md-12">
                                        <div class="form-group row" style="margin-top: 10px;padding-bottom: 5px;">
                                            <button class="btn btn-success" type="submit" id="submit_btn"
                                                style="margin-left:20px;">
                                                Start
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4" id="nomination_list">
                <div class="card-header" style="font-size: 18px;">
                    <span class="icon text-red-50 mr-2" style="color: blue;">
                        <i class="fas fa-hourglass-start"></i>
                    </span>Nomination List
                </div>
                <div class="card-body" id="nomination_list">

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
             $("#start_date").datepicker({
                minDate: ('0'),
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                onSelect: function(date) {
                    var date2 = $('#start_date').datepicker('getDate');
                    // date2.setDate(date2.getDate() + 1);
                    date2.setDate(date2.getDate());
                    $('#end_date').datepicker('setDate', date2);
                    //sets minDate to dt1 date + 1
                    $('#end_date').datepicker('option', 'minDate', date2);
                },
            });
            $("#end_date").datepicker({
                minDate: ('0'),
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                onClose: function() {
                    var dt1 = $('#start_date').datepicker('getDate');
                    var dt2 = $('#end_date').datepicker('getDate');
                    //check to prevent a user from entering a date below date of dt1
                    if (dt2 <= dt1) {
                        var minDate = $('#end_date').datepicker('option', 'minDate');
                        $('#end_date').datepicker('setDate', minDate);
                    }
                }
            });
            $('#membership_position_uuid').select2();
        });
    </script>
@endpush
