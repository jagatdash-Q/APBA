<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventProgramRegistration;
use App\Models\EventRegistration;
use App\Models\EventRegistrationOptional;
use App\Models\EventSpeakers;
use App\Models\EventWorkshop;
use App\Models\EventWorkshopPrograms;
use App\Models\EventWorkshopRegistration;
use App\Traits\Common;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventDetailsController extends Controller
{
    use Common;
    public function eventDetails(Request $request, $slug)
    {
        $data = '';
        $event_details = Event::where('is_news', 0)->where('event_slug', $slug)->with(['getFeaturedImage', 'getEventTabs', 'getEventgallery', 'GetEventWorkshops'])
            // ->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))
            ->first();



        if ($event_details == null)
            abort(404);

        $event_speakers = EventSpeakers::where('event_id', $event_details->id)->with('getSpeakerImage')->paginate(6);
        $total_speaker_count = EventSpeakers::where('event_id', $event_details->id)->count();
        // Check if event
        $current_date = Carbon::now()->startOfDay();
        $end_date = Carbon::parse($event_details->end_date)->startOfDay();
        $is_reg_valid = true;
        if ($current_date->gt($end_date) || $event_details->activities_status == "0")
            $is_reg_valid = false;

        if ($request->ajax()) {

            foreach ($event_speakers as $speakers) {
                if ($speakers->getSpeakerImage != null) {
                    $speaker_image = $speakers->getSpeakerImage->media_url;
                } else {
                    $speaker_image = url('assets/dashboard/images/image_not_found.png');
                }
                $data .= '<a href="' . route('frontend.featured.speaker.details', $speakers->id) . '" class="col-sm-4 event_section_speakers_thumb_div">
                <div class="event_section_speakers_thumb_img">
                <img src="' . $speaker_image . '" alt="...">
                </div>
                <div class="event_section_speakers_content">
                    <p class="event_section_speakers_name">' .
                    $speakers->speaker_name . '</p>
                    <span
                        class="event_section_speakers_desg">' . $speakers->speaker_designation . '</span>
                </div>
            </a>';
            }
            // Get next page data 
            return ['status' => 'success', 'data' => $data, 'current_page_data' => count($event_speakers), 'has_new_page' => $event_speakers->hasMorePages()];
        }

        return view('frontend.events.event_details', compact('event_details', 'event_speakers', 'total_speaker_count', 'is_reg_valid'));
    }
    public function featuredSpeakerDetails($id)
    {
        $speaker_details = EventSpeakers::where('id', $id)->with('getSpeakerImage')->first();
        if ($speaker_details == null)
            abort(404);

        return view('frontend.events.featured_speaker_details', compact('speaker_details'));
    }
    public function eventRegister($uuid)
    {
        $date = [];
        $event_details = Event::where('is_news', 0)->where('uid', $uuid)->with(['GetEventWorkshops', 'getEventWorkshopOptional'])
            // ->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))
            ->first();
        if ($event_details == null)
            abort(404);

        return view('frontend.events.event_register', compact('event_details'));
    }
    public function checkProgram(Request $request)
    {
        $id = [];
        $get_program = EventWorkshopPrograms::where('id', $request->program_id)->first();

        if ($get_program != null) {

            $get_all_workshop_program = EventWorkshopPrograms::where('status', '1')->where('program_date', $get_program->program_date)->whereNot('id', $request->program_id)->get();

            if (count($get_all_workshop_program) > 0) {
                foreach ($get_all_workshop_program as $value) {
                    if ($get_program->start_time >= $value->start_time && $get_program->start_time <= $value->end_time) {
                        $id[] = $value->id;
                    } elseif ($get_program->end_time >= $value->start_time && $get_program->end_time <= $value->end_time) {
                        $id[] = $value->id;
                    }
                }
            }
            return $id;
        }
    }
    public function eventRegistration(Request $request, CustomerController $customerController)
    {
        $customer_id = Auth::guard('customer')->check() == true ? Auth::guard('customer')->user()->id : null;
        try {
            // if ($request->program_id == null)
            //     return redirect()->back()->with('errorMessage', 'Please choose any of the above package.');

            $event_reg = new EventRegistration();
            $event_reg->uuid = Str::uuid()->toString();

            if (Auth::guard('customer')->check()) {
                $event_reg->first_name = Auth::guard('customer')->user()->first_name;
                $event_reg->last_name = Auth::guard('customer')->user()->last_name;
                $event_reg->email = Auth::guard('customer')->user()->email;
                $event_reg->contact_number = null;
                $event_reg->customer_id = Auth::guard('customer')->user()->id;
            } else {
                $event_reg->first_name = $request->temp_first_name;
                $event_reg->last_name = $request->temp_last_name;
                $event_reg->email = $request->temp_email;
                $event_reg->contact_number = $request->temp_contact_no;
                $event_reg->organisation_name = $request->temp_organisation;
                $event_reg->organisation_address = $request->temp_organisations_address;
                $event_reg->phone_code = $request->country_tel_code;
                $event_reg->customer_id = null;
            }

            $event_reg->event_id = $request->event_id;
            $event_reg->total_amount = $request->total_amount;
            // $event_reg->conference_registration_fee = $request->temp_conference_registration_fee;
            // $event_reg->networking_dinner_fee = $request->temp_networking_dinner_fee;
            $event_reg->payment_status = 'pending';
            $event_reg->save();
            if ($event_reg->save()) {
                if ($request->optional_id != null) {
                    $optional_id = explode(",", $request->optional_id);
                    if (count($optional_id) > 0) {
                        foreach ($optional_id as $value) {
                            $event_registration_optionals = new EventRegistrationOptional();
                            $event_registration_optionals->uuid = Str::uuid()->toString();
                            $event_registration_optionals->event_registration_id = $event_reg->id;
                            $event_registration_optionals->event_workshop_optional_id = $value;
                            $event_registration_optionals->save();
                        }
                    }
                }


                // $conference_registration_id = explode(",", $request->conference_registration_id);
                // $networking_dinner_fee_id = explode(",", $request->networking_dinner_fee_id);
                if ($request->program_id != null) {
                    $programs = explode(",", $request->program_id);
                    if (count($programs) > 0) {
                        foreach ($programs as $id) {
                            $get_program = EventWorkshopPrograms::where('id', $id)->first();
                            // if (in_array($get_program->event_workshop_id, $conference_registration_id)) {
                            //     $workshop_conference_registration_fee = EventWorkshop::where('id', $get_program->event_workshop_id)->first();
                            //     $conference_registration_fee = $workshop_conference_registration_fee->conference_registration_fee;
                            // } else {
                            //     $conference_registration_fee = null;
                            // }

                            // if (in_array($get_program->event_workshop_id, $networking_dinner_fee_id)) {
                            //     $workshop_networking_dinner_fee = EventWorkshop::where('id', $get_program->event_workshop_id)->first();
                            //     $networking_dinner_fee = $workshop_networking_dinner_fee->networking_dinner_fee;
                            // } else {
                            //     $networking_dinner_fee = null;
                            // }
                            if ($get_program != null) {
                                $event_program_registration = new EventProgramRegistration();
                                $event_program_registration->uuid = Str::uuid()->toString();
                                $event_program_registration->event_registration_uuid = $event_reg->uuid;
                                $event_program_registration->event_workshop_id = $get_program->event_workshop_id;
                                $event_program_registration->event_program_id = $id;
                                // $event_program_registration->conference_registration_fee = $conference_registration_fee;
                                // $event_program_registration->networking_dinner_fee = $networking_dinner_fee;
                                $event_program_registration->save();
                            }
                        }
                    }
                }


                return $customerController->processTransaction($customer_id, $request->total_amount, 'event registration', null, $event_reg->id);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
    public function retryEventRegistration(Request $request, CustomerController $customerController)
    {
        return $customerController->processTransaction(Auth::guard('customer')->user()->id, $request->total_amount, $request->payment_for, null, $request->event_reg_id);
    }
    public function newsDetails(Request $request, $slug)
    {
        $news_details = Event::where('is_news', 1)->where('event_slug', $slug)->with(['getFeaturedImage'])->first();
        if ($news_details == null)
            abort(404);

        return view('frontend.events.news_details', compact('news_details'));
    }
}
