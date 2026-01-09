<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CategoryListingContent;
use App\Models\Language;
use App\Models\OurTeamCategory;
use App\Models\OurTeamCategoryContent;
use App\Models\WebmasterSection;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OurTeamCategoryController extends Controller
{
    //
    use Common;
    public function __construct()
    {
        // Check Permissions

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('our_team-read')) {
            abort(403);
        }
        $OurTeamCategoryLists = OurTeamCategory::orderby('id', 'asc')->with('userDetails', 'ourTeamCatContent')->paginate(10);
        return view('dashboard.our_teams.category.list', ['OurTeamCategoryLists' => $OurTeamCategoryLists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermission('our_team-create')) {
            abort(403);
        }
        return view('dashboard.our_teams.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('our_team-create')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $unique_check = OurTeamCategoryContent::where('title', $request->title)->first();
        if ($unique_check != null) {
            return redirect()->action('Dashboard\OurTeamCategoryController@index')->with('errorMessage', __('Duplicate title not allowed.'));
        }
        $our_team_category = [];
        $our_team_category['created_by'] = Auth::id();
        $our_team_category['status'] = $request->status;
        $our_team_category['uid'] = Str::uuid()->toString();
        $our_team_category_details = OurTeamCategory::create($our_team_category);
        if (!empty($our_team_category_details)) {
            $our_team_category_content = [];
            $our_team_category_content['uid'] = Str::uuid()->toString();
            $our_team_category_content['category_uid'] = $our_team_category_details->uid;
            $our_team_category_content['title'] = $request->title;
            $our_team_category_content['page_slug'] = $this->slugify($request->title);
            $our_team_category_content_details = OurTeamCategoryContent::create($our_team_category_content);
        }
        if (!empty($our_team_category_details)) {
            return redirect()->action('Dashboard\OurTeamCategoryController@index')->with('doneMessage', 'Category created successfully');
        } else {
            return redirect()->action('Dashboard\OurTeamCategoryController@index')->with('doneMessage', 'Something went wrong please try after sometime');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if (!Auth::user()->hasPermission('our_team-update')) {
            abort(403);
        }
        $our_team_content = OurTeamCategory::where('uid', $request->uid)->with('ourTeamCatContent')->first();
        if ($our_team_content != null) {
            return view('dashboard.our_teams.category.edit', ['our_team_content' => $our_team_content]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OurTeamCategory $blogCategory)
    {
        if (!Auth::user()->hasPermission('our_team-update')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $unique_check = OurTeamCategoryContent::where('title', $request->title)->first();
        if ($unique_check != null &&  $request->title != null && $unique_check->category_uid != $request->uid) {
            return redirect()->action('Dashboard\OurTeamCategoryController@index')->with('errorMessage', __('Duplicate title not allowed.'));
        }
        $our_team_category = [];
        $our_team_category['updated_by'] = 1;
        $our_team_category['status'] = $request->status == 1 ? '1' : '0';
        $our_team_category_details = OurTeamCategory::where('uid', $request->uid)->update($our_team_category);

        // Remove existing category contents
        OurTeamCategoryContent::where('category_uid', $request->uid)->delete();
        if ($our_team_category_details == 1) {
            $our_team_category_content = [];
            $our_team_category_content['uid'] = Str::uuid()->toString();
            $our_team_category_content['category_uid'] = $request->uid;
            $our_team_category_content['title'] = $request->title;
            $our_team_category_content['page_slug'] = $this->slugify($request->title);
            $our_team_category_content_details = OurTeamCategoryContent::create($our_team_category_content);
        }

        if ($our_team_category_details == 1) {
            return redirect()->action('Dashboard\OurTeamCategoryController@index')->with('doneMessage', 'Category updated successfully');
        } else {
            return redirect()->action('Dashboard\OurTeamCategoryController@index')->with('doneMessage', 'Something went wrong please try after sometime');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OurTeamCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->hasPermission('our_team-delete')) {
            abort(403);
        }
        if ($request->uid == null || $request->uid == '') {
            return ['status' => 'error', 'message' => 'Invalid details'];
        }

        // Check if listing content has some data
        $is_cat_exist = OurTeamCategory::where('uid', $request->uid)->with('ourTeamCatContent')->first();
        if ($is_cat_exist != null) {
            if ($is_cat_exist->ourTeamCatContent != null) {
                if (CategoryListingContent::where('category_content_uid', $is_cat_exist->ourTeamCatContent->uid)->count()) {
                    return ['status' => 'error', 'message' => 'Team listing page present in this category please delete the listing page first'];
                } else {
                    // OurTeamCategory::where('uid', $request->uid)->update(['deleted_by' => Auth::id()]);

                    
                    // Delete the Team category Contents
                    OurTeamCategoryContent::where('category_uid',$request->uid)->delete();


                    $res = OurTeamCategory::where('uid',  $request->uid)->delete();


                    return ['status' => 'success', 'message' => 'Category deleted successfully'];
                }
            } else {
                return ['status' => 'error', 'message' => 'Invalid details'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Invalid details'];
        }




        // // checking finished
        // OurTeamCategory::where('uid', $request->uid)->update(['deleted_by' => Auth::id()]);
        // $res = OurTeamCategory::where('uid',  $request->uid)->delete();

        // // Delete OurTeamCategoryContent using soft delete
        // $our_team_category_content_delete = OurTeamCategoryContent::where('category_uid', $request->uid)->delete();

        // if (!empty($res)) {
        //     return redirect()->action('Dashboard\OurTeamCategoryController@index')->with('doneMessage', 'Category deleted successfully');
        // } else {
        //     return redirect()->action('Dashboard\OurTeamCategoryController@index')->with('doneMessage', 'Something went wrong please try after sometime');
        // }
    }
}
