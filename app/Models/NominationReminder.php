<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NominationReminder extends Model
{
    use HasFactory;
    public $fillable = [
        'nomination_uuid',
        'mail_sent_days',
        'customer_id',
    ];
}
