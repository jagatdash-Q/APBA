<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaManager extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $fillable = [
		'media_uid', 'media_url', 'path', 'file_type', 'file_ext', 'file_name', 'alt_tag', 'status', 'created_by', 'updated_by', 'deleted_by'
	];

    public function userDetails()
	{
		return $this->hasOne('App\Models\User', 'id', 'created_by');
	}
}
