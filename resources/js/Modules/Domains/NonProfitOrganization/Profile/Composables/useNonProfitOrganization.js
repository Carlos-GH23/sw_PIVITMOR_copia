import { error422 } from "@/Hooks/useErrorsForm";
import { useForm } from "@inertiajs/vue3";
import { computed, provide } from "vue";

export const useNonProfitOrganization = (props) => {
    const nonProfitOrganization = props.nonProfitOrganization?.data || {};
    const location = nonProfitOrganization?.location || {};

    const form = useForm({
        _method: "patch",
        name: nonProfitOrganization.name,
        description: nonProfitOrganization.description,
        mission: nonProfitOrganization.mission,
        main_projects: nonProfitOrganization.main_projects,
        cluni: nonProfitOrganization.cluni,
        rfc: nonProfitOrganization.rfc,
        legal_representative: nonProfitOrganization.legal_representative,
        market_reach_id: nonProfitOrganization.market_reach_id ?? null,
        economic_sector_id: nonProfitOrganization.economic_sector_id ?? null,
        legal_entity_type_id:
            nonProfitOrganization.legal_entity_type_id ?? null,
        keywords: nonProfitOrganization?.keywords ?? [],

        logo: {
            id: nonProfitOrganization.logo?.id ?? null,
            path: nonProfitOrganization.logo?.path ?? null,
            file: null,
            delete_photo: false,
        },

        location: {
            state_id: location?.neighborhood?.municipality?.state_id ?? null,
            municipality_id: location?.neighborhood?.municipality_id ?? null,
            neighborhood_id: location?.neighborhood_id ?? null,
            postal_code: location?.neighborhood?.postal_code ?? null,
            street: location?.street,
            exterior_number: location?.exterior_number,
            interior_number: location?.interior_number,
            latitude: location?.latitude,
            longitude: location?.longitude,
        },

        contact: {
            id: nonProfitOrganization.contact?.id ?? null,
            name: nonProfitOrganization.contact?.name,
            email: nonProfitOrganization.contact?.email,
            website: nonProfitOrganization.contact?.website,
        },

        phones: nonProfitOrganization.phone_numbers ?? [],
        social_links: nonProfitOrganization.social_links ?? [],
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
        const updatedData = props.nonProfitOrganization?.data;

        if (
            updatedData.logo?.id !== form.logo.id ||
            updatedData.logo?.path !== form.logo.path
        ) {
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

    provide("form", form);
    provide("props", {
        economicSectors: props.economicSectors,
        legalEntityTypes: props.legalEntityTypes,
        marketReaches: props.marketReaches,
    });

    return {
        // attributes
        form,
        processing: computed(() => form.processing),
        // methods
        updateForm,
    };
};
