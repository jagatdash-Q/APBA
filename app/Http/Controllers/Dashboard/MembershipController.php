<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\DefaultMembership;
use App\Models\MembershipContent;
use App\Models\MembershipPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Traits\Common;
use Illuminate\Support\Facades\Validator;

class MembershipController extends Controller
{
    use Common;
    public function createMemberShip(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-create'))
            abort(403);
        $member_ships_exists = '';
        if (Content::where('template_type', 'membership')->where('content_status', '1')->count()) {
            return redirect()->route('admin.contents.manage')->with('errorMessage', 'Membership page already has been created');
        } else {
            $is_content_create = MembershipContent::create([
                'created_by' => Auth::id(),
                'content_id' => $request->content_id,
                'uuid' => Str::uuid()->toString(),
                'page_name' => $request->page_name,
                'page_slug' => $this->slugify($request->page_name),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'section_1_head' => $request->welcome_head,
                'section_1_desc' => $request->welcome_desc,
                'section_1_image' => Helper::GetMediaUid($request->section_1_image),
                'section_2_head' => $request->section_2_heading,
                'banner_image_web' => Helper::GetMediaUid($request->banner_image_web),
                'banner_image_tablet' => Helper::GetMediaUid($request->banner_image_tablet),
                'banner_image_mobile' => Helper::GetMediaUid($request->banner_image_mobile),
                'banner_title' => $request->banner_title,
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
            ]);

            if ($is_content_create) {

                for ($sp_count = 1; $sp_count <= $request->membership_sec_len; $sp_count++) {
                    $membership_name = 'membership_name_' . $sp_count;
                    $membership_srt_desc = 'membership_srt_desc_' . $sp_count;
                    $membership_subscription_type = 'membership_subscription_type_' . $sp_count;
                    $membership_image = 'membership_image_' . $sp_count;
                    $membership_price = 'membership_price_' . $sp_count;
                    $membership_button = 'membership_button_' . $sp_count;
                    $membership_desc = 'membership_desc_' . $sp_count;
                    $membership_plan = 'membership_plan_' . $sp_count;
                    if ($request->has($membership_name)) {
                        if ($request->$membership_name != '' && $request->$membership_srt_desc != '' && $request->$membership_image != '' && $request->$membership_price != '' && $request->$membership_button != '' && $request->$membership_desc != '') {

                            // Check if membership name already taken

                            $is_membership_exist = MembershipPackage::where('membership_name', $request->$membership_name)->first();
                            if ($is_membership_exist == null) {
                                $is_package_create = MembershipPackage::create(
                                    [
                                        'uid' => Str::uuid()->toString(),
                                        'membership_contents_id' => $is_content_create->id,
                                        'membership_name' => $request->$membership_name,
                                        'membership_srt_desc' => $request->$membership_srt_desc,
                                        'subscription_type' => $request->$membership_subscription_type,
                                        'membership_image' => Helper::GetMediaUid($request->$membership_image),
                                        'membership_button_text' => $request->$membership_button,
                                        'membership_description' => $request->$membership_desc,
                                        'membership_price' => $request->$membership_price,
                                        'membership_plan' => $request->$membership_plan,
                                        'created_by' => Auth::id()
                                    ]
                                );
                            } else {
                                $member_ships_exists .= $request->$membership_name . ' , ';
                            }
                        }
                    }
                }

                $data = array(
                    'content_status' => '1'
                );
                Content::whereId($request->content_id)->update($data);
                if ($member_ships_exists == '') {
                    return redirect()->route('admin.contents.manage')->with('doneMessage', 'Membership page created successfully');
                } else {

                    return redirect()->route('admin.contents.manage')->with('errorMessage', 'Membership page created successfully but these membership names already taken ' . substr($member_ships_exists, 0, -1));
                }
            } else {
                return redirect()->route('admin.contents.manage')->with('errorMessage', 'Something went wrong please try after sometime');
            }
        }
    }

