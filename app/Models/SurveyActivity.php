<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Factory helper for static analysis
 *
 * @method static \Database\Factories\SurveyActivityFactory factory(...$parameters)
 *
 * @property-read \App\Models\EventWorkshopOptional|null $getEventOptional
 * @property-read \App\Models\EventWorkshopPrograms|null $getEventProgram
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveyRegistration> $getSurveyRegistration
 */
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
        return $this->hasOne(EventWorkshopOptional::class, 'id', 'event_workshop_optional_id')->with('getEvent');
    }

    public function getSurveyRegistration(): HasMany
    {
        return $this->hasMany(SurveyRegistration::class, 'survey_activity_uuid', 'uuid')->with('getEventProgram');
    }
}
