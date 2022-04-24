<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'BROCAS'
        ]);

        DB::table('categories')->insert([
            'name' => 'CADEADOS'
        ]);

        DB::table('categories')->insert([
            'name' => 'ELETRODOS'
        ]);

        DB::table('categories')->insert([
            'name' => 'FERRAGENS'
        ]);

        DB::table('categories')->insert([
            'name' => 'FERRAMENTAS'
        ]);DB::table('categories')->insert([
            'name' => 'NYLON'
        ]);

        DB::table('categories')->insert([
            'name' => 'PARAFUSOS'
        ]);

        DB::table('categories')->insert([
            'name' => 'PNEU'
        ]);

        DB::table('categories')->insert([
            'name' => 'PORCAS E ARRUELAS'
        ]);

        DB::table('categories')->insert([
            'name' => 'QUIMICOS'
        ]);

        DB::table('categories')->insert([
            'name' => 'TELA'
        ]);

        DB::table('categories')->insert([
            'name' => 'TELHAS'
        ]);

        DB::table('categories')->insert([
            'name' => 'TINTAS'
        ]);

        DB::table('categories')->insert([
            'name' => 'VEDA CALHA'
        ]);

    }
}
