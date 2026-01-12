<?php

namespace Database\Seeders;

use App\Models\OrganizationRegistrationStatus;
use App\Models\OrganizationRegistration;
use App\Models\State;
use App\Models\Municipality;
use Illuminate\Database\Seeder;

class OrganizationRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pending = OrganizationRegistrationStatus::firstOrCreate([
            'name' => 'Pendiente',
        ], [
            'description' => 'Registro pendiente de revisión',
            'color' => 'yellow',
        ]);

        $accepted = OrganizationRegistrationStatus::firstOrCreate([
            'name' => 'Aceptada',
        ], [
            'description' => 'Registro aceptado y validado',
            'color' => 'green',
        ]);

        $rejected = OrganizationRegistrationStatus::firstOrCreate([
            'name' => 'Rechazada',
        ], [
            'description' => 'Registro rechazado',
            'color' => 'red',
        ]);

        // $state = State::first() ?? State::create(['name' => 'Estado Ejemplo', 'code' => 'EE']);
        // $municipality = Municipality::where('state_id', $state->id)->first() ?? Municipality::create(['name' => 'Municipio Ejemplo', 'code' => 'ME', 'state_id' => $state->id]);

        // Pendiente
        // OrganizationRegistration::create([
        //     'name' => 'Org Pendiente',
        //     'email' => 'pendiente@org.com',
        //     'organization_type' => 'Empresa',
        //     'organization_sector' => 'Privado',
        //     'state_id' => $state->id,
        //     'municipality_id' => $municipality->id,
        //     'organization_registration_status_id' => $pending->id,
        //     'rejection_reason' => null,
        // ]);

        // Aceptada
        // OrganizationRegistration::create([
        //     'name' => 'Org Aceptada',
        //     'email' => 'aceptada@org.com',
        //     'organization_type' => 'IES',
        //     'organization_sector' => 'Público',
        //     'state_id' => $state->id,
        //     'municipality_id' => $municipality->id,
        //     'organization_registration_status_id' => $accepted->id,
        //     'rejection_reason' => null,
        // ]);

        // Rechazada
        // OrganizationRegistration::create([
        //     'name' => 'Org Rechazada',
        //     'email' => 'rechazada@org.com',
        //     'organization_type' => 'Organización No Gubernamental',
        //     'organization_sector' => 'Social',
        //     'state_id' => $state->id,
        //     'municipality_id' => $municipality->id,
        //     'organization_registration_status_id' => $rejected->id,
        //     'rejection_reason' => 'Información incompleta o inválida',
        // ]);
    }
}
