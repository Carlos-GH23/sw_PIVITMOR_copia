<?php

use App\Http\Controllers\Academic\AcademicProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Security\ModuleController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\Catalogs\IntellectualPropertyController;
use App\Http\Controllers\Catalogs\EconomicSectorController;
use App\Http\Controllers\Catalogs\KnowledgeAreaController;
use App\Http\Controllers\Catalogs\InstitutionTypeController;
use App\Http\Controllers\Catalogs\ResourceTypeController;
use App\Http\Controllers\Catalogs\SocialSectorController;
use App\Http\Controllers\Catalogs\ProductiveEconomicSectorController;
use App\Http\Controllers\Catalogs\EducationalLevelController;
use App\Http\Controllers\Catalogs\EducationalModalityController;
use App\Http\Controllers\Catalogs\CopaesAccreditationController;
use App\Http\Controllers\Catalogs\CieesAccreditationController;
use App\Http\Controllers\Catalogs\FimpesAccreditationController;
use App\Http\Controllers\Catalogs\CertificationTypeController;
use App\Http\Controllers\Catalogs\NewsCategoryController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Catalogs\OecdSectorController;
use App\Http\Controllers\CapabilityController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\Catalogs\TechnologyLevelController;
use App\Http\Controllers\Catalogs\ActivityController;
use App\Http\Controllers\Institution\FacilityController;
use App\Http\Controllers\Institution\DepartmentController;
use App\Http\Controllers\Institution\AcademicController;
use App\Http\Controllers\AcademicGroups\AcademicBodyController;
use App\Http\Controllers\AcademicGroups\ResearchLineController;
use App\Http\Controllers\Catalogs\FacilityTypeController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\Institution\AcademicOfferingController;
use App\Http\Controllers\Catalogs\TechnologyServiceTypeController;
use App\Http\Controllers\Catalogs\TechnologyServiceCategoryController;
use App\Http\Controllers\TechnologyServiceController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\Institution\InstitutionCertificationController;
use App\Http\Controllers\Institution\EquipmentController;
use App\Http\Controllers\Catalogs\EquipmentTypeController;
use App\Http\Controllers\Notice\NoticeController;
use App\Http\Controllers\Academic\AcademicCertificationController;
use App\Http\Controllers\Catalogs\ResearchAreaController;
use App\Http\Controllers\Institution\CapabilityEvaluationController;
use App\Http\Controllers\Academic\AcademicBackgroundController;
use App\Http\Controllers\Admin\Users\AcademicUsersController;
use App\Http\Controllers\Admin\Users\CompanyUsersController;
use App\Http\Controllers\Admin\Users\GovernmentAgencyUsersController;
use App\Http\Controllers\Admin\Users\InstitutionUsersController;
use App\Http\Controllers\Admin\Users\NonProfitOrganizationUsersController;
use App\Http\Controllers\Admin\CommunicationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CapabilityMatchController;
use App\Http\Controllers\Catalogs\ImpactMetricController;
use App\Http\Controllers\GovernmentAgency\GovernmentAgencyProfileController;
use App\Http\Controllers\Institution\RequirementEvaluationController;
use App\Http\Controllers\Company\JobOfferController;
use App\Http\Controllers\Catalogs\JobOfferTypeController;
use App\Http\Controllers\Catalogs\MatchEvaluationCategoryController;
use App\Http\Controllers\Company\CompanyProfileController;
use App\Http\Controllers\ContactInformationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Institution\InstitutionProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Institution\TechnologyServiceEvaluationController;
use App\Http\Controllers\MatchEvaluationController;
use App\Http\Controllers\NonProfitOrganizationProfileController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\RequirementMatchController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\PrivacityComplianceController;
use App\Http\Controllers\ConsentConfigurationController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\Catalogs\GovernmentSectorController;
use App\Http\Controllers\RequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile-photo', [ProfileController::class, 'destroyPhoto'])->name('profile.destroyPhoto');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Security
    Route::resource('modules', ModuleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::get('/users/institution-profile', [InstitutionUsersController::class, 'index'])->name('users.institutionProfile.index');
    Route::patch('/users/institution-profile/{institution}/enable', [InstitutionUsersController::class, 'enable'])->name('users.institutionProfile.enable');
    Route::get('/users/institution-profile/export-pdf', [InstitutionUsersController::class, 'exportPdf'])->name('users.institutionProfile.exportPdf');
    Route::get('/users/institution-profile/export-excel', [InstitutionUsersController::class, 'exportExcel'])->name('users.institutionProfile.exportExcel');
    Route::get('/users/academic-profile', [AcademicUsersController::class, 'index'])->name('users.academicProfile.index');
    Route::patch('/users/academic-profile/{academic}/enable', [AcademicUsersController::class, 'enable'])->name('users.academicProfile.enable');
    Route::get('/users/academic-profile/export-pdf', [AcademicUsersController::class, 'exportPdf'])->name('users.academicProfile.exportPdf');
    Route::get('/users/academic-profile/export-excel', [AcademicUsersController::class, 'exportExcel'])->name('users.academicProfile.exportExcel');
    Route::get('/users/company-profile', [CompanyUsersController::class, 'index'])->name('users.companyProfile.index');
    Route::patch('/users/company-profile/{company}/enable', [CompanyUsersController::class, 'enable'])->name('users.companyProfile.enable');
    Route::get('/users/company-profile/export-pdf', [CompanyUsersController::class, 'exportPdf'])->name('users.companyProfile.exportPdf');
    Route::get('/users/company-profile/export-excel', [CompanyUsersController::class, 'exportExcel'])->name('users.companyProfile.exportExcel');
    Route::get('/users/government-agency-profile', [GovernmentAgencyUsersController::class, 'index'])->name('users.governmentAgencyProfile.index');
    Route::patch('/users/government-agency-profile/{governmentAgency}/enable', [GovernmentAgencyUsersController::class, 'enable'])->name('users.governmentAgencyProfile.enable');
    Route::get('/users/government-agency-profile/export-pdf', [GovernmentAgencyUsersController::class, 'exportPdf'])->name('users.governmentAgencyProfile.exportPdf');
    Route::get('/users/government-agency-profile/export-excel', [GovernmentAgencyUsersController::class, 'exportExcel'])->name('users.governmentAgencyProfile.exportExcel');
    Route::get('/users/non-profit-organization-profile', [NonProfitOrganizationUsersController::class, 'index'])->name('users.nonProfitOrganizationProfile.index');
    Route::patch('/users/non-profit-organization-profile/{nonProfitOrganization}/enable', [NonProfitOrganizationUsersController::class, 'enable'])->name('users.nonProfitOrganizationProfile.enable');
    Route::get('/users/non-profit-organization-profile/export-pdf', [NonProfitOrganizationUsersController::class, 'exportPdf'])->name('users.nonProfitOrganizationProfile.exportPdf');
    Route::get('/users/non-profit-organization-profile/export-excel', [NonProfitOrganizationUsersController::class, 'exportExcel'])->name('users.nonProfitOrganizationProfile.exportExcel');

    Route::resource('users', UserController::class);

    // Catalogs
    Route::resource('economicSectors', EconomicSectorController::class);
    Route::resource('knowledgeAreas', KnowledgeAreaController::class);
    Route::resource('institutionTypes', InstitutionTypeController::class);
    Route::resource('resourceTypes', ResourceTypeController::class);
    Route::resource('intellectualProperties', IntellectualPropertyController::class);
    Route::resource('technologyLevels', TechnologyLevelController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('oecdSector', OecdSectorController::class);
    Route::resource('facilityTypes', FacilityTypeController::class);
    Route::resource('equipmentTypes', EquipmentTypeController::class);
    Route::resource('technologyServiceTypes', TechnologyServiceTypeController::class);
    Route::resource('technologyServiceCategories', TechnologyServiceCategoryController::class);
    Route::resource('socialSectors', SocialSectorController::class);
    Route::resource('researchAreas', ResearchAreaController::class);
    Route::resource('productiveEconomicSectors', ProductiveEconomicSectorController::class);
    Route::resource('educationalLevels', EducationalLevelController::class);
    Route::resource('educationalModalities', EducationalModalityController::class);
    Route::resource('copaesAccreditations', CopaesAccreditationController::class);
    Route::resource('cieesAccreditations', CieesAccreditationController::class);
    Route::resource('fimpesAccreditations', FimpesAccreditationController::class);
    Route::resource('newsCategories', NewsCategoryController::class);
    Route::resource('jobOfferTypes', JobOfferTypeController::class);
    Route::resource('matchEvaluationCategories', MatchEvaluationCategoryController::class);
    Route::resource('impactMetrics', ImpactMetricController::class);
    Route::resource('governmentSectors', GovernmentSectorController::class);
    Route::resource('certificationTypes', CertificationTypeController::class);

    // Requests - Organization Registrations    
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');    
    Route::post('/requests/{registration}/update-status', [RequestController::class, 'updateStatus'])->name('requests.update-status');

    // IES/CI
    Route::get('capabilities/matches', [CapabilityMatchController::class, 'index'])->name('capabilities.matches.index');
    Route::post('capabilities/{capabilityRequirementMatch}/matches/accept', [CapabilityMatchController::class, 'accept'])->name('capabilities.matches.accept');
    Route::post('capabilities/{capabilityRequirementMatch}/matches/reject', [CapabilityMatchController::class, 'reject'])->name('capabilities.matches.reject');

    Route::get('capabilities/evaluations', [CapabilityEvaluationController::class, 'index'])->name('capabilities.evaluations.index');
    Route::patch('capabilities/{capability}/enable', [CapabilityController::class, 'enable'])->name('capabilities.enable');
    Route::patch('capabilities/{capability}/validity', [CapabilityController::class, 'validity'])->name('capabilities.validity.update');
    Route::resource('capabilities', CapabilityController::class)->middleware('log.visit:capabilities');
    Route::resource('capabilities.evaluations', CapabilityEvaluationController::class)->names('capabilities.evaluations')->only(['create', 'store']);

    Route::get('requirements/matches', [RequirementMatchController::class, 'index'])->name('requirements.matches.index');
    Route::post('requirements/{capabilityRequirementMatch}/matches/accept', [RequirementMatchController::class, 'accept'])->name('requirements.matches.accept');
    Route::post('requirements/{capabilityRequirementMatch}/matches/reject', [RequirementMatchController::class, 'reject'])->name('requirements.matches.reject');

    Route::patch('matchEvaluations/{matchEvaluation}/enableSuccessStory', [MatchEvaluationController::class, 'enableSuccessStory'])->name('matchEvaluations.enableSuccessStory');
    Route::get('matchEvaluations/{capabilityRequirementMatch}/create', [MatchEvaluationController::class, 'create'])->name('matchEvaluations.create');
    Route::post('matchEvaluations/{capabilityRequirementMatch}', [MatchEvaluationController::class, 'store'])->name('matchEvaluations.store');
    Route::resource('matchEvaluations', MatchEvaluationController::class)->except(['create', 'store']);

    Route::get('requirements/evaluations', [RequirementEvaluationController::class, 'index'])->name('requirements.evaluations.index');
    Route::patch('requirements/{requirement}/enable', [RequirementController::class, 'enable'])->name('requirements.enable');
    Route::patch('requirements/{requirement}/validity', [RequirementController::class, 'validity'])->name('requirements.validity.update');
    Route::resource('requirements', RequirementController::class)->middleware('log.visit:requirements');
    Route::resource('requirements.evaluations', RequirementEvaluationController::class)->names('requirements.evaluations')->only(['create', 'store']);

    Route::prefix('institutions')->group(function () {
        Route::singleton('profile', InstitutionProfileController::class)->only(['edit', 'update'])->names('institution.profile');
        Route::resource('academics', AcademicController::class)->names('institutions.academics');
        Route::patch('departments/{department}/enable', [DepartmentController::class, 'enable'])->name('institutions.departments.enable');
        Route::resource('departments', DepartmentController::class)->names('institutions.departments');
        Route::resource('facilities', FacilityController::class)->names('institutions.facilities');
        Route::resource('equipments', EquipmentController::class)->names('institutions.equipments');
        Route::patch('certifications/{institutionCertification}/enable', [InstitutionCertificationController::class, 'enable'])->name('institutions.certifications.enable');
        Route::resource('certifications', InstitutionCertificationController::class)->names('institutions.certifications');
        Route::patch('academics/{academic}/enable', [AcademicController::class, 'enable'])->name('institutions.academics.enable');
        Route::patch('facilities/{facility}/enable', [FacilityController::class, 'enable'])->name('institutions.facilities.enable');
        Route::patch('equipments/{equipment}/enable', [EquipmentController::class, 'enable'])->name('institutions.equipments.enable');
    });
    Route::post('/upload-csv', [CsvController::class, 'uploadCSV'])->name('csv.store');
    Route::get('/download-csv-template', [CsvController::class, 'downloadTemplate'])->name('csv.downloadTemplate');
    //
    Route::resource('academicBodies', AcademicBodyController::class);
    Route::patch('academicBodies/{academicBody}/enable', [AcademicBodyController::class, 'enable'])->name('academicBodies.enable');
    Route::resource('researchLines', ResearchLineController::class);
    Route::patch('researchLines/{researchLine}/enable', [ResearchLineController::class, 'enable'])->name('researchLines.enable');
    Route::patch('academicOfferings/{academicOffering}/enable', [AcademicOfferingController::class, 'enable'])->name('academicOfferings.enable');
    Route::resource('academicOfferings', AcademicOfferingController::class);

    Route::resource('conferences', ConferenceController::class)->middleware('log.visit:conferences');
    Route::patch('conferences/{conference}/enable', [ConferenceController::class, 'enable'])->name('conferences.enable');

    Route::get('technologyServices/evaluations', [TechnologyServiceEvaluationController::class, 'index'])->name('technologyServices.evaluations.index');
    Route::resource('technologyServices.evaluations', TechnologyServiceEvaluationController::class)->names('technologyServices.evaluations')->only(['create', 'store']);
    Route::patch('technologyServices/{technologyService}/enable', [TechnologyServiceController::class, 'enable'])->name('technologyServices.enable');
    Route::patch('technologyServices/{technologyService}/validity', [TechnologyServiceController::class, 'validity'])->name('technologyServices.validity.update');
    Route::resource('technologyServices', TechnologyServiceController::class)->middleware('log.visit:technologyServices');

    Route::resource('/notices', NoticeController::class)->names('notices');
    Route::get('communication', [CommunicationController::class, 'index'])->name('communication.index');
    Route::post('communication/email', [CommunicationController::class, 'email'])->name('communication.email');

    Route::prefix('academic')->group(function () {
        Route::singleton('profile', AcademicProfileController::class)->only(['edit', 'update'])->names('academic.profile');
        Route::resource('academicBackgrounds', AcademicBackgroundController::class)->names('academics.academicBackgrounds');
        Route::resource('/certifications', AcademicCertificationController::class)->names('academics.certifications');
        Route::patch('/certifications/{certification}/enable', [AcademicCertificationController::class, 'enable'])->name('academics.certifications.enable');
    });

    Route::singleton('governmentAgency/profile', GovernmentAgencyProfileController::class)->only(['edit', 'update'])->names('governmentAgency.profile');

    // profile company
    Route::singleton('company/profile', CompanyProfileController::class)->only(['edit', 'update'])->names('company.profile');
    Route::patch('jobOffers/{jobOffer}/enable', [JobOfferController::class, 'enable'])->name('jobOffers.enable');
    Route::resource('jobOffers', JobOfferController::class)->middleware('log.visit:jobOffers');

    // ong profile
    Route::singleton('nonProfitOrganization/profile', NonProfitOrganizationProfileController::class)->only(['edit', 'update'])->names('nonProfitOrganization.profile');
    // Content
    Route::resource('faqs', FaqController::class);
    Route::singleton('contactInformation', ContactInformationController::class)->only(['edit', 'update'])->names('contactInformation');

    // system settings
    Route::get('/system-settings', [SystemSettingController::class, 'index'])->name('system.settings.index');
    Route::patch('/system-settings/policy/update', [PolicyController::class, 'update'])->name('policy.update');
    Route::put('/system-settings/privacity-compliance/create', [PrivacityComplianceController::class, 'store'])->name('privacityCompliance.store');
    Route::patch('/system-settings/consent-configuration/update', [ConsentConfigurationController::class, 'update'])->name('consentConfiguration.update');
    Route::patch('/system-settings/privacity-compliance/enable/{privacityCompliance}', [PrivacityComplianceController::class, 'enable'])->name('privacityCompliance.enable');
    Route::get('/privacity-policy', [PrivacityComplianceController::class, 'index'])->name('policies.index');
    Route::patch('/privacity-policy/accept', [PrivacityComplianceController::class, 'acceptPrivacityAdvice'])->name('policies.accept');
    Route::patch('/system-settings/email-templates/{emailTemplate}/update', [EmailTemplateController::class, 'update'])->name('emailTemplates.update');
    Route::patch('/system-settings/mail-setting/update', [SystemSettingController::class, 'update'])->name('mailSettings.update');

    // backup
    Route::prefix('backup-settings')->name('backup.settings.')->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('index');
        Route::post('/store', [BackupController::class, 'store'])->name('store');
        Route::post('/restore', [BackupController::class, 'restore'])->name('restore');
        Route::patch('/schedule', [BackupController::class, 'schedule'])->name('schedule');
    });

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/searches', SearchController::class)->name('searches');
});

require __DIR__ . '/auth.php';
