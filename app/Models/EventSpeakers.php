<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventSpeakers extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
		'event_id',
		'speaker_name',
		'speaker_designation',
		'speaker_image',
		'speaker_details',
		'speaker_details_data',
		'created_by',
		'updated_by',
		'deleted_by',
	];
	public function getSpeakerImage(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_uid', 'speaker_image');
    }
}
