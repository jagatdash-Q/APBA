<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventWorkshopPrograms extends Model
{
	use HasFactory, SoftDeletes;
	protected $fillable = [
		'event_id',
		'event_workshop_id',
		'program_name',
		'program_slug',
		'program_desc',
		'program_trainers',
		'workshop_number',
		'room_no',
		'price_member',
		'price_guest',
		'start_time',
		'end_time',
		'program_date',
		'survey',
		'survey_activity_uuid',
		'created_by',
		'updated_by',
		'deleted_by',
		'status',
	];
	public function getEventDetails(): HasOne
	{
		return $this->hasOne(Event::class, 'id', 'event_id');
	}
	public function getEventWorkshopDetails(): HasOne
	{
		return $this->hasOne(EventWorkshop::class, 'id', 'event_workshop_id');
	}
	public function getSurveyMailStatus(): HasOne
    {
        return $this->hasOne(SurveyReminder::class, 'survey_activity_uuid', 'survey_activity_uuid');
    }
}
