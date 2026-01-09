<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class SurveyRegistration
 *
 * @method static \Database\Factories\SurveyRegistrationFactory factory(...$parameters)
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $event_program_registration_uuid
 * @property string|null $event_registration_optional_uuid
 * @property string|null $survey_activity_uuid
 * @property string $fullname
 * @property string|null $organization
 * @property string $email
 * @property string|null $content_material
 * @property int|string|null $certificate_sent
 * @property string|null $certificate
 * @property string|null $type
 * @property-read \App\Models\SurveyActivity|null $getSurveyActivity
 * @property-read \App\Models\EventProgramRegistration|null $getEventProgram
 */
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
