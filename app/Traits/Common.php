<?php

namespace App\Traits;

use App\Models\Language_mapping;
use App\Models\CareerListing;
use App\Models\Content;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Career;
use App\Models\CertificateAttribute;
use App\Models\Language;
use App\Models\MediaManager;
use App\Models\OurTeam;
use App\Models\OurTeamListing;
use App\Models\OurTeamListingContent;
use App\Models\Region;
use App\Models\SurveyRegistration;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

trait Common
{
    /* --- create slug from title --- */
    public static function slugify($text)
    {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        if (function_exists('transliterator_transliterate')) $text = transliterator_transliterate('Any-Latin; Latin-ASCII', $text);
        $text = iconv('utf-8', 'ASCII//TRANSLIT//IGNORE', $text);
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        return $text;
    }

    public static function get_active_media_manager_content()
    {
        $media_managers = MediaManager::get()->pluck('file_name')->toArray();
        $media_contents = '';
        if (count($media_managers) > 0) {
            $media_contents = implode(",", $media_managers);
        }
        return $media_contents;
    }
    public static function sent_certificate($survey_uuid)
    {
        $survey_reg = SurveyRegistration::with('getEventProgram', 'getSurveyActivity')->where('uuid', $survey_uuid)->first();
        if ($survey_reg == null)
            abort(404);
        $certificate_attribute = CertificateAttribute::first();
        $image_path = url('/') . '/assets/dashboard/apba_certificate_design/';
        // $image_path = 'https://apba.quocent.com' . '/assets/dashboard/apba_certificate_design/';
        $pdf = PDF::loadView('dashboard.event-manager.survey-certificate.certificate_design', compact('certificate_attribute', 'survey_reg', 'image_path'));
        $pdf->setPaper('A4', 'landscape');
        $file_name = $survey_reg->id . time() . '.pdf';
        $pdfPath = public_path('certificate/' . $file_name);
        $pdf->save($pdfPath);
        if ($survey_reg->certificate != null) {
            if (file_exists(public_path('certificate/' . $survey_reg->certificate))) {
                unlink(public_path('certificate/' . $survey_reg->certificate));
            }
        }
        //   return view('dashboard.event-manager.survey-certificate.certificate_design', compact('certificate_attribute', 'survey_reg', 'image_path'));
        $programdate = isset($survey_reg->getSurveyActivity->getEventOptional->getEvent->start_date) ? Carbon::parse($survey_reg->getSurveyActivity->getEventOptional->getEvent->start_date)->format('d F Y') . ' - ' . Carbon::parse($survey_reg->getSurveyActivity->getEventOptional->getEvent->end_date)->format('d F Y') : '';
        $details = [
            'name' => $survey_reg->fullname,
            'survey_name' => isset($survey_reg->getSurveyActivity->name) ? $survey_reg->getSurveyActivity->name : '',
            'date' => isset($survey_reg->getSurveyActivity->getEventProgram->program_date) ? Carbon::parse($survey_reg->getSurveyActivity->getEventProgram->program_date)->format('jS F Y') : $programdate,
            'file_name' => $file_name,
            'file_path' => $pdfPath
        ];
        // return view('mail.certificate_mail', compact('details'));
        Mail::to($survey_reg->email)->send(new \App\Mail\CertificateMail($details));
        $survey_reg->certificate_sent = 'yes';
        $survey_reg->certificate = $file_name;
        $survey_reg->save();
    }
}
