<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeFirstSectionCard extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'content_id', 'home_content_uuid', 'uuid', 'image', 'heading', 'description', 'view_more_text','view_more_link', 'is_active', 'created_by', 'updated_by', 'deleted_by'
    ];
    public function getCardImage(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_uid', 'image');
    }
}
