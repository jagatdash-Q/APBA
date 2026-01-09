<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class EventWorkshop extends Model
{
	use HasFactory, SoftDeletes;
	protected $fillable = [
		'event_id',
		'workshop_name',
		'workshop_slug',
		'workshop_date',
		'sorting_order',
		'created_by',
		'updated_by',
		'deleted_by',
		'status',
	];


	public function getEventDetails(): HasOne
	{
		return $this->hasOne(Event::class, 'id', 'event_id');
	}

	public function getCreatorDetails(): HasOne
	{
		return $this->hasOne(User::class, 'id', 'created_by');
	}

	public function getModifierDetails(): HasOne
	{
		return $this->hasOne(User::class, 'id', 'updated_by');
	}

	public function getWorkshopPrograms(): HasMany
	{
		return $this->hasMany(EventWorkshopPrograms::class, 'event_workshop_id', 'id');
	}

	public function getWorkshopProgramsOrderly(): HasMany
	{
		return $this->hasMany(EventWorkshopPrograms::class, 'event_workshop_id', 'id')->orderBy('program_date', 'asc')->orderBy('room_no', 'asc');
	}

	public static function boot()
	{
		parent::boot();
		self::deleting(function ($post) {
			$post->getWorkshopPrograms()->each(function ($val) {
				EventWorkshopPrograms::whereId($val->id)->update(['deleted_by' => Auth::id()]);
				EventWorkshopPrograms::whereId($val->id)->delete();
			});
		});
	}
}
