<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_client',
        'sale_date',
        'paied',
        'type_sale',
        'due_date',
        'pay_date',
        'chek',
        'cash',
        'card',
        'total_sale'
    ];
}
