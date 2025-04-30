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
                'membership_name' => 'Debug',
                'price' => 0.00,
                'membership_description' => 'Postulaciones limitadas para que empieces de forma sencilla. Acceso básico a las funcionalidades esenciales para explorar y conocer la plataforma.',
                'unlimited_applications' => false,
                'unlimited_publications' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Plan Pro
            [
                'membership_name' => 'DeployPro',
                'price' => 10.00,
                'membership_description' => 'Amplía tus posibilidades con aplicaciones ilimitadas a proyectos. Diseñado para quienes quieren aprovechar al máximo las oportunidades disponibles en la plataforma.',
                'unlimited_applications' => true,
                'unlimited_publications' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Plan Inicial Enterprise
            [
                'membership_name' => 'Debug Enterprise',
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
                'membership_description' => 'Publicaciones ilimitadas de proyectos. Pensado para empresas que buscan encontrar talento constantemente y sin límites.',
                'unlimited_applications' => false,
                'unlimited_publications' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Plan que tiene Todo en Uno
            [
                'membership_name' => 'TechStack Max',
                'price' => 28.00,
                'membership_description' => 'Publica y aplica sin límites. Expande tu red y colabora en Múltiples Proyectos. Encuentra al talento perfecto de manera Ilimitadas. Visibilidad Máxima. Descubre lo último primero con Acceso Exclusivo Anticipado.',
                'unlimited_applications' => true,
                'unlimited_publications' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
