import { error422 } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";
import { useForm } from "@inertiajs/vue3";
import { computed, provide } from "vue";

export const useCommunications = (props = {}) => {
    const { isLoading, setLoading } = useLoading();
    const routeName = props.routeName || "";



    const form = useForm({
        _method: "post",
        subject: null,
        recipients: null,
        status: null,
        files: [],
        body: null,
        footer: null,
    });

    const storeForm = () => {
        form.post(
            route(`${routeName}email`),
            {
                onBefore: () => setLoading(true),
                onError: () => error422(),
                onFinish: () => setLoading(false),
            }
        );
    };

    provide("form", form);
    provide("roles", props.roles);
    provide("statuses", props.statuses);

    return {
        // attributes
        //form,
        processing: computed(() => form.processing),
        // methods
        storeForm,
    };

};