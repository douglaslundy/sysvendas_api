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
            "name" => "Produto Teste'",
            "bar_code" => 3555,
            "id_unity" => 4,
            "id_category" => 5,
            "cost_value" => 50,
            "stock" => 0,
            "sale_value" => 155,
            "active" => 1
          ]);

    }
}
