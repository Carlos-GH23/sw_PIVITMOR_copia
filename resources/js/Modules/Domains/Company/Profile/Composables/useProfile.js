import { error422 } from "@/Hooks/useErrorsForm";
import { useForm } from "@inertiajs/vue3";
import { provide, watch, computed } from "vue";

export const useProfile = (props = {}) => {
    const company = props.company.data || {};
    const location = company?.location || {};
    const technology = company?.technology || {};
    const hasCompany = technology?.has_company ?? (!!company.technology);

    const form = useForm({
        _method: "patch",
        name: company.name,
        legal_name: company.legal_name,
        rfc: company.rfc,
        year: company.year,
        mission: company.mission ?? null,
        vision: company.vision ?? null,
        overview: company.overview ?? null,
        keywords: company.keywords ?? [],

        logo: {
            id: company.logo?.id ?? null,
            path: company.logo?.path ?? null,
            file: null,
            delete_photo: false,
        },

        location: {
            state_id: location?.neighborhood?.municipality?.state?.id ?? null,
            municipality_id: location?.neighborhood?.municipality?.id ?? null,
            neighborhood_id: location?.neighborhood?.id ?? null,
            postal_code: location?.neighborhood?.postal_code ?? null,
            street: location?.street,
            exterior_number: location?.exterior_number,
            interior_number: location?.interior_number,
            latitude: location?.latitude,
            longitude: location?.longitude,
        },

        contact: {
            id: company.contact?.id ?? null,
            name: company.contact?.name,
            email: company.contact?.email,
            website: company.contact?.website,
        },

        phones: company.phone_numbers ?? [],
        social_links: company.social_links ?? [],

        reniecyt: {
            register_number: company.reniecyt?.register_number ?? null,
            start_date: company.reniecyt?.start_date ?? null,
            end_date: company.reniecyt?.end_date ?? null,
        },

        technology: {
            has_company: hasCompany,
            origen_id: technology.origen_id ?? null,
            innovation_type_id: technology.innovation_type_id ?? null,
            market_reach_id: technology.market_reach_id ?? null,
            technology_level_id: technology.technology_level_id ?? null,
            company_size_id: technology.company_size_id ?? null,
            num_employees: technology.num_employees ?? null,
            description: technology.description ?? null,
        },

        economic_sectors: technology.economic_sectors?.map((economic) => economic.id) ?? [],
        oecd_sectors: technology.oecd_sectors?.map((sector) => sector.id) ?? [],
        files: technology.files ?? [],
    });

    watch(() => form.technology.has_company, (value) => {
        if (!value) {
            form.technology.origen_id = null;
            form.technology.innovation_type_id = null;
            form.technology.market_reach_id = null;
            form.technology.technology_level_id = null;
            form.technology.company_size_id = null;
            form.technology.num_employees = null;
            form.technology.description = null;
            form.economic_sectors = [];
            form.oecd_sectors = [];
            form.files = [];
        }
    });

    const updateForm = () => {
        form.post(route(`${props.routeName}update`), {
            onError: () => {
                error422();
            },
            onSuccess: () => {
                syncForm();
            },
        });
    };

    const syncForm = () => {
        const updatedData = props.company?.data;

        if (updatedData.logo?.id !== form.logo.id || updatedData.logo?.path !== form.logo.path) {
            form.logo.id = updatedData.logo?.id ?? null;
            form.logo.path = updatedData.logo?.path ?? null;
            form.logo.file = null;
            form.logo.delete_photo = false;
        }

        if (updatedData?.phone_numbers) {
            const currentPhones = JSON.stringify(form.phones);
            const newPhones = JSON.stringify(updatedData.phone_numbers);
            if (currentPhones !== newPhones) {
                form.phones = [...updatedData.phone_numbers];
            }
        }

        if (updatedData?.social_links) {
            const currentLinks = JSON.stringify(form.social_links);
            const newLinks = JSON.stringify(updatedData.social_links);
            if (currentLinks !== newLinks) {
                form.social_links = [...updatedData.social_links];
            }
        }

        if (updatedData?.contact) {
            form.contact.id = updatedData.contact.id;
        }
    };

    const resetForm = () => {
        form.reset();
    };

    provide("profileForm", form)
    provide("props", props)
    provide("marketReaches", props.marketReaches)
    provide("company", props.company)
    provide("origens", props.origens)
    provide("companySizes", props.companySizes)
    provide("innovationTypes", props.innovationTypes)
    provide('technologyLevels', props.technologyLevels)
    provide("economicSectors", props.economicSectors)
    provide("oecdSectors", props.oecdSectors)

    return {
        processing: computed(() => form.processing),
        updateForm,
        resetForm,
    };
};