<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static \Database\Factories\VotingFactory factory(...$parameters)
 */
class Voting extends Model
{
    use HasFactory,SoftDeletes;
    public $fillable = [
        'uuid',
        'nomination_uuid',
        'created_by',
        'start_date',
        'end_date',
        'status',
    ];

    // Get the voting positions

    public function getVotingPositions() :HasMany {
        return $this->hasMany(VotingPosition::class,"voting_uuid","uuid")->with(['getNominationPositionDetails','getPositionDetails','getVotedMemberDetails']);
    }

    public function getNominationDetails() :HasOne {
        return $this->hasOne(Nomination::class,"uuid","nomination_uuid")->with('getNominationPosition');
    }

}
