<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'city',
        'street',
        'number',
        'zip_code',
        'district',
        'complement',
        'id_client',
        'active'
    ];
}
