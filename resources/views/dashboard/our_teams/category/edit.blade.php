@extends('dashboard.layouts.master')
@section('title', __('Our Teams Category Update'))
@section('content')
    <style>
        .form-check-input {
            min-height: 0px !important;
        }
    </style>
    <div class="padding">
        <div class="box m-b-0">
            <div class="box-header dker">
                <h3>{{ __('Add Our Teams Category') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    {{ __('Our Teams Category') }}
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        {{-- <a class="nav-link" href="{{ route('admin.our_teams.category') }}">
                            <i class="material-icons md-18">×</i>
                        </a> --}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <div class="card pt-2">
                    <form action="{{ route('admin.our_teams.category.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="base_url" id="base_url" value="{{ url('') }}">
                        <input type="hidden" name="uid" id="uid" value="{{ $our_team_content->uid }}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Category Name</label>
                                @if ($our_team_content->ourTeamCatContent != null)
                                    <input type="text" class="form-control form-control-user" id=""
                                        placeholder="" name="title"
                                        value="{{ $our_team_content->ourTeamCatContent->title }}">
                                @else
                                    <input type="text" class="form-control form-control-user" id=""
                                        placeholder="" name="title" value="">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="">Category Status</label>
                            @if ($our_team_content->status == 1)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status1"
                                        value="1" checked>
                                    <label class="form-check-label" for="status1">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status2"
                                        value="0">
                                    <label class="form-check-label" for="status2">
                                        In active
                                    </label>
                                </div>
                            @else
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status1"
                                        value="1">
                                    <label class="form-check-label" for="status1">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status2"
                                        value="0" checked>
                                    <label class="form-check-label" for="status2">
                                        In active
                                    </label>
                                </div>
                            @endif
                        </div>
                        <div id="end-content">
                            <div class="form-group row" style="margin-top: 20px;padding-bottom: 5px;">
                                <div class="col-sm-10">
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-success" type="submit" name="submit" value="submit"> Publish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
@endpush
