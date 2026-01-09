<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EventRegistration extends Model
{
    use HasFactory;
    public $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'contact_number',
        'customer_id',
        'event_id',
        'total_amount',
        'conference_registration_fee',
        'networking_dinner_fee',
        'payment_status',
        'survey',
        'organisation_name',
        'organisation_address',
        'phone_code',
    ];

    protected $casts = [
        'first_name' => 'encrypted',
        'last_name' => 'encrypted',
        'email' => 'encrypted',
        'contact_number' => 'encrypted',
    ];
    public function getEventDetails(): HasOne
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }
    public function getEventProgram(): HasMany
    {
        return $this->hasMany(EventProgramRegistration::class, 'event_registration_uuid', 'uuid')->with(['getWorkshopDetails', 'getProgramDetails']);
    }
    public function getCustomerDetails(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
    public function getPaymentHistory(): HasMany
    {
        return $this->hasMany(Payment::class, 'event_registartion_id', 'id');
    }
    public function getEventRegistrationOptional(): HasMany
    {
        return $this->hasMany(EventRegistrationOptional::class, 'event_registration_id', 'id')->with('getOptionalDetails');
    }
    public function getEventRegMailStatus(): HasOne
    {
        return $this->hasOne(EventRegistrationReminder::class, 'event_reg_uuid', 'uuid');
    }
}
