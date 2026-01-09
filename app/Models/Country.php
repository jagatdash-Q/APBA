<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $fillable = [
		'name','slug','code','status','created_by','deleted_by','updated_by'
	];
	public function getCreaterDetails()
	{
		return $this->hasOne('App\Models\User', 'id', 'created_by');
	}
}
