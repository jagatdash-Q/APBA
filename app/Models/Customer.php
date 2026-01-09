<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'profile_pic',
        'social_media_link',
        'email',
        'country',
        'password',
        'is_verify_email',
        'registered_on',
        'email_verified_on',
        'email_token',
        'register_by',
        'current_subscription_status',
        'is_term_accept',
        'created_by',
        'deleted_by',
        'active_subscription',
        'active_subscription_expired_on',
        'nomination'
    ];
    protected $casts = [
        'first_name' => 'encrypted',
        'last_name' => 'encrypted',
        'user_name' => 'encrypted',
        'social_media_link' => 'encrypted',
    ];
    public function getActiveSubscriptionDetails(): HasOne
    {
        return $this->hasOne(MembershipPackage::class, 'id', 'active_subscription');
    }

    public function getEventRegistration(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'customer_id', 'id')->with(['getEventDetails', 'getEventProgram', 'getEventRegistrationOptional']);
    }
    public function getSubscriptionHistory(): HasMany
    {
        return $this->hasMany(CustomerSubscription::class, 'customer_id', 'id')->with(['getMembershipDetails']);
    }
    public function getPaymentHistory(): HasMany
    {
        return $this->hasMany(Payment::class, 'customer_id', 'id')->with(['getMembershipDetails']);
    }
}
