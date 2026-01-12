import { router, useForm } from "@inertiajs/vue3";
import { computed, provide } from "vue";
import { error422, messageConfirm } from "@/Hooks/useErrorsForm";
import { verifyPermission } from "@/Hooks/usePermissions";

export const useRequirement = (props) => {
    const { requirement } = props;

    const form = useForm({
        _method: requirement?.data.id ? "patch" : "post",

        photos: requirement?.data.photos ?? [],
        title: requirement?.data.title ?? null,
        technical_description: requirement?.data.technical_description ?? null,
        need_statement: requirement?.data.need_statement ?? null,
        potential_applications: requirement?.data.potential_applications ?? null,
        start_date: requirement?.data.start_date?.raw ?? null,
        end_date: requirement?.data.end_date?.raw ?? null,

        requirement_status_id: requirement?.data.requirement_status_id ?? 1,
        intellectual_property_id: requirement?.data.intellectual_property_id ?? null,
        technology_level_id: requirement?.data.technology_level_id ?? null,

        oecd_sectors: requirement?.data.oecd_sectors?.map(s => s.id) ?? [],
        economic_sectors: requirement?.data.economic_sectors?.map(s => s.id) ?? [],
        keywords: requirement?.data.keywords ?? [],
    });

    const storeForm = (isDraft = true) => {
        if (!isDraft) form.requirement_status_id = verifyPermission('requirements.evaluations.store') ? 3 : 2;
        form.post(route(`${props.routeName}store`), {
            preserveScroll: false,
            preserveState: true,
            onError: () => {
                form.reset('requirement_status_id')
                error422()
            },
        });
    };

    const updateForm = (isDraft = true) => {
        if (!isDraft) form.requirement_status_id = verifyPermission('requirements.evaluations.store') ? 3 : 2;
        form.post(route(`${props.routeName}update`, requirement?.data.id), {
            preserveScroll: false,
            preserveState: true,
            onError: () => {
                form.reset('requirement_status_id')
                error422()
            },
        });
    };

    provide("requirementForm", form);

    return {
        processing: computed(() => form.processing),
        storeForm,
        updateForm,
        deleteForm,
    };
};

export const deleteForm = async (requirement) => {
    const result = await messageConfirm();
    if (!result.isConfirmed) return;

    router.delete(route("requirements.destroy", requirement));
};

export const enableForm = async (requirement) => {
    router.patch(route("requirements.enable", requirement), {
        onSuccess: () => {
            resolve(true);
        },
        onError: () => {
            resolve(false);
        }
    });
};
