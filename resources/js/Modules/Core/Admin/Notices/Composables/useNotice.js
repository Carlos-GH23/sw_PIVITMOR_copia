import { error422, messageConfirm } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";
import { useForm } from "@inertiajs/vue3";
import { computed, provide, onMounted } from "vue";
import { ref } from "vue";

export const useNotice = (props = {}) => {
    const { isLoading, setLoading } = useLoading();
    const notice = props.notice?.data || {};

    const isEditMode = computed(() => !!notice?.id);

    const form = useForm({
        _method: notice.id ? "patch" : "post",
        title: notice.title ?? null,
        subtitle: notice.subtitle ?? null,
        news_category_id: notice.news_category_id ?? null,
        abstract: notice.abstract ?? null,
        notice_body: notice.notice_body ?? null,
        notice_source: notice.notice_source ?? null,
        photo: {
            id: notice.photo?.id ?? null,
            path: notice.photo?.path ?? null,
            file: null,
            delete_photo: false,
            description: notice.photo?.description ?? null,
        },
        author: notice.author ?? null,
        creation_date: notice.creation_date ?? null,
        publication_date: notice.publication_date ?? null,
        notice_status_id: notice.notice_status_id ?? 1,
        comments_enabled: notice.comments_enabled ?? 1,
        email_notification: notice.email_notification ?? 2,

        keywords: notice.keywords ?? [],
    });

    const storeForm = (isDraft = true) => {
        isDraft === true ? form.notice_status_id = 1 : form.notice_status_id = 2;
        form.transform(data => ({
            ...data,
            is_draft: isDraft,
        })).post(
            route(`${props.routeName}store`),
            {
                onBefore: () => setLoading(true),
                onError: () => error422(),
                onFinish: () => setLoading(false),
            }
        );
    };

    const updateForm = (isDraft = true) => {
        isDraft !== false ? form.notice_status_id = 1 : form.notice_status_id = 2;
        form.transform(data => ({
            ...data,
            is_draft: isDraft,
        })).post(
            route(`${props.routeName}update`, notice?.id),
            {
                onBefore: () => setLoading(true),
                onError: () => error422(),
                onFinish: () => setLoading(false),
            }
        );
    };

    const destroyForm = () => {
        messageConfirm().then((res) => {
            if (res.isConfirmed) {
                form.delete(route(`${props.routeName}destroy`, { notice: notice.id }));
            }
        });
    };

    const deleteForm = (notice) => {
        messageConfirm().then((res) => {
            if (res.isConfirmed) {
                form.delete(route(`${props.routeName}destroy`, notice));
            }
        });
    };


    provide("form", form);
    provide("statuses", props.statuses);
    provide("categories", props.categories);
    provide('isEditMode', isEditMode);

    onMounted(() => {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;

        form.creation_date ??= formattedDate;
    });

    return {
        // attributes
        // form,
        processing: computed(() => form.processing),
        // methods
        storeForm,
        updateForm,
        destroyForm,
        deleteForm,
    };

};

export const previewNotice = () => {
    const showFile = ref(false);

    const openModal = () => {
        showFile.value = true;
    };

    const closeModal = () => {
        showFile.value = false;
    };

    return {
        showFile,
        openModal,
        closeModal,
    };
};
