<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $table = 'product_stock';
    protected $hidden = ['id', 'id_product', 'created_at', 'updated_at'];
    protected $fillable = ['id_product', 'stock'];
}



