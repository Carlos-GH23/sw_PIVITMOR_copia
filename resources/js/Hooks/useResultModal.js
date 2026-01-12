import { useLoading } from "@/Hooks/useLoading";
import { useModal } from "@/Hooks/useModal";
import { error404, error500 } from "@/Hooks/useErrorsForm";
import { ref } from "vue";
import axios from "axios";

export const useResultModal = () => {
    const resultDetails = ref(null);
    const initialData = ref(null);

    const { open, isOpen, close } = useModal();
    const { isLoading, setLoading } = useLoading();

    const openModal = async (data) => {
        resultDetails.value = null;
        initialData.value = data;

        open();
        await fetchDetails(data);
    };

    const closeModal = () => {
        close();

        setTimeout(() => {
            resultDetails.value = null;
            initialData.value = null;
        }, 300);
    };

    const fetchDetails = async (data) => {
        try {
            setLoading(true);
            const response = await axios.get(
                route("search.detail", {
                    type: data.resource_type,
                    id: data.id,
                })
            );
            resultDetails.value = response.data;
        } catch (error) {
            if (error.response.status === 404) {
                error404();
            } else if (error.response.status === 500) {
                error500();
            }
            closeModal();
        } finally {
            setLoading(false);
        }
    };

    return {
        isOpen,
        isLoading,
        initialData,
        resultDetails,
        // methods
        openModal,
        closeModal,
    };
};
