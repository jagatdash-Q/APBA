<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventProgramRegistration;
use App\Models\EventRegistrationOptional;
use App\Models\EventWorkshop;
use App\Models\EventWorkshopOptional;
use App\Models\EventWorkshopPrograms;
use App\Models\SurveyActivity;
use App\Models\SurveyRegistration;
use App\Traits\Common;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventWorkshopController extends Controller
{
    use Common;
    public function manageWorkshop(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-read'))
            abort(403);
        $event_ids = EventWorkshop::distinct()->pluck('event_id')->toArray();
        $all_events = Event::where('is_news', 0)->where('status', '1')->whereNotIn('id', $event_ids)->get();

        $workshops = Event::where('is_news', 0)->with('GetEventWorkshops')->whereIn('id', $event_ids)->paginate(10);
        return view('dashboard.event-manager.manage-event-workshop', compact('all_events', 'workshops'));
    }

    public function createEventWorkshop(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-create'))
            abort(403);
        $is_event_exist = Event::where('is_news', 0)->where('uid', $request->eventpicker)->first();
        if ($is_event_exist != null) {

            // Check if workshop Exist 
            $is_workshop = EventWorkshop::where('event_id', $is_event_exist->id)->count();
            $program_dates = $this->dateTimePeriod($is_event_exist->start_date, $is_event_exist->end_date);
            return view('dashboard.event-manager.create-event-workshop', compact('is_event_exist', 'program_dates'));
        } else {
            abort(404);
        }
    }
    public function editEventWorkshop($uuid)
    {
        if (!Auth::user()->hasPermission('event_management-update'))
            abort(403);
        $workshops = Event::where('is_news', 0)->with(['GetEventWorkshops', 'getEventWorkshopOptional'])->where('uid', $uuid)->first();
        if ($workshops == null)
            abort(404);

        $program_dates = $this->dateTimePeriod($workshops->start_date, $workshops->end_date);
        return view('dashboard.event-manager.edit-event-workshop', compact('workshops', 'program_dates'));
    }

    public function updateEventWorkshop(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-update'))
            return ['error', "Access Denied!"];

        try {
            if ((int)$request->total_activity > 0) {
                // check time validation
                // $check_validate = $this->checkTimeValidation($request);

                // if ($check_validate == null) {
                $event = Event::where('is_news', 0)->where('id', $request->event_id)->first();
                if ($event == null)
                    return ['error', 'Event not found!'];

                $event->activities_status = $request->activities_status;
                $event->save();
                if ($event->save()) {
                    if ((int)$request->input('activity_optional_count') > 0) {
                        for ($h = 1; $h <= (int)$request->input('activity_optional_count'); $h++) {
                            if (!empty($request->input('activity_optional_name_' . $h)) || !empty($request->input('activity_optional_price_' . $h)) || !empty($request->input('event_workshop_optional_id_' . $h))) {
                                $event_workshop_optional = EventWorkshopOptional::firstOrNew(['id' => $request->input('event_workshop_optional_id_' . $h)]);
                                $event_workshop_optional->event_id = $request->event_id;
                                $event_workshop_optional->activity_optional_name = $request->input('activity_optional_name_' . $h);
                                $event_workshop_optional->price_member = $request->input('activity_optional_price_member_' . $h);
                                $event_workshop_optional->price_guest = $request->input('activity_optional_price_non_member_' . $h);
                                $event_workshop_optional->save();
                                if ($event_workshop_optional->save()) {
                                    if ($request->input('optional_survey_' . $h) == 'yes') {
                                        $survey_activity = SurveyActivity::firstOrNew(['uuid' => $event_workshop_optional->survey_activity_uuid]);
                                        if ($event_workshop_optional->survey_activity_uuid == null)
                                            $survey_activity->uuid = Str::uuid()->toString();
                                        $survey_activity->name = $request->input('activity_optional_name_' . $h);
                                        $survey_activity->event_workshop_optional_id = $event_workshop_optional->id;
                                        $survey_activity->event_workshop_program_id = null;
                                        $survey_activity->save();
                                        if ($survey_activity->save()) {
                                            $event_workshop_optional->survey = $request->input('optional_survey_' . $h);
                                            $event_workshop_optional->survey_activity_uuid = $survey_activity->uuid;
                                            $event_workshop_optional->save();
                                        }
                                    } else if ($request->input('optional_survey_' . $h) == 'no') {

                                        $get_survey_activity = SurveyActivity::where('uuid', $event_workshop_optional->survey_activity_uuid)->first();

                                        if ($get_survey_activity != null) {

                                            $get_survey_reg = SurveyRegistration::where('survey_activity_uuid', $get_survey_activity->uuid)->first();
                                            if ($get_survey_reg != null) {
                                                EventRegistrationOptional::where('uuid', $get_survey_reg->event_registration_optional_uuid)->update(['survey' => 'no']);
                                                $get_survey_reg->delete();
                                            }
                                            $get_survey_activity->delete();
                                        }

                                        $event_workshop_optional->survey = $request->input('optional_survey_' . $h);
                                        $event_workshop_optional->survey_activity_uuid = null;
                                        $event_workshop_optional->save();
                                    }
                                }
                            }
                        }
                    }

                    for ($i = 1; $i <= (int)$request->total_activity; $i++) {
                        if (!empty($request->input('activity_id_' . $i)) || !empty($request->input('activity_title_' . $i)) || !empty($request->input('select_date_' . $i)) || !empty($request->input('member_fee_' . $i)) || !empty($request->input('non_member_fee_' . $i)) || !empty($request->input('sub_activity_length_' . $i)) || !empty($request->input('activity_optional_count_' . $i))) {

                            $event_activity = EventWorkshop::firstOrNew(['id' => $request->input('activity_id_' . $i)]);
                            if ($event_activity != null) {

                                $get_slug = $this->slugify($request->input('activity_title_' . $i));

                                $event_activity->event_id = $request->event_id;
                                $event_activity->workshop_name = $request->input('activity_title_' . $i);
                                $event_activity->workshop_slug = $get_slug;
                                $event_activity->workshop_date = $request->input('select_date_' . $i);
                                // $event_activity->survey = $request->input('activity_survey_' . $i);
                                $event_activity->sorting_order = $request->input('sort_activity_' . $i);
                                if ($request->page == '1')
                                    $event_activity->updated_by = Auth::id();
                                else
                                    $event_activity->created_by = Auth::id();
                                $event_activity->save();
                                if ($event_activity->save()) {
                                    if ((int)$request->input('sub_activity_length_' . $i) > 0) {

                                        for ($j = 1; $j <= (int)$request->input('sub_activity_length_' . $i); $j++) {

                                            if (!empty($request->input('sub_activity_name_' . $i . '_' . $j)) || !empty($request->input('sub_activity_program_date_' . $i . '_' . $j)) || !empty($request->input('sub_activity_room_' . $i . '_' . $j)) || !empty($request->input('sub_activity_workshop_' . $i . '_' . $j)) || !empty($request->input('sub_activity_start_time_' . $i . '_' . $j)) || !empty($request->input('sub_activity_end_time_' . $i . '_' . $j)) || !empty($request->input('sub_activity_program_' . $i . '_' . $j)) || !empty($request->input('sub_activity_trainers_' . $i . '_' . $j)) || !empty($request->input('sub_activity_member_fee_' . $i . '_' . $j)) || !empty($request->input('sub_activity_non_member_fee_' . $i . '_' . $j))) {


                                                $event_sub_activity = EventWorkshopPrograms::firstOrNew(['id' => $request->input('sub_activity_id_' . $i . '_' . $j)]);

                                                if ($event_sub_activity) {
                                                    $get_program_slug = $this->slugify($request->input('sub_activity_name_' . $i . '_' . $j));

                                                    $event_sub_activity->event_id = $request->event_id;
                                                    $event_sub_activity->event_workshop_id = $event_activity->id;
                                                    $event_sub_activity->program_name = $request->input('sub_activity_name_' . $i . '_' . $j);
                                                    $event_sub_activity->program_slug = $get_program_slug;
                                                    $event_sub_activity->program_desc = $request->input('sub_activity_program_' . $i . '_' . $j);
                                                    $event_sub_activity->program_trainers = $request->input('sub_activity_trainers_' . $i . '_' . $j);
                                                    $event_sub_activity->workshop_number = $request->input('sub_activity_workshop_' . $i . '_' . $j);
                                                    $event_sub_activity->room_no = $request->input('sub_activity_room_' . $i . '_' . $j);
                                                    $event_sub_activity->price_member = $request->input('sub_activity_member_fee_' . $i . '_' . $j);
                                                    $event_sub_activity->price_guest = $request->input('sub_activity_non_member_fee_' . $i . '_' . $j);
                                                    $event_sub_activity->start_time = $request->input('sub_activity_start_time_' . $i . '_' . $j);
                                                    $event_sub_activity->end_time = $request->input('sub_activity_end_time_' . $i . '_' . $j);
                                                    $event_sub_activity->program_date = $request->input('sub_activity_program_date_' . $i . '_' . $j);
                                                    $event_sub_activity->survey = $request->input('sub_activity_survey_' . $i . '_' . $j);
                                                    if ($request->page == '1')
                                                        $event_sub_activity->updated_by = Auth::id();
                                                    else
                                                        $event_sub_activity->created_by = Auth::id();
                                                    $event_sub_activity->status = $request->input('sub_activity_status_' . $i . '_' . $j);
                                                    $event_sub_activity->save();

                                                    if ($event_sub_activity->save()) {
                                                        if ($request->input('sub_activity_survey_' . $i . '_' . $j) == 'yes') {
                                                            $survey_activity = SurveyActivity::firstOrNew(['uuid' => $event_sub_activity->survey_activity_uuid]);
                                                            if ($event_sub_activity->survey_activity_uuid == null)
                                                                $survey_activity->uuid = Str::uuid()->toString();
                                                            $survey_activity->name = $request->input('sub_activity_name_' . $i . '_' . $j);
                                                            $survey_activity->event_workshop_program_id = $event_sub_activity->id;
                                                            $survey_activity->save();
                                                            if ($survey_activity->save()) {
                                                                $event_sub_activity->survey_activity_uuid = $survey_activity->uuid;
                                                                $event_sub_activity->save();
                                                            }
                                                        } else if ($request->input('sub_activity_survey_' . $i . '_' . $j) == 'no') {

                                                            $get_survey_activity = SurveyActivity::where('uuid', $event_sub_activity->survey_activity_uuid)->first();

                                                            if ($get_survey_activity != null) {

                                                                $get_survey_reg = SurveyRegistration::where('survey_activity_uuid', $get_survey_activity->uuid)->first();
                                                                if ($get_survey_reg != null) {
                                                                    EventProgramRegistration::where('uuid', $get_survey_reg->event_program_registration_uuid)->update(['survey' => 'no']);
                                                                    $get_survey_reg->delete();
                                                                }
                                                                $get_survey_activity->delete();
                                                            }
                                                            $event_sub_activity->survey_activity_uuid = null;
                                                            $event_sub_activity->save();
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if ($request->page == '1')
                    return ['success', "Event workshop updated successfully."];
                else
                    return ['success', "Event workshop created successfully."];
                // } else {
                //     return $check_validate;
                // }
            } else {
                return ['error', "Something went wrong! Please try again."];
            }
        } catch (Exception $e) {
            return ['error', $e->getMessage()];
        }
    }

    public function dateTimePeriod($start_date, $end_date)
    {
        $program_dates = [];
        $startDate = Carbon::createFromFormat('Y-m-d', $start_date);
        $endDate = Carbon::createFromFormat('Y-m-d', $end_date);
        $dateRange = CarbonPeriod::create($startDate, $endDate);
        $dates = $dateRange->toArray();
        foreach ($dates as $date) {
            array_push($program_dates, Carbon::parse($date)->format('Y-m-d'));
        }
        return $program_dates;
    }

    public function checkTimeValidation($request)
    {
        // check time validation

        for ($k = 1; $k <= (int)$request->total_activity; $k++) {

            if ((int)$request->input('sub_activity_length_' . $k) > 1) {

                for ($l = (int)$request->input('sub_activity_length_' . $k); $l >= 1; $l--) {
                    if (!empty($request->input('sub_activity_start_time_' . $k . '_' . $l)) || !empty($request->input('sub_activity_end_time_' . $k . '_' . $l))) {

                        for ($h = 1; $h <= (int)$request->input('sub_activity_length_' . $k); $h++) {
                            if (!empty($request->input('sub_activity_start_time_' . $k . '_' . $h)) || !empty($request->input('sub_activity_end_time_' . $k . '_' . $h))) {

                                if ($h != $l) {
                                    // if ($request->input('sub_activity_room_' . $k . '_' . $l) == $request->input('sub_activity_room_' . $k . '_' . $h) && $request->input('sub_activity_program_date_' . $k . '_' . $l) == $request->input('sub_activity_program_date_' . $k . '_' . $h)) {
                                    if ($request->input('sub_activity_program_date_' . $k . '_' . $l) == $request->input('sub_activity_program_date_' . $k . '_' . $h)) {

                                        if ($request->input('sub_activity_start_time_' . $k . '_' . $l) >= $request->input('sub_activity_start_time_' . $k . '_' . $h) && $request->input('sub_activity_start_time_' . $k . '_' . $l) <= $request->input('sub_activity_end_time_' . $k . '_' . $h)) {

                                            return ['error', '"' . $request->input('sub_activity_name_' . $k . '_' . $l) . '" of sub activity start time should be different from other sub activities.'];
                                            break;
                                        }

                                        if ($request->input('sub_activity_end_time_' . $k . '_' . $l) >= $request->input('sub_activity_start_time_' . $k . '_' . $h) && $request->input('sub_activity_end_time_' . $k . '_' . $l) <= $request->input('sub_activity_end_time_' . $k . '_' . $h)) {
                                            return ['error', '"' . $request->input('sub_activity_name_' . $k . '_' . $l) . '" of sub activity end time should be different from other sub activities.'];
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function updateStatusEventWorkshop(Request $request)
    {
        $workshops = Event::where('is_news', 0)->with('GetEventWorkshops')->where('uid', $request->uuid)->first();
        if ($workshops == null)
            abort(404);
        $workshops->activities_status = $request->status;
        $workshops->save();
        return redirect()->back()->with('doneMessage', 'Event status successfully updated.');
    }
    public function deleteEventWorkshopProgram(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-delete'))
            return ['error', "Access Denied!"];

        if ($request->ajax()) {
            try {
                $workshops = EventWorkshop::where('id', $request->workshopId)->first();
                if ($workshops == null)
                    return ['error', "Event Workshop not found!"];

                EventWorkshopPrograms::where('event_workshop_id', $workshops->id)->delete();
                SurveyActivity::where('uuid', $workshops->survey_activity_uuid)->delete();
                $workshops->delete();
                return ['success', "Event workshop program deleted successfully!"];
            } catch (Exception $e) {
                return ['error', $e->getMessage()];
            }
        }
    }
    public function deleteEventOptional(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-delete'))
            return ['error', "Access Denied!"];
        if ($request->ajax()) {
            try {
                EventWorkshopOptional::where('id', $request->id)->delete();
                return ['success', "Event optional program deleted successfully."];
            } catch (Exception $e) {
                return ['error', $e->getMessage()];
            }
        }
    }
}
