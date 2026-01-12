import { useForm, router } from "@inertiajs/vue3";
import { computed, provide } from "vue";
import { messageConfirm } from "@/Hooks/useErrorsForm";
import { error422 } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";


export const useFacility = (routeName, facility = {}) => {
    // Extrae los datos reales si vienen en facility.data
    const { isLoading, setLoading } = useLoading();
    const realFacility = facility?.data ?? facility;
    const form = useForm({
        _method: realFacility.id ? "patch" : "post",
         name: realFacility.name ?? null,
        facility_type_id: realFacility.facility_type_id ?? null,
        description: realFacility.description ?? null,
        department_id: realFacility.department_id ?? null,
        photos: realFacility.photos ?? [],
        files: realFacility.files ?? [],
        equipments: realFacility.equipments ?? [],
        is_active: true,

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
        form.post(route(`${routeName}update`, { facility: realFacility.id }), {
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
                form.delete(route(`${routeName}destroy`, { facility: realFacility.id }));
            }
        });
    };

    const deleteForm = (facility) => {
            messageConfirm().then((res) => {
            if (res.isConfirmed) {
                    form.delete(route(`${routeName}destroy`, facility));
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
