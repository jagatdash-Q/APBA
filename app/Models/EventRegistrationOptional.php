<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EventRegistrationOptional extends Model
{
    use HasFactory;
    public $fillable = [
        'uuid',
        'event_registration_id',
        'event_workshop_optional_id',
        'survey'
    ];
    public function getOptionalDetails(): HasOne
    {
        return $this->hasOne(EventWorkshopOptional::class, 'id', 'event_workshop_optional_id');
    }
    public function getEventRegDetails(): HasOne
    {
        return $this->hasOne(EventRegistration::class, 'id', 'event_registration_id')->with('getEventDetails');
    }
}
