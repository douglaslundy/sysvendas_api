<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable =
    ['name', 'bar_code', 'id_unity', 'id_category', 'cost_value', 'sale_value', 'stock', 'active'];
}
