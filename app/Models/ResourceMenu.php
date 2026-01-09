<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static \Database\Factories\ResourceMenuFactory factory(...$parameters)
 */
class ResourceMenu extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'uuid',
        'resource_uuid',
        'menu',
        'section_id'
    ];
    public function getResourceCard(): HasMany
    {
        return $this->hasMany(ResourceCard::class, 'resource_menu_uuid', 'uuid')->with(['getIcon', 'getHoverIcon']);
    }
    public function getResource(): HasOne
    {
        return $this->hasOne(Resource::class, 'uuid', 'resource_uuid');
    }
}
