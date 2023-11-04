<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitializeAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'ianmars@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('pussylicker'),
            'first_name' => 'Ian Mars',
            'last_name' => 'Montebon',
            'role' => 'ADMINISTRATOR',
            'phone_no' => '09294708232',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
