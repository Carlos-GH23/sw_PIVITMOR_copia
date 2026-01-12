import { error422 } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";
import { useForm } from "@inertiajs/vue3"
import { provide } from "vue";

export const useEvaluation = (props) => {
    const { isLoading, setLoading } = useLoading();

    const form = useForm({
        capability_status_id: null,
        body: null,
        is_visible: true,
    });

     const storeForm = () => {
        form.post(route(`${props.routeName}store`, props.capability.data.id), {
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

    provide('capability', props.capability.data);

    return {
        // attributes
        form,
        processing: form.processing,
        // methods
        storeForm,
    };
}