<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read \App\Models\Event|null $getEvent
 */
class EventWorkshopOptional extends Model
{
    use HasFactory;
    public $fillable = [
        'event_id',
        'activity_optional_name',
        // 'activity_optional_price',
        'price_member',
        'price_guest',
        'survey',
        'survey_activity_uuid'
    ];
    public function getEvent(): HasOne
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }
}
