<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create([
            'name' => 'Admin',
            'description' => 'Administrador',
        ]);

        $permissions = Permission::whereIn('module_key', ['seg', 'cat', 'config'])->get();
        $admin->syncPermissions($permissions);

        $company = Role::create(['name' => 'Empresa', 'description' => 'Empresas, ONGs y Profesionistas']);
        $academic = Role::create(['name' => 'Academico', 'description' => 'Academicos',]);
        $institution = Role::create(['name' => 'IES/CI', 'description' => 'Instituciones de Educación Superior (IES) y Centros de Investigación (CI)']);
        $ong = Role::create(['name' => 'Organización No Gubernamental', 'description' => 'Organización No Gubernamental(ONG)']);
        $dependency = Role::create(['name' => 'Dependencia de gobierno', 'description' => 'Dependencia de gobierno']);

        // permisos para el menu TEMPORAL
        $admin->givePermissionTo([
            'menu.security',
            'menu.catalog',
            'dashboard.institutionIndicatorsAdmin',
            'requests',
            'successStories',
            'reports',
            'contents',
            'portalDesigns',
            'maintenance',
            'settings',
            'searches',
            //
            'menu.match',

            'menu.users',
            'users.institutionProfile',
            'users.institutionProfile.enable',
            'users.academicProfile',
            'users.academicProfile.enable',
            'users.companyProfile',
            'users.companyProfile.enable',
            'users.governmentAgencyProfile',
            'users.governmentAgencyProfile.enable',
            'users.nonProfitOrganizationProfile',
            'users.nonProfitOrganizationProfile.enable',
            'users.exportFiles',
            'requirements.matches.index',
            'capabilities.matches.index',
            'system.settings.index',
            'system.settings.privacityCompliance.update',
            'system.settings.privacityCompliance.enable',
            'system.settings.consentConfiguration.update',
            'system.settings.policy.update',

            'faqs.index',
            'faqs.store',
            'faqs.update',
            'faqs.delete',
            'contactInformation',
            'backup.settings',
            'matchEvaluations.index',
            'matchEvaluations.enableSuccessStory',
        ]);
        $company->givePermissionTo([
            'company.profile',
            'dashboard.opportunities',
            'requirements.index',
            'requirements.store',
            'requirements.update',
            'requirements.delete',
            'requirements.enable',
            'technologyServices.index',
            'technologyServices.store',
            'technologyServices.update',
            'technologyServices.delete',
            'technologyServices.enable',

            'searches',
            'vinculationEvaluations.requirements.index',
            'jobOffers.index',
            'jobOffers.store',
            'jobOffers.update',
            'jobOffers.delete',
            'jobOffers.enable',
            'menu.match',
            'requirements.matches.index',
            'requirements.matches.store',
            'requirements.evaluations.store', // permiso para omitir evaluacion
            'technologyServices.evaluations.store', // permiso para omitir evaluacion
            'matchEvaluations.store',
            'matchEvaluations.update',
        ]);
        $academic->givePermissionTo([
            'dashboard.opportunities',
            'academic.profile',

            'requirements.index',
            'requirements.store',
            'requirements.update',
            'requirements.delete',
            'capabilities.index',
            'capabilities.store',
            'capabilities.update',
            'capabilities.delete',
            'technologyServices.index',
            'technologyServices.store',
            'technologyServices.update',
            'technologyServices.delete',

            'searches',
            'academics.academicBackgrounds.index',
            'academics.academicBackgrounds.store',
            'academics.academicBackgrounds.update',
            'academics.academicBackgrounds.delete',

            'academics.certifications.index',
            'academics.certifications.store',
            'academics.certifications.update',
            'academics.certifications.delete',
            'academics.certifications.enable',

            'conferences.index',
            'conferences.store',
            'conferences.update',
            'conferences.delete',
            'conferences.enable',
            'menu.match',
            'requirements.matches.index',
            'requirements.matches.store',
            'capabilities.matches.index',
            'capabilities.matches.store',

            'policies.index',
            'policies.accept',
            'matchEvaluations.store',
            'matchEvaluations.update',
        ]);
        $institution->givePermissionTo([
            'dashboard.institutionIndicators',

            // profile
            'institution.profile',
            'institutions.departments.index',
            'institutions.departments.store',
            'institutions.departments.update',
            'institutions.departments.delete',
            'institutions.departments.enable',
            'institutions.academics.index',
            'institutions.academics.store',
            'institutions.academics.update',
            'institutions.academics.delete',
            'institutions.certifications.index',
            'institutions.certifications.store',
            'institutions.certifications.update',
            'institutions.certifications.delete',
            'institutions.certifications.enable',
            'institutions.facilities.index',
            'institutions.facilities.store',
            'institutions.facilities.update',
            'institutions.facilities.delete',
            'institutions.facilities.enable',
            'institutions.equipments.index',
            'institutions.equipments.store',
            'institutions.equipments.update',
            'institutions.equipments.delete',
            'institutions.equipments.enable',

            // evaluation
            'technologyServices.index',
            'technologyServices.enable',
            'technologyServices.viewInstitution',
            'requirements.evaluations.index',
            'requirements.evaluations.store',

            'requirements.index',
            'requirements.viewInstitution',
            'requirements.enable',

            'capabilities.index',
            'capabilities.viewInstitution',
            'capabilities.enable',

            'capabilities.evaluations.index',
            'capabilities.evaluations.store',

            'academicOfferings.index',
            'academicOfferings.store',
            'academicOfferings.update',
            'academicOfferings.delete',

            'vinculationEvaluations.requirements.index',
            'vinculationEvaluations.capabilities.index',
            'technologyServices.evaluations.index',
            'technologyServices.evaluations.store',


            'conferences.index',
            'conferences.viewInstitution',
            'conferences.enable',

            'academicBodies.index',
            'academicBodies.store',
            'academicBodies.update',
            'academicBodies.delete',
            'academicBodies.enable',

            'researchLines.index',
            'researchLines.store',
            'researchLines.update',
            'researchLines.delete',
            'researchLines.enable',

            'menu.evaluation',
            'menu.match',
            'requirements.matches.index',
            'capabilities.matches.index',
        ]);
        $ong->givePermissionTo([
            'dashboard.opportunities',
            'nonProfitOrganization.profile',

            'requirements.index',
            'requirements.store',
            'requirements.update',
            'requirements.delete',
            'requirements.enable',

            'searches',
            'vinculationEvaluations.requirements.index',
            'menu.match',
            'requirements.matches.index',
            'requirements.matches.store',
            'requirements.evaluations.store', // permiso para omitir evaluacion
            'matchEvaluations.store',
            'matchEvaluations.update',
        ]);
        $dependency->givePermissionTo([
            'governmentAgency.profile',
            'dashboard.opportunities',

            'requirements.index',
            'requirements.store',
            'requirements.update',
            'requirements.delete',
            'requirements.enable',

            'searches',
            'vinculationEvaluations.requirements.index',
            'menu.match',
            'requirements.matches.index',
            'requirements.matches.store',
            'requirements.evaluations.store', // permiso para omitir evaluacion
            'matchEvaluations.store',
            'matchEvaluations.update',
        ]);
    }
}
