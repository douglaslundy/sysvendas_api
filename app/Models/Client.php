<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable =
    ['full_name','surname','cpf_cnpj', 'email', 'phone','im',
    'ie', 'fantasy_name', 'obs', 'active', 'inactive_date',
    'debit_balance', 'limit', 'marked'];
}
