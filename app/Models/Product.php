<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable =
    // ['name', 'bar_code', 'id_unity', 'id_category', 'cost_value', 'sale_value', 'stock','reason', 'active'];
    ['name', 'bar_code', 'id_unity', 'id_category', 'cost_value', 'sale_value', 'reason', 'active'];

    public function category(){
        return $this->hasOne(Categorie::class, 'id', 'id_category');
    }

    public function unity(){
        // return $this->belongsTo(Categorie::class);
        return $this->hasOne(Unit::class, 'id', 'id_unity');
    }

    public function stock(){
        // return $this->belongsTo(Categorie::class);
        return $this->hasOne(ProductStock::class, 'id_product', 'id');
    }
}
