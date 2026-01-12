import { error422 } from "@/Hooks/useErrorsForm";
import { useForm } from "@inertiajs/vue3";
import { provide, computed } from "vue";

export const useScheduleBackup = (props = {}, emits) => {
    const schedule = props.schedule?.data ?? {};
    const user = props.user?.data ?? {};

    const form = useForm({
        _method: "patch",
        backup_frequency_id: schedule?.backup_frequency?.id ?? null,
        time: schedule?.time ?? null,
        email_notification: false,
        email: user.email,
    });

    const updateForm = () => {
        form.post(route(`${props.routeName}schedule`), {
            onSuccess: () => {
                emits("close");
            },
            onError: () => {
                error422();
            }
        });
    };

    provide("form", form);
    provide("frequencies", props.frequencies);

    return {
        form,
        processing: computed(() => form.processing),
        updateForm,
    };
};