<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeSliderContent extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'content_id', 'home_content_uuid', 'uuid', 'slider_heading', 'slider_desc', 'slider_button_link', 'slider_button_text', 'is_active', 'created_by', 'updated_by', 'deleted_by'
    ];
}
