<?php

namespace Database\Seeders\Catalogs;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Catalogs\EquipmentType;

class EquipmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EquipmentType::create([
            'name' => 'Cromatografía y espectrometría',
            'description' => 'Equipamiento para el análisis químico avanzado de muestras mediante técnicas cromatográficas y espectrométricas, utilizado en investigación, control de calidad y servicios especializados.',
        ]);

        EquipmentType::create([
            'name' => 'Espectroscopía y fotometría',
            'description' => 'Instrumentos para medir propiedades ópticas y espectrales de materiales y sustancias en distintos rangos del espectro electromagnético.',
        ]);

        EquipmentType::create([
            'name' => 'Microscopía y análisis de imagen',
            'description' => 'Infraestructura para la observación, caracterización y análisis morfológico de muestras a diferentes escalas, con apoyo de sistemas digitales de captura y procesamiento de imagen.',
        ]);

        EquipmentType::create([
            'name' => 'Ensayo de materiales y mecánica',
            'description' => 'Equipos destinados a evaluar propiedades mecánicas, térmicas y estructurales de materiales y componentes bajo condiciones controladas.',
        ]);

        EquipmentType::create([
            'name' => 'Patrones de referencia metrológica',
            'description' => 'Instrumentos y patrones utilizados para asegurar la trazabilidad y confiabilidad de las mediciones conforme a estándares nacionales e internacionales.',
        ]);

        EquipmentType::create([
            'name' => 'Equipos de calibración de instrumentos',
            'description' => 'Infraestructura especializada para la calibración de instrumentos de medición empleados en laboratorio, industria y sector salud.',
        ]);

        EquipmentType::create([
            'name' => 'Clúster de cómputo de alto rendimiento',
            'description' => 'Conjunto de nodos de cómputo interconectados que permiten realizar simulaciones numéricas, análisis de grandes volúmenes de datos y aplicaciones de inteligencia artificial.',
        ]);

        EquipmentType::create([
            'name' => 'Sistemas de almacenamiento científico',
            'description' => 'Infraestructura de almacenamiento masivo diseñada para resguardar, gestionar y respaldar datos científicos generados en proyectos de investigación.',
        ]);

        EquipmentType::create([
            'name' => 'Redes de datos científicas y de laboratorio',
            'description' => 'Infraestructura de comunicaciones de alta velocidad que soporta la operación de laboratorios, equipos científicos y servicios tecnológicos.',
        ]);

        EquipmentType::create([
            'name' => 'Servidores de aplicaciones y servicios científicos',
            'description' => 'Servidores físicos o virtuales que alojan plataformas de análisis, sistemas de gestión de datos, aplicaciones científicas y servicios institucionales.',
        ]);

        EquipmentType::create([
            'name' => 'Sistemas de realidad virtual inmersiva',
            'description' => 'Equipamiento tecnológico para crear entornos virtuales inmersivos aplicados a simulación, aprendizaje, salud y evaluación de experiencia de usuario.',
        ]);

        EquipmentType::create([
            'name' => 'Sistemas de seguimiento ocular (eye-tracking)',
            'description' => 'Infraestructura para registrar y analizar el movimiento ocular del usuario con fines de investigación en UX, educación, salud y comportamiento humano.',
        ]);

        EquipmentType::create([
            'name' => 'Sensores fisiológicos y de comportamiento',
            'description' => 'Dispositivos para la medición de variables fisiológicas y conductuales asociadas a estados cognitivos, emocionales y de carga de trabajo.',
        ]);

        EquipmentType::create([
            'name' => 'Simuladores clínicos',
            'description' => 'Equipos y sistemas que reproducen escenarios y procedimientos clínicos para entrenamiento, evaluación y educación en el área de la salud.',
        ]);

        EquipmentType::create([
            'name' => 'Sistemas de cultivo y bioprocesos',
            'description' => 'Infraestructura para el cultivo celular, microbiano o de tejidos, así como para la experimentación en bioprocesos a escala de laboratorio o piloto.',
        ]);

        EquipmentType::create([
            'name' => 'Equipamiento genómico y molecular',
            'description' => 'Equipos especializados para el análisis genético y molecular, incluyendo extracción, amplificación, secuenciación y análisis de material genético.',
        ]);

        EquipmentType::create([
            'name' => 'Sensores y sistemas de monitoreo agroambiental',
            'description' => 'Infraestructura para la medición y monitoreo de variables ambientales y agronómicas en campo o ambientes controlados.',
        ]);

        EquipmentType::create([
            'name' => 'Equipos de monitoreo ambiental',
            'description' => 'Instrumentación destinada a la evaluación de la calidad del aire, del agua, del suelo y de otros componentes ambientales.',
        ]);

        EquipmentType::create([
            'name' => 'Equipos de manufactura aditiva',
            'description' => 'Tecnologías de fabricación basadas en la adición de material, como impresión 3D, para el desarrollo de prototipos y piezas funcionales.',
        ]);

        EquipmentType::create([
            'name' => 'Máquinas herramienta y CNC',
            'description' => 'Infraestructura de manufactura sustractiva para mecanizado y conformado de piezas mediante control numérico computarizado.',
        ]);

        EquipmentType::create([
            'name' => 'Bancos de prueba y prototipado',
            'description' => 'Sistemas y bancadas diseñadas para la evaluación funcional y de desempeño de prototipos mecánicos, eléctricos o mecatrónicos.',
        ]);

        EquipmentType::create([
            'name' => 'Repositorios de datos científicos',
            'description' => 'Plataformas tecnológicas para el almacenamiento, la preservación y la consulta de datos científicos, tanto estructurados como no estructurados.',
        ]);

        EquipmentType::create([
            'name' => 'Colecciones biológicas y bancos de material',
            'description' => 'Infraestructura destinada a la conservación, el resguardo y la catalogación de colecciones científicas y de materiales biológicos.',
        ]);

        EquipmentType::create([
            'name' => 'Sistemas de seguridad, control ambiental y respaldo',
            'description' => 'Infraestructura de apoyo crítico que garantiza la operación segura y continua de laboratorios e instalaciones tecnológicas.',
        ]);
    }
}
