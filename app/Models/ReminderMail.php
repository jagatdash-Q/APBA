<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderMail extends Model
{
    use HasFactory;
    public $fillable = ['customer_id', 'mail_sent_days'];
}
