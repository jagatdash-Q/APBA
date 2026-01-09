<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\CategoryListingContent;
use App\Models\OurTeam;
use App\Models\OurTeamCategory;
use App\Models\OurTeamCategoryContent;
use App\Models\OurTeamListing;
use App\Models\OurTeamListingContent;
use App\Models\User;
use App\Traits\Common;
use App\Traits\EmailTrait;
use App\Traits\Notification as NotificationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OurTeamListingController extends Controller
{
    use Common;
    use NotificationTrait;
    use EmailTrait;
    public function __construct()
    {
        // Check Permissions

    }

    public function index()
    {
        if (!Auth::user()->hasPermission('our_team-read'))
            abort(403);
        $our_teams_list = [];
        $our_teams_list = OurTeamListing::orderby('sort_no', 'asc')->with('lockAcquiredUser', 'userDetails',)->get();
        $our_teams = OurTeam::where('content_status', '1')->get();
        // General END
        return view('dashboard.our_teams.listing.list', compact("our_teams_list", "our_teams"));
    }


    public function create(Request $request)
    {
        if (!Auth::user()->hasPermission('our_team-create'))
            abort(403);
        $our_teams_category_list = OurTeamCategory::where('status', '1')->with('ourTeamCatContent')->get();
        // General END
        return view('dashboard.our_teams.listing.create', compact("our_teams_category_list"));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('our_team-create'))
            abort(403);
        $validator = Validator::make($request->all(), [
            'page_name' => 'required',
            'meta_title' => 'required',
            'meta_keyword' => 'required',
            'meta_description' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'about_title' => 'required',
            'description' => 'required',
            'description_data' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ourteam_data = OurTeam::take(1)->first();
        $unique_listing_id =  Str::uuid()->toString();
        $OurTeamListing = [];
        $OurTeamListing['uid'] = $unique_listing_id;
        $OurTeamListing['our_teams_uid'] = !empty($ourteam_data) ? $ourteam_data->uid : '';
        $OurTeamListing['page_type'] = 'our_teams_listing';
        $OurTeamListing['content_status'] =  $request->submit;
        $OurTeamListing['created_by'] = Auth::id();
        $our_team_listing_details = OurTeamListing::create($OurTeamListing);

        if ($our_team_listing_details) {
            $arr = array(
                'sort_no' => $our_team_listing_details->id
            );

            OurTeamListing::whereId($our_team_listing_details->id)->update($arr);
        }

        if ($our_team_listing_details) {
            $arr = array(
                'sort_no' => $our_team_listing_details->id
            );
            OurTeamListing::whereId($our_team_listing_details->id)->update($arr);
        }

        $OurTeamListingContent['page_name'] = $request->page_name;
        $OurTeamListingContent['page_slug'] = $this->slugify($request->page_name);
        $OurTeamListingContent['meta_title'] = $request->meta_title;
        $OurTeamListingContent['meta_keywoard'] = $request->meta_keyword;
        $OurTeamListingContent['meta_description'] = $request->meta_description;


        $OurTeamListingContent['name'] = $request->name;
        $OurTeamListingContent['slug'] = $this->slugify($request->name);
        $OurTeamListingContent['designation'] = $request->designation;
        $OurTeamListingContent['about_title'] = $request->about_title;
        $OurTeamListingContent['description'] = $request->description;
        $OurTeamListingContent['description_data'] = $request->description_data;
        $OurTeamListingContent['image'] = Helper::GetMediaUid($request->image);
        $OurTeamListingContent['facebook'] = $request->facebook;
        $OurTeamListingContent['twitter'] = $request->twitter;
        $OurTeamListingContent['google_plus'] = $request->google_plus;
        $OurTeamListingContent['linkedin'] = $request->linkedin;
        $OurTeamListingContent['youtube'] = $request->youtube;
        $OurTeamListingContent['instagram'] = $request->instagram;
        $OurTeamListingContent['printrest'] = $request->printrest;
        $OurTeamListingContent['tumblr'] = $request->tumblr;
        $OurTeamListingContent['snapchat'] = $request->snapchat;
        $OurTeamListingContent['whatsapp'] = $request->whatsapp;

        if (!empty($OurTeamListingContent['name'])) {
            $OurTeamListingContent['uid'] = Str::uuid()->toString();
            $OurTeamListingContent['our_teams_listing_uid'] = $unique_listing_id;
            $OurTeamListingContent['status'] = '1';
            $res = OurTeamListingContent::create($OurTeamListingContent);
            if (count($request->our_team_category) > 0)
                foreach ($request->our_team_category as $category_data) {
                    $category_details = OurTeamCategoryContent::where('id', $category_data)->first();
                    if ($category_details != null) {
                        $category_listing_content['category_content_uid'] = $category_details->uid;
                        $category_listing_content['listing_content_uid'] =  $OurTeamListingContent['uid'];
                        $category_listing_contents = CategoryListingContent::create($category_listing_content);
                    }
                }
        }
        return redirect()->action('Dashboard\OurTeamListingController@index')->with('doneMessage', 'Team listing page has been created');
    }

    /* fetch our teams list by our teams  uid  */

    public function edit(Request $request)
    {
        if (!Auth::user()->hasPermission('our_team-update'))
            abort(403);
        $OurTeamListing = OurTeamListing::where('uid', '=', $request->uid)->with('getOurTeamListingContent')->first();
        $our_teams_category_list = OurTeamCategory::where('status', '1')->with('ourTeamCatContent')->get();
        if ($OurTeamListing != null) {
            if ($OurTeamListing->getOurTeamListingContent != null) {
                return view('dashboard.our_teams.listing.edit', compact("OurTeamListing", "our_teams_category_list"));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
        // General END

    }

    /* end of fetch our teams list by our teams  uid  */


    /* update our teams list by our teams  uid  */

    public function update(Request $request)
    {
        if (!Auth::user()->hasPermission('our_team-update'))
            abort(403);
        $validator = Validator::make($request->all(), [
            'page_name' => 'required',
            'meta_title' => 'required',
            'meta_keyword' => 'required',
            'meta_description' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'about_title' => 'required',
            'description' => 'required',
            'description_data' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $OurTeamListing['content_status'] =  $request->submit;
        $OurTeamListing['edited_by'] = Auth::id();
        $our_team_listing_details = OurTeamListing::where('uid', $request->uid)->update($OurTeamListing);

        // Delete our team category content
        $our_team_listing_uids = OurTeamListingContent::where('our_teams_listing_uid', $request->uid)->first();
        if ($our_team_listing_uids != null) {
            $delete_category_content = CategoryListingContent::where('listing_content_uid', $our_team_listing_uids->uid)->delete();
        }
        $OurTeamListingContent['page_name'] = $request->page_name;
        $OurTeamListingContent['page_slug'] = $this->slugify($request->page_name);
        $OurTeamListingContent['meta_title'] = $request->meta_title;
        $OurTeamListingContent['meta_keywoard'] = $request->meta_keyword;
        $OurTeamListingContent['meta_description'] = $request->meta_description;
        $OurTeamListingContent['name'] = $request->name;
        $OurTeamListingContent['designation'] = $request->designation;
        $OurTeamListingContent['about_title'] = $request->about_title;
        $OurTeamListingContent['description'] = $request->description;
        $OurTeamListingContent['description_data'] = $request->description_data;
        $OurTeamListingContent['image'] = Helper::GetMediaUid($request->image);
        $OurTeamListingContent['facebook'] = $request->facebook;
        $OurTeamListingContent['twitter'] = $request->twitter;
        $OurTeamListingContent['google_plus'] = $request->google_plus;
        $OurTeamListingContent['linkedin'] = $request->linkedin;
        $OurTeamListingContent['youtube'] = $request->youtube;
        $OurTeamListingContent['instagram'] = $request->instagram;
        $OurTeamListingContent['printrest'] = $request->printrest;
        $OurTeamListingContent['tumblr'] = $request->tumblr;
        $OurTeamListingContent['snapchat'] = $request->snapchat;
        $OurTeamListingContent['whatsapp'] = $request->whatsapp;
        $listing_content = OurTeamListingContent::where('our_teams_listing_uid', $request->uid)->update($OurTeamListingContent);
        if ($listing_content) {
            if (count($request->our_team_category) > 0) {
                foreach ($request->our_team_category as $category_data) {
                    $category_details = OurTeamCategoryContent::where('id', $category_data)->first();
                    if ($category_details != null) {
                        $category_listing_content['category_content_uid'] = $category_details->uid;
                        $category_listing_content['listing_content_uid'] =  $our_team_listing_uids->uid;
                        $category_listing_contents = CategoryListingContent::create($category_listing_content);
                    }
                }
            }
        } else {
            Log::info('Ourteam Listing details not updated of uid ' .  $request->uid);
            return redirect()->action('Dashboard\OurTeamListingController@index')->with('errorMessage', __('Some error occured. Unable to update OurTeam Listing page!'));
        }

        return redirect()->action('Dashboard\OurTeamListingController@index')->with('doneMessage', 'OurTeam Listing page updated successfully');
    }

    /* End of update our teams list by our teams  uid  */



    /* delete our teams list by our teams  uid  */
    public function delete(Request $request)
    {
        if (!Auth::user()->hasPermission('our_team-delete'))
            abort(403);
        if ($request->id == null || $request->id == '') {
            return ['status' => 'error', 'message' => 'Invalid details'];
        }
        // get listing content uid
        $is_listing_present = OurTeamListing::with('getOurTeamListingContent')->whereId($request->id)->first();
        if ($is_listing_present != null) {
            if ($is_listing_present->getOurTeamListingContent != null) {
                CategoryListingContent::where('listing_content_uid', $is_listing_present->getOurTeamListingContent->uid)->delete();
                OurTeamListing::whereId($request->id)->update(['deleted_by' => Auth::id()]);
                OurTeamListing::whereId($request->id)->delete();
                OurTeamListingContent::where('uid', $is_listing_present->getOurTeamListingContent->uid)->delete();
                return ['status' => 'success', 'message' => 'Listing page deleted successfully'];
            } else {
                return ['status' => 'error', 'message' => 'Invalid request'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Invalid request'];
        }
    }

    /* ENd of delete our team list by our team  uid  */


    public function sortTeamListing(Request $request)
    {
        $data =  json_decode($request->data);
        $menus = OurTeamListing::all();
        if (count($menus) > 0) {
            foreach ($data as $key => $element) {
                foreach ($menus as $menu) {
                    if ($menu->id == $element) {
                        $res = OurTeamListing::where('id', $element)->update(['sort_no' => $key + 1]);
                    }
                }
            }
        }
        $response['status'] = 'success';
        echo json_encode($response);
    }
}
