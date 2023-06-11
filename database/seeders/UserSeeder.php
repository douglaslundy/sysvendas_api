<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'profile' => 'admin',
            'company_id' => 1,
            'name' => 'Douglas Lundy Santos',
            'email' => 'douglaslundy@gmail.com',
            'cpf' => '08449222699',
            'password' => Hash::make('12345'),
            'active' => 1
        ]);

        DB::table('users')->insert([
            'profile' => 'admin',
            'company_id' => 1,
            'name' => 'RONALDO MIGLIORINI  JUNIOR',
            'email' => 'jrferragens84@gmail.com',
            'cpf' => '14980477690',
            'password' => Hash::make('12345'),
            'active' => 1
        ]);
    }
}
