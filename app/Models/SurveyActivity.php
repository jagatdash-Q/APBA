<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyActivity extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'uuid',
        'name',
        'event_workshop_program_id',
        'event_workshop_optional_id'
    ];
    public function getEventProgram(): HasOne
    {
        return $this->hasOne(EventWorkshopPrograms::class, 'id', 'event_workshop_program_id')->with(['getEventWorkshopDetails','getEventDetails']);
    }

    public function getEventOptional(): HasOne
    {
        return $this->hasOne(EventWorkshopOptional::class, 'id', 'event_workshop_optional_id')->With('getEvent');
    }

    public function getSurveyRegistration(): HasMany
    {
        return $this->hasMany(SurveyRegistration::class, 'survey_activity_uuid', 'uuid')->with('getEventProgram');
    }
}
