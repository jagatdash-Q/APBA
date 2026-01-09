<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistrationReminder extends Model
{
    use HasFactory;
    public $fillable = [
        'uuid',
        'event_reg_uuid',
        'mail_sent_for',
    ];
}
