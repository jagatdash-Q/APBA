<?php

namespace App\Console\Commands;

use App\Models\EventProgramRegistration;
use App\Models\EventRegistration;
use App\Models\SurveyReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class CheckSurveyCertification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-survey-certification:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        $check = 0;
        $event_reg = EventRegistration::with('getEventProgram', 'getEventRegistrationOptional')->where('payment_status', 'success')->get();
        if (count($event_reg)) {
            foreach ($event_reg as $value) {
                if (isset($value->getEventProgram)) {
                    if (count($value->getEventProgram)) {
                        $check = 1;
                        foreach ($value->getEventProgram as $event_prog) {
                            $check_survey = 0;
                            if (isset($event_prog->getProgramDetails)) {
                                if ($event_prog->getProgramDetails->survey == 'yes' && $event_prog->getProgramDetails->survey_activity_uuid != null) {
                                    $check_survey = 1;
                                }
                            }
                            if ($check_survey == 1) {
                                $check_mail = SurveyReminder::where('survey_activity_uuid', $event_prog->getProgramDetails->survey_activity_uuid)->where('event_registration_uuid', $value->uuid)->count();
                                if ($check_mail == 0) {
                                    $details = [
                                        'name' => $value->first_name,
                                        'survey_url' => route('customer.survey', $event_prog->uuid)
                                    ];
                                    try {
                                        Mail::to(trim($value->email))->send(new \App\Mail\SurveyMail($details));
                                        $reminder = new SurveyReminder();
                                        $reminder->uuid = Str::uuid()->toString();
                                        $reminder->survey_activity_uuid = $event_prog->getProgramDetails->survey_activity_uuid;
                                        $reminder->event_registration_uuid = $value->uuid;
                                        $reminder->save();
                                    } catch (\Throwable $th) {
                                        info('Survey mail sent Failure for ' . $value->first_name . ' : ' . $th->getMessage());
                                    }
                                }
                            }
                        }
                    }
                }
                if ($check == 0) {
                    if (isset($value->getEventRegistrationOptional)) {
                        if (count($value->getEventRegistrationOptional)) {
                            $check = 1;
                            foreach ($value->getEventRegistrationOptional as $event_opt_reg) {
                                $check_survey = 0;
                                if (isset($event_opt_reg->getOptionalDetails)) {
                                    if ($event_opt_reg->getOptionalDetails->survey == 'yes' && $event_opt_reg->getOptionalDetails->survey_activity_uuid != null) {
                                        $check_survey = 1;
                                    }
                                }
                                if ($check_survey == 1) {
                                    $check_mail = SurveyReminder::where('survey_activity_uuid', $event_opt_reg->getOptionalDetails->survey_activity_uuid)->where('event_registration_uuid', $value->uuid)->count();

                                    if ($check_mail == 0) {
                                        $details = [
                                            'name' => $value->first_name,
                                            'survey_url' => route('customer.optional.survey', $event_opt_reg->uuid)
                                        ];
                                        try {
                                            Mail::to(trim($value->email))->send(new \App\Mail\SurveyMail($details));
                                            $reminder = new SurveyReminder();
                                            $reminder->uuid = Str::uuid()->toString();
                                            $reminder->survey_activity_uuid = $event_opt_reg->getOptionalDetails->survey_activity_uuid;
                                            $reminder->event_registration_uuid = $value->uuid;
                                            $reminder->save();
                                        } catch (\Throwable $th) {
                                            info('Survey mail sent Failure for ' . $value->first_name . ' : ' . $th->getMessage());
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
