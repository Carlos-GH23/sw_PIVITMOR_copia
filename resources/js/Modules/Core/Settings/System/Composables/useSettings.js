import { useForm } from "@inertiajs/vue3"
import { error422 } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";
import { computed } from "vue";


export const useSettings = (props = {}, emit) => {
    const { isLoading, setLoading } = useLoading();
    const consentConfigurations = props.consentConfigurations ?? {};

    const form = useForm({
        _method: 'patch',
        data_usage_consent: consentConfigurations.data_usage_consent !== undefined ? Boolean(consentConfigurations.data_usage_consent) : false,
        force_acceptance: consentConfigurations.force_acceptance !== undefined ? Boolean(consentConfigurations.force_acceptance) : false,
        electronic_communication_consent: consentConfigurations.electronic_communication_consent !== undefined ? Boolean(consentConfigurations.electronic_communication_consent) : false,
        electronic_communication_message: consentConfigurations.electronic_communication_message ?? null,
        statistical_data_consent: consentConfigurations.statistical_data_consent !== undefined ? Boolean(consentConfigurations.statistical_data_consent) : false,
        statistical_data_message: consentConfigurations.statistical_data_message ?? null,
        frequency_of_acceptance: consentConfigurations.frequency_of_acceptance ?? null,
    });
    

    const saveForm = () => {
        form.post(route(`consentConfiguration.update`), {
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