    public function editMembership(Request $request, $id)
    {
        if (!Auth::user()->hasPermission('content_management-update'))
            abort(403);
        $is_content_exist = Content::whereId($id)->first();
        if ($is_content_exist != null) {
            $mebership = MembershipContent::where('content_id', $is_content_exist->id)->with(['getBannerImageWeb', 'getBannerImageTab', 'getBannerImageMobile', 'getfirstSectionImage', 'getMemberships'])->first();
            if ($mebership != null) {
                return view('dashboard.content-manager.membership.edit-membership', compact('mebership'));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function deleteMemberShipPackage(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-delete'))
            return ['status' => 'error', 'message' => 'Access Denied!'];

        $is_package_available = MembershipPackage::whereId($request->id)->first();
        if ($is_package_available == null) {
            return ['status' => 'error', 'message' => 'Invalid membership'];
        } else {
            $form = array(
                'deleted_by' => Auth::id(),
            );
            MembershipPackage::whereId($request->id)->update($form);
            MembershipPackage::whereId($request->id)->delete();
            return ['status' => 'success', 'message' => 'Membership deleted successfully'];
        }
    }


    public function updateMembership(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-update'))
            abort(403);
        $member_ships_exists = '';
        // Check if content exist
        $is_content_exist = Content::whereId($request->content_id)->first();
        if ($is_content_exist == null) {
            return redirect()->route('admin.contents.manage')->with('errorMessage', 'Content section is invalid');
        }

        // Is membership content exist
        $is_membership_exist = MembershipContent::whereId($request->membership_id)->first();

        if ($is_membership_exist == null) {
            return redirect()->route('admin.contents.manage')->with('errorMessage', 'Membership content page is invalid');
        }

        $content_data = array(
            'updated_by' => Auth::id(),
            'page_name' => $request->page_name,
            'page_slug' => $this->slugify($request->page_name),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'section_1_head' => $request->welcome_head,
            'section_1_desc' => $request->welcome_desc,
            'section_1_image' => Helper::GetMediaUid($request->section_1_image),
            'section_2_head' => $request->section_2_heading,
            'banner_image_web' => Helper::GetMediaUid($request->banner_image_web),
            'banner_image_tablet' => Helper::GetMediaUid($request->banner_image_tablet),
            'banner_image_mobile' => Helper::GetMediaUid($request->banner_image_mobile),
            'banner_title' => $request->banner_title,
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
        );


        $is_content_update = MembershipContent::whereId($request->membership_id)->update($content_data);

        if ($is_content_update) {
            for ($sp_count = 1; $sp_count <= $request->membership_sec_len; $sp_count++) {
                $membership_name = 'membership_name_' . $sp_count;
                $membership_srt_desc = 'membership_srt_desc_' . $sp_count;
                $membership_subscription_type = 'membership_subscription_type_' . $sp_count;
                $membership_image = 'membership_image_' . $sp_count;
                $membership_price = 'membership_price_' . $sp_count;
                $membership_button = 'membership_button_' . $sp_count;
                $membership_desc = 'membership_desc_' . $sp_count;
                $membership_id = 'membership_id_' . $sp_count;
                $membership_plan = 'membership_plan_' . $sp_count;
                if ($request->has($membership_id)) {
                    if ($request->$membership_name != '' && $request->$membership_srt_desc != '' && $request->$membership_image != '' && $request->$membership_price != '' && $request->$membership_button != '' && $request->$membership_desc != '') {
                        $is_mem_exist = MembershipPackage::whereId($request->$membership_id)->first();
                        if ($is_mem_exist != null) {
                            if ($is_mem_exist->id == $request->$membership_id) {
                                $package_data = array(
                                    'membership_contents_id' => $request->membership_id,
                                    'membership_name' => $request->$membership_name,
                                    'membership_srt_desc' => $request->$membership_srt_desc,
                                    'subscription_type' => $request->$membership_subscription_type,
                                    'membership_image' => Helper::GetMediaUid($request->$membership_image),
                                    'membership_button_text' => $request->$membership_button,
                                    'membership_description' => $request->$membership_desc,
                                    'membership_price' => $request->$membership_price,
                                    'membership_plan' => $request->$membership_plan,
                                    'updated_by' => Auth::id()
                                );
                                $is_package_update = MembershipPackage::whereId($request->$membership_id)->update($package_data);
                            } else {
                                $member_ships_exists .= $request->$membership_name . ' , ';
                            }
                        }
                    }
                } else {
                    if ($request->has($membership_name)) {
                        if ($request->$membership_name != '' && $request->$membership_srt_desc != '' && $request->$membership_image != '' && $request->$membership_price != '' && $request->$membership_button != '' && $request->$membership_desc != '') {
                            $is_membership_exist = MembershipPackage::where('membership_name', $request->$membership_name)->first();
                            if ($is_membership_exist == null) {
                                $is_package_create = MembershipPackage::create(
                                    [
                                        'uid' => Str::uuid()->toString(),
                                        'membership_contents_id' => $request->membership_id,
                                        'membership_name' => $request->$membership_name,
                                        'membership_srt_desc' => $request->$membership_srt_desc,
                                        'subscription_type' => $request->$membership_subscription_type,
                                        'membership_image' => Helper::GetMediaUid($request->$membership_image),
                                        'membership_button_text' => $request->$membership_button,
                                        'membership_description' => $request->$membership_desc,
                                        'membership_price' => $request->$membership_price,
                                        'membership_plan' => $request->$membership_plan,
                                        'created_by' => Auth::id()
                                    ]
                                );
                            } else {
                                $member_ships_exists .= $request->$membership_name . ' , ';
                            }
                        }
                    }
                }
            }

            $content_details = array(
                'updated_by' => Auth::id(),
            );
            Content::whereId($request->content_id)->update($content_details);
            if ($member_ships_exists == '') {
                return redirect()->route('admin.contents.manage')->with('doneMessage', 'Membership page updated successfully');
            } else {
                return redirect()->route('admin.contents.manage')->with('errorMessage', 'Membership page updated successfully but these membership name already has been taken:- ' . substr($member_ships_exists, 0, -1));
            }
        }
    }

    public function manageDefaultMembership(Request $request)
    {
        $is_membership_content_exist = Content::where('template_type', 'membership')->first();
        if ($is_membership_content_exist != null) {
            $mebership = MembershipContent::where('content_id', $is_membership_content_exist->id)->with(['getMemberships'])->first();
            if ($mebership != null) {
                // Default membership
                $default = DefaultMembership::with('getPackageInfo')->first();
                return view('dashboard.content-manager.membership.default-membership', compact('mebership', 'default'));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }


    public function setDefaultMembership(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'default_membership' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $default = DefaultMembership::with('getPackageInfo')->first();
        if ($default == null) {
            DefaultMembership::create([
                'content_id' => $request->content_id,
                'membership_content_details_id' => $request->content_id,
                'membership_package_id' => $request->default_membership,
                'created_by' => Auth::id()
            ]);

            return redirect()->back()->with('doneMessage', 'Default membership updated successfully');
        } else {
            $arr = array(
                'content_id' => $request->content_id,
                'membership_content_details_id' => $request->content_id,
                'membership_package_id' => $request->default_membership,
                'updated_by' => Auth::id()
            );
            DefaultMembership::whereId($default->id)->update($arr);
            return redirect()->back()->with('doneMessage', 'Default membership updated successfully');
        }
    }
}
