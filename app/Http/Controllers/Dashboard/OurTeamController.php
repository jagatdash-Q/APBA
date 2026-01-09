<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\NotificationCron;
use App\Models\OurTeam;
use App\Models\OurTeamContent;
use App\Models\User;
use App\Models\WebmasterSection;
use App\Traits\Common;
use App\Traits\EmailTrait;
use App\Traits\Notification as NotificationTrait;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OurTeamController extends Controller
{
    use Common;
    use NotificationTrait;
    use EmailTrait;

    //
    public function __construct()
    {
        // Check Permissions

    }

    public function index()
    {
        if (!Auth::user()->hasPermission('our_team-read'))
            abort(403);
        $OurTeams = OurTeam::orderby('updated_at', 'desc')->with('userDetails', 'ourTeamListing', 'lockAcquiredUser', 'teamContent')->paginate(10);
        // General END
        return view('dashboard.our_teams.list', compact("OurTeams"));
    }
    public function create(Request $request)
    {
        if (!Auth::user()->hasPermission('our_team-create'))
            abort(403);
        // return view('dashboard.our_teams.create');
        if (OurTeam::first() == null) {
            $menu_list_msg = '';
            return view('dashboard.our_teams.create');
        } else {
            return redirect()->action('Dashboard\OurTeamController@index')->with('errorMessage', 'Our team page has already been created');
        }
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('our_team-create'))
            abort(403);
        if (OurTeam::first() == null) {
            $validator = Validator::make($request->all(), [
                'page_name' => 'required',
                'meta_title' => 'required',
                'meta_keyword' => 'required',
                'meta_description' => 'required',
                'title' => 'required',
                'desc' => 'required',
                'banner_image_web' => 'required',
                'banner_image_tablet' => 'required',
                'banner_image_mobile' => 'required',
                'banner_title' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $contents['content_status'] = (string)$request->submit;
            $contents['page_type'] = 'our_teams';
            $contents['uid'] = Str::uuid()->toString();
            $contents['created_by'] = Auth::id();
            $content_details = OurTeam::create($contents);
            $our_team_content = [];
            if ($content_details == null) {
                return redirect()->action('Dashboard\OurTeamController@index')->with('errorMessage', 'Something went wrong please try after sometime');
            }

            $form_data = array(
                'uid' => Str::uuid()->toString(),
                'our_teams_uid' => $content_details->uid,
                'page_name' => $request->page_name,
                'page_slug' => $this->slugify($request->page_name),
                'meta_title' => $request->meta_title,
                'meta_keywoard' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'title' => $request->title,
                'desc' => $request->desc,
                'banner_image_web' => Helper::GetMediaUid($request->banner_image_web),
                'banner_image_tablet' => Helper::GetMediaUid($request->banner_image_tablet),
                'banner_image_mobile' => Helper::GetMediaUid($request->banner_image_mobile),
                'banner_head' => $request->banner_title,
                'banner_desc' => $request->banner_desc,
                'button_link' => $request->button_link,
                'button_name' => $request->button_name,
                'banner_title_left_pos_web' => (float)$request->banner_title_left_pos_web_,
                'banner_title_top_pos_web' => (float)$request->banner_title_top_pos_web_,
                'banner_desc_left_pos_web' => (float)$request->banner_desc_left_pos_web_,
                'banner_desc_top_pos_web' => (float)$request->banner_desc_top_pos_web_,
                'button_name_left_pos_web' => (float)$request->button_name_left_pos_web_,
                'button_name_top_pos_web' => (float)$request->button_name_top_pos_web_,
                'banner_title_left_pos_tablet' => (float)$request->banner_title_left_pos_tablet_,
                'banner_title_top_pos_tablet' => (float)$request->banner_title_top_pos_tablet_,
                'banner_desc_left_pos_tablet' => (float)$request->banner_desc_left_pos_tablet_,
                'banner_desc_top_pos_tablet' => (float)$request->banner_desc_top_pos_tablet_,
                'button_name_left_pos_tablet' => (float)$request->button_name_left_pos_tablet_,
                'button_name_top_pos_tablet' => (float)$request->button_name_top_pos_tablet_,
                'banner_title_left_pos_mobile' => (float)$request->banner_title_left_pos_mobile_,
                'banner_title_top_pos_mobile' => (float)$request->banner_title_top_pos_mobile_,
                'banner_desc_left_pos_mobile' => (float)$request->banner_desc_left_pos_mobile_,
                'banner_desc_top_pos_mobile' => (float)$request->banner_desc_top_pos_mobile_,
                'button_name_left_pos_mobile' => (float)$request->button_name_left_pos_mobile_,
                'button_name_top_pos_mobile' => (float)$request->button_name_top_pos_mobile_,
                'status' => (int)$request->submit
            );
            $our_team_contents = OurTeamContent::create($form_data);
            $our_team_details =  OurTeam::where('uid', $content_details->uid)->first();
            $our_team_contents = OurTeamContent::where('our_teams_uid', $our_team_details->uid)->first();
            if ($our_team_details == null || $our_team_contents == null) {
                return redirect()->action('Dashboard\OurTeamController@index')->with('errorMessage', 'Something went wrong please try aftersometime');
            }
            // End of our_teams content
            return redirect()->action('Dashboard\OurTeamController@index')->with('doneMessage', __('Our team content added successfully'));
        } else {
            return redirect()->action('Dashboard\OurTeamController@index')->with('errorMessage', 'Our team page has already been created');
        }
    }

    public function edit($uid)
    {
        if (!Auth::user()->hasPermission('our_team-update'))
        abort(403);
        $our_team = OurTeam::where('uid', $uid)->with('userDetails', 'getOurTeamContent', 'lockAcquiredUser', 'ourTeamListing')->first();
        if ($our_team == null) {
            return view('dashboard.our_teams.list', "our_team")->with('errorMessage', 'Our Teams not found');
        }
        if ($our_team->getOurTeamContent == null) {
            return view('dashboard.our_teams.list', "our_team")->with('errorMessage', 'Our Teams not found');
        }
        return view('dashboard.our_teams.edit', compact("our_team"));
    }


    public function update(Request $request)
    {
        if (!Auth::user()->hasPermission('our_team-update'))
            abort(403);
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'page_name' => 'required',
            'meta_title' => 'required',
            'meta_keyword' => 'required',
            'meta_description' => 'required',
            'title' => 'required',
            'desc' => 'required',
            'banner_image_web' => 'required',
            'banner_image_tablet' => 'required',
            'banner_image_mobile' => 'required',
            'banner_title' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $contents['content_status'] = (string)$request->submit;
        $contents['page_type'] = 'our_teams';
        $contents['edited_by'] = Auth::id();
        $content_details = OurTeam::where('uid', $request->uid)->update($contents);
        $our_team_content = [];
        $form_data = array(
            'page_name' => $request->page_name,
            'page_slug' => $this->slugify($request->page_name),
            'meta_title' => $request->meta_title,
            'meta_keywoard' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'title' => $request->title,
            'desc' => $request->desc,
            'banner_image_web' => Helper::GetMediaUid($request->banner_image_web),
            'banner_image_tablet' => Helper::GetMediaUid($request->banner_image_tablet),
            'banner_image_mobile' => Helper::GetMediaUid($request->banner_image_mobile),
            'banner_head' => $request->banner_title,
            'banner_desc' => $request->banner_desc,
            'button_link' => $request->button_link,
            'button_name' => $request->button_name,
            'banner_title_left_pos_web' => (float)$request->banner_title_left_pos_web_,
            'banner_title_top_pos_web' => (float)$request->banner_title_top_pos_web_,
            'banner_desc_left_pos_web' => (float)$request->banner_desc_left_pos_web_,
            'banner_desc_top_pos_web' => (float)$request->banner_desc_top_pos_web_,
            'button_name_left_pos_web' => (float)$request->button_name_left_pos_web_,
            'button_name_top_pos_web' => (float)$request->button_name_top_pos_web_,
            'banner_title_left_pos_tablet' => (float)$request->banner_title_left_pos_tablet_,
            'banner_title_top_pos_tablet' => (float)$request->banner_title_top_pos_tablet_,
            'banner_desc_left_pos_tablet' => (float)$request->banner_desc_left_pos_tablet_,
            'banner_desc_top_pos_tablet' => (float)$request->banner_desc_top_pos_tablet_,
            'button_name_left_pos_tablet' => (float)$request->button_name_left_pos_tablet_,
            'button_name_top_pos_tablet' => (float)$request->button_name_top_pos_tablet_,
            'banner_title_left_pos_mobile' => (float)$request->banner_title_left_pos_mobile_,
            'banner_title_top_pos_mobile' => (float)$request->banner_title_top_pos_mobile_,
            'banner_desc_left_pos_mobile' => (float)$request->banner_desc_left_pos_mobile_,
            'banner_desc_top_pos_mobile' => (float)$request->banner_desc_top_pos_mobile_,
            'button_name_left_pos_mobile' => (float)$request->button_name_left_pos_mobile_,
            'button_name_top_pos_mobile' => (float)$request->button_name_top_pos_mobile_,
            'status' => (int)$request->submit
        );
        $our_team_contents = OurTeamContent::where('our_teams_uid', $request->uid)->update($form_data);
        // End of our_teams content
        return redirect()->action('Dashboard\OurTeamController@index')->with('doneMessage', __('Our team content updated successfully'));
    }




    public function delete(Request $request)
    {
        if (!Auth::user()->hasPermission('our_team-delete'))
            abort(403);
        $OurTeam = OurTeam::where('uid', $request->uid)->first();
        if ($OurTeam == null) {
            return ['status' => 'error', 'message' => 'Someting went wrong. OurTeam not found!'];
        } else {
            $deleted_data = array(
                'deleted_by' => Auth::id()
            );
            OurTeam::where('uid', $request->uid)->update($deleted_data);
            OurTeam::where('uid', $request->uid)->delete();
            // Make inactive our_teamscontent which is to be deleted
            return ['status' => 'success', 'message' => 'Our team page deleted successfully'];
        }
    }


    // public function update(Request $request)
    // {
    //     $region_id = $request->region_id;
    //     if (empty($region_id)) {
    //         return redirect()->action('Dashboard\OurTeamController@index')->with('errorMessage', __('Country not found'));
    //     }
    //     $langs = $this->get_language_by_country($region_id);
    //     if (empty($langs)) {
    //         return redirect()->action('Dashboard\OurTeamController@index')->with('errorMessage', __('Language not found'));
    //     }

    //     $all_inputs = $request->all();
    //     $filtered_input  = [];
    //     $filtered_input = $this->filter_input($langs, $all_inputs, $filtered_input);
    //     $country = Region::where('id', $region_id)->first();
    //     if ($country == null) {
    //         return redirect()->action('Dashboard\OurTeamController@index')->with('errorMessage', __('Country not found'));
    //     }
    //     $OurTeam = OurTeam::where('uid', $request->uid)->first();
    //     if ($OurTeam == null) {
    //         return redirect()->action('Dashboard\OurTeamController@index')->with('errorMessage', __('Our Team not found'));
    //     }

    //     $contents['content_status'] = (string)$request->submit;
    //     $contents['edited_by'] = 1;
    //     $contents['reject_remarks'] = isset($request->reject_remarks) ? $request->reject_remarks : '';

    //     $content_details = OurTeam::where('uid', $request->uid)->update($contents);

    //     if (empty($content_details)) {
    //         return redirect()->action('Dashboard\OurTeamController@index')->with('errorMessage', __('Something went wrong. Unable to update our team!'));
    //     }

    //     // Delete all OurTeamContentListing & OurTeam content
    //     $our_teams_listing = OurTeamContent::where('our_teams_uid', $request->uid)->get();
    //     if (count($our_teams_listing) > 0) {
    //         $our_team_listing_delete = OurTeamContent::where('our_teams_uid', $request->uid)->delete();
    //     }
    //     /* End of deleting our_team content */
    //     foreach ($langs as $lang) {
    //         $our_team_content_lists = $our_team_content = [];
    //         $our_team_content['title'] = '';
    //         $our_team_content_lists['content_title'] = '';
    //         $current_lang = $lang->language->id;

    //         foreach ($filtered_input[$lang->language->code] as $actual_title => $actual_value) {

    //             if (strpos($actual_title, "page_name") !== false && $actual_value != null) {
    //                 $our_team_content['page_name'] = $actual_value;
    //                 $our_team_content['page_slug'] = $this->slugify($actual_value);
    //             } else if (strpos($actual_title, "meta_title") !== false && $actual_value != null) {
    //                 $our_team_content['meta_title'] = $actual_value;
    //             } else if (strpos($actual_title, "meta_keywoard") !== false && $actual_value != null) {
    //                 $our_team_content['meta_keywoard'] = $actual_value;
    //             } else if (strpos($actual_title, "meta_description") !== false && $actual_value != null) {
    //                 $our_team_content['meta_description'] = $actual_value;
    //             }

    //             if (($actual_title == "title") && $actual_value != null) {
    //                 $our_team_content['title'] = $actual_value;
    //             }

    //             if (strpos($actual_title, "desc") !== false && $actual_value != null) {
    //                 $our_team_content['desc'] = $actual_value;
    //             }
    //         }

    //         if ($our_team_content['title'] != '') {
    //             $our_team_content['uid'] =  Str::uuid()->toString();
    //             $our_team_content['our_teams_uid'] = $request->uid;
    //             $our_team_content['lang_id'] = $current_lang;
    //             $our_team_content_details[$current_lang] = OurTeamContent::create($our_team_content);
    //         }
    //     }


    //     // if ($our_team_content_details != null) {
    //     //     $OurTeam = OurTeam::where('uid', $request->uid)->with('userDetails')->first();
    //     //     $our_team_creator = $OurTeam->userDetails;

    //     //     // Send notification to admin / super admin if send for approval
    //     //     if ($OurTeam->content_status == '2' && Auth::user()->permissions_id == 3) {
    //     //         $notification_status = Notification::where('content_id', $OurTeam->id)->whereIn('notification_type', ['approval'])->first();

    //     //         if ($notification_status != null) {
    //     //             /* Delete all previous notification of this content */
    //     //             $notification_delete = Notification::where('content_id', $OurTeam->id)->delete();
    //     //             $notification_cron_delete = NotificationCron::where('content_id', $OurTeam->id)->delete();
    //     //         }

    //     //         $noti_send_at = Carbon::now();
    //     //         $url = url('/') . '/admin/our-teams/edit/' . $OurTeam->uid;
    //     //         // Editor user details 
    //     //         $user_details = User::where('id', $OurTeam->created_by)->first();
    //     //         if ($user_details == null) {
    //     //             return redirect()->action('Dashboard\OurTeamController@index')->with('errorMessage', __('User not found'));
    //     //         }
    //     //         $OurTeamContent = OurTeamContent::where('our_teams_uid', $OurTeam->uid)->where('lang_id', $country->default_lang)->first();
    //     //         if ($OurTeamContent != null) {
    //     //             $message = 'Content review request from editor ' . $user_details->name . " - " . $OurTeamContent->page_name;

    //     //             $res = $this->content_notifications($OurTeam->id, $OurTeam->created_by, $OurTeam->page_type, 'approval', $noti_send_at, '1', $url, $message);
    //     //         } else {
    //     //             $message = 'Content review request from editor ' . $user_details->name;

    //     //             $res = $this->content_notifications($OurTeam->id, $OurTeam->created_by, $OurTeam->page_type, 'approval', $noti_send_at, '1', $url, $message);
    //     //         }


    //     //         // Send email to all admin and super admin for content approval
    //     //         $subject = 'Content review request from editor ' . $user_details->name . ' - ' . $OurTeamContent->page_name;
    //     //         $receiver = $user_details->email;
    //     //         $data['reviewer_name'] =  '';
    //     //         $data['content_title'] = $OurTeamContent->page_name;
    //     //         $data['target_url'] = $url;
    //     //         $mail_type = 'content_approval';
    //     //         $mail_response = $this->mail_integration($receiver, $subject, $data, $mail_type);
    //     //         Log::info("mail response " . json_encode($mail_response));
    //     //         // End of Send email to all admin and super admin for content approval
    //     //     }



    //     //     if ($our_team_creator == null) {
    //     //         Log::info('Something went wrong, user details not found ' . $OurTeam->uid);
    //     //     } else {
    //     //         // Send notification to editor for the page approved by admin / super admin
    //     //         if (($OurTeam->content_status == '1' || $OurTeam->content_status == '3') && (Auth::user()->permissions_id == 1 || Auth::user()->permissions_id == 2) && $OurTeam->userDetails->permissions_id == 3) {

    //     //             $notification_status = Notification::where('content_id', $OurTeam->id)->whereIn('notification_type', ['approved', 'reject'])->first();

    //     //             if ($notification_status != null) {
    //     //                 /* Delete all previous notification of this content */
    //     //                 $notification_delete = Notification::where('content_id', $OurTeam->id)->delete();
    //     //                 $notification_cron_delete = NotificationCron::where('content_id', $OurTeam->id)->delete();
    //     //             }

    //     //             $now = Carbon::now();
    //     //             $url = url('/') . '/admin/our-teams/edit/' . $OurTeam->uid;
    //     //             $OurTeamContent = OurTeamContent::where('our_teams_uid', $OurTeam->uid)->where('lang_id', $country->default_lang)->first();

    //     //             if ($OurTeam->content_status == '1') {
    //     //                 $message = 'Your content ' . $OurTeamContent->page_name . " has been approved";
    //     //                 $res = $this->content_notifications($OurTeam->id, $OurTeam->created_by, $OurTeam->page_type, 'approved', $now, '1', $url, $message);

    //     //                 // Send email to editor for his/her content approved
    //     //                 // $subject = 'Your content ' . $OurTeamContent->page_name . " has been approved";
    //     //                 // $receiver = $OurTeam->userDetails->email;
    //     //                 // $data['reviewer_name'] =  '';
    //     //                 // $data['content_title'] = $OurTeamContent->page_name;
    //     //                 // $data['target_url'] = $url;
    //     //                 // $mail_type = 'content_approved';
    //     //                 // $mail_response = $this->mail_integration($receiver, $subject, $data, $mail_type);
    //     //                 // End of Send email to all admin and super admin for content approval

    //     //             } else if ($OurTeam->content_status == '3') {
    //     //                 $message = 'Your content ' . $OurTeamContent->page_name . " has been rejected";
    //     //                 $reject_remarks = isset($request->reject_remarks) ? $request->reject_remarks : '';
    //     //                 $res = $this->content_notifications($OurTeam->id, $OurTeam->created_by, $OurTeam->page_type, 'reject', $now, '1', $url, $message, $reject_remarks);

    //     //                 // Send email to editor for content rejected
    //     //                 $subject = 'Your content ' . $OurTeamContent->page_name . " has been rejected";
    //     //                 $receiver = $OurTeam->userDetails->email;
    //     //                 $data['reviewer_name'] =  '';
    //     //                 $data['content_title'] = $OurTeamContent->page_name;
    //     //                 $data['target_url'] = $url;
    //     //                 $mail_type = 'content_rejected';
    //     //                 $data['reject_msg'] = $reject_remarks;

    //     //                 $mail_response = $this->mail_integration($receiver, $subject, $data, $mail_type);
    //     //                 // End of Send email to all admin and super admin for content approval
    //     //             }
    //     //         }
    //     //     }
    //     // }

    //     // // End of  Send notification to editor for the page approved by admin / super admin

    //     // // Remove lock
    //     // $response = $this->release_locked_content($request->uid, 'our_teams');
    //     // End of remove lock

    //     if ($content_details != null) {
    //         // Create listing according to the languages provides
    //         return redirect()->action('Dashboard\OurTeamController@index')->with('doneMessage', __('backend.saveDone'));
    //     } else {
    //         // error
    //         return redirect()->action('Dashboard\OurTeamController@index')->with('doneMessage', __('backend.error'));
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */

    // public function delete(Request $request)
    // {
    //     $OurTeam = OurTeam::where('uid', $request->uid)->first();
    //     if ($OurTeam == null) {
    //         return redirect()->action('Dashboard\OurTeamController@index')->with('errorMessage', __('Someting went wrong. OurTeam not found!'));
    //     }


    //     if (Auth::user()->permissions_id == 3 && $OurTeam->content_status == '2') {
    //         return redirect()->action('Dashboard\ContentsController@index')->with('doneMessage', __("The page is under review, You can't delete the page."));
    //     } else if (Auth::user()->permissions_id == 3 && $OurTeam->content_status == '1') {
    //         return redirect()->action('Dashboard\ContentsController@index')->with('doneMessage', __("The page is published;, You can't delete the page."));
    //     } else if ($OurTeam->content_status == '4') {
    //         return redirect()->action('Dashboard\ContentsController@index')->with('doneMessage', __("The page is unpublished;, You can't delete the page."));
    //     } else {

    //         $delete_notification = $this->notification_delete($OurTeam->id);
    //         $delete_notification_cron = $this->notification_cron_delete($OurTeam->id);

    //         // Make inactive our_teamscontent which is to be deleted
    //         $OurTeamContent = OurTeamContent::where('our_teams_uid', $request->uid)->update(['is_active'=> '0']);

    //         //  OurTeamListing will be deleted
    //         $OurTeamListing = OurTeamListing::where('our_teams_uid', $request->uid)->delete();

    //         $OurTeam->deleted_by = Auth::user()->id;
    //         $OurTeam->save();
    //         $our_teams_res = $OurTeam->delete();

    //         if ($our_teams_res == true) {
    //             return redirect()->action('Dashboard\OurTeamController@index')->with('doneMessage', __('backend.deleteDone'));
    //         } else {
    //             return redirect()->action('Dashboard\OurTeamController@index')->with('errorMessage', __('Someting went wrong. Can not delete this page!'));
    //         }
    //     }
    // }
}
