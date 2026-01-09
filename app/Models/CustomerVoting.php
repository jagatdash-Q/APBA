<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerVoting extends Model
{
    use HasFactory,SoftDeletes;
    public $fillable = [
        'customer_id',
        'member_id',
        'voting_uuid',
        'voting_position_uuid',
        'nomination_uuid'
    ];

    public function getVotedMemberDetails() :HasOne {
        return $this->hasOne(Customer::class,"id","member_id");
    }

    public function getCustomerDetails() :HasOne {
        return $this->hasOne(Customer::class,"id","customer_id")->with('getActiveSubscriptionDetails');
    }

    public function getVotingDetails() :HasOne {
        return $this->hasOne(Voting::class,"uuid","voting_uuid");
    }

    public function getVotingPositionDetails() :HasOne {
        return $this->hasOne(VotingPosition::class,"uuid","voting_position_uuid")->with('getNominationPositionDetails');
    }

    public function getNominationDetails() :HasOne {
        return $this->hasOne(Nomination::class,"uuid","nomination_uuid")->with('getNominationPosition');
    }

}
