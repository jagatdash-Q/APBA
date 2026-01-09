<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NominationPosition extends Model
{
    use HasFactory;
    public $fillable = [
        'uuid',
        'nomination_uuid',
        'position_uuid'
    ];

    public function getPosition(): HasOne
    {
        return $this->hasOne(MembershipPosition::class, 'uuid', 'position_uuid')->with('getMembershipType');
    }

    public function getNomination(): HasOne
    {
        return $this->hasOne(Nomination::class, 'uuid', 'nomination_uuid');
    }
}
