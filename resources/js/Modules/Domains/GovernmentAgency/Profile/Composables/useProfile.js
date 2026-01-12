import { computed, provide } from "vue";
import { useForm } from "@inertiajs/vue3";
import { error422 } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";

export function useProfile(props) {
    const governmentAgency = props.governmentAgency.data || {};
    const location = governmentAgency?.location || {};
    const { isLoading, setLoading } = useLoading();

    const isEditMode = computed(() => !!governmentAgency?.id);

    const form = useForm({
        _method: "patch",
        name: governmentAgency.name,
        acronym: governmentAgency.acronym ?? null,
        mission: governmentAgency.mission ?? null,
        vision: governmentAgency.vision ?? null,
        objectives: governmentAgency.objectives ?? null,
        government_level_id: governmentAgency.government_level_id ?? null,
        government_sector_id: governmentAgency.government_sector_id ?? null,

        logo: {
            id: governmentAgency.logo?.id ?? null,
            path: governmentAgency.logo?.path ?? null,
            file: null,
            delete_photo: false,
        },

        contact: {
            id: governmentAgency.contact?.id ?? null,
            name: governmentAgency.contact?.name,
            email: governmentAgency.contact?.email,
            website: governmentAgency.contact?.website,
        },

        phones: governmentAgency.phone_numbers ?? [],
        social_links: governmentAgency.social_links ?? [],
        keywords: governmentAgency.keywords ?? [],

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
    });

    const syncForm = () => {
        const updatedData = props.governmentAgency?.data;

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

    provide('form', form);
    provide('props', props);
    provide('isEditMode', isEditMode);

    const updateForm = () => {
        form.post(route(`${props.routeName}update`), {
            onStart: () => {
                setLoading(true);
            },
            onFinish: () => {
                setLoading(false);
            },
            onError: () => error422(),
        });
    };
    
    return {
        // attributes
        form,
        isEditMode,
        // methods
        updateForm,
        syncForm,
    };
}