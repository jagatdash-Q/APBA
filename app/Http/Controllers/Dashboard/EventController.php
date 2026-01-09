<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ExportEventRegDetails;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Event;
use App\Models\EventBasicDetails;
use App\Models\EventBioSaftyCourseAndExamDetails;
use App\Models\EventGallery;
use App\Models\EventPreConfVisaInfoDetails;
use App\Models\EventProgramRegistration;
use App\Models\EventRegistration;
use App\Models\EventRegistrationOptional;
use App\Models\EventSpeakerDescriptionImages;
use App\Models\EventSpeakers;
use App\Models\EventTab;
use App\Models\EventTabButton;
use App\Models\EventWorkshop;
use App\Models\EventWorkshopOptional;
use App\Models\EventWorkshopPrograms;
use App\Models\SurveyActivity;
use App\Traits\Common;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Excel;

class EventController extends Controller
{
    use Common;

    public function manageEvents(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-read')) {
            abort(403);
        }
        $events = Event::where('is_news', 0)->orderBy('id', 'desc')->with(['getCreator', 'getModifier'])->paginate(10);
        return view('dashboard.event-manager.manage-events', ['events' => $events]);
    }

    public function createEvent(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-create')) {
            abort(403);
        }
        return view('dashboard.event-manager.add-new-event');
    }

    public function storeEvent(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-create')) {
            abort(403);
        }
        try {
            $validator = Validator::make($request->all(), [
                'event_slug' => 'required',
                'event_name' => 'required',
                'meta_title' => 'required',
                'meta_description' => 'required',
                'meta_keyword' => 'required',
                'featured_image' => 'required',
                'event_location' => 'required',
                'start_date' => 'required|before_or_equal:end_date',
                'end_date' => 'required|after_or_equal:end_date',
                'publish_date' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $temp = $validator->safe()->except(['featured_image', 'meta_keyword', 'meta_description']);
            $temp['featured_image'] = Helper::GetMediaUid($request->featured_image);
            $temp['created_by'] =  Auth::id();
            $temp['uid'] =  Str::uuid()->toString();
            $temp['meta_keywords'] =  $request->meta_keyword;
            $temp['meta_desc'] =  $request->meta_description;
            $temp['status'] =  $request->submit;
            $is_event_exist = Event::where('is_news', 0)->where('event_slug', $request->event_slug)->first();
            if ($is_event_exist != null) {
                return redirect()->back()->with('errorMessage', 'Event name has been taken')->withInput();
            }
            $is_event_create = Event::where('is_news', 0)->create($temp);
            try {
                if ($is_event_create) {
                    // Create event featured speakers section
                    EventTab::create([
                        'event_id' => $is_event_create->id,
                        'tab_name' => $request->featured_speakers_tab,
                        'tab_slug' => $this->slugify($request->featured_speakers_tab),
                        'tab_sort_order' => $request->sort_no_featured_speaker,
                        'tab_desc' => $request->featured_speakers_desc,
                        'tab_desc_data' => '',
                        'tab_type' => 'speaker',
                        'created_by' => Auth::id(),
                    ]);

                    for ($sp_count = 1; $sp_count <= $request->featured_speakers_add_more_count; $sp_count++) {
                        $featured_speaker_name = 'featured_speaker_name_' . $sp_count;
                        $featured_speaker_designation = 'featured_speaker_designation_' . $sp_count;
                        $featured_speaker_url = 'featured_speaker_url_' . $sp_count;
                        $featured_speakers_desc = 'featured_speakers_desc_' . $sp_count;
                        $featured_speakers_desc_data = 'featured_speakers_desc_data_' . $sp_count;
                        if ($request->has($featured_speaker_name) && ($request->$featured_speaker_name != '' && $request->$featured_speaker_designation != '' && $request->$featured_speaker_url != '')) {
                            $is_speaker_create = EventSpeakers::create(
                                [
                                    'event_id' => $is_event_create->id,
                                    'speaker_name' => $request->$featured_speaker_name,
                                    'speaker_designation' => $request->$featured_speaker_designation,
                                    'speaker_image' => Helper::GetMediaUid($request->$featured_speaker_url),
                                    'speaker_details' => $request->$featured_speakers_desc,
                                    'speaker_details_data' => $request->$featured_speakers_desc_data,
                                    'created_by' => Auth::id()
                                ]
                            );
                        }
                    }

                    // Create event gallery section

                    EventTab::create([
                        'event_id' => $is_event_create->id,
                        'tab_name' => $request->photo_gallery_tab,
                        'tab_slug' => $this->slugify($request->photo_gallery_tab),
                        'tab_sort_order' => $request->sort_no_photo_graphy,
                        'tab_desc' => '',
                        'tab_desc_data' => '',
                        'tab_type' => 'gallery',
                        'created_by' => Auth::id(),
                    ]);


                    if ($request->gallery_images != '') {
                        $gallery_images = json_decode($request->gallery_images);
                        if (count($gallery_images) > 0) {
                            foreach ($gallery_images as $img) {
                                EventGallery::create([
                                    'event_id' => $is_event_create->id,
                                    'created_by' => Auth::id(),
                                    'image' => $img
                                ]);
                            }
                        }
                    }

                    for ($i = 1; $i <= $request->total_add_more_sec; $i++) {
                        $tab_value = 'tab_value_' . $i;
                        $sort_no = 'sort_no_' . $i;
                        $section_desc = 'section_desc_' . $i;
                        $section_desc_data = 'section_desc_data_' . $i;
                        if ($request->has($tab_value) && $request->{$tab_value} != '') {
                            // Check if tab created or not 
                            $is_tab_exist = EventTab::where('event_id', $is_event_create->id)->where('tab_name', $request->$tab_value)->first();
                            if ($is_tab_exist == null) {
                                $is_event_tab_create = EventTab::create([
                                    'event_id' => $is_event_create->id,
                                    'tab_name' => $request->$tab_value,
                                    'tab_slug' => $this->slugify($request->$tab_value),
                                    'tab_sort_order' => $request->$sort_no,
                                    'tab_desc' => $request->$section_desc,
                                    'tab_desc_data' => $request->$section_desc_data,
                                    'created_by' => Auth::id(),
                                ]);

                                if ($is_event_tab_create) {
                                    $total_add_more_button = 'total_btn_length_' . $i;
                                    for ($j = 1; $j <= $request->$total_add_more_button; $j++) {
                                        $btn_title = 'btn_title_' . $i . '_' . $j;
                                        $btn_label = 'btn_label_' . $i . '_' . $j;
                                        $btn_link = 'btn_link_' . $i . '_' . $j;
                                        if ($request->has($btn_title) && ($request->$btn_title != '' && $request->$btn_label != '' && $request->$btn_link != '')) {
                                            EventTabButton::create([
                                                'event_id' => $is_event_create->id,
                                                'event_tab_id' => $is_event_tab_create->id,
                                                'button_title' => $request->$btn_title,
                                                'button_label' => $request->$btn_label,
                                                'button_link' => $request->$btn_link,
                                                'created_by' => Auth::id(),
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                return redirect()->route('admin.manage.events')->with('doneMessage', 'Event has been successfully created');
            } catch (Exception $e) {
                Log::info('Error in event details create on :- ' . date('Y-m-d') . 'Error message :-> ' . $e->getMessage());
                return redirect()->route('admin.manage.events')->with('errorMessage', 'Unable to create event please contact our technical team');
            }
        } catch (Exception $e) {
            Log::info('Error in event create on :- ' . date('Y-m-d') . 'Error message :-> ' . $e->getMessage());
            return redirect()->route('admin.manage.events')->with('errorMessage', 'Unable to create event please contact our technical team');
        }
    }

    public function updateEvent(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-update')) {
            abort(403);
        }
        try {
            $validator = Validator::make($request->all(), [
                'event_slug' => 'required',
                'event_name' => 'required',
                'meta_title' => 'required',
                'meta_description' => 'required',
                'meta_keyword' => 'required',
                'featured_image' => 'required',
                'event_location' => 'required',
                'start_date' => 'required|before_or_equal:end_date',
                'end_date' => 'required|after_or_equal:end_date',
                'publish_date' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $temp = $validator->safe()->except(['featured_image', 'meta_keyword', 'meta_description']);
            $temp['featured_image'] = Helper::GetMediaUid($request->featured_image);
            $temp['created_by'] =  Auth::id();
            $temp['meta_keywords'] =  $request->meta_keyword;
            $temp['meta_desc'] =  $request->meta_description;
            $temp['status'] =  $request->submit;
            $is_event_update = Event::where('is_news', 0)->whereId($request->event_id)->update($temp);
            try {
                if ($is_event_update) {
                    // Update event featured speakers section
                    $featured_speaker_tab = array(
                        'tab_name' => $request->featured_speakers_tab,
                        'tab_slug' => $this->slugify($request->featured_speakers_tab),
                        'tab_sort_order' => $request->sort_no_featured_speaker,
                        'tab_desc' => $request->featured_speakers_desc,
                        'tab_desc_data' => '',
                        'tab_type' => 'speaker',
                        'updated_by' => Auth::id(),
                    );
                    EventTab::whereId($request->featured_speaker_tab_id)->update($featured_speaker_tab);

                    for ($sp_count = 1; $sp_count <= $request->featured_speakers_add_more_count; $sp_count++) {
                        $featured_speaker_name = 'featured_speaker_name_' . $sp_count;
                        $featured_speaker_designation = 'featured_speaker_designation_' . $sp_count;
                        $featured_speaker_url = 'featured_speaker_url_' . $sp_count;
                        $featured_speakers_desc = 'featured_speakers_desc_' . $sp_count;
                        $featured_speakers_desc_data = 'featured_speakers_desc_data_' . $sp_count;
                        $featured_speakers_id = 'featured_speaker_id_' . $sp_count;
                        if ($request->has($featured_speaker_name) && ($request->$featured_speaker_name != '' && $request->$featured_speaker_designation != '' && $request->$featured_speaker_url != '')) {
                            if ($request->has($featured_speakers_id)) {
                                $speaker_data = array(
                                    'event_id' => $request->event_id,
                                    'speaker_name' => $request->$featured_speaker_name,
                                    'speaker_designation' => $request->$featured_speaker_designation,
                                    'speaker_image' => Helper::GetMediaUid($request->$featured_speaker_url),
                                    'speaker_details' => $request->$featured_speakers_desc,
                                    'speaker_details_data' => $request->$featured_speakers_desc_data,
                                    'updated_by' => Auth::id()
                                );
                                EventSpeakers::whereId($request->$featured_speakers_id)->update($speaker_data);
                            } else {
                                $is_speaker_create = EventSpeakers::create(
                                    [
                                        'event_id' => $request->event_id,
                                        'speaker_name' => $request->$featured_speaker_name,
                                        'speaker_designation' => $request->$featured_speaker_designation,
                                        'speaker_image' => Helper::GetMediaUid($request->$featured_speaker_url),
                                        'speaker_details' => $request->$featured_speakers_desc,
                                        'speaker_details_data' => $request->$featured_speakers_desc_data,
                                        'created_by' => Auth::id()
                                    ]
                                );
                            }
                        }
                    }

                    // update event gallery section
                    $gallery_tab = array(
                        'tab_name' => $request->photo_gallery_tab,
                        'tab_slug' => $this->slugify($request->photo_gallery_tab),
                        'tab_sort_order' => $request->sort_no_photo_graphy,
                        'tab_desc' => '',
                        'tab_desc_data' => '',
                        'tab_type' => 'gallery',
                        'updated_by' => Auth::id(),
                    );
                    EventTab::whereId($request->photo_graphy_tab_id)->update($gallery_tab);


                    if ($request->gallery_images != '') {
                        $gallery_images = json_decode($request->gallery_images);
                        if (count($gallery_images) > 0) {
                            foreach ($gallery_images as $img) {
                                // Check if image already given
                                $is_image_exist = EventGallery::where('event_id', $request->event_id)->where('image', $img)->first();
                                if ($is_image_exist == null) {
                                    EventGallery::create([
                                        'event_id' => $request->event_id,
                                        'created_by' => Auth::id(),
                                        'image' => $img
                                    ]);
                                }
                            }
                        }
                    }

                    for ($i = 1; $i <= $request->total_add_more_sec; $i++) {
                        $tab_value = 'tab_value_' . $i;
                        $tab_id = 'tab_id_' . $i;
                        $sort_no = 'sort_no_' . $i;
                        $section_desc = 'section_desc_' . $i;
                        $section_desc_data = 'section_desc_data_' . $i;
                        if ($request->has($tab_value) && $request->{$tab_value} != '') {
                            if ($request->has($tab_id)) {
                                $tab_data = array(
                                    'event_id' => $request->event_id,
                                    'tab_name' => $request->$tab_value,
                                    'tab_slug' => $this->slugify($request->$tab_value),
                                    'tab_sort_order' => $request->$sort_no,
                                    'tab_desc' => $request->$section_desc,
                                    'tab_desc_data' => $request->$section_desc_data,
                                    'updated_by' => Auth::id(),
                                );
                                $is_tab_update = EventTab::whereId($request->$tab_id)->update($tab_data);
                                if ($is_tab_update) {
                                    $total_add_more_button = 'total_btn_length_' . $i;
                                    for ($j = 1; $j <= $request->$total_add_more_button; $j++) {
                                        $btn_title = 'btn_title_' . $i . '_' . $j;
                                        $btn_label = 'btn_label_' . $i . '_' . $j;
                                        $btn_link = 'btn_link_' . $i . '_' . $j;
                                        $btn_id = 'btn_id_' . $i . '_' . $j;
                                        if ($request->has($btn_title) && ($request->$btn_title != '' && $request->$btn_label != '' && $request->$btn_link != '')) {
                                            if ($request->has($btn_id)) {
                                                $button_data = array(
                                                    'button_title' => $request->$btn_title,
                                                    'button_label' => $request->$btn_label,
                                                    'button_link' => $request->$btn_link,
                                                    'updated_by' => Auth::id(),
                                                );
                                                EventTabButton::whereId($request->$btn_id)->update($button_data);
                                            } else {
                                                EventTabButton::create([
                                                    'event_id' => $request->event_id,
                                                    'event_tab_id' => $request->$tab_id,
                                                    'button_title' => $request->$btn_title,
                                                    'button_label' => $request->$btn_label,
                                                    'button_link' => $request->$btn_link,
                                                    'created_by' => Auth::id(),
                                                ]);
                                            }
                                        }
                                    }
                                }
                            } else {

                                // Check if tab name taken or not 
                                $is_event_tab_exist = EventTab::where('event_id', $request->event_id)->where('tab_name', $request->$tab_value)->first();
                                if ($is_event_tab_exist == null) {
                                    $is_event_tab_create = EventTab::create([
                                        'event_id' => $request->event_id,
                                        'tab_name' => $request->$tab_value,
                                        'tab_slug' => $this->slugify($request->$tab_value),
                                        'tab_sort_order' => $request->$sort_no,
                                        'tab_desc' => $request->$section_desc,
                                        'tab_desc_data' => $request->$section_desc_data,
                                        'created_by' => Auth::id(),
                                    ]);

                                    if ($is_event_tab_create) {
                                        $total_add_more_button = 'total_btn_length_' . $i;
                                        for ($j = 1; $j <= $request->$total_add_more_button; $j++) {
                                            $btn_title = 'btn_title_' . $i . '_' . $j;
                                            $btn_label = 'btn_label_' . $i . '_' . $j;
                                            $btn_link = 'btn_link_' . $i . '_' . $j;
                                            if ($request->has($btn_title) && ($request->$btn_title != '' && $request->$btn_label != '' && $request->$btn_link != '')) {
                                                EventTabButton::create([
                                                    'event_id' => $request->event_id,
                                                    'event_tab_id' => $is_event_tab_create->id,
                                                    'button_title' => $request->$btn_title,
                                                    'button_label' => $request->$btn_label,
                                                    'button_link' => $request->$btn_link,
                                                    'created_by' => Auth::id(),
                                                ]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                return redirect()->route('admin.manage.events')->with('doneMessage', 'Event has been successfully updated');
            } catch (Exception $e) {
                Log::info('Error in event update details create on :- ' . date('Y-m-d') . 'Error message :-> ' . $e->getMessage());
                return redirect()->route('admin.manage.events')->with('errorMessage', 'Unable to update event please contact our technical team');
            }
        } catch (Exception $e) {
            Log::info('Error in event update on :- ' . date('Y-m-d') . 'Error message :-> ' . $e->getMessage());
            return redirect()->route('admin.manage.events')->with('errorMessage', 'Unable to update event please contact our technical team');
        }
    }

    public function editEvent(Request $request, $slug)
    {
        if (!Auth::user()->hasPermission('event_management-update')) {
            abort(403);
        }
        $events = Event::where('is_news', 0)->where('uid', $slug)->with(['getFeaturedImage', 'getEventgallery', 'getEventSpeakers', 'getEventTabs'])->first();
        if ($events == null) {
            abort(404);
        } else {
            return view('dashboard.event-manager.edit-event', ['events' => $events]);
        }
    }

    public function updateEventStatus(Request $request, $status, $event_id)
    {
        if (!Auth::user()->hasPermission('event_management-update')) {
            abort(403);
        }
        Event::where('is_news', 0)->whereId($event_id)->update(['status' => $status]);
        return redirect()->back()->with('doneMessage', 'Event workshop status updated successfully');
    }

    public function deleteEventImage(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-delete')) {
            return ['status' => 'error', 'message' =>  "Access Denied!"];
        }

        $is_image_exist = EventGallery::whereId($request->id)->first();
        if ($is_image_exist != null) {
            // Remove the file if present 
            // if (public_path('dropzone/' . $is_image_exist->image)) {
            //     unlink(public_path('dropzone/' . $is_image_exist->image));
            // }
            $form_data = array(
                'deleted_by' => Auth::id(),
            );
            EventGallery::whereId($request->id)->update($form_data);
            $is_image_exist->delete();
            return ['status' => 'success', 'message' => 'Event image deleted successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Invalid image'];
        }
    }

    public function deleteEventSpeaker(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-delete')) {
            return ['status' => 'error', 'message' =>  "Access Denied!"];
        }

        $is_speaker_exist = EventSpeakers::whereId($request->id)->first();
        if ($is_speaker_exist != null) {
            $form_data = array(
                'deleted_by' => Auth::id(),
            );
            EventSpeakers::whereId($request->id)->update($form_data);
            $is_speaker_exist->delete();
            return ['status' => 'success', 'message' => 'Speaker deleted successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Invalid speaker'];
        }
    }

    public function deleteEventTab(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-delete')) {
            return ['status' => 'error', 'message' =>  "Access Denied!"];
        }

        $is_tab_exist = EventTab::whereId($request->id)->first();
        if ($is_tab_exist != null) {
            $form_data = array(
                'deleted_by' => Auth::id(),
            );
            EventTab::whereId($request->id)->update($form_data);
            // Delete Event tab Buttons
            EventTabButton::where('event_tab_id', $request->id)->update($form_data);
            EventTabButton::where('event_tab_id', $request->id)->delete();
            $is_tab_exist->delete();
            return ['status' => 'success', 'message' => "Event tab and it's buttons deleted successfully"];
        } else {
            return ['status' => 'error', 'message' => 'Invalid tab'];
        }
    }

    public function deleteEventTabButton(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-delete')) {
            return ['status' => 'error', 'message' =>  "Access Denied!"];
        }
        $is_tab_exist = EventTabButton::whereId($request->id)->first();
        if ($is_tab_exist != null) {
            $form_data = array(
                'deleted_by' => Auth::id(),
            );
            EventTabButton::whereId($request->id)->update($form_data);
            $is_tab_exist->delete();
            return ['status' => 'success', 'message' => "Event tab button has deleted successfully"];
        } else {
            return ['status' => 'error', 'message' => 'Invalid tab button'];
        }
    }
    public function eventDashboard(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-read')) {
            abort(403);
        }
        $reg_summery = [];
        $all_events = Event::where('is_news', 0)->where('status', '1')->orderBy('id', 'desc')->get();
        $month = \DB::table('event_registrations')
            ->select(\DB::raw('MONTH(created_at) as month'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->pluck('month');
        $years = \DB::table('event_registrations')
            ->select(\DB::raw('YEAR(created_at) as year'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->pluck('year');
        $event_workshop = EventWorkshop::orderByDesc('id')->with(['getEventDetails' => function ($query) {
            $query->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'));
        }])->pluck('event_id')->unique();

        if (count($event_workshop) > 0) {
            $count = 0;
            foreach ($event_workshop as $event_id) {
                $total_reg = 0;
                $total_amount = 0;
                $event_reg = EventRegistration::where('event_id', $event_id)->get();

                if (count($event_reg) > 0) {
                    $event_deatils = Event::with('getFeaturedImage')->where('id', $event_id)->first();
                    $reg_summery[$count]['event_id'] = $event_deatils->id;
                    $reg_summery[$count]['event_image'] = $event_deatils->getFeaturedImage->path;
                    $reg_summery[$count]['event_name'] = $event_deatils->event_name;
                    $reg_summery[$count]['event_location'] = $event_deatils->event_location;
                    $reg_summery[$count]['event_start_date'] = $event_deatils->start_date;
                    $reg_summery[$count]['event_end_date'] = $event_deatils->end_date;
                    foreach ($event_reg as $reg) {
                        if ($reg->payment_status == 'success') {
                            $total_amount += $reg->total_amount;
                            $total_reg++;
                        }
                    }
                    $reg_summery[$count]['total_reg'] = $total_reg;
                    $reg_summery[$count]['total_amount'] = $total_amount;
                }
                $count++;
            }
        }


        // $ids = [];
        // $uniqueValues = \DB::table('event_registrations')
        //     ->selectRaw('MIN(id) as id, customer_id, event_id')
        //     ->groupBy('customer_id', 'event_id')
        //     ->get();
        // if (count($uniqueValues)) {
        // foreach ($uniqueValues as $eventId) {
        //     $ids[] = $eventId->id;
        // }
        $user_workshop = EventRegistration::query();
        if (!$request->has('restore') && $request->has('filter')) {
            if ($request->event != null) {
                $user_workshop = $user_workshop->where('event_id', $request->event);
            }
            if ($request->year != null) {
                $user_workshop = $user_workshop->whereYear('created_at', $request->year);
            }
            if ($request->month != null) {
                $user_workshop = $user_workshop->whereMonth('created_at', $request->month);
            }
        }
        $user_workshop = $user_workshop->orderByDesc('id')->with(['getCustomerDetails', 'getEventDetails'])->get();
        // }

        return view('dashboard.event-manager.dashboard', ['reg_summery' => $reg_summery, 'years' => $years, 'month' => $month, 'all_events' => $all_events, 'user_workshop' => $user_workshop]);
    }
    public function eventDetails($uuid, $type = null, $survey_uuid = null)
    {
        if (!Auth::user()->hasPermission('event_management-read')) {
            abort(403);
        }
        $survey = null;
        if ($type == 'survey') {
            $survey = SurveyActivity::where('uuid', $survey_uuid)->first();
        }
        $event_reg_details = EventRegistration::with(['getEventDetails', 'getEventProgram', 'getPaymentHistory', 'getEventRegistrationOptional', 'getEventRegMailStatus'])->where('uuid', $uuid)->first();
        if ($event_reg_details == null) {
            abort(404);
        }
        return view('dashboard.event-manager.event-workshop-details', ['event_reg_details' => $event_reg_details, 'survey' => $survey]);
    }

    public function deleteEvent(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-delete')) {
            return ['status' => 'error', 'message' =>  "Access Denied!"];
        }

        try {
            if ($request->id == '') {
                return ['status' => 'error', 'message' => 'Invalid request'];
            } else {
                $is_event_exist = Event::whereId($request->id)->first();
                if ($is_event_exist == null) {
                    return ['status' => 'error', 'message' => 'Event is invalid'];
                } else {
                    $arr = [
                        'deleted_by' => Auth::id()
                    ];

                    $is_event_exist->getEventTabs()->delete();
                    $is_event_exist->getEventgallery()->delete();
                    $is_event_exist->getEventSpeakers()->delete();
                    $is_event_exist->GetEventWorkshops()->delete();
                    $is_event_exist->getEventWorkshopOptional()->delete();
                    // // delete Event tabs
                    // if(count($is_event_exist->getEventTabs())){
                    //     foreach($is_event_exist->getEventTabs() as $val){
                    //         // delete event tab buttons
                    //         if(count($val->getTabButtons())){
                    //             foreach ($val->getTabButtons() as $value) {
                    //                 EventTabButton::whereId($value->id)->update($arr);
                    //                 EventTabButton::whereId($value->id)->delete();
                    //             }
                    //         }
                    //         EventTab::whereId($val->id)->update($arr);
                    //         EventTab::whereId($val->id)->delete();
                    //     }
                    // }

                    // // delete Event galleries
                    // if(count($is_event_exist->getEventgallery())){
                    //     foreach($is_event_exist->getEventgallery() as $val){
                    //         EventGallery::whereId($val->id)->update($arr);
                    //         EventGallery::whereId($val->id)->delete();
                    //     }
                    // }

                    // // delete Event speakers
                    // if(count($is_event_exist->getEventSpeakers())){
                    //     foreach($is_event_exist->getEventSpeakers() as $val){
                    //         EventSpeakers::whereId($val->id)->update($arr);
                    //         EventSpeakers::whereId($val->id)->delete();
                    //     }
                    // }

                    // // delete Event workshops

                    // if(count($is_event_exist->GetEventWorkshops())){
                    //     foreach($is_event_exist->GetEventWorkshops() as $val){
                    //         // Delete Event workshop programs
                    //         if(count($val->getWorkshopPrograms())){
                    //             foreach ($val->getWorkshopPrograms() as $value) {
                    //                 EventWorkshopPrograms::whereId($value->id)->update($arr);
                    //                 EventWorkshopPrograms::whereId($value->id)->delete();
                    //             }
                    //         }
                    //         EventWorkshop::whereId($val->id)->update($arr);
                    //         EventWorkshop::whereId($val->id)->delete();
                    //     }
                    // }

                    // if(count($is_event_exist->getEventWorkshopOptional())){
                    //     foreach($is_event_exist->getEventWorkshopOptional() as $val){
                    //         // Delete Event workshop program optionals
                    //         EventWorkshopOptional::whereId($val->id)->update($arr);
                    //         EventWorkshopOptional::whereId($val->id)->delete();
                    //     }
                    // }


                    // Delete Event registarations

                    $event_registrations = EventRegistration::where('event_id', $request->id)->get();
                    if (count($event_registrations) > 0) {
                        foreach ($event_registrations as $val) {
                            // delete event_registration_optionals

                            EventRegistrationOptional::where('event_registration_id', $val->id)->delete();
                            EventProgramRegistration::where('event_registration_uuid', $val->uuid)->delete();
                        }
                    }
                    EventRegistration::where('event_id', $request->id)->delete();
                    // Delete event 
                    Event::whereId($request->id)->update($arr);
                    Event::whereId($request->id)->delete();
                    return ['status' => 'success', 'message' => 'Event deleted successfully'];
                }
            }
        } catch (Exception $e) {
            Log::info('Error:->' . json_encode($e->getMessage()));
            return ['status' => 'error', 'message' => 'Something went wrong please try aftersometime'];
        }
    }
    public function exportEventDetails(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-read')) {
            abort(403);
        }
        return Excel::download(new ExportEventRegDetails($request->event_id), 'event_registration_details.xlsx');
    }
}
