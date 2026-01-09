<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\ReminderMail;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;

class CheckSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-subscription:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $customer_data = Customer::where('is_verify_email', '1')->where('current_subscription_status', 'a')->whereNot('active_subscription_expired_on', null)->get();

        if (count($customer_data) > 0) {
            foreach ($customer_data as $data) {
                $reminder_mail = ReminderMail::query();
                $reminder_mail = $reminder_mail->where('customer_id', $data->id);
                $end_date = Carbon::now()->format('Y-m-d');
                $start_date = Carbon::parse($data->active_subscription_expired_on);
                if ($start_date->gte($end_date)) {
                    // info('Active');
                    $days = $start_date->diffInDays($end_date);
                    if ($days == '15') {
                        $reminder_mail = $reminder_mail->where('mail_sent_days', '15')->count();
                        if ($reminder_mail == 0) {
                            try {
                                Mail::to($data->email)->send(new \App\Mail\SubscriptionReminderMail(Carbon::parse($data->active_subscription_expired_on)->format('d F Y'), $data->first_name));
                                $create_reminder = ReminderMail::firstOrNew(array('mail_sent_days' => '15', 'customer_id' => $data->id));
                                $create_reminder->save();
                            } catch (Exception $e) {
                                info('Mail not send to this ' . $data->email . ' mail id for 15 days before reminder mail. Error=> ' . $e->getMessage());
                            }
                        }
                    } elseif ($days == '5') {
                        $reminder_mail = $reminder_mail->where('mail_sent_days', '5')->count();
                        if ($reminder_mail == 0) {
                            try {
                                Mail::to($data->email)->send(new \App\Mail\SubscriptionReminderMail(Carbon::parse($data->active_subscription_expired_on)->format('d F Y'), $data->first_name));
                                $create_reminder = ReminderMail::firstOrNew(array('mail_sent_days' => '5', 'customer_id' => $data->id));
                                $create_reminder->save();
                            } catch (Exception $e) {
                                info('Mail not send to this ' . $data->email . ' mail id for 5 days before reminder mail. Error=> ' . $e->getMessage());
                            }
                        }
                    } elseif ($days == '1') {
                        $reminder_mail = $reminder_mail->where('mail_sent_days', '1')->count();
                        if ($reminder_mail == 0) {
                            try {
                                Mail::to($data->email)->send(new \App\Mail\SubscriptionReminderMail(Carbon::parse($data->active_subscription_expired_on)->format('d F Y'), $data->first_name));
                                $create_reminder = ReminderMail::firstOrNew(array('mail_sent_days' => '1', 'customer_id' => $data->id));
                                $create_reminder->save();
                            } catch (Exception $e) {
                                info('Mail not send to this ' . $data->email . ' mail id for 1 day before reminder mail. Error=> ' . $e->getMessage());
                            }
                        }
                    }
                } else {
                    // info('Expire');
                    $data->current_subscription_status = 'e';
                    $data->save();
                    if ($data->save())
                        $reminder_mail->delete();
                }
            }
        }
    }
}
