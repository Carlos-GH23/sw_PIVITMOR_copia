<?php

namespace Database\Seeders;

use App\Models\Backup\BackupAction;
use App\Models\Backup\BackupFrequency;
use App\Models\Backup\BackupStatus;
use Illuminate\Database\Seeder;

class BackupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BackupStatus::create([
            'name' => 'Realizado',
        ]);
        BackupStatus::create([
            'name' => 'Fallido',
        ]);
        BackupStatus::create([
            'name' => 'En proceso',
        ]);

        BackupAction::create([
            'name' => 'Respaldo Manual',
        ]);
        BackupAction::create([
            'name' => 'Restauración',
        ]);
        BackupAction::create([
            'name' => 'Programación automática',
        ]);

        BackupFrequency::create([
            'name' => 'Diario'
        ]);
        BackupFrequency::create([
            'name' => 'Semanal'
        ]);
        BackupFrequency::create([
            'name' => 'Mensual'
        ]);
    }
}
