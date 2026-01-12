import { error422 } from "@/Hooks/useErrorsForm";
import { useForm } from "@inertiajs/vue3";
import { provide, watch, computed } from "vue";

export const useProfile = (props = {}) => {
    const academic = props.academic.data || {};
    const location = academic?.location || {};

    const form = useForm({
        _method: "patch",
        first_name: academic.first_name,
        last_name: academic.last_name,
        second_last_name: academic.second_last_name ?? null,
        gender: academic.gender,
        biography: academic.biography,

        photo: {
            id: academic.photo?.id ?? null,
            path: academic.photo?.path ?? null,
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
            id: academic.contact?.id ?? null,
            email: academic.contact?.email,
            website: academic.contact?.website,
        },

        phones: academic.phone_numbers ?? [],
        social_links: academic.social_links ?? [],

        department_id: academic.department?.id,
        research_lines: academic.research_lines?.map(line => line.id) ?? [],
        academic_bodies: academic.academic_bodies?.map(body => body.id) ?? [],
        knowledge_lines: academic?.knowledge_lines ?? [],

        sni: {
            has_sni: !!academic.sni_membership,
            number: academic.sni_membership?.number ?? null,
            start_date: academic.sni_membership?.start_date ?? null,
            end_date: academic.sni_membership?.end_date ?? null,
            research_area_id: academic.sni_membership?.research_area_id ?? null,
            sni_level_id: academic.sni_membership?.sni_level_id ?? null,
        },

        profile: {
            has_profile: !!(academic.desirable_profile?.start_date && academic.desirable_profile?.end_date),
            start_date: academic.desirable_profile?.start_date ?? null,
            end_date: academic.desirable_profile?.end_date ?? null,
        },

        oecd_sectors: academic.oecd_sectors?.map((sector) => sector.id) ?? [],
        economic_sectors: academic.economic_sectors?.map((economic) => economic.id) ?? [],
    });

    watch(() => form.profile.has_profile, (value) => {
        if (!value) {
            form.profile.start_date = null;
            form.profile.end_date = null;
        }
    });

    watch(() => form.sni.has_sni, (value) => {
        if (!value) {
            form.sni.number = null;
            form.sni.sni_level_id = null;
            form.sni.research_area_id = null;
            form.sni.start_date = null;
            form.sni.end_date = null;
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
        const updatedData = props.academic?.data;

        if (updatedData.photo?.id !== form.photo.id || updatedData.photo?.path !== form.photo.path) {
            form.photo.id = updatedData.photo?.id ?? null;
            form.photo.path = updatedData.photo?.path ?? null;
            form.photo.file = null;
            form.photo.delete_photo = false;
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

    provide("form", form)
    provide('props', props)
    provide("academic", props.academic)
    provide("departments", props.departments)
    provide("researchAreas", props.researchAreas)
    provide("oecdSectors", props.oecdSectors)
    provide("economicSectors", props.economicSectors)
    provide("researchLevels", props.researchLevels)
    provide("sniiLevels", props.sniiLevels)
    provide("genders", props.genders)

    return {
        processing: computed(() => form.processing),
        updateForm,
    };
};
