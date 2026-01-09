<?php

namespace App\Console\Commands;

use App\Models\EventRegistration;
use App\Models\EventRegistrationReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckEventRegistration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-event-registration:cron';

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
        $event_reg = EventRegistration::with(['getEventDetails', 'getEventProgram', 'getEventRegistrationOptional'])->get();
        if (count($event_reg) > 0) {
            foreach ($event_reg as $event) {
                if ($event->payment_status == 'success') {
                    $nomination_reminder_mail = EventRegistrationReminder::where('event_reg_uuid', $event->uuid)->where('mail_sent_for', $event->payment_status)->count();
                    if ($nomination_reminder_mail == 0) {
                        $details = [
                            'name' => $event->first_name,
                            'customer_id' => $event->customer_id,
                            'event_name' => isset($event->getEventDetails->event_name) ? $event->getEventDetails->event_name : '',
                            'event_start_date' => isset($event->getEventDetails->start_date) ? Carbon::parse($event->getEventDetails->start_date)->format('d F Y') : '',
                            'event_end_date' => isset($event->getEventDetails->end_date) ? Carbon::parse($event->getEventDetails->end_date)->format('d F Y') : '',
                            'event_venue' => isset($event->getEventDetails->event_location) ? $event->getEventDetails->event_location : '',
                            'event_program' => $event->getEventProgram,
                            'event_program_optional' => $event->getEventRegistrationOptional,
                            'total_amount' => $event->total_amount,
                        ];
                        try {
                            Mail::to($event->email)->send(new \App\Mail\EventRegistrationSuccessMail($details));
                            $nomination_reminder_mail_create = new EventRegistrationReminder();
                            $nomination_reminder_mail_create->uuid = Str::uuid()->toString();
                            $nomination_reminder_mail_create->event_reg_uuid = $event->uuid;
                            $nomination_reminder_mail_create->mail_sent_for = $event->payment_status;
                            $nomination_reminder_mail_create->save();
                        } catch (\Throwable $th) {
                            info('Event Success Registration Mail Error Log: ' . $th->getMessage());
                        }
                    }
                } elseif ($event->payment_status == 'failed') {
                    $nomination_reminder_mail = EventRegistrationReminder::where('event_reg_uuid', $event->uuid)->where('mail_sent_for', $event->payment_status)->count();
                    if ($nomination_reminder_mail == 0) {
                        $details = [
                            'name' => $event->first_name,
                            'event_name' => isset($event->getEventDetails->event_name) ? $event->getEventDetails->event_name : '',
                            'event_start_date' => isset($event->getEventDetails->start_date) ? Carbon::parse($event->getEventDetails->start_date)->format('d F Y') : '',
                            'event_end_date' => isset($event->getEventDetails->end_date) ? Carbon::parse($event->getEventDetails->end_date)->format('d F Y') : '',
                            'event_venue' => isset($event->getEventDetails->event_location) ? $event->getEventDetails->event_location : '',
                            'link' => url('/') . "/event-register/" . $event->getEventDetails->uid,
                        ];
                        try {
                            Mail::to($event->email)->send(new \App\Mail\EventRegistrationFailureMail($details));
                            $nomination_reminder_mail_create = new EventRegistrationReminder();
                            $nomination_reminder_mail_create->uuid = Str::uuid()->toString();
                            $nomination_reminder_mail_create->event_reg_uuid = $event->uuid;
                            $nomination_reminder_mail_create->mail_sent_for = $event->payment_status;
                            $nomination_reminder_mail_create->save();
                        } catch (\Throwable $th) {
                            info('Event Failure Registration Mail Error Log: ' . $th->getMessage());
                        }
                    }
                }
            }
        }
    }
}
