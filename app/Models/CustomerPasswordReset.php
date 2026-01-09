<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPasswordReset extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'customer_email',
        'password_reset_token',
        'password_reset_link_sent_on',
        'password_reset_on',
    ];
}
