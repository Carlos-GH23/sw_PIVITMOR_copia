<?php

namespace Database\Seeders\Institution;

use App\Models\Institution\FacilityEquipment;
use Illuminate\Database\Seeder;

class FacilityEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FacilityEquipment::create([
            'name' => 'Interfaz cerebro-computadora',
            'description' => 'Dispositivo que permite la comunicación directa entre el cerebro humano y una computadora.',
            'equipment_type_id' => 1, 
            'facility_id' => 1,
            'department_id' => 1,
            //'institution_id' => 1,
            //'responsible_user_id' => 1,
        ]);
        
        FacilityEquipment::create([
            'name' => 'Sistema de realidad virtual',
            'description' => 'Equipo que proporciona una experiencia inmersiva en un entorno virtual generado por computadora.',
            'equipment_type_id' => 1, 
            'department_id' => 2,
            'facility_id' => 2,
            //'responsible_user_id' => 1,
        ]);
    }
}
