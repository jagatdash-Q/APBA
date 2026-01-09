<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomerNomination extends Model
{
    use HasFactory;
    public $fillable = [
        'customer_id',
        'member_id',
        'nomination_uuid',
        'nomination_position_uuid',
    ];
    public function getMemberName(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'member_id')->select(['id', 'user_name', 'profile_pic']);
    }
    public function getCustomer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
