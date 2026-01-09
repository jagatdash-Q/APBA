<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutContent extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'content_id', 'uuid', 'page_name', 'page_slug', 'meta_title', 'meta_keywoard', 'meta_description', 'heading', 'banner_image_web', 'welcome_head', 'welcome_desc',
        'created_by', 'updated_by', 'deleted_by', 'objective_head', 'objective_desc', 'section_2_head_1', 'section_2_desc_1', 'section_2_head_2', 'section_2_desc_2', 'section_2_head_3', 'section_2_desc_3', 'banner_desc', 'button_link', 'button_name', 'banner_image_tablet', 'banner_image_mobile','section_2_img','banner_title_left_pos_web', 'banner_title_top_pos_web', 'banner_desc_left_pos_web', 'banner_desc_top_pos_web', 'button_name_left_pos_web', 'button_name_top_pos_web', 'banner_title_left_pos_tablet', 'banner_title_top_pos_tablet', 'banner_desc_left_pos_tablet', 'banner_desc_top_pos_tablet', 'button_name_left_pos_tablet', 'button_name_top_pos_tablet', 'banner_title_left_pos_mobile', 'banner_title_top_pos_mobile', 'banner_desc_left_pos_mobile', 'banner_desc_top_pos_mobile', 'button_name_left_pos_mobile', 'button_name_top_pos_mobile',
    ];

    public function getFirstSectionCard(): HasMany
    {
        return $this->hasMany(AboutContentCards::class, 'about_contents_id', 'id')->where('section_id', '=', 'section_1')->with('getImageDetails');
    }

    public function getThirdSectionCard(): HasMany
    {
        return $this->hasMany(AboutContentCards::class, 'about_contents_id', 'id')->where('section_id', '=', 'section_3')->with(['hoverImageDetails','getImageDetails']);
    }

    public function getBannerImageWeb(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_uid', 'banner_image_web');
    }

    public function getBannerImageTab(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_uid', 'banner_image_tablet');
    }

    public function getBannerImageMobile(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_uid', 'banner_image_mobile');
    }

    public function getsecondSectionImage(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_uid', 'section_2_img');
    }
}
