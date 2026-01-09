<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class VotingAcceptedList extends Model
{
    use HasFactory,SoftDeletes;
    public $fillable = [
        'uuid',
        'voting_uuid',
        'voting_position_uuid',
        'member_id',
        'approved_by',
    ];

    public function getElectedMemberDetails(): HasOne
    {
        return $this->hasOne(Customer::class, "id", "member_id");
    }

}
