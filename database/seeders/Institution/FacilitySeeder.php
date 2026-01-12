<?php

namespace Database\Seeders\Institution;

use App\Models\Institution\Facility;
use Illuminate\Database\Seeder;
use App\Models\Institution\Institution;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {      
        Facility::create([
            'name' => 'Laboratorio de sistemas distribuidos',
            'description' => 'Laboratorio equipado con computadoras y servidores para el desarrollo y prueba de sistemas distribuidos.',
            'facility_type_id' => 1,
            'department_id' => 1,
            'is_active' => true,
        ]);

        Facility::create([
            'name' => 'Laboratorio de ingenieria de software',
            'description' => 'Laboratorio dedicado al desarrollo y prueba de software.',
            'facility_type_id' => 2,
            'department_id' => 2,
            'is_active' => true,
        ]);

        Facility::create([
            'name' => 'Laboratorio de iluminación',
            'description' => 'Laboratorio equipado con equipos de iluminación para el estudio y experimentación en iluminación y fotónica.',
            'facility_type_id' => 1,
            'department_id' => 3,
            'is_active' => true,
        ]);

        Facility::create([
            'name' => 'Laboratorio de realidad virtual',
            'description' => 'Laboratorio equipado con tecnología de realidad virtual para el desarrollo y prueba de aplicaciones inmersivas.',
            'facility_type_id' => 2,
            'department_id' => 4,
            'is_active' => true,
        ]);
    }
}
