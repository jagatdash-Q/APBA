<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class OurTeamListingContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid', 'our_teams_listing_uid', 'page_name', 'page_slug', 'meta_title', 'meta_keywoard', 'meta_description', 'name', 'designation', 'about_title', 'description', 'description_data', 'status', 'image' , 'facebook', 'twitter', 'google_plus', 'linkedin', 'youtube', 'instagram', 'printrest','tumblr','snapchat','whatsapp'
    ];

    public function categoryListingContent()
    {
        return $this->hasMany('App\Models\CategoryListingContent', 'listing_content_uid', 'uid')->with('categoryDetail');
    }
    public function image_details()
    {
        return $this->hasOne('App\Models\MediaManager', 'media_uid', 'image');
    }
}
