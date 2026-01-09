<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EventProgramRegistration extends Model
{
    use HasFactory;
    public $fillable = [
        'uuid',
        'event_registration_uuid',
        'event_workshop_id',
        'event_program_id',
        'survey',
        'conference_registration_fee',
        'networking_dinner_fee'
    ];
    public function getWorkshopDetails(): HasOne
    {
        return $this->hasOne(EventWorkshop::class, 'id', 'event_workshop_id')->with('getEventDetails');
    }
    public function getProgramDetails(): HasOne
    {
        return $this->hasOne(EventWorkshopPrograms::class, 'id', 'event_program_id')->with(['getEventDetails','getEventWorkshopDetails','getSurveyMailStatus']);
    }
    public function getEventRegDetails(): HasOne
    {
        return $this->hasOne(EventRegistration::class, 'uuid', 'event_registration_uuid');
    }
}
