<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class NewsController extends Controller
{
    public function manageNews(Request $request)
    {
        if (!Auth::user()->hasPermission('news_management-read'))
            abort(403);
        $news = Event::where('is_news', 1)->with('getFeaturedImage')->paginate(10);

        return view('dashboard.news-manage.index', ['news' => $news]);
    }
    public function createNews(Request $request)
    {
        if (!Auth::user()->hasPermission('news_management-create'))
            abort(403);
        return view('dashboard.news-manage.create');
    }
    public function storeNews(Request $request)
    {
        if (!Auth::user()->hasPermission('news_management-create'))
            abort(403);
        try {
            $news = new Event();
            $news->uid = Str::uuid()->toString();
            $news->event_name = $request->news_name;
            $news->event_slug = $request->news_slug;
            $news->status = $request->submit;
            $news->meta_title = $request->meta_title;
            $news->meta_desc = $request->meta_description;
            $news->meta_keywords = $request->meta_keyword;
            $news->featured_image = Helper::GetMediaUid($request->featured_image);
            $news->created_by = Auth::id();
            if ($request->start_date != null && $request->end_date != null) {
                $news->start_date = $request->start_date;
                $news->end_date = $request->end_date;
            }
            $news->publish_date = $request->publish_date;
            $news->is_news = 1;
            $news->news_desc = $request->news_desc_data;
            $news->news_admin_desc = $request->news_desc;
            $news->save();
            return redirect()->route('admin.manage.news')->with('doneMessage', 'News has been successfully created');
        } catch (Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
    public function deleteNews(Request $request)
    {
        if (!Auth::user()->hasPermission('news_management-delete'))
            abort(403);
        try {
            $news = Event::where('uid', $request->uuid)->first();
            $news->deleted_by = Auth::id();
            $news->save();
            $news->delete();
            return redirect()->back()->with('doneMessage', 'News has been successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
    public function editNews($uuid)
    {
        if (!Auth::user()->hasPermission('news_management-update'))
            abort(403);
        $news = Event::where('is_news', 1)->with('getFeaturedImage')->where('uid', $uuid)->first();
        if ($news == null)
            abort(404);
        return view('dashboard.news-manage.edit', ['news' => $news]);
    }
    public function updateNews(Request $request)
    {
        if (!Auth::user()->hasPermission('news_management-update'))
            abort(403);
        try {
            $news = Event::where('is_news', 1)->where('uid', $request->uuid)->first();
            if ($news == null)
                abort(404);
            $news->event_name = $request->news_name;
            $news->event_slug = $request->news_slug;
            $news->status = $request->submit;
            $news->meta_title = $request->meta_title;
            $news->meta_desc = $request->meta_description;
            $news->meta_keywords = $request->meta_keyword;
            $news->featured_image = Helper::GetMediaUid($request->featured_image);
            $news->updated_by = Auth::id();
            if ($request->start_date != null && $request->end_date != null) {
                $news->start_date = $request->start_date;
                $news->end_date = $request->end_date;
            }
            $news->publish_date = $request->publish_date;
            $news->news_desc = $request->news_desc_data;
            $news->news_admin_desc = $request->news_desc;
            $news->save();
            return redirect()->route('admin.manage.news')->with('doneMessage', 'News has been successfully updated');
        } catch (Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
}
