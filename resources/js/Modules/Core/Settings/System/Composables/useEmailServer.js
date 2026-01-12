import { useForm } from "@inertiajs/vue3"
import { error422 } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";
import { computed } from "vue";


export const useEmailServer = (props = {}) => {
    const { isLoading, setLoading } = useLoading(); 
    const mailSetting = props.mailSetting ?? {};

    const form = useForm({
        _method: 'patch',
        username: mailSetting.username ?? null,
        from_address: mailSetting.from_address ?? null,
        from_name: mailSetting.from_name ?? 'PIVITMor',
        host: mailSetting.host ?? null,
        port: mailSetting.port ?? null,
        trust: mailSetting.trust ?? null,
        encryption: mailSetting.encryption ?? 'tls',
        protocol: mailSetting.protocol ?? null,
        encoding: mailSetting.encoding ?? null,
        starttls_enabled: mailSetting.starttls_enabled !== undefined ? Boolean(mailSetting.starttls_enabled) : true,
        password: null,
        auth_enabled: mailSetting.auth_enabled !== undefined ? Boolean(mailSetting.auth_enabled) : true,
        debug: mailSetting.debug !== undefined ? Boolean(mailSetting.debug) : false,
    });

    const saveForm = () => {
            form.post(route(`mailSettings.update`), {
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

    return {
        // attributes
        processing: computed(() => form.processing),
        form,
        // methods
        saveForm,
    }
}