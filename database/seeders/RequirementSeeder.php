<?php

namespace Database\Seeders;

use App\Models\Requirement;
use App\Models\RequirementStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // statuses
        RequirementStatus::create(['name' => 'Borrador', 'description' => 'Borrador sin enviar a validar', 'color' => 'gray']);
        RequirementStatus::create(['name' => 'Enviado a revisión', 'description' => 'Necesidad enviada a revisión', 'color' => 'yellow']);
        RequirementStatus::create(['name' => 'Validado y autorizado', 'description' => 'Necesidad validada y autorizada', 'color' => 'green']);
        RequirementStatus::create(['name' => 'Rechazada con observaciones', 'description' => 'Necesidad rechazada, con observaciones, enviar nuevamente', 'color' => 'red']);
        RequirementStatus::create(['name' => 'Rechazada', 'description' => 'Necesidad rechazada', 'color' => 'red']);
        RequirementStatus::create(['name' => 'Cerrada', 'description' => 'Necesidad cerrada', 'color' => 'red']);

        // Requirement::create([
        //     'title' => 'Caracterización y Procesamiento de Materiales con Laser',
        //     'technical_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris purus lacus, tincidunt ac lectus id, eleifend ultrices magna. Quisque faucibus, tellus quis congue hendrerit, libero leo dignissim velit, facilisis posuere tortor metus vitae tortor. Aliquam ut aliquam purus, non euismod nisl. Sed semper non orci a auctor. Aliquam viverra placerat nulla, ut vehicula justo porttitor ac. Nulla vitae magna tincidunt, condimentum erat vitae, aliquet magna. Nam tincidunt gravida rhoncus.',
        //     'start_date' => '2025-10-09',
        //     'end_date' => '2025-10-10',
        //     'department_id' => 1,
        //     'user_id' => 2,
        //     'requirement_status_id' => 2,
        // ]);
        // Requirement::create([
        //     'title' => 'Diseño y Síntesis de Materiales Poliméricos	',
        //     'technical_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris purus lacus, tincidunt ac lectus id, eleifend ultrices magna. Quisque faucibus, tellus quis congue hendrerit, libero leo dignissim velit, facilisis posuere tortor metus vitae tortor. Aliquam ut aliquam purus, non euismod nisl. Sed semper non orci a auctor. Aliquam viverra placerat nulla, ut vehicula justo porttitor ac. Nulla vitae magna tincidunt, condimentum erat vitae, aliquet magna. Nam tincidunt gravida rhoncus.',
        //     'start_date' => '2025-10-09',
        //     'end_date' => '2025-10-10',
        //     'department_id' => 2,
        //     'user_id' => 2,
        //     'requirement_status_id' => 1,
        // ]);
        // Requirement::create([
        //     'title' => 'Caracterización Morfológica de Nanopartículas Metálicas',
        //     'technical_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris purus lacus, tincidunt ac lectus id, eleifend ultrices magna. Quisque faucibus, tellus quis congue hendrerit, libero leo dignissim velit, facilisis posuere tortor metus vitae tortor. Aliquam ut aliquam purus, non euismod nisl. Sed semper non orci a auctor. Aliquam viverra placerat nulla, ut vehicula justo porttitor ac. Nulla vitae magna tincidunt, condimentum erat vitae, aliquet magna. Nam tincidunt gravida rhoncus.',
        //     'start_date' => '2025-10-09',
        //     'end_date' => '2025-10-10',
        //     'department_id' => 3,
        //     'user_id' => 2,
        //     'requirement_status_id' => 3,
        // ]);
        // Requirement::create([
        //     'title' => 'Modelado de Propiedades Mecánicas en Impresión 3D',
        //     'technical_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris purus lacus, tincidunt ac lectus id, eleifend ultrices magna. Quisque faucibus, tellus quis congue hendrerit, libero leo dignissim velit, facilisis posuere tortor metus vitae tortor. Aliquam ut aliquam purus, non euismod nisl. Sed semper non orci a auctor. Aliquam viverra placerat nulla, ut vehicula justo porttitor ac. Nulla vitae magna tincidunt, condimentum erat vitae, aliquet magna. Nam tincidunt gravida rhoncus.',
        //     'start_date' => '2025-10-09',
        //     'end_date' => '2025-10-10',
        //     'department_id' => 2,
        //     'user_id' => 2,
        //     'requirement_status_id' => 1,
        // ]);
        // Requirement::create([
        //     'title' => 'Análisis de Adherencia y Resistencia a la Corrosión de Recubrimientos',
        //     'technical_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris purus lacus, tincidunt ac lectus id, eleifend ultrices magna. Quisque faucibus, tellus quis congue hendrerit, libero leo dignissim velit, facilisis posuere tortor metus vitae tortor. Aliquam ut aliquam purus, non euismod nisl. Sed semper non orci a auctor. Aliquam viverra placerat nulla, ut vehicula justo porttitor ac. Nulla vitae magna tincidunt, condimentum erat vitae, aliquet magna. Nam tincidunt gravida rhoncus.',
        //     'start_date' => '2025-10-09',
        //     'end_date' => '2025-10-10',
        //     'department_id' => 1,
        //     'user_id' => 2,
        //     'requirement_status_id' => 4,
        // ]);
    }
}
