import { router } from "@inertiajs/vue3";
import { ref, readonly } from "vue";
import { error500, messageConfirm } from "@/Hooks/useErrorsForm";
import { useModal } from "@/Hooks/useModal";
import axios from "axios";

export const useMatch = (routeName, setLoading) => {
    const match = ref({});
    const { isOpen, open, close } = useModal();

    const getMatch = async (id) => {
        if (!id) return null;

        setLoading(true);
        try {
            const response = await axios.get(
                route("api.capabilities.matches", id)
            );
            match.value = response.data;
            return response.data;
        } catch (error) {
            error500(error?.response.data.message);
            return null;
        } finally {
            setLoading(false);
        }
    };

    const performAction = async (action) => {
        if (!match.value?.id) return;

        const res = await messageConfirm();
        if (!res.isConfirmed) return;

        router.post(route(`${routeName}${action}`, match.value.id), {
            preserveScroll: true,
            onFinish: closeForm(),
        });
    };

    const openForm = async (item) => {
        const data = await getMatch(item.id);
        if (data) open();
    };

    const closeForm = () => {
        match.value = {};
        close();
    };

    return {
        isOpen,
        match: readonly(match),
        openForm,
        closeForm,
        onAccept: () => performAction("accept"),
        onReject: () => performAction("reject"),
    };
};
