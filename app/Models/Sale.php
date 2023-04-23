<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $hidden = ['id_client'];
    protected $fillable = [
        'id_user',
        'id_client',
        'paied',
        'type_sale',
        'due_date',
        'check',
        'cash',
        'card',
        'total_sale',
        'discount',
        'obs'
    ];


    public function itens(){
        // return $this->hasMany(ItensOnSale::class, 'id_sale')->with('product');
        return $this->hasMany(ItensOnSale::class, 'id_sale')->join('products', 'products.id', '=', 'itens_on_sale.id_product');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'id_client');
    }
}
