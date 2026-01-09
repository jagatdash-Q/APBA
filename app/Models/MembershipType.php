<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipType extends Model
{
    use HasFactory;
    public $fillable=[
        'id',
        'uuid',
        'membership_type',
        'status',
        'created_at',
        'updated_at'
    ];
}
