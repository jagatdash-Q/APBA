<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Nomination;
use App\Models\NominationPosition;
use App\Models\NominationReminder;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckNomination extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-nomination:cron';

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
        $nomination = Nomination::with('getNominationPosition')->where('status', '1')->get();
        if (count($nomination) > 0) {
            foreach ($nomination as $data) {
                $nomiantion_end_date = Carbon::parse($data->end_date);
                $nomination_start_date = Carbon::parse($data->start_date);
                $nomination_create_date = Carbon::parse($data->created_at)->format('Y-m-d');
                $today_date = Carbon::now()->format('Y-m-d');
                $customer_data = Customer::where('is_verify_email', '1')->where('current_subscription_status', 'a')->where('nomination', 'yes')->get();

                // Nomination create mail
                if ($nomination_create_date === $today_date && count($customer_data) > 0) {
                    foreach ($customer_data as $customer) {
                        $this->mail_sent($data, $customer, 'create_day');
                    }
                }
                // Nomination start mail
                if ($nomination_start_date->eq($today_date) && count($customer_data) > 0) {
                    foreach ($customer_data as $customer) {
                        $this->mail_sent($data, $customer, '0');
                    }
                }

                // Nomination reminder mail
                if ($nomiantion_end_date->gte($today_date)) {
                    if (count($customer_data) > 0) {
                        foreach ($customer_data as $customer) {
                            $days = $nomiantion_end_date->diffInDays($today_date);
                            if ($days == '30') {
                                $this->mail_sent($data, $customer, $days);
                            } elseif ($days == '14') {
                                $this->mail_sent($data, $customer, $days);
                            } elseif ($days == '7') {
                                $this->mail_sent($data, $customer, $days);
                            } elseif ($days == '1') {
                                $this->mail_sent($data, $customer, $days);
                            }
                        }
                    }
                } else {
                    // Nomination expire check
                    $data->status = '0';
                    $data->save();
                }
            }
        }
    }
    public function mail_sent($nomination, $customer, $days)
    {
        $nomination_reminder_mail = NominationReminder::where('customer_id', $customer->id)->where('mail_sent_days', $days)->count();
        if ($nomination_reminder_mail == 0) {
            try {
                if ($days == 'create_day') {
                    $position_name = [];
                    if (count($nomination->getNominationPosition) > 0) {
                        foreach ($nomination->getNominationPosition as $key => $value) {
                            if (isset($value->getPosition)) {
                                $position_name[$key] = $value->getPosition->membership_position;
                            }
                        }
                    }
                    $details = [
                        'name' => $customer->user_name,
                        'position' => $position_name,
                        'start_date' => Carbon::parse($nomination->start_date)->format('d F Y'),
                        'end_date' => Carbon::parse($nomination->end_date)->format('d F Y')
                    ];
                    Mail::to($customer->email)->send(new \App\Mail\Nomination\NominationCreateMail($details));
                } elseif ($days == '0') {
                    $details = [
                        'name' => $customer->user_name,
                        'start_date' => Carbon::parse($nomination->start_date)->format('d F Y'),
                        'end_date' => Carbon::parse($nomination->end_date)->format('d F Y')
                    ];
                    Mail::to($customer->email)->send(new \App\Mail\Nomination\NominationStartMail($details));
                } else {
                    $details = [
                        'name' => $customer->user_name,
                        'start_date' => Carbon::parse($nomination->start_date)->format('d F Y'),
                        'end_date' => Carbon::parse($nomination->end_date)->format('d F Y')
                    ];
                    Mail::to($customer->email)->send(new \App\Mail\Nomination\NominationReminderMail($details));
                }
                $create_reminder = NominationReminder::firstOrNew(array('nomination_uuid' => $nomination->uuid, 'mail_sent_days' => $days, 'customer_id' => $customer->id));
                $create_reminder->save();
            } catch (Exception $e) {
                info('Mail not send to this ' . $customer->email . ' mail id for ' . $days . ' days before reminder mail. Error=> ' . $e->getMessage());
            }
        }
    }
}
