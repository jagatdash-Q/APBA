@extends('dashboard.layouts.master')
@section('title', __('Create Event Activity'))
@section('content')
    @push('after-styles')
        <style>
            .card-header {
                cursor: pointer;
            }

            .card .card-header[data-toggle="collapse"]::after {
                color: #4e73df;
                content: '\f077';
            }

            .card .card-header[data-toggle="collapse"].collapsed::after {
                color: #4e73df;
                content: '\f078';
            }

            .del_icon {
                width: 50px;
                margin-left: -30px;
                margin-right: 10px;
                color: red;
                cursor: pointer;
            }

            .speaker-sec {
                padding: 10px;
                border: 1px solid black;
                border-radius: 10px;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .sub-activity-container {
                padding: 10px;
                border: 1px solid black;
                border-radius: 10px;
                margin-top: 5px;
                margin-bottom: 5px;
            }

            .main-container {
                margin: 10px;
            }

            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                margin: 0;
            }

            .empty-editor {
                border: 2px solid red !important;
            }
        </style>
    @endpush
    @include('dashboard.common.index')
    <div class="padding">
        <div class="box m-b-0">
            <div class="box-header dker">
                <h3>{{ __('Add Event Activity Details') }}</h3>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <form id="workshop_form">
                    @csrf
                    <input type="hidden" id="total_activity" name="total_activity" value="0">

                    <input type="hidden" name="event_id" value="{{ $is_event_exist->id }}">
                    <input type="hidden" id="page" value="0">
                    <input type="hidden" name="activities_status" id="activities_status" value="1">
                    <input type="hidden" id="activity_optional_count" name="activity_optional_count" value="0">
                    <div class="form-group row mt-2 mb-2">
                        <div class="col-md-12 text-right">
                            <button onclick="addActivityOptional();" class="btn btn-primary" type="button">Add activity
                                optional price</button>
                        </div>
                        <div class="col-12" id="append_optional_price"></div>

                        {{-- <div class="col-md-6" style="display:flex !important;">
                            <span>Conference Registration Fee : </span>
                            <input type="number" name="conference_registration_fee" id="conference_registration_fee"
                                class="form-control"/>
                        </div>
                        <div class="col-md-6" style="display:flex !important;">
                            <span>Networking Dinner Fee : </span>
                            <input type="number" name="networking_dinner_fee" id="networking_dinner_fee"
                                class="form-control" />
                        </div> --}}
                    </div>
                    <div class="pt-2 card">
                        <div id="activity_container" class="accordion-sort">
                        </div>
                        <div class="col-md-12 mt-2 mb-2">
                            <button class="btn btn-primary" type="button" onclick="addActivity()">Add new Activity</button>
                        </div>
                        <div class="col-md-12 mt-2 mb-2 disp-none" id="submit-container">
                            <button class="btn btn-warning" type="button" name="submit" value="0" id="draft_btn" onclick="createWorkshop('0')"> Draft </button>
                            <button class="btn btn-success" type="button" name="submit" value="1" id="submit_btn" style="margin-left:20px;" onclick="createWorkshop('1')">
                                Publish
                            </button>
                            {{-- <button class="btn btn-success" type="button">Save Activities</button> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    @include('dashboard/event-manager/event_workshop_js')
@endpush
