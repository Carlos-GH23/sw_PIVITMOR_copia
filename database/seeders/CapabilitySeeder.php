<?php

namespace Database\Seeders;

use App\Models\Capability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CapabilityStatus;

class CapabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CapabilityStatus::create(['name' => 'Borrador', 'description' => 'Borrador sin enviar a validar', 'color' => 'gray']);
        CapabilityStatus::create(['name' => 'Enviado a revisión', 'description' => 'Capacidad enviada a revisión', 'color' => 'yellow']);
        CapabilityStatus::create(['name' => 'Validado y autorizado', 'description' => 'Capacidad validada y autorizada', 'color' => 'green']);
        CapabilityStatus::create(['name' => 'Rechazada con observaciones', 'description' => 'Capacidad rechazada con observaciones, enviar nuevamente', 'color' => 'red']);
        CapabilityStatus::create(['name' => 'Rechazada', 'description' => 'Capacidad rechazada', 'color' => 'red']);
        CapabilityStatus::create(['name' => 'Cerrado', 'description' => 'Capacidad autorizada y vencida', 'color' => 'gray']);
        
        // Capability::create([
        //     'title' => 'Caracterización y Procesamiento de Materiales con Laser',
        //     'technical_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris purus lacus, tincidunt ac lectus id, eleifend ultrices magna. Quisque faucibus, tellus quis congue hendrerit, libero leo dignissim velit, facilisis posuere tortor metus vitae tortor. Aliquam ut aliquam purus, non euismod nisl. Sed semper non orci a auctor. Aliquam viverra placerat nulla, ut vehicula justo porttitor ac. Nulla vitae magna tincidunt, condimentum erat vitae, aliquet magna. Nam tincidunt gravida rhoncus.',
        //     'start_date' => '2025-10-09',
        //     'end_date' => '2025-10-10',
        //     'department_id' => 1,
        //     'user_id' => 3,
        //     'capability_status_id' => 2,
        // ]);

        // Capability::create([
        //     'title' => 'Físico química de Compuestos Orgánicos con Aplicación en Química Fina',
        //     'technical_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris purus lacus, tincidunt ac lectus id, eleifend ultrices magna. Quisque faucibus, tellus quis congue hendrerit, libero leo dignissim velit, facilisis posuere tortor metus vitae tortor. Aliquam ut aliquam purus, non euismod nisl. Sed semper non orci a auctor. Aliquam viverra placerat nulla, ut vehicula justo porttitor ac. Nulla vitae magna tincidunt, condimentum erat vitae, aliquet magna. Nam tincidunt gravida rhoncus.',
        //     'start_date' => '2025-10-09',
        //     'end_date' => '2025-10-10',
        //     'department_id' => 2,
        //     'user_id' => 3,
        //     'capability_status_id' => 1,
        // ]);

        // Capability::create([
        //     'title' => 'Análisis Modelado Diseño e Implementación de Sistemas embebidos',
        //     'technical_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris purus lacus, tincidunt ac lectus id, eleifend ultrices magna. Quisque faucibus, tellus quis congue hendrerit, libero leo dignissim velit, facilisis posuere tortor metus vitae tortor. Aliquam ut aliquam purus, non euismod nisl. Sed semper non orci a auctor. Aliquam viverra placerat nulla, ut vehicula justo porttitor ac. Nulla vitae magna tincidunt, condimentum erat vitae, aliquet magna. Nam tincidunt gravida rhoncus.',
        //     'start_date' => '2025-10-09',
        //     'end_date' => '2025-10-10',
        //     'department_id' => 3,
        //     'user_id' => 3,
        //     'capability_status_id' => 3,
        // ]);

        // Capability::create([
        //     'title' => 'Modelado de Propiedades Mecánicas en Impresión 3D',
        //     'technical_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris purus lacus, tincidunt ac lectus id, eleifend ultrices magna. Quisque faucibus, tellus quis congue hendrerit, libero leo dignissim velit, facilisis posuere tortor metus vitae tortor. Aliquam ut aliquam purus, non euismod nisl. Sed semper non orci a auctor. Aliquam viverra placerat nulla, ut vehicula justo porttitor ac. Nulla vitae magna tincidunt, condimentum erat vitae, aliquet magna. Nam tincidunt gravida rhoncus.',
        //     'start_date' => '2025-10-09',
        //     'end_date' => '2025-10-10',
        //     'department_id' => 2,
        //     'user_id' => 3,
        //     'capability_status_id' => 1,
        // ]);

        // Capability::create([
        //     'title' => 'Análisis de Adherencia y Resistencia a la Corrosión de Recubrimientos',
        //     'technical_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris purus lacus, tincidunt ac lectus id, eleifend ultrices magna. Quisque faucibus, tellus quis congue hendrerit, libero leo dignissim velit, facilisis posuere tortor metus vitae tortor. Aliquam ut aliquam purus, non euismod nisl. Sed semper non orci a auctor. Aliquam viverra placerat nulla, ut vehicula justo porttitor ac. Nulla vitae magna tincidunt, condimentum erat vitae, aliquet magna. Nam tincidunt gravida rhoncus.',
        //     'start_date' => '2025-10-09',
        //     'end_date' => '2025-10-10',
        //     'department_id' => 1,
        //     'user_id' => 3,
        //     'capability_status_id' => 4,
        // ]);
    }
}
