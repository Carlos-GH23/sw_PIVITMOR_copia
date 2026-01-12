import { useForm, router } from "@inertiajs/vue3";
import { computed, provide } from "vue";
import { error422 } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";
import { messageConfirm } from "@/Hooks/useErrorsForm";

export const useEquipment = (routeName, facilityEquipment = {}) => {
    const { isLoading, setLoading } = useLoading();
    // Extrae los datos reales si vienen en facility.data
    const equipment = facilityEquipment?.data ?? facilityEquipment;
    const form = useForm({
        _method: equipment.id ? "patch" : "post",
        name: equipment.name ?? null,
        equipment_type_id: equipment.equipment_type_id ?? null,
        description: equipment.description ?? null,
        facility_id: equipment.facility_id ?? null,
        responsible_id: equipment.responsible_id ?? null,
        photos: equipment.photos ?? [],
        files: equipment.files ?? [],
        status: true,
        department_id: equipment.department_id ?? null,
    });

    const saveForm = () => {
        form.post(route(`${routeName}store`), {
            onBefore: () => {
                setLoading(true);
            },
            onError: () => {
                error422();
            },
            onFinish: () => {
                setLoading(false);
            },
        });
    };

    const updateForm = () => {
        form.post(route(`${routeName}update`, { equipment: equipment.id }), {
            onBefore: () => {
                setLoading(true);
            },
            onError: () => {
                error422();
            },
            onFinish: () => {
                setLoading(false);
            },
        });
    };

    const destroyForm = () => {
        messageConfirm().then((res) => {
            if (res.isConfirmed) {
                form.delete(route(`${routeName}destroy`, { equipment: equipment.id }));
            }
        });
    };

    const deleteForm = (equipment) => {
        messageConfirm().then((res) => {
            if (res.isConfirmed) {
                form.delete(route(`${routeName}destroy`, equipment));
            }
        });
    };

    const enable = (id) => {
            router.patch(route(`${routeName}enable`, id), {}, {
                preserveScroll: true,
            });
        };

    provide("form", form);

    return {
        // attributes
        form,
        processing: computed(() => form.processing),
        // methods
        saveForm,
        updateForm,
        destroyForm,
        deleteForm,
        enable,
    };
};
