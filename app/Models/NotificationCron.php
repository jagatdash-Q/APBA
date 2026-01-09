<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NotificationCron
 *
 * @property int $id
 * @property int $content_id
 * @property int $user_id
 * @property int $notification_id
 * @property string|null $message
 * @property string|null $content_url
 * @property string|null $type
 * @property int|null $cron_type
 * @property string|null $read_at
 * @property string|null $status
 */
class NotificationCron extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'user_id',
        'notification_id',
        'message',
        'content_url',
        'type',
        'cron_type',
        'read_at',
        'status',
    ];
}
