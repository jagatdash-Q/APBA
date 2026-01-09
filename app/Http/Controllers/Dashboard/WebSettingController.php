<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;

use App\Models\WebSetting;
use App\Http\Requests\StoreWebSettingRequest;
use App\Http\Requests\UpdateWebSettingRequest;

class WebSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $WebSetting = WebSetting::find(1);
        return view('dashboard.websetting', compact('WebSetting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWebSettingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WebSetting $webSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebSetting $webSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebSettingRequest $request, WebSetting $webSetting)
    {
        $WebSetting = WebSetting::find(1);
        if ($WebSetting) {
            $WebSetting = WebSetting::find(1);
            $WebSetting->site_logo = Helper::getMediaUid($request->site_logo);
            $WebSetting->fav_icon = Helper::getMediaUid($request->fav_icon);
            $WebSetting->site_name = $request->site_name;
            $WebSetting->site_email = $request->site_email;
            $WebSetting->site_copyrights = $request->site_copyrights;
            $WebSetting->site_title = $request->site_title;
            $WebSetting->site_address = $request->site_address;
            $WebSetting->fb_link = $request->fb_link;
            $WebSetting->insta_link = $request->insta_link;
            $WebSetting->linkdn_link = $request->linkdn_link;
            $WebSetting->youtube_link = $request->youtube_link;
            $WebSetting->save();
        } else {
            WebSetting::query()->truncate();
            $WebSetting = new WebSetting;
            $WebSetting->site_logo = Helper::getMediaUid($request->site_logo);
            $WebSetting->fav_icon = Helper::getMediaUid($request->fav_icon);
            $WebSetting->site_name = $request->site_name;
            $WebSetting->site_email = $request->site_email;
            $WebSetting->site_copyrights = $request->site_copyrights;
            $WebSetting->site_title = $request->site_title;
            $WebSetting->site_address = $request->site_address;
            $WebSetting->fb_link = $request->fb_link;
            $WebSetting->insta_link = $request->insta_link;
            $WebSetting->linkdn_link = $request->linkdn_link;
            $WebSetting->youtube_link = $request->youtube_link;
            $WebSetting->save();
        }

        return redirect()->route('websetting.index')->withSuccess('Site Setting updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebSetting $webSetting)
    {
        //
    }
}
