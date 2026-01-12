
import { router, useForm } from "@inertiajs/vue3";
import { computed, provide } from "vue";
import { error422, messageConfirm } from "@/Hooks/useErrorsForm";
import { verifyPermission } from "@/Hooks/usePermissions";


export const useService = (props) => {
    const { service } = props;

    const form = useForm({
        _method: service?.data.id ? "patch" : "post",

        photos: service?.data.photos ?? [],
        title: service?.data.title ?? null,
        technical_description: service?.data.technical_description ?? null,
        start_date: service?.data.start_date?.raw ?? null,
        end_date: service?.data.end_date?.raw ?? null,

        technology_service_type_id: service?.data.service_type_id ?? null,
        technology_service_category_id: service?.data.service_category_id ?? null,
        department_id: service?.data.department_id ?? null,

        oecd_sectors: service?.data.oecd_sectors?.map(s => s.id) ?? [],
        economic_sectors: service?.data.economic_sectors?.map(s => s.id) ?? [],
        academics: service?.data.academics?.map(a => a.id) ?? [],
        facilities: service?.data.facilities?.map(f => f.id) ?? [],
        equipments: service?.data.equipments?.map(e => e.id) ?? [],
        keywords: service?.data.keywords ?? [],
        files: service?.data.files ?? [],
        technology_service_status_id: service?.data.technology_service_status_id ?? 1,
    });

    const storeForm = (isDraft = true) => {
        if (!isDraft) form.technology_service_status_id = verifyPermission('technologyServices.evaluations.store') ? 3 : 2;
        form.post(route(`${props.routeName}store`), {
            preserveScroll: false,
            preserveState: true,
            onError: () => {
                form.reset('technology_service_status_id');
                error422()
            },
        });
    };

    const updateForm = (isDraft = true) => {
        if (!isDraft) form.technology_service_status_id = verifyPermission('technologyServices.evaluations.store') ? 3 : 2;
        form.post(route(`${props.routeName}update`, service?.data.id), {
            preserveScroll: false,
            preserveState: true,
            onError: () => {
                form.reset('technology_service_status_id');
                error422()
            },
        });
    };

    provide("form", form);
    provide("oecdSectors", props.oecdSectors);
    provide("economicSectors", props.economicSectors);
    provide("serviceTypes", props.serviceTypes);
    provide("serviceCategories", props.serviceCategories);
    provide("departments", props.departments);
    provide("academics", props.academics);
    provide("facilities", props.facilities);
    provide("equipments", props.equipments);

    return {
        processing: computed(() => form.processing),
        storeForm,
        updateForm,
    };
};


export const deleteService = async (serviceId) => {
    const result = await messageConfirm();
    if (!result.isConfirmed) return;
    router.delete(route("technologyServices.destroy", serviceId));
};

export const enableService = async (serviceId) => {
    return new Promise((resolve) => {
        router.patch(route("technologyServices.enable", serviceId), {
            onSuccess: () => resolve(true),
            onError: () => resolve(false),
        });
    });
};