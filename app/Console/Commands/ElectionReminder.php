<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Voting;
use App\Models\VotingReminderMailSentStatus;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ElectionReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'election-reminder:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder and election start mail to customer';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Send create mail 
        // Get the voting created today
        try {
            $voting_positions = [];
            $voting_details = [];
            $votings = Voting::whereDate('created_at', '=', Carbon::today())->with(['getVotingPositions', 'getNominationDetails'])->get();
            foreach ($votings as $index => $value) {
                // Get the positions
                if (count($value->getVotingPositions)) {
                    $voting_details[$index]['nomination_name'] = $value->getNominationDetails->name;
                    $voting_details[$index]['voting_start_date'] = $value->start_date;
                    $voting_details[$index]['voting_end_date'] = $value->end_date;
                    $voting_details[$index]['uuid'] = $value->uuid;
                    foreach ($value->getVotingPositions as $key => $val) {
                        if ($val->getNominationPositionDetails != null) {
                            if ($val->getNominationPositionDetails->getPosition != null) {
                                array_push($voting_positions, $val->getNominationPositionDetails->getPosition->membership_position);
                            }
                        }
                    }
                    $voting_details[$index]['positions'] = $voting_positions;
                    $voting_positions = [];
                }
            }
            if (count($voting_details)) {
                foreach ($voting_details as $vot) {
                    // check customer whom mail sent
                    $customerID = VotingReminderMailSentStatus::where('voting_uuid', $vot['uuid'])->where('mail_sent_for', 'create_day')->pluck('customer_id')->toArray();
                    $customers = Customer::with('getActiveSubscriptionDetails')->whereNotIn('id', $customerID)->where('is_verify_email', '1')->where('current_subscription_status', 'a')->where('nomination', 'yes')->get();
                    $count = 1;
                    // Check the subscription details
                    foreach ($customers as $val) {
                        // check maximum number of customers insert
                        if ($count <= 125) {
                            if ($val->getActiveSubscriptionDetails != null) {
                                if (strpos($val->getActiveSubscriptionDetails, "Corporate") == false) {
                                    // Check if mail sent or not 
                                    $is_mail_sent = VotingReminderMailSentStatus::where('customer_id', $val->id)->where('voting_uuid', $vot['uuid'])->where('mail_sent_for', 'create_day')->first();
                                    if ($is_mail_sent == null) {
                                        $details = [
                                            'nomination_name' => $vot['nomination_name'],
                                            'positions' => $vot['positions'],
                                            'voting_start_date' => Carbon::parse($vot['voting_start_date'])->format('F jS,Y'),
                                            'voting_end_date' => Carbon::parse($vot['voting_end_date'])->format('F jS,Y'),
                                            'customer_name' => $val->user_name
                                        ];
                                        try {
                                            Mail::to($val->email)->send(new \App\Mail\election\ElectionCreateMail($details));
                                            VotingReminderMailSentStatus::create([
                                                'customer_id' => $val->id,
                                                'voting_uuid' => $vot['uuid'],
                                                'mail_sent_for' => "create_day",
                                            ]);
                                        } catch (Exception $e) {
                                            Log::info('Mail sent error of Election starting : -' . $e->getMessage());
                                        }
                                    }
                                }
                            }
                        }
                        $count++;
                    }
                }
            }
        } catch (Exception $e) {
            Log::info('Mail sent error of Election : -' . $e->getMessage());
        }

        // send mail on interval
        try {
            $voting_positions = [];
            $voting_details = [];
            $votings = Voting::whereDate('end_date', '>=', Carbon::today())->with(['getVotingPositions', 'getNominationDetails'])->get();
            foreach ($votings as $index => $value) {
                // Get the positions
                if (count($value->getVotingPositions)) {
                    $voting_details[$index]['voting_start_date'] = $value->start_date;
                    $voting_details[$index]['voting_end_date'] = $value->end_date;
                    $voting_details[$index]['uuid'] = $value->uuid;
                    foreach ($value->getVotingPositions as $key => $val) {
                        if ($val->getNominationPositionDetails != null) {
                            if ($val->getNominationPositionDetails->getPosition != null) {
                                array_push($voting_positions, $val->getNominationPositionDetails->getPosition->membership_position);
                            }
                        }
                    }
                    $voting_details[$index]['positions'] = $voting_positions;
                    $voting_positions = [];
                }
            }
            if (count($voting_details)) {
                foreach ($voting_details as $vot) {

                    $customerID = VotingReminderMailSentStatus::where('voting_uuid', $vot['uuid'])->where('mail_sent_for', 'start_day')->pluck('customer_id')->toArray();
                    $customers = Customer::with('getActiveSubscriptionDetails')->whereNotIn('id', $customerID)->where('is_verify_email', '1')->where('current_subscription_status', 'a')->where('nomination', 'yes')->get();
                    // Check the subscription details
                    $v_count = 1;
                    foreach ($customers as $val) {
                        if ($v_count <= 125) {
                            if ($val->getActiveSubscriptionDetails != null) {
                                if (strpos($val->getActiveSubscriptionDetails, "Corporate") == false) {
                                    // Sent mail on start day
                                    if (Carbon::parse($vot['voting_start_date'])->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                                        // Check if mail sent or not 
                                        $is_mail_sent = VotingReminderMailSentStatus::where('customer_id', $val->id)->where('voting_uuid', $vot['uuid'])->where('mail_sent_for', 'start_day')->first();
                                        if ($is_mail_sent == null) {
                                            $details = [
                                                'name' => $val->user_name,
                                                'start_date' => Carbon::parse($vot['voting_start_date'])->format('F jS,Y'),
                                                'end_date' => Carbon::parse($vot['voting_end_date'])->format('F jS,Y')
                                            ];
                                            try {
                                                Mail::to($val->email)->send(new \App\Mail\election\ElectionStartMail($details));
                                                VotingReminderMailSentStatus::create([
                                                    'customer_id' => $val->id,
                                                    'voting_uuid' => $vot['uuid'],
                                                    'mail_sent_for' => "start_day",
                                                ]);
                                            } catch (Exception $e) {
                                                Log::info('Mail sent error of Election starting : -' . $e->getMessage());
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $v_count++;
                    }

                    $customerID = VotingReminderMailSentStatus::where('voting_uuid', $vot['uuid'])->where('mail_sent_for', '30')->pluck('customer_id')->toArray();
                    $customers = Customer::with('getActiveSubscriptionDetails')->whereNotIn('id', $customerID)->where('is_verify_email', '1')->where('current_subscription_status', 'a')->where('nomination', 'yes')->get();
                    $val_count = 1;
                    foreach ($customers as $val) {
                        if ($val_count <= 125) {
                            if ($val->getActiveSubscriptionDetails != null) {
                                if (strpos($val->getActiveSubscriptionDetails, "Corporate") == false) {
                                    if (Carbon::parse($vot['voting_start_date'])->format('Y-m-d') != Carbon::now()->format('Y-m-d')) {
                                        // date difference 
                                        $end_date = Carbon::parse(Carbon::parse($vot['voting_end_date'])->format('Y-m-d'));
                                        $current_date = Carbon::parse(Carbon::now()->format('Y-m-d'));
                                        $days_difference = $current_date->diffInDays($end_date);
                                        if ($end_date->gt($current_date)) {
                                            if ($days_difference == 30) {
                                                $is_mail_sent = VotingReminderMailSentStatus::where('customer_id', $val->id)->where('voting_uuid', $vot['uuid'])->where('mail_sent_for', $days_difference)->first();
                                                if ($is_mail_sent == null) {
                                                    $details = [
                                                        'name' => $val->user_name,
                                                        'start_date' => Carbon::parse($vot['voting_start_date'])->format('F jS,Y'),
                                                        'end_date' => Carbon::parse($vot['voting_end_date'])->format('F jS,Y')
                                                    ];
                                                    try {
                                                        Mail::to($val->email)->send(new \App\Mail\election\ElectionReminderMail($details));
                                                        VotingReminderMailSentStatus::create([
                                                            'customer_id' => $val->id,
                                                            'voting_uuid' => $vot['uuid'],
                                                            'mail_sent_for' => $days_difference,
                                                        ]);
                                                    } catch (Exception $e) {
                                                        Log::info('Mail sent error of Election of  : -' . $e->getMessage());
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $val_count++;
                    }

                    $customerID = VotingReminderMailSentStatus::where('voting_uuid', $vot['uuid'])->where('mail_sent_for', '14')->pluck('customer_id')->toArray();
                    $customers = Customer::with('getActiveSubscriptionDetails')->whereNotIn('id', $customerID)->where('is_verify_email', '1')->where('current_subscription_status', 'a')->where('nomination', 'yes')->get();
                    $var14_count = 1;
                    foreach ($customers as $val) {
                        if ($var14_count <= 125) {
                            if ($val->getActiveSubscriptionDetails != null) {
                                if (strpos($val->getActiveSubscriptionDetails, "Corporate") == false) {
                                    if (Carbon::parse($vot['voting_start_date'])->format('Y-m-d') != Carbon::now()->format('Y-m-d')) {
                                        // date difference 
                                        $end_date = Carbon::parse(Carbon::parse($vot['voting_end_date'])->format('Y-m-d'));
                                        $current_date = Carbon::parse(Carbon::now()->format('Y-m-d'));
                                        $days_difference = $current_date->diffInDays($end_date);
                                        if ($end_date->gt($current_date)) {
                                            if ($days_difference == 14) {
                                                $is_mail_sent = VotingReminderMailSentStatus::where('customer_id', $val->id)->where('voting_uuid', $vot['uuid'])->where('mail_sent_for', $days_difference)->first();
                                                if ($is_mail_sent == null) {
                                                    $details = [
                                                        'name' => $val->user_name,
                                                        'start_date' => Carbon::parse($vot['voting_start_date'])->format('F jS,Y'),
                                                        'end_date' => Carbon::parse($vot['voting_end_date'])->format('F jS,Y')
                                                    ];
                                                    try {
                                                        Mail::to($val->email)->send(new \App\Mail\election\ElectionReminderMail($details));
                                                        VotingReminderMailSentStatus::create([
                                                            'customer_id' => $val->id,
                                                            'voting_uuid' => $vot['uuid'],
                                                            'mail_sent_for' => $days_difference,
                                                        ]);
                                                    } catch (Exception $e) {
                                                        Log::info('Mail sent error of Election of  : -' . $e->getMessage());
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $var14_count++;
                    }

                    $customerID = VotingReminderMailSentStatus::where('voting_uuid', $vot['uuid'])->where('mail_sent_for', '7')->pluck('customer_id')->toArray();
                    $customers = Customer::with('getActiveSubscriptionDetails')->whereNotIn('id', $customerID)->where('is_verify_email', '1')->where('current_subscription_status', 'a')->where('nomination', 'yes')->get();
                    $var7_count = 1;
                    foreach ($customers as $val) {
                        if ($var7_count <= 125) {
                            if ($val->getActiveSubscriptionDetails != null) {
                                if (strpos($val->getActiveSubscriptionDetails, "Corporate") == false) {
                                    if (Carbon::parse($vot['voting_start_date'])->format('Y-m-d') != Carbon::now()->format('Y-m-d')) {
                                        // date difference 
                                        $end_date = Carbon::parse(Carbon::parse($vot['voting_end_date'])->format('Y-m-d'));
                                        $current_date = Carbon::parse(Carbon::now()->format('Y-m-d'));
                                        $days_difference = $current_date->diffInDays($end_date);
                                        if ($end_date->gt($current_date)) {
                                            if ($days_difference == 7) {
                                                $is_mail_sent = VotingReminderMailSentStatus::where('customer_id', $val->id)->where('voting_uuid', $vot['uuid'])->where('mail_sent_for', $days_difference)->first();
                                                if ($is_mail_sent == null) {
                                                    $details = [
                                                        'name' => $val->user_name,
                                                        'start_date' => Carbon::parse($vot['voting_start_date'])->format('F jS,Y'),
                                                        'end_date' => Carbon::parse($vot['voting_end_date'])->format('F jS,Y')
                                                    ];
                                                    try {
                                                        Mail::to($val->email)->send(new \App\Mail\election\ElectionReminderMail($details));
                                                        VotingReminderMailSentStatus::create([
                                                            'customer_id' => $val->id,
                                                            'voting_uuid' => $vot['uuid'],
                                                            'mail_sent_for' => $days_difference,
                                                        ]);
                                                    } catch (Exception $e) {
                                                        Log::info('Mail sent error of Election of  : -' . $e->getMessage());
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $var7_count++;
                    }

                    $customerID = VotingReminderMailSentStatus::where('voting_uuid', $vot['uuid'])->where('mail_sent_for', '1')->pluck('customer_id')->toArray();
                    $customers = Customer::with('getActiveSubscriptionDetails')->whereNotIn('id', $customerID)->where('is_verify_email', '1')->where('current_subscription_status', 'a')->where('nomination', 'yes')->get();
                    $var1_count = 1;
                    foreach ($customers as $val) {
                        if ($var1_count <= 125) {
                            if ($val->getActiveSubscriptionDetails != null) {
                                if (strpos($val->getActiveSubscriptionDetails, "Corporate") == false) {
                                    if (Carbon::parse($vot['voting_start_date'])->format('Y-m-d') != Carbon::now()->format('Y-m-d')) {
                                        // date difference 
                                        $end_date = Carbon::parse(Carbon::parse($vot['voting_end_date'])->format('Y-m-d'));
                                        $current_date = Carbon::parse(Carbon::now()->format('Y-m-d'));
                                        $days_difference = $current_date->diffInDays($end_date);
                                        if ($end_date->gt($current_date)) {
                                            if ($days_difference == 1) {
                                                $is_mail_sent = VotingReminderMailSentStatus::where('customer_id', $val->id)->where('voting_uuid', $vot['uuid'])->where('mail_sent_for', $days_difference)->first();
                                                if ($is_mail_sent == null) {
                                                    $details = [
                                                        'name' => $val->user_name,
                                                        'start_date' => Carbon::parse($vot['voting_start_date'])->format('F jS,Y'),
                                                        'end_date' => Carbon::parse($vot['voting_end_date'])->format('F jS,Y')
                                                    ];
                                                    try {
                                                        Mail::to($val->email)->send(new \App\Mail\election\ElectionReminderMail($details));
                                                        VotingReminderMailSentStatus::create([
                                                            'customer_id' => $val->id,
                                                            'voting_uuid' => $vot['uuid'],
                                                            'mail_sent_for' => $days_difference,
                                                        ]);
                                                    } catch (Exception $e) {
                                                        Log::info('Mail sent error of Election of  : -' . $e->getMessage());
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $var1_count++;
                    }
                }
            }
        } catch (Exception $e) {
            Log::info('Mail sent error of Election : -' . $e->getMessage());
        }
    }
}
