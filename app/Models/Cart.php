<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_product',
        'name_product',
        'bar_code',
        'qdt',
        'value',
        'number_item'
    ];

}
