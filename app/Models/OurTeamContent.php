<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurTeamContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid', 'our_teams_uid', 'page_name', 'page_slug', 'meta_title', 'meta_keywoard', 'meta_description', 'title', 'desc', 'status','banner_image_web','banner_image_tablet','banner_image_mobile','banner_head','banner_desc','button_link','button_name',
        'banner_title_left_pos_web', 'banner_title_top_pos_web', 'banner_desc_left_pos_web', 'banner_desc_top_pos_web', 'button_name_left_pos_web', 'button_name_top_pos_web', 'banner_title_left_pos_tablet', 'banner_title_top_pos_tablet', 'banner_desc_left_pos_tablet', 'banner_desc_top_pos_tablet','button_name_left_pos_tablet','button_name_top_pos_tablet','banner_title_left_pos_mobile','banner_title_top_pos_mobile','banner_desc_left_pos_mobile','banner_desc_top_pos_mobile','button_name_left_pos_mobile','button_name_top_pos_mobile',
    ];
    public function imageDetails()
	{
		return $this->hasOne('App\Models\MediaManager', 'media_uid','banner_image_web');
	}

    public function imageDetailsTab()
	{
		return $this->hasOne('App\Models\MediaManager', 'media_uid','banner_image_tablet');
	}

    public function imageDetailsMobile()
	{
		return $this->hasOne('App\Models\MediaManager', 'media_uid','banner_image_mobile');
	}
}
