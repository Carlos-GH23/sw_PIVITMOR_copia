import { useForm } from "@inertiajs/vue3"
import { error422 } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";
import { computed } from "vue";

export const usePolitic = (props = {}) => {
    const { isLoading, setLoading } = useLoading();
    const policies = props.policies ?? {};

    const form = useForm({
        _method: 'patch',
        cookies_policy: policies?.cookies_policy ?? null,
        terms_and_conditions: policies?.terms_and_conditions ?? null,
        legal_references: policies?.legal_references ?? null,
    });

    

    const saveForm = () => {
        form.post(route(`policy.update`), {
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

    return {
        // attributes
        processing: computed(() => form.processing),
        form,
        // methods
        saveForm,

    }
}