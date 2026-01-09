<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotingReminderMailSentStatus extends Model
{
    use HasFactory;
    public $fillable = [
        'customer_id',
        'voting_uuid',
        'mail_sent_for',
    ];
}
