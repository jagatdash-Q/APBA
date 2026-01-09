<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OurTeamListing extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'uid', 'our_teams_uid', 'sort_no' ,  'lock_acquired_by', 'page_type', 'reviewed_by', 'deleted_by', 'reject_remarks', 'content_status','edited_by','reject_remarks','created_by'
    ];
    public function ourTeamListingContent()
    {
		return $this->hasMany('App\Models\OurTeamListingContent', 'our_teams_listing_uid','uid')->with('categoryListingContent');
	}

    public function getOurTeamListingContent()
    {
		return $this->hasOne('App\Models\OurTeamListingContent', 'our_teams_listing_uid','uid')->with(['image_details','categoryListingContent']);
	}
    public function userDetails()
	{
		return $this->hasOne('App\Models\User', 'id', 'created_by');
	}
	
    public function lockAcquiredUser()
	{
	  return $this->hasOne('App\Models\User','id', 'lock_acquired_by');
	}
}
