<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContentApprovalEmailToAdmin;
use App\Mail\ContentRejectionEmailToEditor;
use App\Mail\ContentApprovalThreeDaysReminderEmailToAdmin;
use App\Mail\ContentApprovalFiveDaysReminderEmailToAdmin;
use Exception;
use Illuminate\Support\Facades\Log;

trait EmailTrait
{
    /* --- fetch languge data by region id --- */
    public function mail_integration($receiver, $subject, $data, $mail_type = null)
    {

        $data['receiver_name'] = '';

        if($receiver != null){
            $user_details = User::where('email', $receiver)->first();
            if($user_details != null){
                $data['receiver_name'] = $user_details->name;
            }
        }

        switch ($mail_type) {
            case 'content_approval':
                $user_list = User::whereIn('permissions_id', [1, 2])->get();

                if (count($user_list) > 0) {
                    foreach ($user_list as $user) {
                        $data['reviewer_name'] = $user->name;
                        try {
                            Mail::to($user->email)->send(new ContentApprovalEmailToAdmin( $subject , $data));
                        } catch (Exception $e) {
                            Log::info($e->getMessage());
                        }
                    }
                }

                break;
                // case 'content_approved':
                //     try {
                //         Mail::to($receiver)->send(new ContentApprovedEmailToEditor($data, $subject));
                //     } catch (Exception $e) {
                //         Log::info($e->getMessage());
                //     }
                //     break;

            case 'content_rejected':
                if ($receiver == null) {
                    $data['subject'] = $subject;
                    $data['receiver'] = $receiver;
                    $data['data'] = $data;
                    Log::info(json_encode($data));
                    $data['message'] = 'Receiver not found';
                    return true;
                }

                try {
                     Mail::to($receiver)->send(new ContentRejectionEmailToEditor( $subject , $data));
                } catch (Exception $e) {
                    Log::info($e->getMessage());
                }


                break;

            case 'three_days_approval_noti':
                if ($receiver == null) {
                    $data['subject'] = $subject;
                    $data['receiver'] = $receiver;
                    $data['data'] = $data;
                    $data['message'] = 'Receiver not found';
                    Log::info(json_encode($data));
                    return true;
                }

                try {
                    Mail::to($receiver)->send(new ContentApprovalThreeDaysReminderEmailToAdmin( $subject , $data));
                } catch (Exception $e) {
                    Log::info($e->getMessage());
                }


                break;

            case 'five_days_approval_noti':
                if ($receiver == null) {
                    $data['subject'] = $subject;
                    $data['receiver'] = $receiver;
                    $data['data'] = $data;
                    $data['message'] = 'Receiver not found';
                    Log::info(json_encode($data));
                    return true;
                }

                try {
                    Mail::to($receiver)->send(new ContentApprovalFiveDaysReminderEmailToAdmin($subject, $data));
                } catch (Exception $e) {
                    Log::info($e->getMessage());
                }
                break;

            default:
                return false;
        }
        return true;
    }
}
