<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static \Database\Factories\ResourceFactory factory(...$parameters)
 */
class Resource extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'content_id',
        'uuid',
        'page_name',
        'page_slug',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'banner_title',
        'banner_desc',
        'button_link',
        'button_name',
        'banner_image_web',
        'banner_image_tablet',
        'banner_image_mobile',
        'banner_title_left_pos_web',
        'banner_title_top_pos_web',
        'banner_desc_left_pos_web',
        'banner_desc_top_pos_web',
        'button_name_left_pos_web',
        'button_name_top_pos_web',
        'banner_title_left_pos_tablet',
        'banner_title_top_pos_tablet',
        'banner_desc_left_pos_tablet',
        'banner_desc_top_pos_tablet',
        'button_name_left_pos_tablet',
        'button_name_top_pos_tablet',
        'banner_title_left_pos_mobile',
        'banner_title_top_pos_mobile',
        'banner_desc_left_pos_mobile',
        'banner_desc_top_pos_mobile',
        'button_name_left_pos_mobile',
        'button_name_top_pos_mobile',
        'title',
        'description',
    ];

    public function getResourceMenu(): HasMany
    {
        return $this->hasMany(ResourceMenu::class, 'resource_uuid', 'uuid')->with('getResourceCard');
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
}
