<?php

namespace App\Traits;

use App\Models\Language_mapping;
use App\Models\CareerListing;
use App\Models\Content;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Language;
use App\Models\MediaManager;
use App\Models\Notification as NotificationModel;
use App\Models\NotificationCron;
use App\Models\Region;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait Notification
{
    /*  Notification Management */
    public function content_notifications($content_id, $sender_id, $page_type, $notification_type, $noti_send_at, $status, $content_url, $message, $reject_remarks = null)
    {

        $notification['content_id'] = $content_id;
        $notification['sender_id'] = $sender_id;
        $notification['page_type'] = $page_type;
        $notification['notification_type'] = $notification_type;
        $notification['noti_send_at'] = $noti_send_at;
        $notification['status'] = $status;
        $notification['content_url'] = $content_url;
        $notification['message'] = $message;
        if($reject_remarks != null && $notification_type == 'reject'){
            $notification['reject_remarks'] = $reject_remarks;
        }
        
        if ($notification_type == 'approval') {
            $res = array();
            // Fetch all admin and super admin notifications

            $user_list = User::whereIn('permissions_id', [1, 2])->get();
            if (count($user_list) > 0) {
                foreach ($user_list as $user) {
                    $notification['receiver_id'] = $user->id;
                    $res[] = NotificationModel::create($notification);
                }
            }
            return $res;
        } else {
            return NotificationModel::create($notification);
        }
    }

    public function notification_cron()
    {
        // Check for 3 days notification

        $date = Carbon::today()->subDay()->toDateString();

        $notification_cron_3 = NotificationModel::where('status', '1')->where('notification_type', 'approval')->where('noti_send_at', '=', $date)->where('noti_cron', '0')->with('pageDetails', 'senderDetails', 'receiverDetails')->groupBy('content_id')->get();


        if (count($notification_cron_3) > 0) {
            foreach ($notification_cron_3 as $notification) {

                $notification_cron = array();
                $notification_cron['content_id'] = $notification->content_id;
                $notification_cron['user_id'] = $notification->receiver_id;
                $notification_cron['notification_id'] = $notification->id;
                $notification_cron['message'] = $notification->message;
                $notification_cron['content_url'] = $notification->content_url;
                $notification_cron['type'] = 'notification';
                $notification_cron['cron_type'] = '1';
                $res = NotificationCron::create($notification_cron);

                if ($res != null) {
                    // update notification
                    $noti_res = NotificationModel::where('content_id', $notification->content_id)->update(['noti_cron' => '1']);
                }
            }
        }

        // Checking for 7 days notifications
        $date = Carbon::today()->subDay()->toDateString();
        $notification_cron_7 = NotificationModel::where('status', '1')->where('notification_type', 'approval')->where('noti_send_at', '=', $date)->where('noti_cron', '1')->with('pageDetails', 'senderDetails', 'receiverDetails')->get();


        if (count($notification_cron_7) > 0) {
            foreach ($notification_cron_7 as $notification) {

                $notification_cron = array();
                $notification_cron['content_id'] = $notification->content_id;
                $notification_cron['user_id'] = $notification->receiver_id;
                $notification_cron['notification_id'] = $notification->id;
                $notification_cron['content_url'] = $notification->content_url;
                $notification_cron['message'] = $notification->message;
                $notification_cron['type'] = 'notification';
                $notification_cron['cron_type'] = '2';
                $res = NotificationCron::create($notification_cron);
                if ($res != null) {
                    // update notification
                    $noti_res = NotificationModel::where('content_id', $notification->content_id)->update([
                        'noti_cron' => '2'
                    ]);
                }
            }
        }
    }

    public function email_cron()
    {
        // Check for 3 days notification

        $date = Carbon::today()->subDay()->toDateString();
        $notification_cron_3 = NotificationModel::where('status', '1')->where('notification_type', 'approval')->where('noti_send_at', '=', $date)->where('noti_email_cron', '0')->with('pageDetails', 'senderDetails', 'receiverDetails')->get();

        if (count($notification_cron_3) > 0) {
            foreach ($notification_cron_3 as $notification) {

                // $notification_cron = array();
                // $notification_cron['content_id'] = $notification['content_id'];
                // $notification_cron['user_id'] = $notification['user_id'];
                // $notification_cron['notification_id'] = $notification['notification_id'];
                // $notification_cron['message'] = $notification['message'];
                // $notification_cron['type'] = $notification['type'];
                // $notification_cron['cron_type'] = $notification['cron_type'];
                // $res = NotificationCron::create($notification_cron);

                // Send email

                // if ($res != null) {
                // update notification
                $noti_res = NotificationModel::where('content_id', $notification->content_id)->update([
                    'noti_email_cron' => '1'
                ]);
                // }
            }
        }

        // Checking for 7 days notifications
        $date = Carbon::today()->subDay()->toDateString();
        $notification_cron_7 = NotificationModel::where('status', '1')->where('notification_type', 'content_approval')->where('noti_send_at', '=', $date)->where('noti_email_cron', '1')->with('pageDetails', 'senderDetails', 'receiverDetails')->get();

        if (count($notification_cron_7) > 0) {
            foreach ($notification_cron_3 as $notification) {

                // $notification_cron = array();
                // $notification_cron['content_id'] = $notification['content_id'];
                // $notification_cron['user_id'] = $notification['user_id'];
                // $notification_cron['notification_id'] = $notification['notification_id'];
                // $notification_cron['message'] = $notification['message'];
                // $notification_cron['type'] = $notification['type'];
                // $notification_cron['cron_type'] = $notification['cron_type'];
                // $res = NotificationCron::create($notification_cron);

                // Send EMail Notification



                // if ($res != null) {
                // update notification
                $noti_res = NotificationModel::where('content_id', $notification->content_id)->update([
                    'noti_email_cron', '2'
                ]);
                // }
            }
        }
    }

    public function notification_update($content_id, $status, $action, $data_model = null)
    {

        $current_date_time = Carbon::now()->toDateTimeString();

        switch ($status) {
            case 'view':
                // Check notification in notification model
                if ($data_model  == null) {
                    $notification_data = NotificationModel::where('content_id', $content_id)->first();
                    if($notification_data == null){
                        return false;
                    }
                    $update_array = [
                        'read_at' => $current_date_time,
                        // 'reviewed_date' => date("Y-m-d h:m:s", $t),
                        // 'updated_at' => date("Y-m-d h:m:s", $t),
                        // 'updated_by' => $user_id,
                    ];
                    $notification_update_status = NotificationModel::where('content_id', $content_id)->where('status', '1')->update($update_array);
                    if (!empty($notification_update_status)) {

                        // redirect to actual view  
                        // $notification = Notification::where('content_id', $content_id)->first();
                        return $notification_update_status;
                    } else {

                        return false;
                    }
                } elseif ($data_model == 'noti_cron') {
                    // Notification for cron data
                    $notification_cron_data = NotificationCron::where('content_id', $content_id)->first();
                    if (!empty($notification_cron_data)) {
                        $notification_update_status = NotificationCron::where('content_id', $content_id)->where('status', '1')->update([
                            'read_at' => $current_date_time,
                            'status' => '0'
                        ]);
                    }
                }

            case 'update':
                $update_array = [
                    'read_at' => $current_date_time,
                    'status' => '0'
                ];

                if ($data_model == 'noti_cron') {
                    return NotificationCron::where('content_id', $content_id)->where('status', '1')->update($update_array);
                }

                $notification_update_status = NotificationModel::where('content_id', $content_id)->where('status', '1')->update($update_array);
                if (!empty($notification_update_status)) {
                    // redirect to actual view  
                    return $notification_update_status;
                } else {
                    return false;
                }
        }
    }

    public function notification_delete($content_id)
    {
        $notification_lists = NotificationModel::where('content_id', $content_id)->get();
        if (count($notification_lists) > 0) {
            $noti_delete_status = NotificationModel::where('content_id', $content_id)->delete();;
            if ($noti_delete_status == false) {
                Log::info('Notification can not deleted of page id ' . $content_id);
                return $noti_delete_status;
            }
        }
        return true;
    }

    public function notification_cron_delete($content_id)
    {
        $notification_lists = NotificationCron::where('content_id', $content_id)->get();
        if (count($notification_lists) > 0) {
            $noti_delete_status = NotificationModel::where('content_id', $content_id)->delete();;
            if ($noti_delete_status == false) {
                Log::info('Notification cron can not deleted of page id ' . $content_id);
                return $noti_delete_status;
            }
        }
        return true;
    }
}
