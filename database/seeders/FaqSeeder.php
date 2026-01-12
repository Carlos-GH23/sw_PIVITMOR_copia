<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::create([
            'question' => '¿Qué es PIVITMor?',
            'answer' => 'PIVITMor es una plataforma que conecta la oferta y la demanda tecnológica en Morelos, impulsando la innovación y el desarrollo económico.',
        ]);
        Faq::create([
            'question' => '¿Quiénes pueden usar PIVITMor?',
            'answer' => 'Empresas, emprendedores, instituciones académicas, gobierno y sociedad civil que busquen soluciones tecnológicas o quieran ofrecerlas.',
        ]);
        Faq::create([
            'question' => '¿Cómo me registro en PIVITMor?',
            'answer' => 'Puedes registrarte como demandante (si buscas tecnología) u ofertante (si la ofreces) a través de nuestro formulario en línea.',
        ]);
        Faq::create([
            'question' => '¿Tiene algún costo usar PIVITMor?',
            'answer' => 'El uso básico de la plataforma es gratuito. Para servicios premium o especializados, consulta nuestras opciones de membresía.',
        ]);
    }
}
