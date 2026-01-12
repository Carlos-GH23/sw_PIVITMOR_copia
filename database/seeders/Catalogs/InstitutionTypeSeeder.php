<?php

namespace Database\Seeders\Catalogs;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitutionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            // CI (institution_category_id = 2)
            [
                'code' => 'CI_CONAHCYT_CPI',
                'name' => 'Centros Públicos de Investigación del Conahcyt',
                'description' => 'Centros del sistema Conahcyt con misión de I+D, formación de capital humano y servicios tecnológicos especializados.',
                'institution_category_id' => 2
            ],
            [
                'code' => 'CI_PRIV',
                'name' => 'Centros privados de I+D',
                'description' => 'Laboratorios corporativos o fundaciones privadas con actividades de I+D, transferencia y servicios tecnológicos.',
                'institution_category_id' => 2
            ],
            [
                'code' => 'CI_SECTOR_PUBLIC',
                'name' => 'Centros sectoriales públicos',
                'description' => 'Centros de investigación de dependencias/organismos (salud, agro, energía, ambiente) con agenda aplicada y de interés público.',
                'institution_category_id' => 2
            ],
            [
                'code' => 'CI_UNIV',
                'name' => 'Centros/Institutos de investigación universitarios',
                'description' => 'Unidades de I+D adscritas a IES (facultades, institutos, laboratorios nacionales); ejecutan proyectos y servicios tecnológicos.',
                'institution_category_id' => 2
            ],
            // IES (institution_category_id = 1)
            [
                'code' => 'IES_INTERCULT',
                'name' => 'Universidades Interculturales',
                'description' => 'Enfoque intercultural y comunitario; pertinencia regional y rescate de lenguas/culturas; programas con componente social.',
                'institution_category_id' => 1
            ],
            [
                'code' => 'IES_NORMALES',
                'name' => 'Escuelas Normales',
                'description' => 'Instituciones de formación inicial y continua de docentes; nivel licenciatura y posgrado en educación.',
                'institution_category_id' => 1
            ],
            [
                'code' => 'IES_PRIV_INST',
                'name' => 'Institutos/Escuelas superiores privadas especializadas',
                'description' => 'Instituciones privadas especializadas (negocios, salud, arte, tecnología) con foco profesionalizante.',
                'institution_category_id' => 1
            ],
            [
                'code' => 'IES_PRIV_UNIV',
                'name' => 'Universidades particulares / privadas',
                'description' => 'Universidades privadas con oferta de licenciatura/posgrado; investigación y vinculación variable según institución.',
                'institution_category_id' => 1
            ],
            [
                'code' => 'IES_PUBLIC_FED',
                'name' => 'Universidades públicas federales',
                'description' => 'Universidades de carácter federal (p. ej., UNAM, IPN) con autonomía/ley orgánica. Generan docencia, investigación y vinculación.',
                'institution_category_id' => 1
            ],
            [
                'code' => 'IES_PUBLIC_STATE_AUT',
                'name' => 'Universidades públicas estatales autónomas',
                'description' => 'Universidades estatales con autonomía reconocida por ley; oferta de licenciatura/posgrado e investigación.',
                'institution_category_id' => 1
            ],
            [
                'code' => 'IES_PUBLIC_STATE_NOAUT',
                'name' => 'Universidades públicas estatales no autónomas',
                'description' => 'Universidades estatales con régimen no autónomo; orientadas a formación profesional y vinculación regional.',
                'institution_category_id' => 1
            ],
            [
                'code' => 'IES_TECNM',
                'name' => 'Institutos Tecnológicos (TecNM)',
                'description' => 'Institutos y Tecnológicos del TecNM con enfoque en ingeniería, tecnología aplicada y vinculación productiva.',
                'institution_category_id' => 1
            ],
            [
                'code' => 'IES_UPOL',
                'name' => 'Universidades Politécnicas',
                'description' => 'Enfoque en ingeniería y posgrados profesionales; alta vinculación con la industria y proyectos aplicados.',
                'institution_category_id' => 1
            ],
            [
                'code' => 'IES_UT',
                'name' => 'Universidades Tecnológicas',
                'description' => 'Modelo 2+1/TSU y continuidad a ingeniería; fuerte orientación práctica y al sector productivo.',
                'institution_category_id' => 1
            ],
        ];

        DB::table('institution_types')->insert($types);
    }
}
