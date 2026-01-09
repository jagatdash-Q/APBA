<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTabButton extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
		'event_id',
		'event_tab_id',
		'button_title',
		'button_label',
		'button_link',
		'created_by',
		'updated_by',
		'deleted_by',
	];
}
