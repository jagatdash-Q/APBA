<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ExportSurvey;
use App\Http\Controllers\Controller;
use App\Models\CertificateAttribute;
use App\Models\SurveyActivity;
use App\Models\SurveyRegistration;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Spatie\Browsershot\Browsershot;

class EventSurveyCertificateController extends Controller
{
    use Common;
    public function dashboard(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-read'))
            abort(403);
        $all_survey_list = SurveyActivity::get();
        $survey_list = SurveyActivity::query();
        if (!$request->has('restore')) {
            if ($request->has('filter')) {
                if ($request->uuid != null)
                    $survey_list = $survey_list->where('uuid', $request->uuid);
            }
        }
        $survey_list = $survey_list->with('getEventProgram', 'getSurveyRegistration', 'getEventOptional')->orderBy('id', 'desc')->get();
        return view('dashboard.event-manager.survey-certificate.dashboard', compact('survey_list', 'all_survey_list'));
    }
    public function viewSurvey($uuid)
    {
        if (!Auth::user()->hasPermission('event_management-read'))
            abort(403);
        $survey_list = SurveyActivity::where('uuid', $uuid)->with('getEventProgram', 'getSurveyRegistration')->first();
        if ($survey_list == null)
            abort(404);
        return view('dashboard.event-manager.survey-certificate.view-survey', compact('survey_list'));
    }
    public function editSurvey($uuid)
    {
        if (!Auth::user()->hasPermission('event_management-update'))
            abort(403);
        $survey_reg = SurveyRegistration::with('getSurveyActivity')->where('uuid', $uuid)->first();
        if ($survey_reg == null)
            abort(404);
        return view('dashboard.event-manager.survey-certificate.edit-survey', compact('survey_reg'));
    }
    public function updateSurveyForm(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-update'))
            abort(403);
        try {
            $survey_reg = SurveyRegistration::where('uuid', $request->uuid)->first();
            if ($survey_reg == null)
                abort(404);
            $survey_reg->fullname = $request->fullname;
            $survey_reg->organization = $request->organization;
            $survey_reg->email = $request->email;
            $survey_reg->content_material = $request->content_material;
            $survey_reg->speaker_knowledge = $request->speaker_knowledge;
            $survey_reg->trainer_presentation = $request->trainer_presentation;
            $survey_reg->q_a_session = $request->q_a_session;
            $survey_reg->overall_delivery = $request->overall_delivery;
            $survey_reg->conference_content = $request->conference_content;
            $survey_reg->conference_relevant = $request->conference_relevant;
            $survey_reg->future_conference = $request->future_conference;
            $survey_reg->feedback = $request->feedback;
            $survey_reg->save();
            return redirect()->back()->with('doneMessage', 'Survey form update successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorMessage', $th->getMessage());
        }
    }
    public function exportSurvey(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-read'))
            abort(403);
        return Excel::download(new ExportSurvey($request->survey_uuid), 'survey.xlsx');
    }
    public function certificateAttributes(Request $request)
    {
        if (!Auth::user()->hasPermission('event_management-read'))
            abort(403);
        $certificate_attribute = CertificateAttribute::first();
        return view('dashboard.event-manager.survey-certificate.certificate-attribute', compact('certificate_attribute'));
    }
    public function certificateAttributesCreate(Request $request)
    {
        if ($request->type == 1) {
            if (!Auth::user()->hasPermission('event_management-update'))
                abort(403);
        } else {
            if (!Auth::user()->hasPermission('event_management-create'))
                abort(403);
        }
        try {
            $certificate = CertificateAttribute::firstOrNew(['uuid' => $request->uuid]);
            $path = "/assets/dashboard/apba_certificate_design";
            if (request()->hasFile('logo_1')) {
                $fileName = pathinfo($request->logo_1->getClientOriginalName(), PATHINFO_FILENAME);
                $logo_1 = $this->slugify($fileName) . "." . $request->logo_1->extension();
                if ($request->type == 1)
                    $pre_logo_1 = $certificate->logo_1;
            }


            if (request()->hasFile('logo_2')) {
                $fileName = pathinfo($request->logo_2->getClientOriginalName(), PATHINFO_FILENAME);
                $logo_2 = $this->slugify($fileName) . "." . $request->logo_2->extension();
                if ($request->type == 1)
                    $pre_logo_2 = $certificate->logo_2;
            }
            if (request()->hasFile('signature_1')) {
                $fileName = pathinfo($request->signature_1->getClientOriginalName(), PATHINFO_FILENAME);
                $signature_1 = $this->slugify($fileName) . "." . $request->signature_1->extension();
                if ($request->type == 1)
                    $pre_signature_1 = $certificate->signature_1;
            }
            if (request()->hasFile('signature_2')) {
                $fileName = pathinfo($request->signature_2->getClientOriginalName(), PATHINFO_FILENAME);
                $signature_2 = $this->slugify($fileName) . "." . $request->signature_2->extension();
                if ($request->type == 1)
                    $pre_signature_2 = $certificate->signature_2;
            }

            if (request()->hasFile('background_image')) {
                $fileName = pathinfo($request->background_image->getClientOriginalName(), PATHINFO_FILENAME);
                $background_image = $this->slugify($fileName) . "." . $request->background_image->extension();
                if ($request->type == 1)
                    $pre_background_image = $certificate->background_image;
            }
            if (request()->hasFile('logo_1'))
                $certificate->logo_1 = $logo_1;
            if (request()->hasFile('logo_2'))
                $certificate->logo_2 = $logo_2;
            if (request()->hasFile('signature_1'))
                $certificate->signature_1 = $signature_1;
            if (request()->hasFile('signature_2'))
                $certificate->signature_2 = $signature_2;
            if (request()->hasFile('background_image'))
                $certificate->background_image = $background_image;
            $certificate->introducer_name_1 = $request->introducer_name_1;
            $certificate->introducer_name_2 = $request->introducer_name_2;
            $certificate->introducer_company_1 = $request->introducer_company_1;
            $certificate->introducer_company_2 = $request->introducer_company_2;
            $certificate->save();
            if ($certificate->save()) {
                if (request()->hasFile('logo_1')) {
                    $request->logo_1->move(public_path() . $path, $logo_1);
                    if ($request->type == 1)
                        unlink(public_path() . $path . '/' . $pre_logo_1);
                }

                if (request()->hasFile('logo_2')) {
                    $request->logo_2->move(public_path() . $path, $logo_2);
                    if ($request->type == 1)
                        unlink(public_path() . $path . '/' . $pre_logo_2);
                }
                if (request()->hasFile('signature_1')) {
                    $request->signature_1->move(public_path() . $path, $signature_1);
                    if ($request->type == 1)
                        unlink(public_path() . $path . '/' . $pre_signature_1);
                }
                if (request()->hasFile('signature_2')) {
                    $request->signature_2->move(public_path() . $path, $signature_2);
                    if ($request->type == 1)
                        unlink(public_path() . $path . '/' . $pre_signature_2);
                }

                if (request()->hasFile('background_image')) {
                    $request->background_image->move(public_path() . $path, $background_image);
                    if ($request->type == 1)
                        unlink(public_path() . $path . '/' . $pre_background_image);
                }
            }
            if ($request->type == 0)
                return redirect()->back()->with('doneMessage', 'Attributes created successfully.');
            else
                return redirect()->back()->with('doneMessage', 'Attributes updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorMessage', $th->getMessage());
        }
    }
    public function certificateSent($survey_uuid)
    {
        if (!Auth::user()->hasPermission('event_management-read'))
            abort(403);
        try {
            $this->sent_certificate($survey_uuid);
            return redirect()->back()->with('doneMessage', 'Certificate Successfully Sent.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorMessage', $th->getMessage());
        }
    }
}
