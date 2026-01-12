<?php

namespace Database\Seeders\GovernmentAgency;

use App\Models\GovernmentAgency\GovernmentLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernmentLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GovernmentLevel::create(['name' => 'Municipal', 'description' => 'Nivel de gobierno a nivel de municipios o ciudades.']);
        GovernmentLevel::create(['name' => 'Estatal', 'description' => 'Nivel de gobierno a nivel de estados o provincias.']);
        GovernmentLevel::create(['name' => 'Federal', 'description' => 'Nivel de gobierno a nivel nacional o federal.']);

        $sectores = [
            [
                'name' => 'Salud',
                'description' => 'Gestión de servicios médicos, hospitales públicos, prevención de enfermedades y promoción de la salud comunitaria.'
            ],
            [
                'name' => 'Educación',
                'description' => 'Administración del sistema educativo, escuelas, universidades y programas de formación académica y docente.'
            ],
            [
                'name' => 'Seguridad y Protección Ciudadana',
                'description' => 'Mantenimiento del orden público, prevención del delito, vigilancia policial y estrategias de seguridad nacional.'
            ],
            [
                'name' => 'Economía y Desarrollo Productivo',
                'description' => 'Fomento al comercio, industria, emprendimiento y políticas para el crecimiento económico sostenible.'
            ],
            [
                'name' => 'Medio Ambiente y Recursos Naturales',
                'description' => 'Protección de ecosistemas, gestión de recursos naturales, sustentabilidad y combate al cambio climático.'
            ],
            [
                'name' => 'Ciencia, Tecnología e Innovación (TICs)',
                'description' => 'Impulso a la investigación científica, desarrollo tecnológico, digitalización y reducción de la brecha digital.'
            ],
            [
                'name' => 'Obras Públicas e Infraestructura',
                'description' => 'Planificación, construcción y mantenimiento de carreteras, puentes, edificios públicos y equipamiento urbano.'
            ],
            [
                'name' => 'Gobernación y Asuntos Políticos',
                'description' => 'Coordinación de políticas internas, relaciones institucionales, gobernabilidad y fortalecimiento democrático.'
            ],
            [
                'name' => 'Desarrollo Social y Bienestar',
                'description' => 'Programas de apoyo a grupos vulnerables, combate a la pobreza e inclusión social.'
            ],
            [
                'name' => 'Cultura y Patrimonio',
                'description' => 'Promoción de las artes, preservación del patrimonio histórico, museos y expresiones culturales.'
            ],
            [
                'name' => 'Transporte y Movilidad',
                'description' => 'Regulación del transporte público y privado, movilidad urbana, logística y conectividad vial.'
            ],
            [
                'name' => 'Vivienda y Desarrollo Urbano',
                'description' => 'Planeación urbana, zonificación y programas de acceso a vivienda digna y ordenamiento territorial.'
            ],
            [
                'name' => 'Agua y Saneamiento',
                'description' => 'Gestión de recursos hídricos, abastecimiento de agua potable, alcantarillado y tratamiento de aguas residuales.'
            ],
            [
                'name' => 'Trabajo y Previsión Social',
                'description' => 'Regulación de relaciones laborales, fomento al empleo digno, seguridad social y derechos de los trabajadores.'
            ],
            [
                'name' => 'Relaciones Exteriores y Cooperación Internacional',
                'description' => 'Diplomacia, gestión de tratados internacionales, consulados y representación del país en el extranjero.'
            ],
            [
                'name' => 'Hacienda y Finanzas Públicas',
                'description' => 'Administración del presupuesto público, recaudación fiscal, gastos e ingresos del estado.'
            ],
            [
                'name' => 'Justicia y Derechos Humanos',
                'description' => 'Administración de justicia, defensa de los derechos humanos y asesoría jurídica legal.'
            ],
            [
                'name' => 'Protección Civil y Gestión de Riesgos',
                'description' => 'Prevención, preparación y respuesta ante desastres naturales, emergencias y situaciones de riesgo.'
            ],
        ];

        DB::table('government_sectors')->insert($sectores);
    }
}
