<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerSubscription extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'membership_id',
        'customer_id',
        'amount',
        'subscription_in',
        'subscription_expired_on',
    ];
    public function getMembershipDetails(): HasOne
    {
        return $this->hasOne(MembershipPackage::class, 'id', 'membership_id');
    }
}
