<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OurTeamCategory extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $fillable = [
        'uid', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];
    public function userDetails()
	{
		return $this->hasOne('App\Models\User', 'id', 'created_by');
	}
    public function ourTeamCategoryContent()
	{
	  return $this->hasMany('App\Models\OurTeamCategoryContent', 'category_uid','uid');
	}
	public function ourTeamCatContent(){
		return $this->hasOne('App\Models\OurTeamCategoryContent', 'category_uid','uid');
	}

}
