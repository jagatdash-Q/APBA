<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Resource;
use App\Models\ResourceCard;
use App\Models\ResourceMenu;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    use Common;
    public function tempCardCreate(Request $request)
    {
        if ($request->ajax()) {
            $card_count = $request->card_count;
            $menu_section_count = $request->menu_section_count;
            $resource_card = new ResourceCard();
            $resource_card->uuid = Str::uuid()->toString();
            $resource_card->resource_uuid = $request->input('resource_uuid');
            $resource_card->resource_menu_uuid = null;
            $resource_card->title = $request->input('card_section_' . $menu_section_count . '_title_' . $card_count);
            $resource_card->icon = Helper::GetMediaUid($request->input('card_section_' . $menu_section_count . '_icon_' . $card_count));
            $resource_card->hover_icon = Helper::GetMediaUid($request->input('card_section_' . $menu_section_count . '_hover_icon_' . $card_count));
            $resource_card->link = $request->input('card_section_' . $menu_section_count . '_url_' . $card_count);
            $resource_card->publish_date = $request->input('card_section_' . $menu_section_count . '_date_' . $card_count);
            $resource_card->status = $request->input('card_section_' . $menu_section_count . '_status_' . $card_count);
            $resource_card->section_id = $request->menu_section_count;
            $resource_card->save();
            return $this->get_temp_card_data($request->input('resource_uuid'), $menu_section_count);
        }
    }

    public function get_temp_card_data($temp_uuid, $section_id)
    {
        $temp_card_data = ResourceCard::with(['getIcon', 'getHoverIcon'])->where('resource_uuid', $temp_uuid)->where('section_id', $section_id)->orderBy('id', 'asc')->get();
        return $temp_card_data;
    }
    public function tempCardDelete(Request $request)
    {
        if ($request->ajax()) {
            ResourceCard::where('resource_uuid', $request->temp_uuid)->where('uuid', $request->uuid)->delete();
            return $this->get_temp_card_data($request->temp_uuid, $request->menu_section_count);
        }
    }
    public function tempCardEdit(Request $request)
    {
        if ($request->ajax()) {
            return ResourceCard::with(['getIcon', 'getHoverIcon'])->where('resource_uuid', $request->resource_uuid)->where('uuid', $request->uuid)->first();
        }
    }
    public function tempCardUpdate(Request $request)
    {
        if ($request->ajax()) {
            $resource_card = ResourceCard::where('resource_uuid', $request->resource_uuid)->where('uuid', $request->uuid)->first();

            $resource_card->title = $request->input('card_section_' . $request->menu_section_count . '_title_' . $resource_card->id);
            $resource_card->icon = Helper::GetMediaUid($request->input('card_section_' . $request->menu_section_count . '_icon_' . $resource_card->id));
            $resource_card->hover_icon = Helper::GetMediaUid($request->input('card_section_' . $request->menu_section_count . '_hover_icon_' . $resource_card->id));
            $resource_card->link = $request->input('card_section_' . $request->menu_section_count . '_url_' . $resource_card->id);
            $resource_card->publish_date = $request->input('card_section_' . $request->menu_section_count . '_date_' . $resource_card->id);
            $resource_card->status = $request->input('card_section_' . $request->menu_section_count . '_status_' . $resource_card->id);
            $resource_card->section_id = $request->menu_section_count;
            $resource_card->save();

            return $this->get_temp_card_data($request->input('resource_uuid'), $request->menu_section_count);
        }
    }
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
            if ($request->menu_section_count != null) {
                $menu_section_count = (int)$request->menu_section_count;
                // $resource = new Resource();
                $resource =  Resource::firstOrNew(['uuid' => $request->uuid]);
                $resource->content_id = $request->content_id;
                // $resource->uuid = $request->uuid;
                $resource->page_name = $request->page_name;
                $resource->page_slug = $this->slugify($request->page_name);
                $resource->meta_title = $request->meta_title;
                $resource->meta_keyword = $request->meta_keyword;
                $resource->meta_description = $request->meta_description;
                $resource->banner_title = $request->banner_title;
                $resource->banner_desc = $request->banner_desc;
                $resource->button_link = $request->button_link;
                $resource->button_name = $request->button_name;
                $resource->banner_image_web = Helper::GetMediaUid($request->banner_image_web);
                $resource->banner_image_tablet = Helper::GetMediaUid($request->banner_image_tablet);
                $resource->banner_image_mobile = Helper::GetMediaUid($request->banner_image_mobile);
                $resource->banner_title_left_pos_web = (float)$request->banner_title_left_pos_web_;
                $resource->banner_title_top_pos_web = (float)$request->banner_title_top_pos_web_;
                $resource->banner_desc_left_pos_web = (float)$request->banner_desc_left_pos_web_;
                $resource->banner_desc_top_pos_web = (float)$request->banner_desc_top_pos_web_;
                $resource->button_name_left_pos_web = (float)$request->button_name_left_pos_web_;
                $resource->button_name_top_pos_web = (float)$request->button_name_top_pos_web_;
                $resource->banner_title_left_pos_tablet = (float)$request->banner_title_left_pos_tablet_;
                $resource->banner_title_top_pos_tablet = (float)$request->banner_title_top_pos_tablet_;
                $resource->banner_desc_left_pos_tablet = (float)$request->banner_desc_left_pos_tablet_;
                $resource->banner_desc_top_pos_tablet = (float)$request->banner_desc_top_pos_tablet_;
                $resource->button_name_left_pos_tablet = (float)$request->button_name_left_pos_tablet_;
                $resource->button_name_top_pos_tablet = (float)$request->button_name_top_pos_tablet_;
                $resource->banner_title_left_pos_mobile = (float)$request->banner_title_left_pos_mobile_;
                $resource->banner_title_top_pos_mobile = (float)$request->banner_title_top_pos_mobile_;
                $resource->banner_desc_left_pos_mobile = (float)$request->banner_desc_left_pos_mobile_;
                $resource->banner_desc_top_pos_mobile = (float)$request->banner_desc_top_pos_mobile_;
                $resource->button_name_left_pos_mobile = (float)$request->button_name_left_pos_mobile_;
                $resource->button_name_top_pos_mobile = (float)$request->button_name_top_pos_mobile_;
                $resource->title = $request->title;
                $resource->description = $request->description;

                $resource->save();

                if ($resource->save()) {

                    if ($menu_section_count >= 0) {

                        for ($i = 0; $i <= $menu_section_count; $i++) {
                            if (!empty($request->input('menu_section_' . $i . '_title'))) {
                                // $resource_menu = new ResourceMenu();
                                $resource_menu = ResourceMenu::firstOrNew(['uuid' => $request->input('menu_section_' . $i . '_uuid')]);
                                // $resource_menu->uuid = Str::uuid()->toString();
                                $resource_menu->resource_uuid = $resource->uuid;
                                $resource_menu->menu = $request->input('menu_section_' . $i . '_title');
                                $resource_menu->section_id = $i;
                                $resource_menu->save();
                                if ($resource_menu->save()) {
                                    $get_card =  ResourceCard::where('resource_uuid', $resource->uuid)->where('section_id', $i)->get();
                                    if (count($get_card)) {
                                        foreach ($get_card as $card) {
                                            $card->resource_menu_uuid = $resource_menu->uuid;
                                            $card->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $data = array(
                        'content_status' => '1'
                    );
                    Content::whereId($request->content_id)->update($data);
                    if ($request->page_type == "update")
                        return redirect()->back()->with('doneMessage', 'Resource page updated successfully');
                    else
                        return redirect()->route('admin.contents.manage')->with('doneMessage', 'Resource page created successfully');
                }
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

        $resource = Resource::with(['getBannerImageWeb', 'getBannerImageTab', 'getBannerImageMobile', 'getResourceMenu'])->where('content_id', $content_details->id)->first();
        if ($resource == null)
            abort(404);

        return view('dashboard.content-manager.resource.create', compact('content_details', 'resource'));
    }
    public function removeSection(Request $request)
    {
        if(!Auth::user()->hasPermission('content_management-delete'))
        abort(403);
        $menu = ResourceMenu::where('resource_uuid', $request->resource_uuid)->where('section_id', $request->section_id)->first();
        $card = ResourceCard::where('resource_menu_uuid', $menu->resource_menu_uuid)->first();
        $menu->delete();
        $card->delete();
    }
}
