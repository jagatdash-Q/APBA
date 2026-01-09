<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Team
 *
 * @property int $id
 * @property string $name
 */
class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
