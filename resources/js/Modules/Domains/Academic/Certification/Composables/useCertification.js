import { useForm, router } from "@inertiajs/vue3";
import { provide, computed } from "vue";
import { messageConfirm } from "@/Hooks/useErrorsForm";
import { error422 } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";
import { watch } from "vue";

export const useCertification = (props = {}) => {
    const { isLoading, setLoading } = useLoading();

    const certification = props.certification?.data || {};

    const form = useForm({
        _method: certification.id ? "patch" : "post",
        name: certification.name ?? null,
        description: certification.description ?? null,
        certification_level_id: certification.certification_level_id ?? null,
        certifying_entity: certification.certifying_entity ?? null,
        accreditation_entity_id: certification.accreditation_entity_id ?? null,
        country_id: certification.country_id ?? null,
        status_id: certification.status_id ?? null,
        issue_date: certification.issue_date ?? null,
        expiry_date: certification.expiry_date ?? null,
        validity_duration: certification.validity_duration ?? null,
        is_active: certification.is_active !== undefined ? Boolean(certification.is_active) : true,

        files: certification.files ?? [],
    });

    const calculateMonthDifference = (startDate, endDate) => {
        if (!startDate || !endDate) {
        }

        const d1 = new Date(startDate);
        const d2 = new Date(endDate);

        if (isNaN(d1.getTime()) || isNaN(d2.getTime()) || d1 > d2) {
            return null;
        }

        let yearDiff = d2.getFullYear() - d1.getFullYear();
        let monthDiff = d2.getMonth() - d1.getMonth();
        let dayDiff = d2.getDate() - d1.getDate();

        if (dayDiff < 0) {
            monthDiff--;
        }

        const totalMonths = (yearDiff * 12) + monthDiff;
        return totalMonths < 0 ? 0 : totalMonths;
    };

    watch(
        () => [form.issue_date, form.expiry_date],
        ([newIssueDate, newExpiryDate]) => {
            form.validity_duration = calculateMonthDifference(newIssueDate, newExpiryDate);
        },
        { immediate: true }
    );

    provide('form', form);
    provide('countries', props.countries);
    provide('levels', props.levels);
    provide('entities', props.entities);
    provide('statuses', props.statuses);

    const saveForm = () => {
        form.post(route(`${props.routeName}store`), {
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

    const updateForm = () => {
        form.post(route(`${props.routeName}update`, { certification: certification.id }), {
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

    const destroyForm = () => {
        messageConfirm().then((res) => {
            if (res.isConfirmed) {
                form.delete(route(`${props.routeName}destroy`, { certification: certification.id }));
            }
        });
    };

    const deleteForm = (certification) => {
        messageConfirm().then((res) => {
            if (res.isConfirmed) {
                form.delete(route(`${props.routeName}destroy`, { certification: certification.id }));
            }
        });
    };

    const enable = (id) => {
                router.patch(route(`${props.routeName}enable`, id), {}, {
                    preserveScroll: true,
                });
            };

    return {
        processing: computed(() => form.processing),
        saveForm,
        updateForm,
        destroyForm,
        deleteForm,
        enable,
        form,
    };
};