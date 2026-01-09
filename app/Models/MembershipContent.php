<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipContent extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'content_id', 'uuid', 'page_name', 'page_slug', 'meta_title', 'meta_keyword', 'meta_description',
        'section_1_head', 'section_1_desc', 'section_1_image', 'section_2_head', 'banner_title', 'banner_desc', 'button_link',
        'button_name', 'banner_image_web', 'banner_image_tablet', 'banner_image_mobile', 'created_by', 'locked_by', 'updated_by', 'deleted_by',
        'banner_title_left_pos_web', 'banner_title_top_pos_web', 'banner_desc_left_pos_web', 'banner_desc_top_pos_web', 'button_name_left_pos_web', 'button_name_top_pos_web', 'banner_title_left_pos_tablet', 'banner_title_top_pos_tablet', 'banner_desc_left_pos_tablet', 'banner_desc_top_pos_tablet', 'button_name_left_pos_tablet', 'button_name_top_pos_tablet', 'banner_title_left_pos_mobile', 'banner_title_top_pos_mobile', 'banner_desc_left_pos_mobile', 'banner_desc_top_pos_mobile', 'button_name_left_pos_mobile', 'button_name_top_pos_mobile',
    ];

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

    public function getfirstSectionImage(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_uid', 'section_1_image');
    }

    public function getMemberships(): HasMany
    {
        return $this->hasMany(MembershipPackage::class, 'membership_contents_id', 'id')->with('getMembershipImage');
    }

}
