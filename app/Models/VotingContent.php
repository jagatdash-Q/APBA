<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotingContent extends Model
{
    use HasFactory;
    public $fillable = [
        'uuid',
        'heading',
        'description',
        'description_data',
        'content_description',
        'content_description_data',
        'created_by',
        'updated_by',
    ];
}
