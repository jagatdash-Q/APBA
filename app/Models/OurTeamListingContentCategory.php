<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurTeamListingContentCategory extends Model
{
    use HasFactory;
    protected $fillable = [
         'uid', 'category_uid', 'title', 'page_slug', 'status'
    ];
}
