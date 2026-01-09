<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateAttribute extends Model
{
    use HasFactory;
    public $fillable = [
        'uuid',
        'logo_1',
        'logo_2',
        'signature_1',
        'signature_2',
        'introducer_name_1',
        'introducer_name_2',
        'introducer_company_1',
        'introducer_company_2',
        'background_image',
    ];
}
