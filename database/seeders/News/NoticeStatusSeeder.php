<?php

namespace Database\Seeders\News;

use App\Models\Notice\NoticeStatus;
use Illuminate\Database\Seeder;

class NoticeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NoticeStatus::create([
            'name' => 'Borrador',
            'description' => 'Noticia en estado de borrador, no visible para el público.',
            'color' => 'gray'
        ]);

        NoticeStatus::create([
            'name' => 'Publicado',
            'description' => 'Noticia publicada y visible para el público.',
            'color' => 'green'
        ]);

        NoticeStatus::create([
            'name' => 'Archivado',
            'description' => 'Noticia archivada, no visible para el público.',
            'color' => 'blue'
        ]);
    }
}
