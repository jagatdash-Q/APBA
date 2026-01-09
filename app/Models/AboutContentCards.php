<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutContentCards extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $fillable = [
		'about_contents_id', 'about_us_uid', 'section_id', 'sort_no', 'image', 'hover_image', 'desc',
        'created_by', 'updated_by', 'deleted_by'
	];


    public function getImageDetails() : HasOne {
        return $this->hasOne(MediaManager::class, 'media_uid', 'image');
    }

    public function hoverImageDetails() : HasOne
	{
		return $this->hasOne('App\Models\MediaManager', 'media_uid','hover_image');
	}
}
