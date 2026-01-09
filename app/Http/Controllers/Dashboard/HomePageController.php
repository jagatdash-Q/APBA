<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\HomeContent;
use App\Models\HomeFinalSectionContent;
use App\Models\HomeFirstSectionCard;
use App\Models\HomePartnerSection;
use App\Models\HomeSliderContent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Traits\Common;

class HomePageController extends Controller
{
    use Common;
    public function createSlider(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-create'))
            return ['status' => 'error', 'message' => 'Access Denied!'];

        // Check if home page created or not
        $home_content_uuid = '';
        if ($request->has('home_content_uuid')) {
            $home_content_uuid = $request->home_content_uuid;
        }
        try {
            HomeSliderContent::create([
                'content_id' => $request->content_id,
                'home_content_uuid' => $home_content_uuid,
                'uuid' => Str::uuid()->toString(),
                'slider_heading' => $request->slider_heading,
                'slider_desc' => $request->slider_desc,
                'slider_button_link' => $request->slider_button_link,
                'slider_button_text' => $request->slider_button_text,
                'is_active' => '1',
                'created_by' => Auth::id(),
            ]);
            if ($home_content_uuid == '') {
                $result = HomeSliderContent::where('content_id', $request->content_id)->get();
            } else {
                $result = HomeSliderContent::where('home_content_uuid', $request->home_content_uuid)->get();
            }
            return ['status' => 'success', 'message' => '', 'result' => $result];
        } catch (Exception $e) {
            Log::info('Home slider create error :-' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Something went wrong , Please try after sometime'];
        }
    }

    public function updateSlider(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-update'))
            return ['status' => 'error', 'message' => 'Access Denied!'];
        try {
            $home_content_uuid = '';
            if ($request->has('home_content_uuid')) {
                $home_content_uuid = $request->home_content_uuid;
            }
            HomeSliderContent::whereId($request->slider_unique)->update([
                'slider_heading' => $request->slider_heading,
                'slider_desc' => $request->slider_desc,
                'slider_button_link' => $request->slider_button_link,
                'slider_button_text' => $request->slider_button_text,
                'home_content_uuid' => $home_content_uuid,
                'updated_by' => Auth::id()
            ]);

            if ($home_content_uuid == '') {
                $result = HomeSliderContent::where('content_id', $request->content_id)->get();
            } else {
                $result = HomeSliderContent::where('home_content_uuid', $request->home_content_uuid)->get();
            }
            return ['status' => 'success', 'message' => '', 'result' => $result];
        } catch (Exception $e) {
            Log::info('Home slider create error :-' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Something went wrong , Please try after sometime'];
        }
    }

    public function createCard(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-create'))
            return ['status' => 'error', 'message' => 'Access Denied!'];
        // Check if home page created or not
        $home_content_uuid = '';
        if ($request->has('home_content_uuid')) {
            $home_content_uuid = $request->home_content_uuid;
        }
        try {
            HomeFirstSectionCard::create([
                'content_id' => $request->content_id,
                'home_content_uuid' => $home_content_uuid,
                'uuid' => Str::uuid()->toString(),
                'heading' => $request->card_heading,
                'description' => $request->card_desc,
                'view_more_text' => $request->card_link_text,
                'view_more_link' => $request->card_link,
                'image' => Helper::GetMediaUid($request->card_img),
                'is_active' => '1',
                'created_by' => Auth::id(),
            ]);
            if ($home_content_uuid == '') {
                $result = HomeFirstSectionCard::where('content_id', $request->content_id)->with('getCardImage')->get();
            } else {
                $result = HomeFirstSectionCard::where('home_content_uuid', $request->home_content_uuid)->with('getCardImage')->get();
            }
            return ['status' => 'success', 'message' => '', 'result' => $result];
        } catch (Exception $e) {
            Log::info('Home slider create error :-' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Something went wrong , Please try after sometime'];
        }
    }

    public function updateCard(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-update'))
            return ['status' => 'error', 'message' => 'Access Denied!'];
        try {
            $home_content_uuid = '';
            if ($request->has('home_content_uuid')) {
                $home_content_uuid = $request->home_content_uuid;
            }
            HomeFirstSectionCard::whereId($request->card_unique)->update([
                'heading' => $request->card_heading,
                'description' => $request->card_desc,
                'view_more_text' => $request->card_link_text,
                'view_more_link' => $request->card_link,
                'image' => Helper::GetMediaUid($request->card_img),
                'home_content_uuid' => $home_content_uuid,
                'updated_by' => Auth::id(),
            ]);

            if ($home_content_uuid == '') {
                $result = HomeFirstSectionCard::where('content_id', $request->content_id)->with('getCardImage')->get();
            } else {
                $result = HomeFirstSectionCard::where('home_content_uuid', $request->home_content_uuid)->with('getCardImage')->get();
            }
            return ['status' => 'success', 'message' => '', 'result' => $result];
        } catch (Exception $e) {
            Log::info('Home slider create error :-' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Something went wrong , Please try after sometime'];
        }
    }

    public function createPartner(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-create'))
            return ['status' => 'error', 'message' => 'Access Denied!'];
        // Check if home page created or not
        $home_content_uuid = '';
        if ($request->has('home_content_uuid')) {
            $home_content_uuid = $request->home_content_uuid;
        }
        try {
            HomePartnerSection::create([
                'content_id' => $request->content_id,
                'home_content_uuid' => $home_content_uuid,
                'uuid' => Str::uuid()->toString(),
                'hover_text' => $request->partner_name,
                'hover_link' => $request->partner_link,
                'image' => Helper::GetMediaUid($request->partner_img),
                'is_active' => '1',
                'created_by' => Auth::id(),
            ]);
            if ($home_content_uuid == '') {
                $result = HomePartnerSection::where('content_id', $request->content_id)->with('getPartnerImage')->get();
            } else {
                $result = HomePartnerSection::where('home_content_uuid', $request->home_content_uuid)->with('getPartnerImage')->get();
            }
            return ['status' => 'success', 'message' => '', 'result' => $result];
        } catch (Exception $e) {
            Log::info('Home partner create error :-' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Something went wrong , Please try after sometime'];
        }
    }

    public function updatePartner(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-update'))
            return ['status' => 'error', 'message' => 'Access Denied!'];
        try {
            $home_content_uuid = '';
            if ($request->has('home_content_uuid')) {
                $home_content_uuid = $request->home_content_uuid;
            }
            HomePartnerSection::whereId($request->partner_unique)->update([
                'hover_text' => $request->partner_name,
                'hover_link' => $request->partner_link,
                'home_content_uuid' => $home_content_uuid,
                'image' => Helper::GetMediaUid($request->partner_img),
                'updated_by' => Auth::id(),
            ]);

            if ($home_content_uuid == '') {
                $result = HomePartnerSection::where('content_id', $request->content_id)->with('getPartnerImage')->get();
            } else {
                $result = HomePartnerSection::where('home_content_uuid', $request->home_content_uuid)->with('getPartnerImage')->get();
            }
            return ['status' => 'success', 'message' => '', 'result' => $result];
        } catch (Exception $e) {
            Log::info('Home slider create error :-' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Something went wrong , Please try after sometime'];
        }
    }


    public function createFinalSectionCard(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-create'))
            return ['status' => 'error', 'message' => 'Access Denied!'];
        // Check if home page created or not
        $home_content_uuid = '';
        if ($request->has('home_content_uuid')) {
            $home_content_uuid = $request->home_content_uuid;
        }
        try {
            HomeFinalSectionContent::create([
                'content_id' => $request->content_id,
                'home_content_uuid' => $home_content_uuid,
                'uuid' => Str::uuid()->toString(),
                'heading' => $request->card_heading,
                'description' => $request->card_desc,
                'read_more_button_text' => $request->card_link_text,
                'read_more_link' => $request->card_link,
                'image' => Helper::GetMediaUid($request->card_img),
                'is_active' => '1',
                'created_by' => Auth::id(),
            ]);
            if ($home_content_uuid == '') {
                $result = HomeFinalSectionContent::where('content_id', $request->content_id)->with('getCardImage')->get();
            } else {
                $result = HomeFinalSectionContent::where('home_content_uuid', $request->home_content_uuid)->with('getCardImage')->get();
            }
            return ['status' => 'success', 'message' => '', 'result' => $result];
        } catch (Exception $e) {
            Log::info('Home slider create error :-' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Something went wrong , Please try after sometime'];
        }
    }

    public function updateFinalSectionCard(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-update'))
            return ['status' => 'error', 'message' => 'Access Denied!'];
        try {
            $home_content_uuid = '';
            if ($request->has('home_content_uuid')) {
                $home_content_uuid = $request->home_content_uuid;
            }
            HomeFinalSectionContent::whereId($request->card_unique)->update([
                'heading' => $request->card_heading,
                'description' => $request->card_desc,
                'read_more_button_text' => $request->card_link_text,
                'read_more_link' => $request->card_link,
                'home_content_uuid' => $home_content_uuid,
                'image' => Helper::GetMediaUid($request->card_img),
                'updated_by' => Auth::id(),
            ]);
            if ($home_content_uuid == '') {
                $result = HomeFinalSectionContent::where('content_id', $request->content_id)->with('getCardImage')->get();
            } else {
                $result = HomeFinalSectionContent::where('home_content_uuid', $request->home_content_uuid)->with('getCardImage')->get();
            }
            return ['status' => 'success', 'message' => '', 'result' => $result];
        } catch (Exception $e) {
            Log::info('Home slider create error :-' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Something went wrong , Please try after sometime'];
        }
    }


    // Edit function for every dynamic card section

    public function editHomeSections(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-update'))
            return ['status' => 'error', 'message' => 'Access Denied!'];
        if ($request->section == 'home_slider') {
            $is_slider_exist =  HomeSliderContent::whereId($request->id)->first();
            if ($is_slider_exist == null) {
                return ['status' => 'error', 'message' => 'Slider not found'];
            } else {
                return ['status' => 'success', 'result' => $is_slider_exist];
            }
        } elseif ($request->section == 'home_card') {
            $is_card_exist =  HomeFirstSectionCard::whereId($request->id)->with('getCardImage')->first();
            if ($is_card_exist == null) {
                return ['status' => 'error', 'message' => 'Card not found'];
            } else {
                return ['status' => 'success', 'result' => $is_card_exist];
            }
        } elseif ($request->section == 'home_partner') {
            $is_partner_exist =  HomePartnerSection::whereId($request->id)->with('getPartnerImage')->first();
            if ($is_partner_exist == null) {
                return ['status' => 'error', 'message' => 'Partner not found'];
            } else {
                return ['status' => 'success', 'result' => $is_partner_exist];
            }
        } elseif ($request->section == 'home_final_card') {
            $is_card_exist =  HomeFinalSectionContent::whereId($request->id)->with('getCardImage')->first();
            if ($is_card_exist == null) {
                return ['status' => 'error', 'message' => 'Card not found'];
            } else {
                return ['status' => 'success', 'result' => $is_card_exist];
            }
        } else {
            return ['status' => 'error', 'message' => 'Invalid request'];
        }
    }

    // Delete function for every dynamic card section
    public function deleteHomeSections(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-delete'))
            return ['status' => 'error', 'message' => 'Access Denied!'];
        if ($request->section == 'home_slider') {
            try {
                $is_slider_exist = HomeSliderContent::whereId($request->id)->first();
                $home_content_uuid = '';
                if ($is_slider_exist == null) {
                    return ['status' => 'error', 'message' => 'Slider does not exist'];
                } else {
                    HomeSliderContent::whereId($request->id)->update([
                        'deleted_by' => Auth::id()
                    ]);
                    HomeSliderContent::whereId($request->id)->delete();
                    if ($request->has('home_content_uuid')) {
                        $home_content_uuid = $request->home_content_uuid;
                    }
                    if ($home_content_uuid == '') {
                        $result = HomeSliderContent::where('content_id', $request->content_id)->get();
                    } else {
                        $result = HomeSliderContent::where('home_content_uuid', $request->home_content_uuid)->get();
                    }
                    return ['status' => 'success', 'message' => 'Slider deleted successfully', 'result' => $result];
                }
            } catch (Exception $e) {
                Log::info('Home slider create error :-' . $e->getMessage());
                return ['status' => 'error', 'message' => 'Something went wrong , Please try after sometime'];
            }
        } else if ($request->section == 'home_card') {
            try {
                $is_card_exist = HomeFirstSectionCard::whereId($request->id)->first();
                $home_content_uuid = '';
                if ($is_card_exist == null) {
                    return ['status' => 'error', 'message' => 'Slider does not exist'];
                } else {
                    HomeFirstSectionCard::whereId($request->id)->update([
                        'deleted_by' => Auth::id()
                    ]);
                    HomeFirstSectionCard::whereId($request->id)->delete();
                    if ($request->has('home_content_uuid')) {
                        $home_content_uuid = $request->home_content_uuid;
                    }
                    if ($home_content_uuid == '') {
                        $result = HomeFirstSectionCard::where('content_id', $request->content_id)->with('getCardImage')->get();
                    } else {
                        $result = HomeFirstSectionCard::where('home_content_uuid', $request->home_content_uuid)->with('getCardImage')->get();
                    }
                    return ['status' => 'success', 'message' => 'Card deleted successfully', 'result' => $result];
                }
            } catch (Exception $e) {
                Log::info('Home slider create error :-' . $e->getMessage());
                return ['status' => 'error', 'message' => 'Something went wrong , Please try after sometime'];
            }
        } else if ($request->section == 'home_partner') {
            try {
                $is_partner_exist = HomePartnerSection::whereId($request->id)->first();
                $home_content_uuid = '';
                if ($is_partner_exist == null) {
                    return ['status' => 'error', 'message' => 'Partner does not exist'];
                } else {
                    HomePartnerSection::whereId($request->id)->update([
                        'deleted_by' => Auth::id()
                    ]);
                    HomePartnerSection::whereId($request->id)->delete();
                    if ($request->has('home_content_uuid')) {
                        $home_content_uuid = $request->home_content_uuid;
                    }
                    if ($home_content_uuid == '') {
                        $result = HomePartnerSection::where('content_id', $request->content_id)->with('getPartnerImage')->get();
                    } else {
                        $result = HomePartnerSection::where('home_content_uuid', $request->home_content_uuid)->with('getPartnerImage')->get();
                    }
                    return ['status' => 'success', 'message' => 'Partner deleted successfully', 'result' => $result];
                }
            } catch (Exception $e) {
                Log::info('Home slider create error :-' . $e->getMessage());
                return ['status' => 'error', 'message' => 'Something went wrong , Please try after sometime'];
            }
        } elseif ($request->section == 'home_final_card') {
            try {
                $is_card_exist = HomeFinalSectionContent::whereId($request->id)->first();
                $home_content_uuid = '';
                if ($is_card_exist == null) {
                    return ['status' => 'error', 'message' => 'Slider does not exist'];
                } else {
                    HomeFinalSectionContent::whereId($request->id)->update([
                        'deleted_by' => Auth::id()
                    ]);
                    HomeFinalSectionContent::whereId($request->id)->delete();
                    if ($request->has('home_content_uuid')) {
                        $home_content_uuid = $request->home_content_uuid;
                    }
                    if ($home_content_uuid == '') {
                        $result = HomeFinalSectionContent::where('content_id', $request->content_id)->with('getCardImage')->get();
                    } else {
                        $result = HomeFinalSectionContent::where('home_content_uuid', $request->home_content_uuid)->with('getCardImage')->get();
                    }
                    return ['status' => 'success', 'message' => 'Card deleted successfully', 'result' => $result];
                }
            } catch (Exception $e) {
                Log::info('Home slider create error :-' . $e->getMessage());
                return ['status' => 'error', 'message' => 'Something went wrong , Please try after sometime'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Invalid request'];
        }
    }


    // Minimum required validation for all cards

    public function validateHomePageCard(Request $request)
    {
        $home_content_uuid = '';
        if ($request->has('home_content_uuid')) {
            $home_content_uuid = $request->home_content_uuid;
        }
        if ($home_content_uuid == '') {
            $slider_content_count = HomeSliderContent::where('content_id', $request->content_id)->count();
            if ($slider_content_count < 2) {
                return ['status' => 'error', 'message' => 'Minimum two slider section required for home page'];
            }
            $first_section_count = HomeFirstSectionCard::where('content_id', $request->content_id)->count();
            if ($first_section_count < 2) {
                return ['status' => 'error', 'message' => 'Minimum two home cards required for home page'];
            }
            $partners_count = HomePartnerSection::where('content_id', $request->content_id)->count();
            if ($partners_count < 3) {
                return ['status' => 'error', 'message' => 'Minimum three partners section required for home page'];
            }
            $final_section_count = HomeFinalSectionContent::where('content_id', $request->content_id)->count();
            if ($final_section_count < 1) {
                return ['status' => 'error', 'message' => 'Minimum one bottom card required for home page'];
            }

            return ['status' => 'success', 'message' => ''];
        } else {
            $slider_content_count = HomeSliderContent::where('home_content_uuid', $request->home_content_uuid)->count();
            if ($slider_content_count < 2) {
                return ['status' => 'error', 'message' => 'Minimum two slider section required for home page'];
            }
            $first_section_count = HomeFirstSectionCard::where('home_content_uuid', $request->home_content_uuid)->count();
            if ($first_section_count < 2) {
                return ['status' => 'error', 'message' => 'Minimum two home cards required for home page'];
            }
            $partners_count = HomePartnerSection::where('home_content_uuid', $request->home_content_uuid)->count();
            if ($partners_count < 3) {
                return ['status' => 'error', 'message' => 'Minimum three partners section required for home page'];
            }
            $final_section_count = HomeFinalSectionContent::where('home_content_uuid', $request->home_content_uuid)->count();
            if ($final_section_count < 1) {
                return ['status' => 'error', 'message' => 'Minimum one bottom card required for home page'];
            }
            return ['status' => 'success', 'message' => ''];
        }
    }

    public function createHomePage(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-create'))
            abort(403);
        if (Content::where('template_type', 'home')->where('content_status', '1')->count()) {
            return redirect()->route('admin.contents.manage')->with('errorMessage', 'Home page has been created');
        } else {
            try {
                $is_home_create = HomeContent::create([
                    'content_id' => $request->content_id,
                    'uuid' => Str::uuid()->toString(),
                    'page_name' => $request->page_name,
                    'page_slug' => $this->slugify($request->page_name),
                    'meta_title' => $request->meta_title,
                    'meta_keyword' => $request->meta_keyword,
                    'meta_description' => $request->meta_description,
                    'banner_image_web' => Helper::GetMediaUid($request->banner_image_web),
                    'banner_image_tablet' => Helper::GetMediaUid($request->banner_image_tablet),
                    'banner_image_mobile' => Helper::GetMediaUid($request->banner_image_mobile),
                    'section_1_img_1' => Helper::GetMediaUid($request->section_1_img_1),
                    'section_1_img_2' => Helper::GetMediaUid($request->section_1_img_2),
                    'section_1_heading' => $request->section_1_heading,
                    'section_1_desc' => $request->section_1_desc,
                    'section_1_button_text' => $request->section_1_button_text,
                    'section_1_button_link' => $request->section_1_button_link,
                    'section_2_heading' => $request->section_2_heading,
                    'section_2_desc' => $request->section_2_desc,
                    'created_by' => Auth::id()
                ]);
                if ($is_home_create) {

                    $data = array(
                        'content_status' => '1'
                    );
                    Content::whereId($request->content_id)->update($data);

                    $homesliders = HomeSliderContent::where('content_id', $request->content_id)->get();
                    foreach ($homesliders as $val) {
                        HomeSliderContent::whereId($val->id)->update([
                            'home_content_uuid' => $is_home_create->uuid
                        ]);
                    }

                    $home_first_section_cards = HomeFirstSectionCard::where('content_id', $request->content_id)->get();
                    foreach ($home_first_section_cards as $val) {
                        HomeFirstSectionCard::whereId($val->id)->update([
                            'home_content_uuid' => $is_home_create->uuid
                        ]);
                    }

                    $home_partner_section_cards = HomePartnerSection::where('content_id', $request->content_id)->get();
                    foreach ($home_partner_section_cards as $val) {
                        HomePartnerSection::whereId($val->id)->update([
                            'home_content_uuid' => $is_home_create->uuid
                        ]);
                    }

                    $home_final_section_cards = HomeFinalSectionContent::where('content_id', $request->content_id)->get();
                    foreach ($home_final_section_cards as $val) {
                        HomeFinalSectionContent::whereId($val->id)->update([
                            'home_content_uuid' => $is_home_create->uuid
                        ]);
                    }
                }
                return redirect()->route('admin.contents.manage')->with('doneMessage', 'Home page created successfully');
            } catch (Exception $e) {
                Log::info("Error in creating home page :- " . json_encode($e->getMessage()));
                return redirect()->route('admin.contents.manage')->with('errorMessage', 'Unable to create home page please try after sometime');
            }
        }
    }


    public function updateHomePage(Request $request)
    {
        if (!Auth::user()->hasPermission('content_management-update'))
        abort(403);
        try {
            $is_home_update = HomeContent::where('uuid', $request->home_content_uuid)->update([
                'content_id' => $request->content_id,
                'page_name' => $request->page_name,
                'page_slug' => $this->slugify($request->page_name),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'banner_image_web' => Helper::GetMediaUid($request->banner_image_web),
                'banner_image_tablet' => Helper::GetMediaUid($request->banner_image_tablet),
                'banner_image_mobile' => Helper::GetMediaUid($request->banner_image_mobile),
                'section_1_img_1' => Helper::GetMediaUid($request->section_1_img_1),
                'section_1_img_2' => Helper::GetMediaUid($request->section_1_img_2),
                'section_1_heading' => $request->section_1_heading,
                'section_1_desc' => $request->section_1_desc,
                'section_1_button_text' => $request->section_1_button_text,
                'section_1_button_link' => $request->section_1_button_link,
                'section_2_heading' => $request->section_2_heading,
                'section_2_desc' => $request->section_2_desc,
                'updated_by' => Auth::id()
            ]);
            $data = array(
                'updated_by' => Auth::id()
            );
            Content::whereId($request->content_id)->update($data);
            return redirect()->route('admin.contents.manage')->with('doneMessage', 'Home page updated successfully');
        } catch (Exception $e) {
            Log::info("Error in updating home page :- " . json_encode($e->getMessage()));
            return redirect()->route('admin.contents.manage')->with('errorMessage', 'Unable to update home page please try after sometime');
        }
    }


    public function editHomePage(Request $request, $id)
    {
        if (!Auth::user()->hasPermission('content_management-update'))
            abort(403);
        $is_content_exist = Content::whereId($id)->first();
        if ($is_content_exist != null) {
            $home = HomeContent::where('content_id', $is_content_exist->id)->with(['getBannerImageWeb', 'getBannerImageTab', 'getBannerImageMobile', 'getfirstSectionfirstImage', 'getfirstSectionsecondImage', 'getSliders', 'getFirstSectionCards', 'getFinalSectionCards', 'getPartners'])->first();
            if ($home != null) {
                return view('dashboard.content-manager.home.edit', compact('home'));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
}
