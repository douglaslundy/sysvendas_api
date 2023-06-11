<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('clients')->insert([
            "id" => 120,
            "full_name" => "ALBERTO da silva",
            "surname" => null,
            "cpf_cnpj" => 35984000000,
            "email" => "as@GMAIL.COM",
            "phone" => "(35) 8555-7563",
            "im" => null,
            "ie" => null,
            "fantasy_name" => "BETO",
            "obs" => false,
            "debit_balance" => 0,
            "limit" => 0,
            "active" => 1,
            "marked" => 0
        ]);
        DB::table('clients')->insert([
            "id" => 101,
            "full_name" => "jose da silva",
            "surname" => null,
            "cpf_cnpj" => 359840870000,
            "email" => "as@GMAIL.COM",
            "phone" => "(35) 8555-7563",
            "im" => null,
            "ie" => null,
            "fantasy_name" => "BETO",
            "obs" => false,
            "debit_balance" => 0,
            "limit" => 0,
            "active" => 1,
            "marked" => 0
        ]);
        DB::table('clients')->insert([
            "id" => 102,
            "full_name" => "joao da silva",
            "surname" => null,
            "cpf_cnpj" => 35984050000,
            "email" => "as@GMAIL.COM",
            "phone" => "(35) 8555-7563",
            "im" => null,
            "ie" => null,
            "fantasy_name" => "BETO",
            "obs" => false,
            "debit_balance" => 0,
            "limit" => 0,
            "active" => 1,
            "marked" => 0
        ]);

    }
}
