<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SurveyRegistration extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'event_program_registration_uuid',
        'event_registration_optional_uuid',
        'survey_activity_uuid',
        'fullname',
        'organization',
        'email',
        'content_material',
        'speaker_knowledge',
        'trainer_presentation',
        'q_a_session',
        'overall_delivery',
        'conference_content',
        'conference_relevant',
        'future_conference',
        'feedback',
        'survey_url',
        'certificate_sent',
        'certificate',
        'type'
    ];
    public function getEventProgram(): HasOne
    {
        return $this->hasOne(EventProgramRegistration::class, 'uuid', 'event_program_registration_uuid')->with('getEventRegDetails', 'getProgramDetails');
    }
    public function getSurveyActivity(): HasOne
    {
        return $this->hasOne(SurveyActivity::class, 'uuid', 'survey_activity_uuid')->with('getEventProgram', 'getEventOptional');
    }
}
