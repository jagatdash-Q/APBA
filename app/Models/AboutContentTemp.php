<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AboutContentTemp extends Model
{
    use HasFactory;
	protected $fillable = [
		'content_id', 'section_id', 'sort_no', 'image', 'hover_image', 'desc',
        'created_by'
	];

    public function imageDetails() : HasOne
	{
		return $this->hasOne('App\Models\MediaManager', 'media_uid','image');
	}

	public function hoverImageDetails() : HasOne
	{
		return $this->hasOne('App\Models\MediaManager', 'media_uid','hover_image');
	}
}
