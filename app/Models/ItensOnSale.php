<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensOnSale extends Model
{
    use HasFactory;
    protected $table = 'itens_on_sale';
    public $timestamps = false;

    protected $fillable = [
        'id_sale',
        'id_user',
        'id_product',
        'qdt',
        'sale_value',
    ];

}
