import { useForm } from "@inertiajs/vue3"
import { error422 } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";
import { computed } from "vue";


export const usePrivacity = (props = {}, emit) => {
    const { isLoading, setLoading } = useLoading();
    //const policies = props.policies ?? {};

    const form = useForm({
        _method: 'put',
        version: null,
        effective_date: null,
        privacity_advice: null,
        is_active: true,
    });


    const saveForm = () => {
        form.post(route(`privacityCompliance.store`), {
            onBefore: () => {
                setLoading(true);
            },
            onError: () => {
                error422();
            },
            onFinish: () => {
                setLoading(false);
            },
            onSuccess: () => {
                emit('close');
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