<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_users')->insert([
            'user_name' => 'Admin',
            'email' => 'Admin@gmail.com',
            'user_pass' => Hash::make('contraseña123'),
            'published' => false,
            'id_membership' => 1, //valor de referencia a la tabla tbl_memberships 
            'membership_status' => true,
            'user_rating' => 0,
            'remenber_token' => Str::random(60), // Token aleatorio
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
