<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurTeamCategoryContent extends Model
{
    use HasFactory;

    protected $fillable = [
         'uid', 'category_uid', 'title', 'page_slug', 'status'
    ];
    public function ourTeamCategoryContent()
    {
      return $this->hasMany('App\Models\ourTeamContent', 'category_uid','uid');
    }
    public function userDetails()
      {
          return $this->hasOne('App\Models\User', 'id', 'created_by');
      }
      
      
}
