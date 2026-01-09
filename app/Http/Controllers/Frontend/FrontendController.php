<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use App\Models\AboutContentCards;
use App\Models\CategoryListingContent;
use App\Models\ContactUs;
use App\Models\Content;
use App\Models\Country;
use App\Models\Event;
use App\Models\EventSpeakers;
use App\Models\EventTab;
use App\Models\EventWorkshop;
use App\Models\HomeContent;
use App\Models\HomeFinalSectionContent;
use App\Models\HomeFirstSectionCard;
use App\Models\HomePartnerSection;
use App\Models\HomeSliderContent;
use App\Models\MembershipContent;
use App\Models\MembershipPackage;
use App\Models\OurTeam;
use App\Models\OurTeamCategory;
use App\Models\OurTeamListing;
use App\Models\OurTeamListingContent;
use App\Models\Resource;
use App\Models\ResourceCard;
use App\Models\ResourceMenu;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class FrontendController extends Controller
{
    use Common;
    public function index(Request $request)
    {
        $is_content_exist = Content::where('template_type', 'home')->where('content_status', '1')->first();
        if ($is_content_exist != null) {
            $home = HomeContent::where('content_id', $is_content_exist->id)->with(['getBannerImageWeb', 'getBannerImageTab', 'getBannerImageMobile', 'getfirstSectionfirstImage', 'getfirstSectionsecondImage', 'getSliders', 'getFirstSectionCards', 'getFinalSectionCards', 'getPartners'])->first();
            // get lattest news and Events
            $lattest_news_and_event = Event::where('status', '1')->orderBy('publish_date', 'desc')->limit(3)->with('getFeaturedImage')->get();
            if ($home != null) {
                return view('frontend.home', ['home' => $home, 'lattest_news_and_event' => $lattest_news_and_event]);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
    public function about(Request $request)
    {
        $is_content_available = Content::where('template_type', 'about')->where('content_status', '1')->first();
        if ($is_content_available != null) {
            $about_content_details = AboutContent::where('content_id', $is_content_available->id)->with(['getFirstSectionCard', 'getThirdSectionCard', 'getBannerImageWeb', 'getBannerImageTab', 'getBannerImageMobile', 'getsecondSectionImage'])->first();
            if ($about_content_details != null) {
                return view('frontend.about_us', ['about_content_details' => $about_content_details]);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function ourTeam(Request $request)
    {
        $is_our_team_page_exist = OurTeam::where('content_status', '1')->with('getOurTeamContent')->first();
        if ($is_our_team_page_exist == null) {
            abort(404);
        } elseif ($is_our_team_page_exist->getOurTeamContent != null) {
            $our_team_categories = OurTeamCategory::orderby('id', 'asc')->where('status', '1')->with('ourTeamCatContent')->get();
            $our_teams_list_count = OurTeamListing::orderby('sort_no', 'asc')->with('getOurTeamListingContent', 'userDetails')->where('content_status', '1')->count();
            $our_teams_list = OurTeamListing::orderby('sort_no', 'asc')->with('getOurTeamListingContent', 'userDetails')->where('content_status', '1')->paginate(9);
            $tot = ($our_teams_list_count / 9);
            $total_pages = (int)($our_teams_list_count / 9);
            if (is_float($tot)) {
                $total_pages += 1;
            }
            $title = $is_our_team_page_exist->getOurTeamContent->meta_title;
            $description =  $is_our_team_page_exist->getOurTeamContent->meta_description;
            $keywords = $is_our_team_page_exist->getOurTeamContent->meta_keywoard;
            $current_page_data = count($our_teams_list);
            $has_new_page = $our_teams_list->hasMorePages();
            if ($request->ajax()) {
                $current_page_data = count($our_teams_list);
                $has_new_page = $our_teams_list->hasMorePages();
                $view = view('frontend.our_team_data', ['our_team_categories' => $our_team_categories, 'is_our_team_page_exist' => $is_our_team_page_exist, 'our_teams_list' => $our_teams_list, 'our_teams_list_count' => $our_teams_list_count, 'total_pages' => $total_pages, 'title' => $title, 'description' => $description, 'keywords' => $keywords, 'current_page_data' => $current_page_data, 'has_new_page' => $has_new_page])->render();
                return response()->json(['html' => $view, 'current_page_data' => $current_page_data, 'has_new_page' => $has_new_page]);
            }
            return view('frontend.our_team', ['our_team_categories' => $our_team_categories, 'is_our_team_page_exist' => $is_our_team_page_exist, 'our_teams_list' => $our_teams_list, 'our_teams_list_count' => $our_teams_list_count, 'total_pages' => $total_pages, 'title' => $title, 'description' => $description, 'keywords' => $keywords, 'current_page_data' => $current_page_data, 'has_new_page' => $has_new_page]);
        } else {
            abort(404);
        }
    }

    public function ourTeamDetails(Request $request, $uid, $slug)
    {
        $is_listing_exist =  OurTeamListingContent::where('uid', $uid)->with(['categoryListingContent', 'image_details'])->first();
        if ($is_listing_exist != null) {
            return view('frontend.our_team_details', ['is_listing_exist' => $is_listing_exist]);
        }
        abort(404);
    }

    public function ourTeamCatListings(Request $request)
    {
        if ($request->cat_uid == '0') {
            $our_teams_list = OurTeamListing::orderby('sort_no', 'asc')->with('getOurTeamListingContent', 'userDetails')->where('content_status', '1')->paginate(9);
            $current_page_data = count($our_teams_list);
            $has_new_page = $our_teams_list->hasMorePages();
            if ($request->ajax()) {
                $current_page_data = count($our_teams_list);
                $has_new_page = $our_teams_list->hasMorePages();
                $view = view('frontend.our_team_data', ['our_teams_list' => $our_teams_list, 'current_page_data' => $current_page_data, 'has_new_page' => $has_new_page])->render();
                return response()->json(['html' => $view, 'current_page_data' => $current_page_data, 'has_new_page' => $has_new_page]);
            }
        } elseif (CategoryListingContent::where('category_content_uid', $request->cat_uid)->count()) {
            $get_listing_content_uid = CategoryListingContent::where('category_content_uid', $request->cat_uid)->pluck('listing_content_uid');
            // Get OurteamListingIds
            $get_listing_uids = OurTeamListingContent::whereIn('uid', $get_listing_content_uid)->pluck('our_teams_listing_uid');
            $our_teams_list = OurTeamListing::orderby('sort_no', 'asc')->with('getOurTeamListingContent', 'userDetails')->whereIn('uid', $get_listing_uids)->where('content_status', '1')->paginate(9);
            $current_page_data = count($our_teams_list);
            $has_new_page = $our_teams_list->hasMorePages();
            if ($request->ajax()) {
                $current_page_data = count($our_teams_list);
                $has_new_page = $our_teams_list->hasMorePages();
                $view = view('frontend.our_team_data', ['our_teams_list' => $our_teams_list, 'current_page_data' => $current_page_data, 'has_new_page' => $has_new_page])->render();
                return response()->json(['html' => $view, 'current_page_data' => $current_page_data, 'has_new_page' => $has_new_page]);
            }
        } else {
            return response()->json(['html' => '']);
        }
    }

    public function resources(Request $request)
    {
        $content_details = Content::where('template_type', 'resources')->where('content_status', '1')->first();
        if ($content_details == null) {
            abort(404);
        }
        $resource = Resource::query();
        $resource = $resource->where('content_id', $content_details->id)->with(['getBannerImageWeb', 'getBannerImageTab', 'getBannerImageMobile']);

        if ($resource->first() == null) {
            abort(404);
        }

        if ($request->ajax()) {
            $menu_id = $request->menuId;
            $sort = $request->sort;
            $timing = $request->timing;

            if ($menu_id != null) {
                $resource = $resource->with(['getResourceMenu' => function ($query) use ($menu_id, $sort, $timing) {
                    $query->orderByRaw("id = ? desc", [$menu_id]);
                    $query->with(['getResourceCard' => function ($card_query) use ($sort, $timing) {
                        if ($sort != null) {
                            $card_query->orderBy('publish_date', $sort);
                        }
                        if ($timing != null) {
                            $card_query->whereMonth('publish_date', $timing);
                        }
                    }]);
                }]);
            }

            $resource = $resource->first();
            return view('frontend.resource-cards', ['resource' => $resource]);
        } else {
            $resource = $resource->with(['getResourceMenu' => function ($query1) {
                $query1->with(['getResourceCard' => function ($card_query1) {
                    $card_query1->orderBy('publish_date', 'desc');
                }]);
            }])->first();
        }
        return view('frontend.resources', ['resource' => $resource]);
    }

    // public function resources(Request $request)
    // {
    //     $content_details = Content::where('template_type', 'resources')->where('content_status', '1')->first();
    //     if ($content_details == null)
    //         abort(404);
    //     $resource = Resource::query();
    //     $resource = $resource->where('content_id', $content_details->id)->with(['getBannerImageWeb', 'getBannerImageTab', 'getBannerImageMobile']);

    //     if ($resource->first() == null)
    //         abort(404);

    //     if ($request->ajax()) {
    //         $menu_id = $request->menuId;
    //         $sort = $request->sort;
    //         $timing = $request->timing;

    //         if ($menu_id != null) {
    //             $resource = $resource->with(['getResourceMenu' => function ($query) use ($menu_id, $sort, $timing) {
    //                 $query->orderByRaw("id = ? desc", [$menu_id]);
    //                 $query->with(['getResourceCard' => function ($card_query) use ($sort, $timing) {
    //                     if ($sort != null)
    //                         $card_query->orderBy('id', $sort);
    //                     if ($timing != null)
    //                         $card_query->whereMonth('created_at', $timing);
    //                 }]);
    //             }]);
    //         }

    //         $resource = $resource->first();
    //         return view('frontend.resource-cards', compact('resource'));
    //     } else {
    //         $resource = $resource->with(['getResourceMenu'=>function($query1){
    //             $query1->with(['getResourceCard' => function ($card_query1){
    //                     $card_query1->orderBy('id', 'desc');
    //             }]);
    //         }])->first();
    //     }
    //     return view('frontend.resources', compact('resource'));
    // }

    public function newsAndEvents(Request $request)
    {
        $event = Event::query();
        $event = $event->with('getFeaturedImage');

        // ->where(function ($query) {
        //     $query->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))
        //         ->orWhereNull('start_date')
        //         ->orWhereNull('end_date');
        // });

        if ($request->ajax()) {
            if ($request->sort != null) {
                $event = $event->orderBy('publish_date', $request->sort);
            }

            if ($request->timing != null) {
                $event = $event->whereMonth('publish_date', $request->timing);
            }

            if ($request->radio_val != null) {
                $event = $event->where('is_news', $request->radio_val);
            }

            $event = $event->where('status', '1');
            $event = $event->paginate(9);
            return view('frontend.events.event_cards', ['event' => $event]);
        }

        $event = $event->orderBy('publish_date', 'desc')->where('status', '1')->paginate(9);
        return view('frontend.news_events', ['event' => $event]);
    }

    public function membership()
    {
        $is_content_available = Content::where('template_type', 'membership')->where('content_status', '1')->first();
        if ($is_content_available != null) {
            $mebership = MembershipContent::where('content_id', $is_content_available->id)->with(['getBannerImageWeb', 'getBannerImageTab', 'getBannerImageMobile', 'getfirstSectionImage', 'getMemberships'])->first();
            if ($mebership != null) {
                return view('frontend.membership', ['mebership' => $mebership]);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function contact()
    {
        $content_details = Content::where('template_type', 'contact-us')->where('content_status', '1')->first();
        if ($content_details == null) {
            abort(404);
        }
        $contact_us = ContactUs::where('content_id', $content_details->id)->with(['getBannerImageWeb', 'getBannerImageTab', 'getBannerImageMobile'])->first();
        $country = Country::select('name')->get();
        return view('frontend.contact', ['country' => $country, 'contact_us' => $contact_us]);
    }

    public function submitContactQuery(Request $request)
    {
        $rules = [
            'captcha' => 'required|captcha'
        ];
        $customMessages = [
            'captcha.captcha' => 'The :attribute does not match with the image.'
        ];
        $this->validate($request, $rules, $customMessages);
        $email = env("MAIL_FROM_ADDRESS", "no-reply@a-pba.org");
        try {
            Mail::to($email)->send(new \App\Mail\ContactUsQueryMail($request));
            return redirect()->back()->with('doneMessage', 'Thank you! We will connect you shortly.');
        } catch (Exception $e) {
            Log::info('Error in sending contact us email :-' . $e->getMessage());
            return redirect()->back()->with('errorMessage', 'Something went wrong!');
        }
    }
    public function subscriberEmail(Request $request)
    {
        $rules = [
            'captcha' => 'required|captcha'
        ];
        $customMessages = [
            'captcha.captcha' => 'The :attribute does not match with the image.'
        ];
        $this->validate($request, $rules, $customMessages);
        $email = env("MAIL_FROM_ADDRESS", "no-reply@a-pba.org");
        try {
            Mail::to($email)->send(new \App\Mail\SubscriberMail($request->subscriber_email));
            return redirect()->back()->with('doneMessage', 'Thank you! We will connect you shortly.');
        } catch (Exception $e) {
            Log::info('Error in sending subscriber email :-' . $e->getMessage());
            return redirect()->back()->with('errorMessage', 'Something went wrong!');
        }
    }
    public function searchDetails(Request $request)
    {
        $result = [];
        $count = 0;
        $search = $request->search_text;

        // About Us Section Check
        $about_card_search = AboutContentCards::where('desc', 'like', '%' . $search . '%')->pluck('about_contents_id')->toArray();
        $about_search = AboutContent::query();
        if (count($about_card_search) > 0) {
            $about_search = $about_search->whereIn('id', $about_card_search)->get();
        } else {
            $about_search = $about_search->where('page_name', 'like', '%' . $search . '%')
                ->orWhere('heading', 'like', '%' . $search . '%')
                ->orWhere('welcome_head', 'like', '%' . $search . '%')
                ->orWhere('welcome_desc', 'like', '%' . $search . '%')
                ->orWhere('objective_head', 'like', '%' . $search . '%')
                ->orWhere('objective_desc', 'like', '%' . $search . '%')
                ->orWhere('section_2_head_1', 'like', '%' . $search . '%')
                ->orWhere('section_2_desc_1', 'like', '%' . $search . '%')
                ->orWhere('section_2_head_2', 'like', '%' . $search . '%')
                ->orWhere('section_2_desc_2', 'like', '%' . $search . '%')
                ->orWhere('section_2_head_3', 'like', '%' . $search . '%')
                ->orWhere('section_2_desc_3', 'like', '%' . $search . '%')
                ->get();
        }
        if (count($about_search) > 0) {
            foreach ($about_search as $value) {
                $result['about-us'][] = $value;
                $count++;
            }
        } else {
            $result['about-us'] = 0;
        }

        // Our Team Section Check
        $our_team_listing_content = OurTeamListingContent::where('name', 'like', '%' . $search . '%')
            ->orWhere('designation', 'like', '%' . $search . '%')
            ->orWhere('description_data', 'like', '%' . $search . '%')
            ->get();
        if (count($our_team_listing_content) > 0) {
            foreach ($our_team_listing_content as $our_team) {
                $result['our-team'][] = $our_team;
                $count++;
            }
        } else {
            $result['our-team'] = 0;
        }

        // News & Event Section Check
        $event_speaker = EventSpeakers::where('speaker_name', 'like', '%' . $search . '%')
            ->orWhere('speaker_designation', 'like', '%' . $search . '%')
            ->orWhere('speaker_details_data', 'like', '%' . $search . '%')
            ->get();
        if (count($event_speaker) > 0) {
            $counter = count($event_speaker);
            for ($i = 0; $i < $counter; $i++) {
                $result['news-event'][$i]['title'] = $event_speaker[$i]->speaker_name;
                $result['news-event'][$i]['description'] = $event_speaker[$i]->speaker_details_data;
                $result['news-event'][$i]['redirect_url'] = $request->root() . '/featured-speaker-details/' . $event_speaker[$i]->id;
                $count++;
            }
        }

        $event_workshop = EventWorkshop::where('workshop_name', 'like', '%' . $search . '%')->with(['getEventDetails', 'getWorkshopPrograms' => function ($query) use ($search) {
            $query->orWhere('program_name', 'like', '%' . $search . '%');
            $query->orWhere('program_desc', 'like', '%' . $search . '%');
            $query->orWhere('program_trainers', 'like', '%' . $search . '%');
        }])->get();
        if (count($event_workshop) > 0) {
            $counter = count($event_workshop);
            for ($j = 0; $j < $counter; $j++) {
                $result['news-event'][$j]['title'] = $event_workshop[$j]['getEventDetails']['event_name'];
                $result['news-event'][$j]['description'] = $event_workshop[$j]->workshop_name;
                $result['news-event'][$j]['redirect_url'] = $request->root() . '/event-register/' . $event_workshop[$j]->getEventDetails->uid;
                $count++;
            }
        }

        $event_tab = EventTab::where('tab_name', 'like', '%' . $search . '%')
            ->orWhere('tab_desc_data', 'like', '%' . $search . '%')
            ->pluck('event_id')->toArray();

        $event = Event::query();

        if (count($event_tab) > 0) {
            $event = $event->with('getEventTabs')->whereIn('id', $event_tab)->get();
        } else {
            $event = $event->with('getEventTabs')
                ->where('event_name', 'like', '%' . $search . '%')
                ->orWhere('event_location', 'like', '%' . $search . '%')
                ->orWhere('news_desc', 'like', '%' . $search . '%')
                ->get();
        }

        if (count($event) > 0) {
            $counter = count($event);
            for ($k = 0; $k < $counter; $k++) {
                $result['news-event'][$k]['title'] = $event[$k]['event_name'];
                if ($event[$k]['is_news'] == 0) {
                    $result['news-event'][$k]['description'] = $event[$k]['getEventTabs'][0]['tab_desc_data'];
                    $result['news-event'][$k]['redirect_url'] = $request->root() . '/event-details/' . $event[$k]['event_slug'];
                } else {
                    $result['news-event'][$k]['description'] = $event[$k]['news_desc'];
                    $result['news-event'][$k]['redirect_url'] = $request->root() . '/news-details/' . $event[$k]['event_slug'];
                }
                $count++;
            }
        }

        // Membership Section Check

        $member_package = MembershipPackage::where('membership_name', 'like', '%' . $search . '%')
            ->orWhere('membership_srt_desc', 'like', '%' . $search . '%')
            ->orWhere('membership_description', 'like', '%' . $search . '%')
            ->orWhere('membership_plan', 'like', '%' . $search . '%')
            ->pluck('membership_contents_id')->toArray();


        $member = MembershipContent::query();
        if (count($member_package) > 0) {
            $member = $member->whereIn('id', $member_package)->get();
        } else {
            $member = $member->where('page_name', 'like', '%' . $search . '%')
                ->orWhere('section_1_head', 'like', '%' . $search . '%')
                ->orWhere('section_1_desc', 'like', '%' . $search . '%')
                ->orWhere('banner_title', 'like', '%' . $search . '%')
                ->get();
        }

        if (count($member) > 0) {
            $counter = count($member);
            for ($l = 0; $l < $counter; $l++) {
                $result['membership'][$l]['title'] = $member[$l]['section_1_head'];
                $result['membership'][$l]['description'] = $member[$l]['section_1_desc'];
                $result['membership'][$l]['redirect_url'] = $request->root() . '/membership';
                $count++;
            }
        }

        // Resource Section Check

        $resource = Resource::where('page_name', 'like', '%' . $search . '%')
            ->orWhere('banner_title', 'like', '%' . $search . '%')
            ->orWhere('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->get();

        if (count($resource) > 0) {
            $counter = count($resource);
            for ($m = 0; $m < $counter; $m++) {
                $result['resource'][$m]['title'] = $resource[$m]['page_name'];
                $result['resource'][$m]['description'] = $resource[$m]['description'];
                $result['resource'][$m]['redirect_url'] = $request->root() . '/resources';
                $count++;
            }
        }


        $resource_menu = ResourceMenu::with(['getResource'])->where('menu', 'like', '%' . $search . '%')->get();
        if (count($resource_menu) > 0) {
            $counter = count($resource_menu);
            for ($n = 0; $n < $counter; $n++) {
                $result['resource'][$n]['title'] = $resource_menu[$n]['menu'];
                $result['resource'][$n]['description'] = $resource_menu[$n]['getResource']['description'];
                $result['resource'][$n]['redirect_url'] = $request->root() . '/resources';
                $count++;
            }
        }

        $resource_card = ResourceCard::with(['getResource'])->where('title', 'like', '%' . $search . '%')->get();
        if (count($resource_card) > 0) {
            $counter = count($resource_card);
            for ($p = 0; $p < $counter; $p++) {
                $result['resource'][$p]['title'] = $resource_card[$p]['title'];
                if ($resource_card[$p]['getResource'] != null) {
                    $result['resource'][$p]['description'] = $resource_card[$p]['getResource']['description'];
                } else {
                    $result['resource'][$p]['description'] = '';
                }
                $result['resource'][$p]['redirect_url'] = $request->root() . '/resources';
                $count++;
            }
        }

        $resource_alt_tag = ResourceCard::with(['getAltSearch' => function ($query) use ($search) {
            $query->where('alt_tag', 'like', '%' . $search . '%');
        }])->get();

        if (count($resource_alt_tag) > 0) {
            $counter = count($resource_alt_tag);
            for ($p = 0; $p < $counter; $p++) {

                if ($resource_alt_tag[$p]['getAltSearch'] != null) {
                    $result['resource'][$p]['title'] = $resource_alt_tag[$p]['title'];
                    if ($resource_alt_tag[$p]['getResource'] != null) {
                        $result['resource'][$p]['description'] = $resource_alt_tag[$p]['getResource']['description'];
                    } else {
                        $result['resource'][$p]['description'] = '';
                    }
                    $result['resource'][$p]['redirect_url'] = $request->root() . '/resources';
                    $count++;
                }
            }
        }

        // Home page search
        $home = HomeContent::where('page_name', 'like', '%' . $search . '%')
            ->orWhere('section_1_heading', 'like', '%' . $search . '%')
            ->orWhere('section_1_desc', 'like', '%' . $search . '%')
            ->orWhere('section_2_heading', 'like', '%' . $search . '%')
            ->orWhere('section_2_desc', 'like', '%' . $search . '%')
            ->get();

        if (count($home) > 0) {
            $counter = count($home);
            for ($m = 0; $m < $counter; $m++) {
                $result['home'][$m]['title'] = $home[$m]['page_name'];
                $result['home'][$m]['description'] = $home[$m]['section_1_desc'];
                $result['home'][$m]['redirect_url'] = $request->root() . '/';
                $count++;
            }
        } else {
            $result['home'] = [];
        }

        $home_final_section_card = HomeFinalSectionContent::where('is_active', '1')
            ->where('heading', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->get();
        $counter = count($home_final_section_card);

        for ($m = 0; $m < $counter; $m++) {
            $count_var = count($result['home']);
            $result['home'][($count_var)]['title'] = $home_final_section_card[$m]['heading'];
            $result['home'][($count_var)]['description'] = $home_final_section_card[$m]['description'];
            $result['home'][($count_var)]['redirect_url'] = $request->root() . '/';
            $count++;
        }

        $home_first_section_card = HomeFirstSectionCard::where('is_active', '1')
            ->where('heading', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->get();
        $counter = count($home_first_section_card);

        for ($m = 0; $m < $counter; $m++) {
            $count_var = count($result['home']);
            $result['home'][($count_var)]['title'] = $home_first_section_card[$m]['heading'];
            $result['home'][($count_var)]['description'] = $home_first_section_card[$m]['description'];
            $result['home'][($count_var)]['redirect_url'] = $request->root() . '/';
            $count++;
        }

        $home_partner_section = HomePartnerSection::where('is_active', '1')
            ->where('hover_text', 'like', '%' . $search . '%')
            ->get();
        $counter = count($home_partner_section);

        for ($m = 0; $m < $counter; $m++) {
            $count_var = count($result['home']);
            $result['home'][($count_var)]['title'] = $home_partner_section[$m]['hover_text'];
            $result['home'][($count_var)]['description'] = $home_partner_section[$m]['hover_text'];
            $result['home'][($count_var)]['redirect_url'] = $request->root() . '/';
            $count++;
        }

        $home_slider_section = HomeSliderContent::where('is_active', '1')
            ->where('slider_heading', 'like', '%' . $search . '%')
            ->orWhere('slider_desc', 'like', '%' . $search . '%')
            ->get();
        $counter = count($home_slider_section);

        for ($m = 0; $m < $counter; $m++) {
            $count_var = count($result['home']);
            $result['home'][($count_var)]['title'] = $home_slider_section[$m]['slider_heading'];
            $result['home'][($count_var)]['description'] = $home_slider_section[$m]['slider_desc'];
            $result['home'][($count_var)]['redirect_url'] = $request->root() . '/';
            $count++;
        }

        // dd($result['home']);

        return view('frontend.search_page', ['result' => $result, 'count' => $count, 'search' => $search]);
    }
    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
}
