<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class Customer
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $mobile
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $country
 * @property string|null $postcode
 * @property string|null $company
 * @property string|null $role
 * @property string|null $title
 * @property string|null $password
 * @property bool $is_active
 * @property string|null $active_subscription_expired_on
 * @property string|null $subscription_expired_on
 * @property-read \App\Models\MembershipPackage|null $getActiveSubscriptionDetails
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CustomerSubscription[] $getSubscriptionHistory
 */
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
