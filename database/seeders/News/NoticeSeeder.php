<?php

namespace Database\Seeders\News;

use Illuminate\Database\Seeder;
use App\Models\Notice\Notice;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notice::create([
            'title' => 'Lanzamiento de la nueva plataforma de innovación',
            'subtitle' => 'Una iniciativa para fomentar el desarrollo tecnológico',
            'abstract' => 'La nueva plataforma busca conectar ideas innovadoras con recursos y apoyo financiero.',
            'notice_body' => 'La plataforma de innovación ha sido diseñada para facilitar la interacción entre
            investigadores y el sector empresarial. A través de esta iniciativa, se espera impulsar proyectos que contribuyan
            al desarrollo tecnológico y económico del país. La plataforma ofrecerá herramientas para la gestión de
            proyectos, acceso a financiamiento y oportunidades de networking.',
            'notice_source' => 'Departamento de Innovación Tecnológica',
            'creation_date' => now(),
            'publication_date' => now(),
            'email_notification' => 1,
            'author' => 'Admin',
            'notice_status_id' => 2,
            'news_category_id' => 1,
        ]);

        Notice::create([
            'title' => 'Impulsa Gobierno de Morelos emprendimiento infantil y juvenil con taller especializado.',
            'subtitle' => 'A través de “Mi Primer Emprendimiento Jr”, se brindaron las herramientas e inspiración para transformar las ideas en proyectos con impacto real para las comunidades',
            'abstract' => 'Con el objetivo de fomentar la cultura emprendedora desde temprana edad, el Gobierno del Estado de Morelos,
             a través de la Dirección General de Ciencia y Tecnología (DGCT),
              llevó a cabo el taller “Mi Primer Emprendimiento Jr”. Esta iniciativa está dirigida a niñas,
               niños y jóvenes de entre 8 y 17 años, con el propósito de proporcionarles las herramientas
                necesarias para desarrollar sus ideas y convertirlas en proyectos viables que generen
                 un impacto positivo en sus comunidades.',
            'notice_body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
              exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
               in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut
                 labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                  nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                   esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                    sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'notice_source' => 'Departamento de Innovación Tecnológica',
            'creation_date' => '2025-08-20',
            'publication_date' => '2025-08-25',
            'email_notification' => 1,
            'author' => 'DGCS del Gobierno del Estado de Morelos',
            'notice_status_id' => 2,
            'news_category_id' => 1,
        ]);
    }
}
