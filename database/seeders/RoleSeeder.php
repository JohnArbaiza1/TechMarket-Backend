<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_roles')->insert([
            [
                'name' => 'admin',
                'description' => 'Administrador',
                'state' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'editor',
                'description' => 'Editor del sistema',
                'state' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}