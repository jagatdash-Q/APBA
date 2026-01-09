<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $fillable = [
		'template_id', 'template_type', 'created_by', 'deleted_by', 'updated_by',
        'content_status'
	];

    public function getCreaterDetails()
	{
		return $this->hasOne('App\Models\User', 'id', 'created_by');
	}
    public function GetEditorDetails()
	{
		return $this->hasOne('App\Models\User', 'id', 'updated_by');
	}
}
