<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nomination extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'uuid',
        'name',
        'start_date',
        'end_date',
        'status',
        'created_by',
    ];
    public function getNominationPosition(): HasMany
    {
        return $this->hasMany(NominationPosition::class, 'nomination_uuid', 'uuid')->with('getPosition');
    }
}
