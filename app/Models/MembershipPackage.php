<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipPackage extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'membership_contents_id', 'membership_name', 'membership_srt_desc', 'subscription_type', 'membership_image', 'membership_button_text', 'membership_description',
        'membership_price', 'membership_plan', 'created_by', 'updated_by', 'deleted_by', 'uid'
    ];

    public function getMembershipImage(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_uid', 'membership_image');
    }
}
