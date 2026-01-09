<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeContent extends Model
{
  use HasFactory, SoftDeletes;
  protected $fillable = [
    'content_id', 'uuid', 'page_name', 'page_slug', 'meta_title', 'meta_keyword', 'meta_description', 'banner_image_web', 'banner_image_tablet', 'banner_image_mobile', 'section_1_img_1', 'section_1_img_2', 'section_1_heading', 'section_1_button_text',
    'section_1_button_link', 'section_1_desc', 'section_2_heading', 'section_2_desc', 'created_by', 'updated_by', 'deleted_by'
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

  public function getfirstSectionfirstImage(): HasOne
  {
    return $this->hasOne(MediaManager::class, 'media_uid', 'section_1_img_1');
  }

  public function getfirstSectionsecondImage(): HasOne
  {
    return $this->hasOne(MediaManager::class, 'media_uid', 'section_1_img_2');
  }


  public function getSliders(): HasMany
  {
    return $this->hasMany(HomeSliderContent::class, 'home_content_uuid', 'uuid');
  }

  public function getFirstSectionCards(): HasMany
  {
    return $this->hasMany(HomeFirstSectionCard::class, 'home_content_uuid', 'uuid')->with('getCardImage');
  }

  public function getFinalSectionCards(): HasMany
  {
    return $this->hasMany(HomeFinalSectionContent::class, 'home_content_uuid', 'uuid')->with('getCardImage');
  }

  public function getPartners(): HasMany
  {
    return $this->hasMany(HomePartnerSection::class, 'home_content_uuid', 'uuid')->with('getPartnerImage');
  }

}
