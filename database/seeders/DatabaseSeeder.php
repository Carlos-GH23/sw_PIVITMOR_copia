<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\Catalogs\EconomicSectorSeeder;
use Database\Seeders\Catalogs\KnowledgeAreaSeeder;
use Database\Seeders\Catalogs\InstitutionTypeSeeder;
use Database\Seeders\Catalogs\ResourceTypeSeeder;
use Database\Seeders\Catalogs\IntellectualPropertySeeder;
use Database\Seeders\Catalogs\TechnologyLevelSeeder;
use Database\Seeders\Catalogs\ActivitySeeder;
use Database\Seeders\Catalogs\OecdSectorSeeder;
use Database\Seeders\Catalogs\ProductiveEconomicSectorSeeder;
use Database\Seeders\Catalogs\NewsCategorySeeder;
use Database\Seeders\Catalogs\SocialSectorSeeder;
use Database\Seeders\AcademicGroups\AcademicDisciplineSeeder;
use Database\Seeders\AcademicGroups\ConsolidationDegreeSeeder;
use Database\Seeders\AcademicGroups\AcademicBodySeeder;
use Database\Seeders\AcademicGroups\ResearchLineSeeder;
use Database\Seeders\Catalogs\FacilityTypeSeeder;
use Database\Seeders\Catalogs\EquipmentTypeSeeder;
use Database\Seeders\Catalogs\MatchEvaluationCategorySeeder;
use Database\Seeders\Institution\FacilityEquipmentSeeder;
use Database\Seeders\Institution\FacilitySeeder;
use Database\Seeders\Institution\AcademicSeeder;
use Database\Seeders\Institution\AcademicOfferingSeeder;
use Database\Seeders\Institution\InstitutionCategorySeeder;
use Database\Seeders\News\NoticeStatusSeeder;
use Database\Seeders\News\NoticeSeeder;
use Database\Seeders\Academic\AccreditationEntitySeeder;
use Database\Seeders\Academic\CertificationLevelSeeder;
use Database\Seeders\Academic\AcademicCertificationSeeder;
use Database\Seeders\Academic\CertificationStatusSeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\GovernmentAgency\GovernmentLevelSeeder;
use Database\Seeders\GovernmentAgency\GovernmentAgencySeeder;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\AudienceTypeSeeder;
use Database\Seeders\Catalogs\LegalEntityTypeSeeder;
use Database\Seeders\Catalogs\TechnologyServiceCategorySeeder;
use Database\Seeders\Catalogs\TechnologyServiceTypeSeeder;
use Database\Seeders\Institution\InstitutionSeeder;
use Database\Seeders\Company\CompanySeeder;
use Database\Seeders\Company\CompanySizeSeeder;
use Database\Seeders\Company\InnovationTypeSeeder;
use Database\Seeders\Company\MarketReachSeeder;
use Database\Seeders\Company\OrigenSeeder;
use Database\Seeders\JobOfferTypeSeeder;
use Database\Seeders\Institution\SniLevelSeeder;
use Database\Seeders\MailSettingSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ModuleSeeder::class,
            PermissionSeeder::class,
            MockupsSeeder::class,
            RoleSeeder::class,
            AssignRoleToUser::class,
            FileTypeSeeder::class,
            EconomicSectorSeeder::class,
            KnowledgeAreaSeeder::class,
            TechnologyLevelSeeder::class,
            OecdSectorSeeder::class,
            ActivitySeeder::class,
            IntellectualPropertySeeder::class,
            InstitutionCategorySeeder::class,
            InstitutionTypeSeeder::class,
            ResourceTypeSeeder::class,
            // InstitutionSeeder::class,

            AcademicPositionSeeder::class,
            AcademicDegreeSeeder::class,
            ResearchAreaSeeder::class,
            AcademicDisciplineSeeder::class,
            ConsolidationDegreeSeeder::class,
            FacilityTypeSeeder::class,
            LocationSeeder::class,
            // DepartmentSeeder::class,
            // FacilitySeeder::class,
            CapabilitySeeder::class,
            EducationalLevelSeeder::class,
            StudyModeSeeder::class,
            CopaesTypeSeeder::class,
            CieesAreaSeeder::class,
            FimpesAccreditationSeeder::class,
            CertificationTypeSeeder::class,
            EquipmentTypeSeeder::class,
            // FacilityEquipmentSeeder::class,
            // AcademicBodySeeder::class,
            // ResearchLineSeeder::class,
            TechnologyServiceCategorySeeder::class,
            TechnologyServiceTypeSeeder::class,
            NewsCategorySeeder::class,
            NoticeStatusSeeder::class,
            // NoticeSeeder::class,
            SocialSectorSeeder::class,
            // CertificationSeeder::class,
            // AcademicSeeder::class,
            // AcademicOfferingSeeder::class,
            ProductiveEconomicSectorSeeder::class,
            RequirementSeeder::class,
            LanguageSeeder::class,
            AudienceTypeSeeder::class,
            CountrySeeder::class,
            AccreditationEntitySeeder::class,
            CertificationLevelSeeder::class,
            CertificationStatusSeeder::class,
            // AcademicCertificationSeeder::class,
            TechnologyServiceSeeder::class,
            GovernmentLevelSeeder::class,
            // CompanySeeder::class,
            CompanySizeSeeder::class,
            InnovationTypeSeeder::class,
            MarketReachSeeder::class,
            OrigenSeeder::class,
            // GovernmentAgencySeeder::class,
            SniLevelSeeder::class,
            ConferenceSeeder::class,
            // AcademicBackgroundSeeder::class,
            JobOfferTypeSeeder::class,
            // JobOfferSeeder::class,
            LegalEntityTypeSeeder::class,
            // NonProfitOrganizationSeeder::class,
            CapabilityRequirementMatchSeeder::class,
            MatchEvaluationCategorySeeder::class,
            MatchEvaluationSeeder::class,
            ImpactMetricSeeder::class,
            FaqSeeder::class,
            // ContactInformationSeeder::class,
            BackupSeeder::class,
            // PrivacityComplianceSeeder::class,
            //PolicySeeder::class,
            EmailTemplateSeeder::class,
            // EcosystemSeeder::class,
            //AssignSectorsToExistingRecordsSeeder::class,
            EconomicSocialSectorSeeder::class,
            // MailSettingSeeder::class,
            OrganizationRegistrationSeeder::class,
        ]);
    }
}
