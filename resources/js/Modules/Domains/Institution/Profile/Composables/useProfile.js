import { error422 } from "@/Hooks/useErrorsForm";
import { useForm } from "@inertiajs/vue3";
import { provide, computed } from "vue";

export function useProfile(props) {
    const institution = props.institution.data || {};
    const location = institution?.location || {};

    const form = useForm({
        _method: "patch",
        name: institution.name,
        institution_category_id: institution.institution_type?.institution_category?.id ?? null,
        institution_type_id: institution.institution_type?.id ?? null,
        description: institution.description ?? null,

        logo: {
            id: institution.logo?.id ?? null,
            path: institution.logo?.path ?? null,
            file: null,
            delete_photo: false,
        },

        contact: {
            id: institution.contact?.id ?? null,
            name: institution.contact?.name,
            email: institution.contact?.email,
            website: institution.contact?.website,
        },

        phones: institution.phone_numbers ?? [],
        social_links: institution.social_links ?? [],

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

        reniecyt: {
            register_number: institution.reniecyt?.register_number ?? null,
            start_date: institution.reniecyt?.start_date ?? null,
            end_date: institution.reniecyt?.end_date ?? null,
        },

        oecd_sectors: institution.oecd_sectors?.map((sector) => sector.id) ?? [],
        knowledge_areas: institution.knowledge_areas?.map((knowledge) => knowledge.id) ?? [],
        economic_sectors: institution.economic_sectors?.map((economic) => economic.id) ?? [],

        keywords: institution.keywords ?? [],
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
        const updatedData = props.institution?.data;

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

    provide("form", form)
    provide("props", props)
    provide("knowledges", props.knowledges)
    provide("economicSectors", props.economicSectors)
    provide("oecdSectors", props.oecdSectors)

    return {
        processing: computed(() => form.processing),
        resetForm,
        updateForm,
    };
}