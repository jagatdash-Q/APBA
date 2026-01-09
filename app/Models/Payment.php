<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;
    public $fillable = [
        'customer_id',
        'subscription_id',
        'event_registartion_id',
        'payment_status',
        'total_amount',
        'payment_for',
        'payment_mode',
        'response',
    ];
    public function getMembershipDetails(): HasOne
    {
        return $this->hasOne(MembershipPackage::class, 'id', 'subscription_id');
    }
}
