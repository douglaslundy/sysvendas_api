<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensOnBudget extends Model
{
    use HasFactory;
    protected $table = 'itens_on_budget';
    protected $hidden = ['id', 'id_sale', 'id_user', 'id_product', 'sale_value', 'cost_value', 'id_unity', 'id_category', 'id_product_stock', 'active', 'reason'];
    // public $timestamps = false;

    protected $fillable = [
        'id_sale',
        'id_user',
        'id_product',
        'qdt',
        'item_value',
    ];
}
