import { useForm } from "@inertiajs/vue3";
import { messageConfirm } from "@/Hooks/useErrorsForm";
import { error422 } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";

export const usePolicy = (props = {}) => {
    const { isLoading, setLoading } = useLoading();
    const privacityConfirm = props.privacityConfirmation?.data || {};

    const form = useForm({
        _method: "patch",
        is_accepted: privacityConfirm.is_accepted ?? false,
        user_id: privacityConfirm.user_id ?? null,
        privacity_compliance_id: privacityConfirm.privacity_compliance_id ?? (props.privacity?.data.id ?? null),
    });

    const acceptForm = () => {
        form.transform(data => ({
            ...data,
            is_accepted: true,
        })).post(route(`${props.routeName}accept`), {
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

    const denyForm = () => {
        messageConfirm().then((res) => {
            if (res.isConfirmed) {
                form.transform(data => ({
                    ...data,
                    is_accepted: false,
                })).post(route(`${props.routeName}accept`), {
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
            }
        });
    };

    return {
        acceptForm,
        denyForm,
    };

}