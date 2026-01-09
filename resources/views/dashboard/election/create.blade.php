@extends('dashboard.layouts.master')
@section('title', __('Create Election'))
@section('content')
    @push('after-styles')
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Create Election') }}</h3>
            </div>
            <div class="card mb-4">
                <div class="card-header" style="font-size: 18px;">
                    <span class="icon text-red-50 mr-2" style="color: blue;">
                        <i class="fas fa-hourglass-start"></i>
                    </span>Election
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.election.store') }}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Choose Nomination<span id="danger">*</span></label>
                                            <select name="nomination" id="nomination" required
                                                onchange="getAvailableVotingPosition(this.value)" class="form-control">
                                                <option value="">Please choose...</option>
                                                @foreach ($nominations as $val)
                                                    <option value="{{ $val->uuid }}">{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-3">
                                            <label class="form-label">Start Date<span id="danger">*</span></label>
                                            <input type="text" class="form-control text-secondary" name="start_date"
                                                id="start_date" value="{{ old('start_date') }}" required
                                                onkeydown="event.preventDefault()" autocomplete="off">
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label">End Date<span id="danger">*</span></label>
                                            <input type="text" class="form-control text-secondary" name="end_date"
                                                id="end_date" value="{{ old('end_date') }}" required
                                                onkeydown="event.preventDefault()" autocomplete="off">
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Choose Voting Positions(Multiple Select)<span
                                                    id="danger">*</span></label>
                                            <select name="nomination_position[]" id="nomination_position" required
                                                class="form-control" multiple>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="end-content">
                                    <div class="col-md-12">
                                        <div class="form-group row" style="margin-top: 10px;padding-bottom: 5px;">
                                            <button class="btn btn-success" type="submit" id="submit_btn"
                                                style="margin-left:20px;">
                                                Create Election
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
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
            $('#nomination_position').select2({

            });
        });

        let getAvailableVotingPosition = (nomination_uuid) => {
            $('#nomination_position').html('');
            $("#loader").css('display', 'block');
            $("body").addClass('disable-loader');
            $.ajax({
                url: "{{ route('admin.election.get.available.positions') }}",
                type: 'post',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'nomination_uuid': nomination_uuid
                },
                success: function(data) {
                    console.log(data);
                    $("#loader").css('display', 'none');
                    $("body").removeClass('disable-loader');
                    if (data.result.length) {
                        data.result.forEach(res => {
                            if (res.get_position != null) {
                                if (res.get_position != null) {
                                    $('#nomination_position').append(
                                        `<option value="${res.uuid}"> ${res.get_position.membership_position} </option>`
                                    );
                                }
                            }

                        });
                    }
                },
                error: function(res) {
                    console.log(res);
                    $("#loader").css('display', 'none');
                    $("body").removeClass('disable-loader');
                }
            });
        }
    </script>
@endpush
