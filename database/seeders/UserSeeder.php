<?php

namespace Database\Seeders;

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
            'role' => 1,
            'firstname' => 'Divyang',
            'lastname' => 'Dodiya',
            'email' => 'divyangtest@yopmail.com',
            'password' => Hash::make('admin@123'),
        ]);

    }
}
