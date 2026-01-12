<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institution\InstitutionCertification;


class CertificationSeeder extends Seeder
{
    public function run()
    {
        InstitutionCertification::create([
            'name' => 'Certificación ISO 9001',
            'description' => 'Certificación de calidad ISO 9001 para procesos administrativos.',
            'certification_type_id' => 1,
            'certifying_entity' => 'Entidad Certificadora Nacional',
            'certified_resource_id' => 1,
            'certified_resource_type' => 'App\Models\Institution\Facility',
            'is_active' => true,
            'resource_type_id' => 1,
            'department_id' => 1,
            'institution_id' => 1,
        ]);
        InstitutionCertification::create([
            'name' => 'Certificación ISO 14001',
            'description' => 'Certificación ambiental ISO 14001 para laboratorios.',
            'certification_type_id' => 1,
            'certifying_entity' => 'Entidad Certificadora Internacional',
            'certified_resource_id' => 1,
            'certified_resource_type' => 'App\Models\Institution\Facility',
            'is_active' => true,
            'resource_type_id' => 1,
            'department_id' => 2,
            'institution_id' => 1,
        ]);
        InstitutionCertification::create([
            'name' => 'Certificación NOM',
            'description' => 'Certificación NOM para equipos electrónicos.',
            'certification_type_id' => 2,
            'certifying_entity' => 'Secretaría de Economía',
            'certified_resource_id' => 1,
            'certified_resource_type' => 'App\Models\Institution\Facility',
            'is_active' => true,
            'resource_type_id' => 2,
            'department_id' => 3,
            'institution_id' => 1,
        ]);
        InstitutionCertification::create([
            'name' => 'Certificación de Seguridad',
            'description' => 'Certificación de seguridad para instalaciones mecánicas.',
            'certification_type_id' => 2,
            'certifying_entity' => 'Entidad de Seguridad Industrial',
            'certified_resource_id' => 1,
            'certified_resource_type' => 'App\Models\Institution\Facility',
            'is_active' => true,
            'resource_type_id' => 2,
            'department_id' => 4,
            'institution_id' => 1,
        ]);
        InstitutionCertification::create([
            'name' => 'Certificación de Calidad en Ingeniería',
            'description' => 'Certificación de calidad para procesos de ingeniería.',
            'certification_type_id' => 3,
            'certifying_entity' => 'Colegio de Ingenieros',
            'certified_resource_id' => 1,
            'certified_resource_type' => 'App\Models\Institution\Facility',
            'is_active' => false,
            'resource_type_id' => 3,
            'department_id' => 5,
            'institution_id' => 1,
        ]);
    }
}
