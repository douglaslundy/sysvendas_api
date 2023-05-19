<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    // protected $hidden = ['id_product'];
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_product',
        'item_value',
        'qtd'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'id_product');
    }
}
