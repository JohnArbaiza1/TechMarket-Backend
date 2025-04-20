<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_profiles')->insert([
            [
                'first_name' => 'John Elvis',
                'last_name' => 'Arbaiza Velásquez',
                'phone_number' => '12309847',
                'address' => 'Calle Pixel 128, Colonia Código Fuente Python, Ciudad Django',
                'description' => 'Administrador del sistema.',
                'image_url' => 'https://i.pinimg.com/736x/fd/b8/b3/fdb8b39e23b9d4a3a7ead99e849298c9.jpg',
                'social_media_links' => json_encode([
                    'GitHub' => 'https://github.com/JohnArbaiza1',

                ]),
                'education' => 'Ingeniería en Sistemas Informáticos - UES',
                'work_experience' => 'Administrador de sistemas en TechCorp (2013-2023)',
                'skills' => 'Gestión de servidores, Ciberseguridad, PHP, MySQL',
                'id_user' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Diego Isaac',
                'last_name' => 'García Pimentel',
                'phone_number' => '09812374',
                'address' => 'Boulevard del Algoritmo 42, Torre C, Oficina 301, Parque Tecnológico, Ciudad kotlin, CP 11223',
                'description' => 'Moderador de contenidos y soporte técnico.',
                'image_url' => 'https://i.pinimg.com/564x/9d/6b/9d/9d6b9db2dcb0526a09b89fb35d075c72.jpg',
                'social_media_links' => json_encode([
                    'GitHub' => 'https://github.com/DIGP1',
                ]),
                'education' => 'Ingeniería en Sistemas Informáticos - UES',
                'work_experience' => 'Backend, Bases de datos, Moderador',
                'skills' => 'Comunicación, Gestión de comunidades, C#, PHP, Larvel',
                'id_user' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
