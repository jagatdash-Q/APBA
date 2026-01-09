<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OurTeam extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uid', 'lock_acquired_by', 'page_type', 'reviewed_by', 'deleted_by', 'edited_by','content_status','reject_remarks','created_by'
    ];
    public function userDetails()
	{
		return $this->hasOne('App\Models\User', 'id', 'created_by');
	}
	public function ourTeamContent()
    {
		return $this->hasMany('App\Models\OurTeamContent', 'our_teams_uid','uid');
	}

	public function getOurTeamContent()
    {
		return $this->hasOne('App\Models\OurTeamContent', 'our_teams_uid','uid')->with(['imageDetails','imageDetailsTab','imageDetailsMobile']);
	}
	public function teamContent()
    {
		return $this->hasOne('App\Models\OurTeamContent', 'our_teams_uid','uid');
	}

	public function ourTeamListing()
    {
		return $this->hasMany('App\Models\OurTeamListing', 'our_teams_uid','uid')->with('ourTeamListingContent');
	}

	public function lockAcquiredUser()
	{
	  return $this->belongsTo('App\Models\User', 'lock_acquired_by','id');
	}
	
}
