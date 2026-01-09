<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NominationAcceptList extends Model
{
    use HasFactory;
    public $fillable = [
        'nomination_uuid',
        'nomination_position_uuid',
        'member_id',
        'accepted_by',
    ];
}
