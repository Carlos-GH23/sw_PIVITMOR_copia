<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'menu.security', 'guard_name' => 'web', 'description' => 'Visibilidad menú', 'module_key' => 'menu']);
        Permission::create(['name' => 'menu.catalog', 'guard_name' => 'web', 'description' => 'Visibilidad menú', 'module_key' => 'menu']);
        Permission::create(['name' => 'menu.evaluation', 'guard_name' => 'web', 'description' => 'Visibilidad menú', 'module_key' => 'menu']);
        Permission::create(['name' => 'menu.match', 'guard_name' => 'web', 'description' => 'Visibilidad menú', 'module_key' => 'menu']);

        Permission::create(['name' => 'modules.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'seg']);
        Permission::create(['name' => 'modules.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'seg']);
        Permission::create(['name' => 'modules.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'seg']);
        Permission::create(['name' => 'modules.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'seg']);

        Permission::create(['name' => 'permissions.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'seg']);
        Permission::create(['name' => 'permissions.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'seg']);
        Permission::create(['name' => 'permissions.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'seg']);
        Permission::create(['name' => 'permissions.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'seg']);

        Permission::create(['name' => 'roles.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'seg']);
        Permission::create(['name' => 'roles.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'seg']);
        Permission::create(['name' => 'roles.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'seg']);
        Permission::create(['name' => 'roles.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'seg']);

        Permission::create(['name' => 'users.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'seg']);
        Permission::create(['name' => 'users.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'seg']);
        Permission::create(['name' => 'users.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'seg']);
        Permission::create(['name' => 'users.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'seg']);

        // catalogs
        Permission::create(['name' => 'economicSectors.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'economicSectors.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'economicSectors.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'economicSectors.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'knowledgeAreas.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'knowledgeAreas.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'knowledgeAreas.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'knowledgeAreas.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'intellectualProperties.index', 'guard_name' => 'web', 'description' => 'Read Sections', 'module_key' => 'cat']);
        Permission::create(['name' => 'intellectualProperties.store', 'guard_name' => 'web', 'description' => 'Create Sections', 'module_key' => 'cat']);
        Permission::create(['name' => 'intellectualProperties.update', 'guard_name' => 'web', 'description' => 'Update Sections', 'module_key' => 'cat']);
        Permission::create(['name' => 'intellectualProperties.delete', 'guard_name' => 'web', 'description' => 'Delete Sections', 'module_key' => 'cat']);

        Permission::create(['name' => 'institutionTypes.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'institutionTypes.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'institutionTypes.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'institutionTypes.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'resourceTypes.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'resourceTypes.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'resourceTypes.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'resourceTypes.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'technologyLevels.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'technologyLevels.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'technologyLevels.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'technologyLevels.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'activities.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'activities.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'activities.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'activities.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'oecdSector.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'oecdSector.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'oecdSector.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'oecdSector.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'technologyServiceCategories.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'technologyServiceCategories.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'technologyServiceCategories.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'technologyServiceCategories.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'technologyServiceTypes.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'technologyServiceTypes.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'technologyServiceTypes.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'technologyServiceTypes.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'productiveEconomicSectors.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'productiveEconomicSectors.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'productiveEconomicSectors.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'productiveEconomicSectors.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'educationalLevels.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'educationalLevels.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'educationalLevels.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'educationalLevels.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'socialSectors.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'socialSectors.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'socialSectors.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'socialSectors.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'researchAreas.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'researchAreas.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'researchAreas.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'researchAreas.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'educationalModalities.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'educationalModalities.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'educationalModalities.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'educationalModalities.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'copaesAccreditations.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'copaesAccreditations.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'copaesAccreditations.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'copaesAccreditations.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'cieesAccreditations.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'cieesAccreditations.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'cieesAccreditations.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'cieesAccreditations.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'fimpesAccreditations.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'fimpesAccreditations.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'fimpesAccreditations.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'fimpesAccreditations.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'newsCategories.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'newsCategories.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'newsCategories.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'newsCategories.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'jobOfferTypes.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'jobOfferTypes.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'jobOfferTypes.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'jobOfferTypes.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'matchEvaluationCategories.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'matchEvaluationCategories.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'matchEvaluationCategories.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'matchEvaluationCategories.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'impactMetrics.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'impactMetrics.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'impactMetrics.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'impactMetrics.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'notices.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'notices.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'notices.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'notices.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'faqs.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'faqs.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'faqs.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'faqs.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'governmentSectors.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'governmentSectors.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'governmentSectors.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'governmentSectors.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'certificationTypes.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'certificationTypes.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'certificationTypes.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'certificationTypes.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'facilityTypes.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'facilityTypes.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'facilityTypes.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'facilityTypes.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'equipmentTypes.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'equipmentTypes.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'equipmentTypes.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'equipmentTypes.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        // config
        Permission::create(['name' => 'communication.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'config']);
        Permission::create(['name' => 'communication.email', 'guard_name' => 'web', 'description' => 'Enviar Registros', 'module_key' => 'config']);
        
        Permission::create(['name' => 'system.settings.index', 'guard_name' => 'web', 'description' => 'Acceder a los ajustes del sistema', 'module_key' => 'config']);
        Permission::create(['name' => 'system.settings.privacityCompliance.update', 'guard_name' => 'web', 'description' => 'Actualizar Políticas de Privacidad', 'module_key' => 'config']);
        Permission::create(['name' => 'system.settings.privacityCompliance.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar Políticas de Privacidad', 'module_key' => 'config']);
        Permission::create(['name' => 'system.settings.consentConfiguration.update', 'guard_name' => 'web', 'description' => 'Actualizar Configuración de Consentimiento', 'module_key' => 'config']);
        Permission::create(['name' => 'system.settings.policy.update', 'guard_name' => 'web', 'description' => 'Actualizar Políticas', 'module_key' => 'config']);

        // IES/CI
        Permission::create(['name' => 'institution.profile', 'guard_name' => 'web', 'description' => 'Leer Perfil', 'module_key' => 'profile']);
        Permission::create(['name' => 'requirements.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'requirements.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'requirements.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'requirements.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'requirements.viewInstitution', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'requirements.enable', 'guard_name' => 'web', 'description' => 'Habilitar Registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'capabilities.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'capabilities.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'capabilities.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'capabilities.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'capabilities.viewInstitution', 'guard_name' => 'web', 'description' => 'Leer registros de institución', 'module_key' => 'institution']);
        Permission::create(['name' => 'capabilities.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'institutions.departments.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.departments.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.departments.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.departments.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.departments.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar Registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'institutions.academics.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.academics.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.academics.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.academics.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'institutions.certifications.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.certifications.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.certifications.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.certifications.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.certifications.enable', 'guard_name' => 'web', 'description' => 'Habilitar Registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'institutions.facilities.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.facilities.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.facilities.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.facilities.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.facilities.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar Registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'institutions.equipments.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.equipments.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.equipments.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.equipments.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'institutions.equipments.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar Registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'academicOfferings.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'academicOfferings.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'academicOfferings.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'academicOfferings.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'technologyServices.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'technologyServices.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'technologyServices.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'technologyServices.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'technologyServices.viewInstitution', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'technologyServices.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar Registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'conferences.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'conferences.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'conferences.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'conferences.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'conferences.viewInstitution', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'conferences.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar Registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'academicBodies.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'academicBodies.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'academicBodies.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'academicBodies.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'academicBodies.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'researchLines.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'researchLines.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'researchLines.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'researchLines.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'researchLines.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar registros', 'module_key' => 'institution']);

        //evaluations
        Permission::create(['name' => 'requirements.evaluations.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'requirements.evaluations.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'requirements.matches.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'requirements.matches.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'capabilities.evaluations.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'capabilities.evaluations.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'capabilities.matches.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'capabilities.matches.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'technologyServices.evaluations.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'technologyServices.evaluations.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);

        Permission::create(['name' => 'matchEvaluations.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'matchEvaluations.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'matchEvaluations.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'institution']);
        Permission::create(['name' => 'matchEvaluations.enableSuccessStory', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar Registros', 'module_key' => 'institution']);

        //company
        Permission::create(['name' => 'company.profile', 'guard_name' => 'web', 'description' => 'Leer Perfil', 'module_key' => 'profile']);
        Permission::create(['name' => 'jobOffers.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'company']);
        Permission::create(['name' => 'jobOffers.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'company']);
        Permission::create(['name' => 'jobOffers.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'company']);
        Permission::create(['name' => 'jobOffers.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'company']);
        Permission::create(['name' => 'jobOffers.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar Registros', 'module_key' => 'company']);

        // gob
        Permission::create(['name' => 'governmentAgency.profile', 'guard_name' => 'web', 'description' => 'Leer Perfil', 'module_key' => 'profile']);

        // ong
        Permission::create(['name' => 'nonProfitOrganization.profile', 'guard_name' => 'web', 'description' => 'Leer Perfil', 'module_key' => 'profile']);

        // academic
        Permission::create(['name' => 'academic.profile', 'guard_name' => 'web', 'description' => 'Leer Perfil', 'module_key' => 'profile']);
        Permission::create(['name' => 'academics.academicBackgrounds.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'academic']);
        Permission::create(['name' => 'academics.academicBackgrounds.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'academic']);
        Permission::create(['name' => 'academics.academicBackgrounds.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'academic']);
        Permission::create(['name' => 'academics.academicBackgrounds.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'academic']);
        Permission::create(['name' => 'academics.certifications.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'academic']);
        Permission::create(['name' => 'academics.certifications.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'academic']);
        Permission::create(['name' => 'academics.certifications.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'academic']);
        Permission::create(['name' => 'academics.certifications.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'academic']);
        Permission::create(['name' => 'academics.certifications.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar Registros', 'module_key' => 'academic']);

        Permission::create(['name' => 'policies.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'academic']);
        Permission::create(['name' => 'policies.accept', 'guard_name' => 'web', 'description' => 'Aceptar Políticas', 'module_key' => 'academic']);

        //users
        Permission::create(['name' => 'menu.users', 'guard_name' => 'web', 'description' => 'Leer Perfil Usuario', 'module_key' => 'menu']);
        Permission::create(['name' => 'users.institutionProfile', 'guard_name' => 'web', 'description' => 'Leer Perfil Institución', 'module_key' => 'config']);
        Permission::create(['name' => 'users.institutionProfile.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar registros', 'module_key' => 'config']);
        Permission::create(['name' => 'users.academicProfile', 'guard_name' => 'web', 'description' => 'Leer Perfil Académico', 'module_key' => 'menu']);
        Permission::create(['name' => 'users.academicProfile.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar registros', 'module_key' => 'config']);
        Permission::create(['name' => 'users.companyProfile', 'guard_name' => 'web', 'description' => 'Leer Perfil Empresa', 'module_key' => 'menu']);
        Permission::create(['name' => 'users.companyProfile.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar registros', 'module_key' => 'config']);
        Permission::create(['name' => 'users.governmentAgencyProfile', 'guard_name' => 'web', 'description' => 'Leer Perfil Gobierno', 'module_key' => 'config']);
        Permission::create(['name' => 'users.governmentAgencyProfile.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar registros', 'module_key' => 'config']);
        Permission::create(['name' => 'users.nonProfitOrganizationProfile', 'guard_name' => 'web', 'description' => 'Leer Perfil ONG', 'module_key' => 'menu']);
        Permission::create(['name' => 'users.nonProfitOrganizationProfile.enable', 'guard_name' => 'web', 'description' => 'Habilitar/Deshabilitar registros', 'module_key' => 'config']);
        Permission::create(['name' => 'users.exportFiles', 'guard_name' => 'web', 'description' => 'Exportar archivos de usuarios', 'module_key' => 'config']);

        // dashboard
        Permission::create(['name' => 'dashboard.opportunities', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'dashboard']);
        Permission::create(['name' => 'dashboard.institutionIndicators', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'dashboard']);
        Permission::create(['name' => 'dashboard.institutionIndicatorsAdmin', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'dashboard']);

        //contact information
        Permission::create(['name' => 'contactInformation', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'config']);

        // backup
        Permission::create(['name' => 'backup.settings', 'guard_name' => 'web', 'description' => 'Administrar Respaldo', 'module_key' => 'backup']);

        // reports
        Permission::create(['name' => 'reports', 'guard_name' => 'web', 'description' => 'Administrar Reportes', 'module_key' => 'reports']);
    }
}
