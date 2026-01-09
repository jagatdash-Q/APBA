<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use App\Models\ContactUs;
use App\Models\Event;
use App\Models\HomeContent;
use App\Models\MembershipContent;
use App\Models\OurTeamContent;
use App\Models\OurTeamListingContent;
use App\Models\Resource;
use Illuminate\Http\Request;
use App\Traits\Common;

class CommonController extends Controller
{
    use Common;
    public function ckUpload(Request $request)
    {
        $originName = $request->file('upload')->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $request->file('upload')->getClientOriginalExtension();
        $fileName = $fileName . '_' . time() . '.' . $extension;

        $request->file('upload')->move(public_path('uploads/ckeditor_images'), $fileName);

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        $url = asset('uploads/ckeditor_images/' . $fileName);
        $msg = 'Image uploaded successfully';
        $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";

        @header('Content-type: text/html; charset=utf-8');
        echo $response;
    }

    public function check_unique_page_slug(Request $request)
    {
        $page_name = $request->page_name;
        $original_page_name = $request->original_page_name;
        $page_type = $request->page_type;
        $page_slug = $this->slugify($page_name);
        switch ($page_type) {
            case 'our_teams':
                $ourteam_content = OurTeamContent::where('page_slug', $page_slug)->pluck('id')->toArray();
                if (count($ourteam_content) >= 1) {
                    if ($page_name == $original_page_name) {
                        $data['status'] = 'success';
                        $data['message'] = 'Page slug is available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Page slug is not available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    }
                } else {
                    $data['status'] = 'success';
                    $data['message'] = 'Page slug is available';
                    $data['page_slug'] = $page_slug;
                    return json_encode($data);
                }
                break;
            case 'our_teams_listing':
                $ourteam_content = OurTeamListingContent::where('page_slug', $page_slug)->pluck('id')->toArray();
                if (count($ourteam_content) >= 1) {
                    if ($page_name == $original_page_name) {
                        $data['status'] = 'success';
                        $data['message'] = 'Page slug is available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Page slug is not available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    }
                } else {
                    $data['status'] = 'success';
                    $data['message'] = 'Page slug is available';
                    $data['page_slug'] = $page_slug;
                    return json_encode($data);
                }
                break;
            case 'about_us':
                $about_content = AboutContent::where('page_slug', $page_slug)->pluck('id')->toArray();
                if (count($about_content) >= 1) {
                    if ($page_name == $original_page_name) {
                        $data['status'] = 'success';
                        $data['message'] = 'Page slug is available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Page slug is not available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    }
                } else {
                    $data['status'] = 'success';
                    $data['message'] = 'Page slug is available';
                    $data['page_slug'] = $page_slug;
                    return json_encode($data);
                }
                break;
            case 'membership':
                $membership_content = MembershipContent::where('page_slug', $page_slug)->pluck('id')->toArray();
                if (count($membership_content) >= 1) {
                    if ($page_name == $original_page_name) {
                        $data['status'] = 'success';
                        $data['message'] = 'Page slug is available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Page slug is not available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    }
                } else {
                    $data['status'] = 'success';
                    $data['message'] = 'Page slug is available';
                    $data['page_slug'] = $page_slug;
                    return json_encode($data);
                }
                break;
            case 'events':
                $ourteam_content = Event::where('is_news', 0)->where('event_slug', $page_slug)->pluck('id')->toArray();
                if (count($ourteam_content) >= 1) {
                    if ($page_name == $original_page_name) {
                        $data['status'] = 'success';
                        $data['message'] = 'Event slug is available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Event slug is not available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    }
                } else {
                    $data['status'] = 'success';
                    $data['message'] = 'Event slug is available';
                    $data['page_slug'] = $page_slug;
                    return json_encode($data);
                }
                break;
            case 'news':
                $ourteam_content = Event::where('is_news', 1)->where('event_slug', $page_slug)->pluck('id')->toArray();
                if (count($ourteam_content) >= 1) {
                    if ($page_name == $original_page_name) {
                        $data['status'] = 'success';
                        $data['message'] = 'News slug is available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'News slug is not available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    }
                } else {
                    $data['status'] = 'success';
                    $data['message'] = 'News slug is available';
                    $data['page_slug'] = $page_slug;
                    return json_encode($data);
                }
                break;
            case 'resource':
                $ourteam_content = Resource::where('page_slug', $page_slug)->pluck('id')->toArray();
                if (count($ourteam_content) >= 1) {
                    if ($page_name == $original_page_name) {
                        $data['status'] = 'success';
                        $data['message'] = 'Resource slug is available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Resource slug is not available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    }
                } else {
                    $data['status'] = 'success';
                    $data['message'] = 'Resource slug is available';
                    $data['page_slug'] = $page_slug;
                    return json_encode($data);
                }
                break;
            case 'contact-us':
                $ourteam_content = ContactUs::where('page_slug', $page_slug)->pluck('id')->toArray();
                if (count($ourteam_content) >= 1) {
                    if ($page_name == $original_page_name) {
                        $data['status'] = 'success';
                        $data['message'] = 'Contact us slug is available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Contact us slug is not available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    }
                } else {
                    $data['status'] = 'success';
                    $data['message'] = 'Contact us slug is available';
                    $data['page_slug'] = $page_slug;
                    return json_encode($data);
                }
                break;
                case 'home':
                    $home_content = HomeContent::where('page_slug', $page_slug)->pluck('id')->toArray();
                    if (count($home_content) >= 1) {
                        if ($page_name == $original_page_name) {
                            $data['status'] = 'success';
                            $data['message'] = 'Home page slug is available';
                            $data['page_slug'] = $page_slug;
                            return json_encode($data);
                        } else {
                            $data['status'] = 'error';
                            $data['message'] = 'Home page slug is not available';
                            $data['page_slug'] = $page_slug;
                            return json_encode($data);
                        }
                    } else {
                        $data['status'] = 'success';
                        $data['message'] = 'Home page slug is available';
                        $data['page_slug'] = $page_slug;
                        return json_encode($data);
                    }
                    break;
            default:
                $data['status'] = 'success';
                $data['message'] = 'Page slug is available';
                $data['page_slug'] = $page_slug;
                return json_encode($data);
        }
    }


    public function fileUpload(Request $request)
    {
        $file = $request->file('file');
        $fileName = rand() . '.' . $file->extension();
        $file->move(public_path('dropzone'), $fileName);
        return ['success' => $fileName];
    }
}
