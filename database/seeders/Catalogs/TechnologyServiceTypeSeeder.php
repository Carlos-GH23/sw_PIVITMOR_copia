<?php

namespace Database\Seeders\Catalogs;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Catalogs\TechnologyServiceType;

class TechnologyServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TechnologyServiceType::create([
            'code' => 'ANA_BIO',
            'category_id' => 1,
            'name' => 'Pruebas biotecnológicas y bioanalíticas',
            'description' => 'Ensayos microbiológicos, enzimáticos, celulares y farmacológicos en laboratorio especializado.',
        ]);
        TechnologyServiceType::create([
            'code' => 'ANA_FQ',
            'category_id' => 1,
            'name' => 'Análisis fisicoquímicos',
            'description' => 'Determinaciones en matrices (agua, aire, suelo, alimentos, materiales) bajo métodos validados.',
        ]);
        TechnologyServiceType::create([
            'code' => 'ANA_MAT',
            'category_id' => 1,
            'name' => 'Caracterización de materiales',
            'description' => 'Propiedades mecánicas, eléctricas, térmicas, estructurales y nano/micro (SEM, XRD, DSC, DMA, etc.).',
        ]);
        TechnologyServiceType::create([
            'code' => 'CAP_COMP',
            'category_id' => 5,
            'name' => 'Certificación de competencias técnicas',
            'description' => 'Evaluación de habilidades y certificación de competencias laborales/ocupacionales.',
        ]);
        TechnologyServiceType::create([
            'code' => 'CAP_CUR',
            'category_id' => 5,
            'name' => 'Cursos especializados',
            'description' => 'Actualización técnica presencial/virtual; contenidos alineados a normas y mejores prácticas.',
        ]);
        TechnologyServiceType::create([
            'code' => 'CAP_EQU',
            'category_id' => 5,
            'name' => 'Entrenamiento en equipos e infraestructura',
            'description' => 'Operación segura y avanzada de equipos/laboratorios; protocolos y buenas prácticas.',
        ]);
        TechnologyServiceType::create([
            'code' => 'CON_ASE',
            'category_id' => 4,
            'name' => 'Asesoría y diagnóstico tecnológico',
            'description' => 'Vigilancia tecnológica, roadmap y diagnóstico de brechas (capacidad vs. requerimientos).',
        ]);
        TechnologyServiceType::create([
            'code' => 'CON_FACT',
            'category_id' => 4,
            'name' => 'Estudios de factibilidad e impacto',
            'description' => 'Análisis técnico-económico, riesgos, regulatorio y evaluación costo-beneficio.',
        ]);
        TechnologyServiceType::create([
            'code' => 'CON_IP',
            'category_id' => 4,
            'name' => 'Transferencia tecnológica y PI',
            'description' => 'Búsqueda del estado de la técnica, patent landscaping, licenciamiento y estrategias de PI.',
        ]);
        TechnologyServiceType::create([
            'code' => 'DIS_IND',
            'category_id' => 5,
            'name' => 'Diseño industrial y de producto',
            'description' => 'Diseño de producto, empaque, ergonomía y validación de uso.',
        ]);
        TechnologyServiceType::create([
            'code' => 'DIS_PROC',
            'category_id' => 5,
            'name' => 'Ingeniería y optimización de procesos',
            'description' => 'Rediseño, automatización, escalamiento y control de procesos productivos.',
        ]);
        TechnologyServiceType::create([
            'code' => 'DIS_PROT',
            'category_id' => 5,
            'name' => 'Diseño y fabricación de prototipos',
            'description' => 'Prototipado mecánico/electrónico/embebido y pruebas de funcionalidad.',
        ]);
        TechnologyServiceType::create([
            'code' => 'ENS_CERT',
            'category_id' => 2,
            'name' => 'Certificación de producto o proceso',
            'description' => 'Evaluación de conformidad, informes técnicos y soporte para certificación externa.',
        ]);
        TechnologyServiceType::create([
            'code' => 'ENS_MET',
            'category_id' => 2,
            'name' => 'Calibración y metrología',
            'description' => 'Calibración de equipos, trazabilidad, incertidumbre y mantenimiento metrológico.',
        ]);
        TechnologyServiceType::create([
            'code' => 'ENS_NOM',
            'category_id' => 2,
            'name' => 'Ensayos normalizados NOM/NMX/ISO/ASTM',
            'description' => 'Pruebas conforme a normas para seguridad, desempeño y calidad de productos/procesos.',
        ]);
        TechnologyServiceType::create([
            'code' => 'ID_COL',
            'category_id' => 6,
            'name' => 'Proyectos I+D colaborativos',
            'description' => 'Co-desarrollo con industria/gobierno; pruebas de concepto y transferencia.',
        ]);
        TechnologyServiceType::create([
            'code' => 'ID_PIL',
            'category_id' => 6,
            'name' => 'Pruebas piloto y validación tecnológica',
            'description' => 'Validación en entorno relevante/operativo, protocolos y reportes técnicos.',
        ]);
        TechnologyServiceType::create([
            'code' => 'ID_SW',
            'category_id' => 6,
            'name' => 'Desarrollo de software y soluciones digitales',
            'description' => 'Arquitectura, desarrollo y validación de software, analítica e IA aplicada.',
        ]);
        TechnologyServiceType::create([
            'code' => 'PRO_INT',
            'category_id' => 7,
            'name' => 'Integración tecnológica (IoT/automatización)',
            'description' => 'Integración de sensores, control, comunicaciones y automatización de líneas o procesos.',
        ]);
        TechnologyServiceType::create([
            'code' => 'PRO_MFG',
            'category_id' => 7,
            'name' => 'Manufactura avanzada y prototipado',
            'description' => 'Impresión 3D, CNC, manufactura asistida por computadora y control de calidad.',
        ]);
        TechnologyServiceType::create([
            'code' => 'PRO_PILO',
            'category_id' => 7,
            'name' => 'Operación de planta piloto',
            'description' => 'Servicios de planta piloto para escalamiento (alimentos, química, energía, etc.).',
        ]);
    }
}