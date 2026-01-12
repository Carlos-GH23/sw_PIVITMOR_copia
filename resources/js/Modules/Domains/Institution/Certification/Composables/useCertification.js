import { useForm, router } from "@inertiajs/vue3";
import { computed, provide } from "vue";
import { messageConfirm } from "@/Hooks/useErrorsForm";

export const useCertification = (routeName, certification = {}) => {
    const certificationData = certification?.data ?? certification;
    const form = useForm({
        _method: certificationData.id ? "patch" : "post",
        name: certificationData.name ?? null,
        certification_type_id: certificationData.certification_type_id ?? null,
        description: certificationData.description ?? null,
        certifying_entity: certificationData.certifying_entity ?? null,
        resource_type_id: certificationData.resource_type_id ?? null,
        department_id: certificationData.department_id ?? null,
        certified_resource_id: certificationData.certified_resource_id ?? null,
        files: certificationData.files ?? [],
    });

    const saveForm = () => {
        form.post(route(`${routeName}store`));
    };

    const updateForm = () => {
        form.post(
            route(`${routeName}update`, { certification: certificationData.id })
        );
    };

    const destroyForm = () => {
        form.delete(
            route(`${routeName}destroy`, {
                certification: certificationData.id,
            })
        );
    };

    const deleteForm = (certification) => {
        messageConfirm().then((res) => {
            if (res.isConfirmed) {
                form.delete(route(`${routeName}destroy`, certification));
            }
        });
    };

    provide("form", form);

    return {
        form,
        processing: computed(() => form.processing),
        saveForm,
        updateForm,
        destroyForm,
        deleteForm,
    };
};

export const enableCertification = async (certificationId) => {
    router.patch(route("institutions.certifications.enable", certificationId), {
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
