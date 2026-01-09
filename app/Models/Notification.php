<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Notification
 *
 * @property int $id
 * @property int $content_id
 * @property int|null $sender_id
 * @property int|null $receiver_id
 * @property string|null $page_type
 * @property string|null $notification_type
 * @property string|null $noti_send_at
 * @property string|null $status
 * @property string|null $content_url
 * @property string|null $message
 * @property string|null $reject_remarks
 * @property int|null $noti_cron
 * @property int|null $noti_email_cron
 * @property string|null $read_at
 */
class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'sender_id',
        'receiver_id',
        'page_type',
        'notification_type',
        'noti_send_at',
        'status',
        'content_url',
        'message',
        'reject_remarks',
        'noti_cron',
        'noti_email_cron',
        'read_at',
    ];

    /**
     * @return BelongsTo
     */
    public function pageDetails(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    /**
     * @return BelongsTo
     */
    public function senderDetails(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * @return BelongsTo
     */
    public function receiverDetails(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
