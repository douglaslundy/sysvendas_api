<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            "id" => 1,
            "fantasy_name" => "JR Ferragens",
            "corporate_name" => "JR Ferragens",
            "cnpj" => '34498355000174',
            "email" => "jrferragens84@gmail.com",
            "phone" => "35988592759",
            "master_password" => "827ccb0eea8a706c4c34a16891f84e7b",
            "im" => null,
            "ie" => null,
            "validity_date" => "2025-01-01",
            "zip_code"=> "37175000",
            "city"=> "Ilicínea",
            "street"=> "15 de novembro",
            "number"=> "700",
            "neighborhood"=> "Jardim Planalto",
            "complement"=> "Loja",
            "balance" => 0,
            "active" => 1,
            "marked" => 0
        ]);
    }
}
