<?php

namespace Database\Seeders;

use App\Enums\ImpactMetricType;
use App\Models\Catalogs\ImpactMetric;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImpactMetricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImpactMetric::create(['name' => 'Publicaciones conjuntas', 'type' => ImpactMetricType::ScientificTechnological]);
        ImpactMetric::create(['name' => 'Patentes / Prototipos', 'type' => ImpactMetricType::ScientificTechnological]);
        ImpactMetric::create(['name' => 'Software o modelos registrados', 'type' => ImpactMetricType::ScientificTechnological]);
        ImpactMetric::create(['name' => 'Incrementa nivel TRL', 'type' => ImpactMetricType::ScientificTechnological]);
        ImpactMetric::create(['name' => 'Transferencias tecnológicas', 'type' => ImpactMetricType::ScientificTechnological]);
        ImpactMetric::create(['name' => 'Participación estudiantil / formación', 'type' => ImpactMetricType::ScientificTechnological]);
        ImpactMetric::create(['name' => 'Transferencia de conocimiento y capacitación', 'type' => ImpactMetricType::ScientificTechnological]);

        ImpactMetric::create(['name' => 'Valor económico total (MXN)', 'type' => ImpactMetricType::Economic]);
        ImpactMetric::create(['name' => 'Empleos generados', 'type' => ImpactMetricType::Economic]);
        ImpactMetric::create(['name' => 'Incremento de productividad (%)', 'type' => ImpactMetricType::Economic]);
        ImpactMetric::create(['name' => 'Nuevos productos o servicios', 'type' => ImpactMetricType::Economic]);
        ImpactMetric::create(['name' => 'Acceso a nuevos mercados', 'type' => ImpactMetricType::Economic]);
        ImpactMetric::create(['name' => 'Impacto territorial y regional', 'type' => ImpactMetricType::Economic]);

        ImpactMetric::create(['name' => 'Alianzas y convenios', 'type' => ImpactMetricType::Institutional]);
        ImpactMetric::create(['name' => 'Fortalecimiento de infraestructura', 'type' => ImpactMetricType::Institutional]);
        ImpactMetric::create(['name' => 'Programas académicos vinculados', 'type' => ImpactMetricType::Institutional]);
        ImpactMetric::create(['name' => 'Participación en redes / clusters', 'type' => ImpactMetricType::Institutional]);
        ImpactMetric::create(['name' => 'Reconocimientos institucionales', 'type' => ImpactMetricType::Institutional]);
        ImpactMetric::create(['name' => 'Madurez de la vinculación intersectorial', 'type' => ImpactMetricType::Institutional]);

        ImpactMetric::create(['name' => 'Beneficiarios atendidos', 'type' => ImpactMetricType::SocialEnvironmental]);
        ImpactMetric::create(['name' => 'Reducción de emisiones (tCO₂e/año)', 'type' => ImpactMetricType::SocialEnvironmental]);
        ImpactMetric::create(['name' => 'Impacto comunitario', 'type' => ImpactMetricType::SocialEnvironmental]);
        ImpactMetric::create(['name' => 'Contribución a ODS', 'type' => ImpactMetricType::SocialEnvironmental]);
        ImpactMetric::create(['name' => 'Inclusión y equidad (%)', 'type' => ImpactMetricType::SocialEnvironmental]);
        ImpactMetric::create(['name' => 'Sostenibilidad del proyecto', 'type' => ImpactMetricType::SocialEnvironmental]);

        ImpactMetric::create(['name' => 'Satisfacción de actores (1-5)', 'type' => ImpactMetricType::PerceptionSatisfaction]);
        ImpactMetric::create(['name' => 'Reputación institucional (1-5)', 'type' => ImpactMetricType::PerceptionSatisfaction]);
        ImpactMetric::create(['name' => 'Testimonios cualitativos', 'type' => ImpactMetricType::PerceptionSatisfaction]);
        ImpactMetric::create(['name' => 'Continuidad de colaboración (%)', 'type' => ImpactMetricType::PerceptionSatisfaction]);
        ImpactMetric::create(['name' => 'Comunicación y gestión (%)', 'type' => ImpactMetricType::PerceptionSatisfaction]);

        ImpactMetric::create(['name' => 'Mejora en servicios públicos (%)', 'type' => ImpactMetricType::PublicInnovation]);
        ImpactMetric::create(['name' => 'Digitalización y simplificación (%)', 'type' => ImpactMetricType::PublicInnovation]);
        ImpactMetric::create(['name' => 'Transparencia y datos abiertos', 'type' => ImpactMetricType::PublicInnovation]);
        ImpactMetric::create(['name' => 'Replicabilidad regional', 'type' => ImpactMetricType::PublicInnovation]);
        ImpactMetric::create(['name' => 'Políticas o normativas derivadas', 'type' => ImpactMetricType::PublicInnovation]);

        ImpactMetric::create(['name' => 'Licencia', 'type' => ImpactMetricType::TechnologicalTransfers]);
        ImpactMetric::create(['name' => 'Cesión', 'type' => ImpactMetricType::TechnologicalTransfers]);
        ImpactMetric::create(['name' => 'Know-how', 'type' => ImpactMetricType::TechnologicalTransfers]);
        ImpactMetric::create(['name' => 'Spin-off', 'type' => ImpactMetricType::TechnologicalTransfers]);

        ImpactMetric::create(['name' => 'Académicos', 'type' => ImpactMetricType::Audiences]);
        ImpactMetric::create(['name' => 'EBT', 'type' => ImpactMetricType::Audiences]);
        ImpactMetric::create(['name' => 'Estudiantes', 'type' => ImpactMetricType::Audiences]);
        ImpactMetric::create(['name' => 'Gobierno', 'type' => ImpactMetricType::Audiences]);
        ImpactMetric::create(['name' => 'ONG', 'type' => ImpactMetricType::Audiences]);
        ImpactMetric::create(['name' => 'Comunidad', 'type' => ImpactMetricType::Audiences]);

        ImpactMetric::create(['name' => 'ODS 1: Fin de la pobreza', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 2: Hambre cero', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 3: Salud y bienestar', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 4: Educación de calidad', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 5: Igualdad de género', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 6: Agua limpia y saneamiento', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 7: Energía asequible y no contaminante', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 8: Trabajo decente y crecimiento económico', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 9: Industria, innovación e infraestructura', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 10: Reducción de las desigualdades', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 11: Ciudades y comunidades sostenibles', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 12: Producción y consumo responsables', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 13: Acción por el clima', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 14: Vida submarina', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 15: Vida de ecosistemas terrestres', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 16: Paz, justicia e instituciones sólidas', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
        ImpactMetric::create(['name' => 'ODS 17: Alianzas para lograr los objetivos', 'type' => ImpactMetricType::SustainableDevelopmentGoals]);
    }
}
