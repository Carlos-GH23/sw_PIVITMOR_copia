import { computed, ref } from "vue"
import { router } from "@inertiajs/vue3";
import { verifyPermission } from "@/Hooks/usePermissions";
import { error500, messageConfirm } from "@/Hooks/useErrorsForm";
import axios from "axios";
import { useLoading } from "@/Hooks/useLoading";

export const useMatch = (routeName, close) => {
    const match = ref(null)
    const { isLoading, setLoading } = useLoading()

    const fetchMatch = async (id) => {
        if (!id) return
        setLoading(true)
        try {
            const response = await axios.get(route('api.requirements.matches', id))
            match.value = response.data
        } catch (error) {
            error500()
        } finally {
            setLoading(false)
        }
    }

    const acceptForm = async () => {
        if (!match.value) return
        const res = await messageConfirm()
        if (res.isConfirmed) {
            router.post(route(`${routeName}accept`, match.value.id), {
                preserveScroll: true,
                onSuccess: close(),
            })
        }
    }

    const rejectForm = async () => {
        if (!match.value) return
        const res = await messageConfirm()
        if (res.isConfirmed) {
            router.post(route(`${routeName}reject`, match.value.id), {
                preserveScroll: true,
                onSuccess: close(),
            })
        }
    }

    const disableButtons = computed(() =>
        verifyPermission('requirements.matches.store') &&
        match.value?.match_status_id === 1
    )

    return {
        capability: computed(() => match.value?.capability),
        isLoading,
        //
        fetchMatch,
        acceptForm,
        rejectForm,
        disableButtons,
    }
}