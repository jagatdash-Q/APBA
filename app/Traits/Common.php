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
    public static function slugify(mixed $text): string
    {
        $text = (string) $text;
        $text = preg_replace('~[^\\pL\\d]+~u', '-', $text) ?: '';
        $text = trim($text, '-');
        if (function_exists('transliterator_transliterate')) {
            $text = transliterator_transliterate('Any-Latin; Latin-ASCII', $text);
        }
        $converted = @iconv('utf-8', 'ASCII//TRANSLIT//IGNORE', (string) $text);
        $text = (string) ($converted !== false ? $converted : $text);
        $text = function_exists('mb_strtolower') ? mb_strtolower((string) $text) : strtolower((string) $text);
        return preg_replace('~[^-\\w]+~', '', $text) ?: '';
    }

    public static function get_active_media_manager_content(): string
    {
        $media_managers = MediaManager::get()->pluck('file_name')->toArray();
        $media_contents = '';
        if (count($media_managers) > 0) {
            $media_contents = implode(",", $media_managers);
        }
        return $media_contents;
    }

    public static function sent_certificate(string $survey_uuid): void
    {
        /** @var \App\Models\SurveyRegistration|null $survey_reg */
        $survey_reg = SurveyRegistration::with('getEventProgram', 'getSurveyActivity')->where('uuid', $survey_uuid)->first();
        if ($survey_reg == null) {
            abort(404);
        }
        $certificate_attribute = CertificateAttribute::first();
        $image_path = url('/') . '/assets/dashboard/apba_certificate_design/';
        // $image_path = 'https://apba.quocent.com' . '/assets/dashboard/apba_certificate_design/';
        $pdf = PDF::loadView('dashboard.event-manager.survey-certificate.certificate_design', ['certificate_attribute' => $certificate_attribute, 'survey_reg' => $survey_reg, 'image_path' => $image_path]);
        $pdf->setPaper('A4', 'landscape');
        $file_name = $survey_reg->id . time() . '.pdf';
        $pdfPath = public_path('certificate/' . $file_name);
        $pdf->save($pdfPath);
        if ($survey_reg->certificate != null && file_exists(public_path('certificate/' . $survey_reg->certificate))) {
            unlink(public_path('certificate/' . $survey_reg->certificate));
        }
        //   return view('dashboard.event-manager.survey-certificate.certificate_design', compact('certificate_attribute', 'survey_reg', 'image_path'));
        $event = $survey_reg->getSurveyActivity?->getEventOptional?->getEvent;
        $programdate = isset($event->start_date) ? Carbon::parse($event->start_date)->format('d F Y') . ' - ' . Carbon::parse($event->end_date)->format('d F Y') : '';
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
