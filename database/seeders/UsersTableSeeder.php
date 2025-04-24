<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_users')->insert([
            [
                'user_name' => 'Admin',
                'email' => 'Admin@gmail.com',
                'user_pass' => Hash::make('contraseña123'),
                'published' => false,
                'id_membership' => 5, //valor de referencia a la tabla tbl_memberships 
                'membership_status' => true,
                'user_rating' => 0,
                'remenber_token' => Str::random(60), // Token aleatorio
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name' => 'Moderador',
                'email' => 'moderador@gmail.com', 
                'user_pass' => Hash::make('contraseñaModerador123'),  
                'published' => false, 
                'id_membership' => 5, 
                'membership_status' => true,
                'user_rating' => 0,
                'remenber_token' => Str::random(60),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Obtener roles
        $adminRole = Role::where('name', 'admin')->first();
        $editorRole = Role::where('name', 'editor')->first();

        // Verifica que los roles existen
        if (!$adminRole || !$editorRole) {
            dd('Faltan los roles en la base de datos');
        }

        // Obtener usuarios
        $adminUser = User::where('email', 'Admin@gmail.com')->first();
        $moderadorUser = User::where('email', 'moderador@gmail.com')->first();

        // Asignar roles
        if ($adminUser && $adminRole) {
            $adminUser->roles()->syncWithoutDetaching([$adminRole->id]);
        }

        if ($moderadorUser && $editorRole) {
            $moderadorUser->roles()->syncWithoutDetaching([$editorRole->id]);
        }
    }
}
