<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomePartnerSection extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'content_id', 'home_content_uuid', 'uuid', 'image', 'hover_text', 'hover_link', 'is_active', 'created_by', 'updated_by', 'deleted_by'
    ];
    public function getPartnerImage(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_uid', 'image');
    }
}
