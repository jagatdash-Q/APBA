<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryListingContent extends Model
{
    use HasFactory;
    protected $fillable = [
        'listing_content_uid', 'category_content_uid'
    ];

    public function categoryDetail()
    {
        return $this->hasOne('App\Models\OurTeamCategoryContent', 'uid', 'category_content_uid');
    }

    public function ourTeamListingContent()
    {
        return $this->hasOne('App\Models\OurTeamListingContent', 'uid', 'listing_content_uid');
    }
}
