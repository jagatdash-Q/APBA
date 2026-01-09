<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyReminder extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'survey_activity_uuid',
        'event_registration_uuid',
    ];
}
