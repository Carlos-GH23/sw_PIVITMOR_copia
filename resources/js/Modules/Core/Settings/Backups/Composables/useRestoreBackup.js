import { messageConfirm, error422 } from "@/Hooks/useErrorsForm";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

export const useRestoreBackup = (routeName, emits) => {
    const page = usePage();
    const backupsData = computed(() => page.props.availableBackups.data || []);

    const form = useForm({
        backup_id: null,
    });

    const selectedBackup = computed(() =>
        backupsData.value.find((backup) => backup.id === form.backup_id) || {}
    );

    const restore = async () => {
        const result = await messageConfirm();
        if (!result.isConfirmed) return;

        form.post(route(`${routeName}restore`), {
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
        form,
        processing: form.processing,
        backupsData,
        selectedBackup,
        restore,
    };
};
