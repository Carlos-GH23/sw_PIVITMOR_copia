import {
    mdiNumeric1Circle,
    mdiNumeric2Circle,
    mdiNumeric3Circle,
    mdiNumeric4Circle,
    mdiNumeric5Circle,
} from "@mdi/js";
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";

export const tabs = [
    
    {
        value: "info",
        icon: mdiNumeric1Circle,
        name: "Información general",
        fields: [
            "title",
            "subtitle",
            "news_category_id",
            "objective",
            "profile",
            "keywords",
        ],
    },
    {
        value: "content",
        icon: mdiNumeric2Circle,
        name: "Contenido",
        fields: [
            "abstract",
            "notice_body",
            "notice_source",
        ],
    },
    {
        value: "multimedia",
        icon: mdiNumeric3Circle,
        name: "Multimedia",
        fields: [
            "photo",
            "photo.file",
            "photo.description",
        ],
    },
    {
        value: "metadata",
        icon: mdiNumeric4Circle,
        name: "Metadatos de publicación",
        fields: [
            "author",
            "creation_date",
            "publication_date",
            "notice_status_id",
            "comments_enabled",
            "email_notification",
        ],
    },
];

const activeTab = ref("info");

export const useTabs = () => {
        const errors = computed(() => usePage().props.errors);
    
        const fieldMatchesError = (fieldPattern, errorKey) => {
            if (!fieldPattern.includes('*')) {
                return fieldPattern === errorKey;
            }
            const regexPattern = fieldPattern
                .replace(/\./g, '\\.')
                .replace(/\*/g, '\\d+');
            
            const regex = new RegExp(`^${regexPattern}$`);
            return regex.test(errorKey);
        };
    
        const tabErrors = computed(() => {
            return tabs.reduce((acc, tab) => {
                if (!tab.fields) {
                    acc[tab.value] = false;
                    return acc;
                }
    
                acc[tab.value] = tab.fields.some((field) => {
                    if (errors.value[field]) {
                        return true;
                    }
    
                    if (field.includes('*')) {
                        return Object.keys(errors.value).some(errorKey => 
                            fieldMatchesError(field, errorKey)
                        );
                    }
                    return false;
                });
    
                return acc;
            }, {});
        });

    return {
        activeTab,
        step: computed(() => tabs.findIndex((tab) => tab.value === activeTab.value)),
        tabErrors,
    };
};
