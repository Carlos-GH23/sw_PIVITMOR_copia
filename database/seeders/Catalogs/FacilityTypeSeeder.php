<?php

namespace Database\Seeders\Catalogs;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Catalogs\FacilityType;

class FacilityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilityTypes = [
            [
                'name' => 'Centro de investigación',
                'description' => 'Instalaciones dedicadas a la investigación científica y tecnológica.'
            ],
            [
                'name' => 'Laboratorio',
                'description' => 'Espacios equipados para realizar experimentos y análisis científicos.'
            ],
            [
                'name' => 'Laboratorio de ensayo',
                'description' => 'Instalación equipada para realizar ensayos físicos, químicos, biológicos o mecánicos sobre materiales, productos o muestras, con fines de investigación, desarrollo tecnológico o prestación de servicios especializados.'
            ],
            [
                'name' => 'Laboratorio de calibración',
                'description' => 'Instalación dedicada a la calibración de instrumentos de medición, garantizando la trazabilidad metrológica a patrones nacionales o internacionales.'
            ],
            [
                'name' => 'Laboratorio clínico',
                'description' => 'Instalación especializada en el análisis de muestras biológicas humanas para diagnóstico, investigación o vigilancia epidemiológica, bajo normatividad sanitaria vigente.'
            ],
            [
                'name' => 'Laboratorio con nivel de bioseguridad',
                'description' => 'Instalación diseñada para el manejo seguro de agentes biológicos clasificados por nivel de riesgo, con infraestructura de contención y protocolos de bioseguridad.'
            ],
            [
                'name' => 'Bioterio / Unidad de experimentación animal',
                'description' => 'Instalación destinada al alojamiento, manejo y experimentación con modelos animales para investigación y docencia, bajo criterios de bienestar animal y ética.'
            ],
            [
                'name' => 'Unidad de salud ocupacional y ergonomía',
                'description' => 'Instalación orientada al estudio de condiciones laborales, factores de riesgo psicosocial, ergonomía y seguridad en el trabajo mediante evaluaciones especializadas.'
            ],
            [
                'name' => 'Centro de cómputo de alto rendimiento',
                'description' => 'Instalación con infraestructura de cómputo de alto desempeño, almacenamiento masivo y redes de alta velocidad para simulación, modelado y análisis intensivo de datos.'
            ],
            [
                'name' => 'Centro de datos / repositorio científico',
                'description' => 'Instalación dedicada al resguardo, la gestión y la preservación de datos científicos y colecciones digitales, con políticas de acceso y respaldo.'
            ],
            [
                'name' => 'Centro de simulación clínica',
                'description' => 'Instalación especializada en la simulación de procedimientos y escenarios clínicos mediante maniquíes, simuladores y sistemas audiovisuales.'
            ],
            [
                'name' => 'Laboratorio de simulación industrial',
                'description' => 'Instalación enfocada en la simulación de procesos industriales y pruebas de prototipos físicos o virtuales en entornos controlados.'
            ],
            [
                'name' => 'Planta piloto',
                'description' => 'Instalación que reproduce procesos productivos a escala piloto para validar tecnologías antes de su escalamiento industrial.'
            ],
            [
                'name' => 'Taller tecnológico / de prototipado',
                'description' => 'Instalación con maquinaria y herramientas para la fabricación, ajuste y prueba de prototipos mecánicos, electrónicos o mecatrónicos.'
            ],
            [
                'name' => 'Laboratorio de fabricación digital (Fab Lab / Maker Space)',
                'description' => 'Espacio equipado con tecnologías de fabricación digital para apoyar proyectos de investigación, docencia, innovación y vinculación.'
            ],
            [
                'name' => 'Laboratorio de TIC y ciberseguridad',
                'description' => 'Instalación orientada al desarrollo, prueba y análisis de tecnologías de información, redes, software y ciberseguridad.'
            ],
            [
                'name' => 'Laboratorio de factores humanos y UX',
                'description' => 'Instalación dedicada al estudio de la interacción humano–computadora, experiencia de usuario, ergonomía cognitiva y comportamiento del usuario.'
            ],
            [
                'name' => 'Estación experimental de campo',
                'description' => 'Instalación ubicada en entornos naturales o productivos para realizar experimentos a cielo abierto y monitoreo ambiental o agronómico.'
            ],
            [
                'name' => 'Invernadero / casa de malla experimental',
                'description' => 'Instalación controlada para investigación en cultivos, mejoramiento genético y tecnologías de producción vegetal.'
            ],
            [
                'name' => 'Observatorio / estación de observación',
                'description' => 'Instalación equipada para la observación astronómica, atmosférica, geofísica o ambiental mediante instrumentación especializada.'
            ],
            [
                'name' => 'Colección científica / banco de materiales',
                'description' => 'Instalación destinada al resguardo, conservación y catalogación de colecciones biológicas, genéticas, geológicas u otros materiales científicos.'
            ],
            [
                'name' => 'Centro de transferencia tecnológica e incubación',
                'description' => 'Instalación que integra espacios, infraestructura y servicios para la incubación de proyectos, transferencia de tecnología y apoyo a empresas de base tecnológica.'
            ],
        ];

        foreach ($facilityTypes as $type) {
            FacilityType::create($type);
        }
    }
}
