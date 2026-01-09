<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DefaultMembership extends Model
{
    use HasFactory;
    protected $fillable = [
        'content_id',
        'membership_content_details_id',
        'membership_package_id',
        'created_by',
        'updated_by',
    ];

    public function getPackageInfo() : HasOne {
        return $this->hasOne(MembershipPackage::class,'id','membership_package_id');
    }

}
