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
            // Plan Inicial
            [
                'membership_name' => 'Inicial',
                'price' => 0.00,
                'membership_description' => 'Postulaciones limitadas para que empieces de forma sencilla. Acceso básico a las funcionalidades esenciales para explorar y conocer la plataforma.',
                'unlimited_applications' => false,
                'unlimited_publications' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Plan Pro
            [
                'membership_name' => 'Pro',
                'price' => 10.00,
                'membership_description' => 'Amplía tus posibilidades con 8 postulaciones mensuales. Conéctate y colabora en hasta 4 Proyectos Múltiples. Publicación de hasta 3 proyectos. Destácate entre la multitud con mayor visibilidad en la plataforma.',
                'unlimited_applications' => false,
                'unlimited_publications' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Plan Inicial Enterprise
            [
                'membership_name' => 'Inicial Enterprise',
                'price' => 0.00,
                'membership_description' => 'Publica 1 proyecto y atrae al profesional ideal. Evalúa hasta 2 candidatos para elegir al mejor. Visibilidad básica para tu proyecto en la plataforma.',
                'unlimited_applications' => false,
                'unlimited_publications' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Plan Pro Enterprise
            [
                'membership_name' => 'Pro Enterprise',
                'price' => 20.00,
                'membership_description' => 'Publica 5 proyectos al mes y amplía tus opciones. Evalúa hasta 8 candidatos para elegir al mejor. Visibilidad destacada para atraer talento top.',
                'unlimited_applications' => false,
                'unlimited_publications' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Plan Todo en Uno
            [
                'membership_name' => 'Todo en Uno',
                'price' => 28.00,
                'membership_description' => 'Postulaciones y Publicaciones Ilimitadas. Expande tu red y colabora en Múltiples Proyectos. Encuentra al talento perfecto con Evaluaciones Ilimitadas. Visibilidad Máxima. Descubre lo último primero con Acceso Exclusivo Anticipado.',
                'unlimited_applications' => true,
                'unlimited_publications' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
