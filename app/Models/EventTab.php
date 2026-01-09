<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class EventTab extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
		'event_id',
		'tab_name',
		'tab_slug',
		'tab_sort_order',
		'tab_desc',
		'tab_desc_data',
		'tab_type',
		'created_by',
		'updated_by',
		'deleted_by',
	];

    public function getTabButtons(): HasMany
    {
        return $this->hasMany(EventTabButton::class, 'event_tab_id', 'id');
    }

	public static function boot()
    {
        parent::boot();
        self::deleting(function ($post) {
            $post->getTabButtons()->each(function ($val) {
                $val->delete();
            });
        });
    }
}
