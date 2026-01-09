<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static \Database\Factories\ResourceCardFactory factory(...$parameters)
 */
class ResourceCard extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'uuid',
        'resource_uuid',
        'resource_menu_uuid',
        'title',
        'icon',
        'hover_icon',
        'link',
        'status',
        'section_id',
        'publish_date'
    ];
    public function getIcon(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_uid', 'icon');
    }
    public function getHoverIcon(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_uid', 'hover_icon');
    }
    public function getResource(): HasOne
    {
        return $this->hasOne(Resource::class, 'uuid', 'resource_uuid');
    }
    public function getAltSearch(): HasOne
    {
        return $this->hasOne(MediaManager::class, 'media_url', 'link');
    }
}
