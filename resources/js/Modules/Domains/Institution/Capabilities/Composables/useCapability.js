import { error422, messageConfirm } from "@/Hooks/useErrorsForm";
import { router, useForm } from "@inertiajs/vue3";
import { reject } from "lodash";
import { computed, provide } from "vue";

export const useCapability = (props) => {
    const capability = props.capability?.data || {};

    const form = useForm({
        _method: capability.id ? "patch" : "post",
        title: capability.title,
        technical_description: capability.technical_description,
        problem_statement: capability.problem_statement,
        potential_applications: capability.potential_applications,
        start_date: capability?.start_date?.raw ?? null,
        end_date: capability?.end_date?.raw ?? null,

        keywords: capability?.keywords ?? [],
        activities: capability.activities?.map((activity) => activity.id) ?? [],
        knowledge_areas:
            capability.knowledge_areas?.map((knowledge) => knowledge.id) ?? [],
        oecd_sectors: capability.oecd_sectors?.map((sector) => sector.id) ?? [],
        economic_sectors:
            capability.economic_sectors?.map((sector) => sector.id) ?? [],
        academics: capability.academics?.map((academic) => academic.id) ?? [],
        files: capability?.files ?? [],
        photos: capability?.photos ?? [],

        capability_status_id: capability.capability_status_id ?? 1,
        intellectual_property_id: capability.intellectual_property_id ?? null,
        technology_level_id: capability.technology_level_id ?? null,
    });

    const storeForm = (isDraft = true) => {
        if (!isDraft) form.capability_status_id = 2;
        form.post(route(`${props.routeName}store`), {
            onError: () => {
                error422();
            },
        });
    };

    const updateForm = (isDraft = true) => {
        if (!isDraft) form.capability_status_id = 2;
        form.post(route(`${props.routeName}update`, capability?.id), {
            onError: () => {
                error422();
            },
        });
    };

    provide("form", form);
    provide("department", props.department);
    provide("intellectualProperties", props.intellectualProperties);
    provide("techLevels", props.techLevels);
    provide("activities", props.activities);
    provide("oecdSectors", props.oecdSectors);
    provide("economicSectors", props.economicSectors);
    provide("academics", props.academics);

    return {
        // attributes
        processing: computed(() => form.processing),
        // methods
        storeForm,
        updateForm,
    };
};

export const deleteCapability = async (capabilityId) => {
    const result = await messageConfirm();
    if (!result.isConfirmed) return;

    router.delete(route("capabilities.destroy", capabilityId));
};

export const enableCapability = async (capabilityId) => {
    router.patch(route("capabilities.enable", capabilityId), {
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
