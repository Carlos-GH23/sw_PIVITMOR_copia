import { router, useForm } from "@inertiajs/vue3";
import { computed, provide } from "vue";
import { error422, messageConfirm } from "@/Hooks/useErrorsForm";

export const useJobOffer = (props) => {
    const { jobOffer } = props;

    const form = useForm({
        _method: jobOffer?.data.id ? "patch" : "post",

        position: jobOffer?.data.position ?? null,
        name: jobOffer?.data.name ?? null,
        gender: jobOffer?.data.gender ?? null,
        job_offer_type_id: jobOffer?.data.job_offer_type_id ?? null,
        academic_degree_id: jobOffer?.data.academic_degree_id ?? null,
        travel_requirements: jobOffer?.data.travel_requirements ?? null,
        start_date: jobOffer?.data.start_date ?? null,
        end_date: jobOffer?.data.end_date ?? null,
        job_description: jobOffer?.data.job_description ?? null,
        responsibilities: jobOffer?.data.responsibilities ?? null,
        skills_languages: jobOffer?.data.skills_languages ?? null,
        observations: jobOffer?.data.observations ?? null,
        comments: jobOffer?.data.comments ?? null,
        oecd_sectors: jobOffer?.data.oecd_sectors?.map(s => s.id) ?? [],
        economic_sectors: jobOffer?.data.economic_sectors?.map(s => s.id) ?? [],

        contact: {
            id: jobOffer?.data.contact?.id ?? null,
            name: jobOffer?.data.contact?.name ?? null,
            email: jobOffer?.data.contact?.email ?? null,
            website: jobOffer?.data.contact?.website ?? null,
        },

        phones: jobOffer?.data.phone_numbers ?? [],
        social_links: jobOffer?.data.social_links ?? [],
    });

    const storeForm = () => {
        form.post(
            route(`${props.routeName}store`),
            {
                preserveScroll: false,
                preserveState: true,
                onError: () => error422(),
            }
        );
    };

    const updateForm = () => {
        form.post(
            route(`${props.routeName}update`, jobOffer?.data.id),
            {
                preserveScroll: false,
                preserveState: true,
                onError: () => error422(),
            }
        );
    };

    provide("formJobOffer", form);

    return {
        processing: computed(() => form.processing),
        storeForm,
        updateForm,
    };
};

export const deleteJobOffer = (jobOfferId) => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            router.delete(route('jobOffers.destroy', jobOfferId));
        }
    });
};

export const enableJobOffer = async (jobOfferId) => {
    router.patch(route("jobOffers.enable", jobOfferId), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            resolve(true);
        },
        onError: () => {
            reject(false);
        },
    });
};

