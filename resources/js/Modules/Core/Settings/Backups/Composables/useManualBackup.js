import { useForm } from "@inertiajs/vue3";
import { error422 } from "@/Hooks/useErrorsForm";

export const useManualBackup = (routeName, emits) => {
    const form = useForm({
        name: null,
        description: null,
        is_encrypted: false,
    });

    const storeBackup = () => {
        form.post(route(`${routeName}store`), {
            onSuccess: () => {
                emits("close");
                form.reset();
            },
            onError: () => {
                error422();
            },
        });
    };

    return {
        // attributes
        form,
        processing: form.processing,
        storeBackup
    }
}