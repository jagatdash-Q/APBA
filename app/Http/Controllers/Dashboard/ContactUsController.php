<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Content;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactUsController extends Controller
{
    use Common;
    public function store(Request $request)
    {
        if ($request->page_type == "update") {
            if (!Auth::user()->hasPermission('content_management-update'))
                abort(403);
        } else {
            if (!Auth::user()->hasPermission('content_management-create'))
                abort(403);
        }

        try {
            $contact_us = ContactUs::firstOrNew(['uuid' => $request->uuid]);

            $contact_us->content_id = $request->content_id;

            $contact_us->page_name = $request->page_name;
            $contact_us->page_slug = $this->slugify($request->page_name);
            $contact_us->meta_title = $request->meta_title;
            $contact_us->meta_keyword = $request->meta_keyword;
            $contact_us->meta_description = $request->meta_description;
            $contact_us->banner_title = $request->banner_title;
            $contact_us->banner_desc = $request->banner_desc;
            $contact_us->button_link = $request->button_link;
            $contact_us->button_name = $request->button_name;
            $contact_us->banner_image_web = Helper::GetMediaUid($request->banner_image_web);
            $contact_us->banner_image_tablet = Helper::GetMediaUid($request->banner_image_tablet);
            $contact_us->banner_image_mobile = Helper::GetMediaUid($request->banner_image_mobile);
            $contact_us->banner_title_left_pos_web = (float)$request->banner_title_left_pos_web_;
            $contact_us->banner_title_top_pos_web = (float)$request->banner_title_top_pos_web_;
            $contact_us->banner_desc_left_pos_web = (float)$request->banner_desc_left_pos_web_;
            $contact_us->banner_desc_top_pos_web = (float)$request->banner_desc_top_pos_web_;
            $contact_us->button_name_left_pos_web = (float)$request->button_name_left_pos_web_;
            $contact_us->button_name_top_pos_web = (float)$request->button_name_top_pos_web_;
            $contact_us->banner_title_left_pos_tablet = (float)$request->banner_title_left_pos_tablet_;
            $contact_us->banner_title_top_pos_tablet = (float)$request->banner_title_top_pos_tablet_;
            $contact_us->banner_desc_left_pos_tablet = (float)$request->banner_desc_left_pos_tablet_;
            $contact_us->banner_desc_top_pos_tablet = (float)$request->banner_desc_top_pos_tablet_;
            $contact_us->button_name_left_pos_tablet = (float)$request->button_name_left_pos_tablet_;
            $contact_us->button_name_top_pos_tablet = (float)$request->button_name_top_pos_tablet_;
            $contact_us->banner_title_left_pos_mobile = (float)$request->banner_title_left_pos_mobile_;
            $contact_us->banner_title_top_pos_mobile = (float)$request->banner_title_top_pos_mobile_;
            $contact_us->banner_desc_left_pos_mobile = (float)$request->banner_desc_left_pos_mobile_;
            $contact_us->banner_desc_top_pos_mobile = (float)$request->banner_desc_top_pos_mobile_;
            $contact_us->button_name_left_pos_mobile = (float)$request->button_name_left_pos_mobile_;
            $contact_us->button_name_top_pos_mobile = (float)$request->button_name_top_pos_mobile_;

            $contact_us->title = $request->title;
            $contact_us->description = $request->description;
            $contact_us->address_1 = $request->address_1;
            $contact_us->address_2 = $request->address_2;
            $contact_us->mobile = $request->mobile;
            $contact_us->email = $request->email;
            $contact_us->google_map = $request->google_map;
            $contact_us->save();
            if ($contact_us->save()) {
                $data = array(
                    'content_status' => '1'
                );
                Content::whereId($request->content_id)->update($data);
                if ($request->page_type == "update")
                    return redirect()->back()->with('doneMessage', 'Contact us page updated successfully');
                else
                    return redirect()->route('admin.contents.manage')->with('doneMessage', 'Contact us page created successfully');
            }
        } catch (Exception $e) {
            if ($request->page_type == "update")
                return redirect()->back()->with('errorMessage', 'Something went wrong please try after sometime');
            else
                return redirect()->route('admin.contents.manage')->with('errorMessage', 'Something went wrong please try after sometime');
        }
    }
    public function edit($id)
    {
        if(!Auth::user()->hasPermission('content_management-update'))
        abort(403);
        $content_details = Content::where('id', $id)->first();
        if ($content_details == null)
            abort(404);

        $contact_us = ContactUs::with(['getBannerImageWeb', 'getBannerImageTab', 'getBannerImageMobile', 'getResourceMenu'])->where('content_id', $content_details->id)->first();
        if ($contact_us == null)
            abort(404);

        return view('dashboard.content-manager.contact_us.index', compact('content_details', 'contact_us'));
    }
}
