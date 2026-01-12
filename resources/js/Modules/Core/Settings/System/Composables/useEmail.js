import { useForm } from "@inertiajs/vue3"
import { useLoading } from "@/Hooks/useLoading";

export const useEmail = (props = {}) => {
    const { isLoading, setLoading } = useLoading();
    const templates = props.emailTemplates?.data ?? {};

    const form = useForm({
        _method: 'patch',
        key: null,
        subject: null,
        body: null,
        variables: [],
        footer: null,
        selectedTemplate: null,
        name: null,
    });

    const setTemplate = () => {
        const template = templates.find(t => t.id === form.selectedTemplate);

        form.key = template.key;
        form.subject = template.subject;
        form.body = template.body;
        form.variables = template.available_variables;
        form.name = template.name;
        form.footer = template.footer;
    }

    const saveForm = () => {
        if (!form.selectedTemplate) return;
        form.post(route(`emailTemplates.update`, form.selectedTemplate), {
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
        processing: form.processing,
        form,
        setTemplate,
        saveForm,
    }
}