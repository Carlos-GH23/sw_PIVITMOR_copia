import { error422, messageConfirm } from "@/Hooks/useErrorsForm";
import { useForm, router } from "@inertiajs/vue3";
import { provide, computed } from "vue";

export const useResearchLine = (props = {}) => {
    const researchLine = props.researchLine?.data || {};

    const isEditMode = computed(() => !!researchLine?.id);

    const form = useForm({
        _method: researchLine?.id ? "patch" : "post",
        name: researchLine.name,
        description: researchLine.description,
        department_id: researchLine.department?.id ?? null,
        academics: researchLine.academics?.map(academic => academic.id) ?? [],
        economic_sectors: researchLine.economic_sectors?.map(economic => economic.id) ?? [],
        oecd_sectors: researchLine.oecd_sectors?.map(sector => sector.id) ?? [],
        keywords: researchLine.keywords ?? [],
        files: researchLine.files ?? [],

        logo: {
            id: researchLine.logo?.id ?? null,
            path: researchLine.logo?.path ?? null,
            file: null,
            delete_photo: false,
        },
    });

    const storeForm = () => {
        form.post(
            route(`${props.routeName}store`),
            {
                onError: () => {
                    error422();
                },
            }
        );
    };

    const updateForm = () => {
        form.post(
            route(`${props.routeName}update`, researchLine.id),
            {
                onError: () => {
                    error422();
                },
                onSuccess: () => {
                    syncForm();
                },
            }
        );
    };

    const deleteForm = (id) => {
        messageConfirm().then((res) => {
            if (res.isConfirmed) {
                router.delete(route(`${props.routeName}destroy`, id), {
                    preserveState: false,
                });
            }
        });
    };

    const enable = (id) => {
        router.patch(route(`${props.routeName}enable`, id), {}, {
            preserveScroll: true,
        });
    };

    const syncForm = () => {
        const updatedData = props.researchLine?.data;

        if (updatedData.logo?.id !== form.logo.id || updatedData.logo?.path !== form.logo.path) {
            form.logo.id = updatedData.logo?.id ?? null;
            form.logo.path = updatedData.logo?.path ?? null;
            form.logo.file = null;
            form.logo.delete_photo = false;
        }
    };

    provide("form", form);
    provide("isEditMode", isEditMode);
    provide("props", props);
    provide("economicSectors", props.economicSectors);
    provide("oecdSectors", props.oecdSectors);
    provide("departments", props.departments);
    provide("academics", props.academics);

    return {
        processing: computed(() => form.processing),
        storeForm,
        updateForm,
        deleteForm,
        enable,
    };
}