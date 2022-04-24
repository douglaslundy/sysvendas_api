<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            'name' => 'KG'
        ]);

        DB::table('units')->insert([
            'name' => 'UN'
        ]);

        DB::table('units')->insert([
            'name' => 'LT'
        ]);
        DB::table('units')->insert([
            'name' => 'PC'
        ]);

        DB::table('units')->insert([
            'name' => 'BAR'
        ]);

        DB::table('units')->insert([
            'name' => 'BR'
        ]);

        DB::table('units')->insert([
            'name' => 'KT'
        ]);

        DB::table('units')->insert([
            'name' => 'MT'
        ]);

        DB::table('units')->insert([
            'name' => 'PAR'
        ]);

        DB::table('units')->insert([
            'name' => 'PDC'
        ]);

        DB::table('units')->insert([
            'name' => 'ROL'
        ]);

    }
}
