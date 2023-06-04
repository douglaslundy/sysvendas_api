<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $hidden = ['id_client'];
    protected $fillable = [
        'id_user',
        'id_client',
        'total_sale',
        'discount',
        'obs'
    ];


    public function itens(){
        return $this->hasMany(ItensOnBudget::class, 'id_sale')->join('products', 'products.id', '=', 'itens_on_budget.id_product');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
