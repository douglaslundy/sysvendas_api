<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            "id" => 1,
            "name" => "Produto Teste 1'",
            "bar_code" => 35525,
            "id_unity" => 4,
            "id_category" => 5,
            "cost_value" => 50,
            "sale_value" => 155,
            "active" => 1
          ]);
        DB::table('products')->insert([
            "id" => 2,
            "name" => "Produto Teste 2'",
            "bar_code" => 35355,
            "id_unity" => 4,
            "id_category" => 5,
            "cost_value" => 50,
            "sale_value" => 155,
            "active" => 1
          ]);
        DB::table('products')->insert([
            "id" => 3,
            "name" => "Produto Teste 3'",
            "bar_code" => 35855,
            "id_unity" => 4,
            "id_category" => 5,
            "cost_value" => 50,
            "sale_value" => 155,
            "active" => 1
          ]);

    }
}
