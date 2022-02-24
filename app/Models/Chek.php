<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chek extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'cpf_cnpj_chek',
        'check_number',
        'id_client',
        'date_chek',
        'date_pay',
        'date_pay_out',
        'situation',
    ];
}
