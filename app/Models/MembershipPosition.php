<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MembershipPosition extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'uuid',
        'membership_type_uuid',
        'membership_position',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getMembershipType(): HasOne
    {
        return $this->hasOne(MembershipType::class, 'uuid', 'membership_type_uuid');
    }
}
