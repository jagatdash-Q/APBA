<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class VotingPosition extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'uuid',
        'voting_uuid',
        'nomination_position_uuid'
    ];

    public function getPositionDetails(): HasOne
    {
        return $this->hasOne(MembershipPosition::class, "uuid", "nomination_position_uuid");
    }

    public function getVotedMemberDetails(): HasOne
    {
        return $this->hasOne(CustomerVoting::class, "voting_position_uuid", "uuid")->with(['getVotedMemberDetails']);
    }

    public function getTotalVoting(): HasMany
    {
        return $this->hasMany(CustomerVoting::class, "voting_position_uuid", "uuid");
    }

    public function getNominationPositionDetails(): HasOne
    {
        return $this->hasOne(NominationPosition::class, "uuid", "nomination_position_uuid")->with('getPosition');
    }

    public function getVotingDetails(): HasOne
    {
        return $this->hasOne(Voting::class, "uuid", "voting_uuid")->with('getNominationDetails');
    }
}
