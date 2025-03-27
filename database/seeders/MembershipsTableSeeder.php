<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_memberships')->insert([
            'membership_name' => 'Inicial',
            'price' => 0.00,
            'membership_description' => 'Plan Inicial gratuito',
            'unlimited_applications' => false,
            'unlimited_publications' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
