<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use App\Models\AboutContentCards;
use App\Models\AboutContentTemp;
use App\Models\Content;
use App\Models\MembershipContent;
use App\Models\Template;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ContentController extends Controller
{
    use Common;
    public function manageContents(Request $request)
    {
        if(!Auth::user()->hasPermission('content_management-read'))
        abort(403);
        $templates = Template::all();
        $contents = Content::where('content_status', '1')->with(['getCreaterDetails', 'GetEditorDetails'])->orderBy('id', 'desc')->get();
        return view('dashboard.content-manager.index', compact('contents', 'templates'));
    }

    public function createContent(Request $request, $id, $slug)
    {
        if(!Auth::user()->hasPermission('content_management-create'))
        abort(403);
        // Check if template exist
        if (Template::whereId($id)->count()) {
            if ($slug == 'about') {
                if (Content::where('template_type', $slug)->where('content_status', '1')->count()) {
                    return redirect()->route('admin.contents.manage')->with('errorMessage', 'About us page has already been created');
                }
                $content_details = Content::create([
                    'template_id' => $id,
                    'template_type' => $slug,
                    'created_by' => Auth::id(),
                    'content_status' => '0',
                ]);
                return view('dashboard.content-manager.about.create-about', compact('content_details'));
            } else if ($slug == 'membership') {
                if (Content::where('template_type', $slug)->where('content_status', '1')->count()) {
                    return redirect()->route('admin.contents.manage')->with('errorMessage', 'Membership page has already been created');
                }
                $content_details = Content::create([
                    'template_id' => $id,
                    'template_type' => $slug,
                    'created_by' => Auth::id(),
                    'content_status' => '0',
                ]);
                return view('dashboard.content-manager.membership.create-membership', compact('content_details'));
            } else if ($slug == 'resources') {
                if (Content::where('template_type', $slug)->where('content_status', '1')->count()) {
                    return redirect()->route('admin.contents.manage')->with('errorMessage', 'Resource page has already been created');
                }
                $content_details = Content::create([
                    'template_id' => $id,
                    'template_type' => $slug,
                    'created_by' => Auth::id(),
                    'content_status' => '0',
                ]);
                $resource = null;
                return view('dashboard.content-manager.resource.create', compact('content_details', 'resource'));
            } else if ($slug == 'contact-us') {
                if (Content::where('template_type', $slug)->where('content_status', '1')->count()) {
                    return redirect()->route('admin.contents.manage')->with('errorMessage', 'Contact us page has already been created');
                }
                $content_details = Content::create([
                    'template_id' => $id,
                    'template_type' => $slug,
                    'created_by' => Auth::id(),
                    'content_status' => '0',
                ]);
                $contact_us = null;
                return view('dashboard.content-manager.contact_us.index', compact('content_details', 'contact_us'));
            } else if ($slug == 'home') {
                if (Content::where('template_type', $slug)->where('content_status', '1')->count()) {
                    return redirect()->route('admin.contents.manage')->with('errorMessage', 'Home page has already been created');
                }
                $content_details = Content::create([
                    'template_id' => $id,
                    'template_type' => $slug,
                    'created_by' => Auth::id(),
                    'content_status' => '0',
                ]);
                return view('dashboard.content-manager.home.create', compact('content_details'));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }


    public function createAboutTempCard(Request $request)
    {
        if ($request->section_id == 'section_1') {
            if (AboutContentTemp::where('content_id', $request->content_id)->where('section_id', $request->section_id)->count() >= 4) {
                return ['status' => 'error', 'message' => 'already all contents has been given', 'result' => AboutContentTemp::where('content_id', $request->content_id)->where('section_id', $request->section_id)->with(['hoverImageDetails', 'imageDetails'])->get()];
            } else {
                if (in_array(pathinfo(Helper::getMediaPath($request->card_img), PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg', 'pdf'])) {
                    return ['status' => 'error', 'message' => 'Only image is allowed', 'result' => AboutContentTemp::where('content_id', $request->content_id)->where('section_id', $request->section_id)->with(['hoverImageDetails', 'imageDetails'])->get()];
                }
                AboutContentTemp::create([
                    'content_id' => $request->content_id,
                    'section_id' => $request->section_id,
                    'desc' => $request->desc_card,
                    'created_by' => Auth::id(),
                    'image' => Helper::GetMediaUid($request->card_img),
                    'hover_image' => Helper::GetMediaUid($request->card_img_2),
                ]);
                return ['status' => 'success', 'message' => 'Section details has been created', 'result' => AboutContentTemp::where('content_id', $request->content_id)->where('section_id', $request->section_id)->with(['hoverImageDetails', 'imageDetails'])->get()];
            }
        } else {
            if (AboutContentTemp::where('content_id', $request->content_id)->where('section_id', $request->section_id)->count() >= 5) {
                return ['status' => 'error', 'message' => 'already all contents has been given', 'result' => AboutContentTemp::where('content_id', $request->content_id)->where('section_id', $request->section_id)->with(['hoverImageDetails', 'imageDetails'])->get()];
            } else {
                if (in_array(pathinfo(Helper::getMediaPath($request->card_img), PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg', 'pdf'])) {
                    return ['status' => 'error', 'message' => 'Only image is allowed', 'result' => AboutContentTemp::where('content_id', $request->content_id)->where('section_id', $request->section_id)->with(['hoverImageDetails', 'imageDetails'])->get()];
                }
                AboutContentTemp::create([
                    'content_id' => $request->content_id,
                    'section_id' => $request->section_id,
                    'desc' => $request->desc_card,
                    'created_by' => Auth::id(),
                    'image' => Helper::GetMediaUid($request->card_img),
                    'hover_image' => Helper::GetMediaUid($request->card_img_2),
                ]);
                return ['status' => 'success', 'message' => 'Section details has been created', 'result' => AboutContentTemp::where('content_id', $request->content_id)->where('section_id', $request->section_id)->with(['hoverImageDetails', 'imageDetails'])->get()];
            }
        }
    }


    public function createAboutCard(Request $request)
    {
        if ($request->section_id == 'section_1') {
            if (AboutContentCards::where('about_contents_id', $request->about_contents_id)->where('section_id', $request->section_id)->count() >= 4) {
                return ['status' => 'error', 'message' => 'already all contents has been given', 'result' => AboutContentCards::where('about_contents_id', $request->about_contents_id)->where('section_id', $request->section_id)->with(['hoverImageDetails', 'getImageDetails'])->get()];
            } else {
                if (in_array(pathinfo(Helper::getMediaPath($request->card_img), PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg', 'pdf'])) {
                    return ['status' => 'error', 'message' => 'Only image is allowed', 'result' => AboutContentCards::where('about_contents_id', $request->about_contents_id)->where('section_id', $request->section_id)->with(['hoverImageDetails', 'getImageDetails'])->get()];
                }
                AboutContentCards::create([
                    'about_contents_id' => $request->about_contents_id,
                    'section_id' => $request->section_id,
                    'desc' => $request->desc_card,
                    'created_by' => Auth::id(),
                    'image' => Helper::GetMediaUid($request->card_img),
                    'hover_image' => Helper::GetMediaUid($request->card_img_2),
                ]);
                return ['status' => 'success', 'message' => 'Section details has been created', 'result' => AboutContentCards::where('about_contents_id', $request->about_contents_id)->where('section_id', $request->section_id)->with(['hoverImageDetails', 'getImageDetails'])->get()];
            }
        } else {
            if (AboutContentCards::where('about_contents_id', $request->about_contents_id)->where('section_id', $request->section_id)->count() >= 5) {
                return ['status' => 'error', 'message' => 'already all contents has been given', 'result' => AboutContentCards::where('about_contents_id', $request->about_contents_id)->where('section_id', $request->section_id)->with(['hoverImageDetails', 'getImageDetails'])->get()];
            } else {
                if (in_array(pathinfo(Helper::getMediaPath($request->card_img), PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg', 'pdf'])) {
                    return ['status' => 'error', 'message' => 'Only image is allowed', 'result' => AboutContentCards::where('about_contents_id', $request->about_contents_id)->where('section_id', $request->section_id)->with(['hoverImageDetails', 'getImageDetails'])->get()];
                }
                AboutContentCards::create([
                    'about_contents_id' => $request->about_contents_id,
                    'section_id' => $request->section_id,
                    'desc' => $request->desc_card,
                    'created_by' => Auth::id(),
                    'image' => Helper::GetMediaUid($request->card_img),
                    'hover_image' => Helper::GetMediaUid($request->card_img_2),
                ]);
                return ['status' => 'success', 'message' => 'Section details has been created', 'result' => AboutContentCards::where('about_contents_id', $request->about_contents_id)->where('section_id', $request->section_id)->with(['hoverImageDetails', 'getImageDetails'])->get()];
            }
        }
    }


    public function editAboutCard(Request $request)
    {
        if(!Auth::user()->hasPermission('content_management-update'))
        abort(403);
        $card_details = AboutContentCards::whereId($request->id)->with(['hoverImageDetails', 'getImageDetails'])->first();
        return ['status' => 'success', 'result' => $card_details];
    }

    public function updateAboutCard(Request $request)
    {
        if(!Auth::user()->hasPermission('content_management-update'))
        abort(403);
        $card_details = AboutContentCards::whereId($request->card_details_id)->with(['hoverImageDetails', 'getImageDetails'])->first();
        if ($card_details != null) {
            if (in_array(pathinfo(Helper::getMediaPath($request->card_img), PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg', 'pdf'])) {
                return ['status' => 'error', 'message' => 'Only image is allowed', 'result' => AboutContentCards::where('section_id', $card_details->section_id)->with(['hoverImageDetails', 'getImageDetails'])->get()];
            }
            $arr = array(
                'desc' => $request->desc_card,
                'updated_by' => Auth::id(),
                'image' => Helper::GetMediaUid($request->card_img),
                'hover_image' => Helper::GetMediaUid($request->card_img_2),
            );
            AboutContentCards::whereId($request->card_details_id)->update($arr);
            $result = AboutContentCards::where('section_id', $card_details->section_id)->with(['hoverImageDetails', 'getImageDetails'])->get();
            return ['status' => 'success', 'message' => 'Card details updated successfully', 'result' => $result, 'section_id' => $card_details->section_id];
        } else {
            return ['status' => 'error', 'message' => 'Card details invalid'];
        }
    }


    public function deleteAboutCard(Request $request)
    {
        $card_details = AboutContentCards::whereId($request->id)->delete();
        $result = AboutContentCards::where('section_id', $request->section_id)->with(['hoverImageDetails', 'getImageDetails'])->get();
        return ['status' => 'success', 'message' => 'Card deleted successfully', 'result' => $result];
    }



    public function createAboutPage(Request $request)
    {
        if(!Auth::user()->hasPermission('content_management-create'))
        abort(403);
        if (Content::where('template_type', 'about')->where('content_status', '1')->count()) {
            return redirect()->route('admin.contents.manage')->with('errorMessage', 'About us page already has been created');
        } else {
            $is_content_create = AboutContent::create([
                'created_by' => Auth::id(),
                'content_id' => $request->content_id,
                'uuid' => Str::uuid()->toString(),
                'page_name' => $request->page_name,
                'page_slug' => $this->slugify($request->page_name),
                'meta_title' => $request->meta_title,
                'meta_keywoard' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'welcome_head' => $request->welcome_head,
                'welcome_desc' => $request->welcome_desc,
                'section_2_head_1' => $request->section_2_head_1,
                'section_2_desc_1' => $request->section_2_desc_1,
                'section_2_head_2' => $request->section_2_head_2,
                'section_2_desc_2' => $request->section_2_desc_2,
                'section_2_head_3' => $request->section_2_head_3,
                'section_2_desc_3' => $request->section_2_desc_3,
                'objective_head' => $request->objective_head,
                'objective_desc' => $request->objective_desc,
                'banner_image_web' => Helper::GetMediaUid($request->banner_image_web),
                'banner_image_tablet' => Helper::GetMediaUid($request->banner_image_tablet),
                'banner_image_mobile' => Helper::GetMediaUid($request->banner_image_mobile),
                'section_2_img' => Helper::GetMediaUid($request->section_2_img),
                'heading' => $request->banner_title,
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
                $temp_contents = AboutContentTemp::where('content_id', $request->content_id)->with('imageDetails')->get();
                foreach ($temp_contents as $val) {
                    AboutContentCards::create([
                        'about_contents_id' => $is_content_create->id,
                        'about_us_uid' => $is_content_create->uid,
                        'section_id' => $val->section_id,
                        'created_by' => Auth::id(),
                        'image' => $val->image,
                        'hover_image' => $val->hover_image,
                        'desc' => $val->desc,
                    ]);
                    AboutContentTemp::whereId($val->id)->delete();
                }
                $data = array(
                    'content_status' => '1'
                );
                Content::whereId($request->content_id)->update($data);
                return redirect()->route('admin.contents.manage')->with('doneMessage', 'About us page created successfully');
            } else {
                return redirect()->route('admin.contents.manage')->with('errorMessage', 'Something went wrong please try after sometime');
            }
        }
    }

    public function updateAboutPage(Request $request)
    {
        if(!Auth::user()->hasPermission('content_management-update'))
        abort(403);
        $content_details = array(
            'updated_by' => Auth::id(),
        );

        Content::whereId($request->content_id)->update($content_details);

        $content_details = array(
            'updated_by' => Auth::id(),
            'page_name' => $request->page_name,
            'page_slug' => $this->slugify($request->page_name),
            'meta_title' => $request->meta_title,
            'meta_keywoard' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'welcome_head' => $request->welcome_head,
            'welcome_desc' => $request->welcome_desc,
            'section_2_head_1' => $request->section_2_head_1,
            'section_2_desc_1' => $request->section_2_desc_1,
            'section_2_head_2' => $request->section_2_head_2,
            'section_2_desc_2' => $request->section_2_desc_2,
            'section_2_head_3' => $request->section_2_head_3,
            'section_2_desc_3' => $request->section_2_desc_3,
            'objective_head' => $request->objective_head,
            'objective_desc' => $request->objective_desc,
            'banner_image_web' => Helper::GetMediaUid($request->banner_image_web),
            'banner_image_tablet' => Helper::GetMediaUid($request->banner_image_tablet),
            'banner_image_mobile' => Helper::GetMediaUid($request->banner_image_mobile),
            'section_2_img' => Helper::GetMediaUid($request->section_2_img),
            'heading' => $request->banner_title,
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

        AboutContent::whereId($request->about_contents_id)->update($content_details);
        return redirect()->route('admin.contents.manage')->with('doneMessage', 'About us page updated successfully');
    }

    public function editAboutPage(Request $request, $id)
    {
        if(!Auth::user()->hasPermission('content_management-update'))
        abort(403);
        $is_content_exist = Content::whereId($id)->first();
        if ($is_content_exist != null) {
            $about_content_details = AboutContent::where('content_id', $is_content_exist->id)->with(['getFirstSectionCard', 'getThirdSectionCard', 'getBannerImageWeb', 'getBannerImageTab', 'getBannerImageMobile', 'getsecondSectionImage'])->first();
            if ($about_content_details != null) {
                return view('dashboard.content-manager.about.edit-about', compact('about_content_details'));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function deleteContent(Request $request)
    {
        if(!Auth::user()->hasPermission('content_management-delete'))
        abort(403);
        // Check if content exist or not
        $is_content_exists =  Content::whereId($request->id)->first();
        if ($is_content_exists == null) {
            return ['status' => 'error', 'message' => 'Content not exist'];
        } else {
            $deleted_data = array(
                'deleted_by' => Auth::id()
            );
            if ($request->page_type == 'about') {
                AboutContent::where('content_id', $request->id)->update($deleted_data);
                Content::whereId($request->id)->update($deleted_data);
                AboutContent::where('content_id', $request->id)->delete();
                Content::whereId($request->id)->delete();
                return ['status' => 'success', 'message' => 'About us page content deleted successfully'];
            } else if ($request->page_type == 'membership') {
                MembershipContent::where('content_id', $request->id)->update($deleted_data);
                Content::whereId($request->id)->update($deleted_data);
                MembershipContent::where('content_id', $request->id)->delete();
                Content::whereId($request->id)->delete();
                return ['status' => 'success', 'message' => 'Membership deleted successfully'];
            } else {
                return ['status' => 'error', 'message' => 'Content not exist'];
            }
        }
    }
}
