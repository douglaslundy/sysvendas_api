<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
    // protected $hidden = ['master_password'];

    protected $fillable = ['fantasy_name','cnpj', 'corporate_name', 'email', 'master_password', 'ie', 'im', 'balance', 'zip_code', 'city', 'street', 'number', 'complement','neighborhood', 'phone', 'validity_date', 'active', 'marked'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
