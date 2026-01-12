import { useForm } from "@inertiajs/vue3";
import { computed, watch } from "vue";
import { error422 } from "./useErrorsForm";

export const useValidity = (props, emit) => {
    const form = useForm({
        start_date: props?.record?.start_date?.raw ?? null,
        end_date: props?.record?.end_date?.raw ?? null,
    });

    const close = () => {
        form.reset();
        form.clearErrors();
        emit("close");
    };

    const updateValidity = () => {
        form.patch(
            route(`${props.routeName}validity.update`, props.record.id),
            {
                preserveScroll: true,
                preserveState: true,
                onError: () => {
                    error422();
                },
                onSuccess: () => {
                    close();
                },
            }
        );
    };

    watch(
        () => props.show,
        (isShowing) => {
            if (isShowing && props?.record) {
                form.start_date = props?.record?.start_date?.raw ?? null;
                form.end_date = props?.record?.end_date?.raw ?? null;
            }
        }
    );

    return {
        // attributes
        form,
        // methods
        close,
        updateValidity,
    };
};
