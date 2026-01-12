import { router } from '@inertiajs/vue3';
import { computed } from 'vue';

export const readMore = (item) => {
    router.visit(route("welcome.notices.details", {
        slug: item.slug,
        id: item.id
    }));
};

export const useNew = (notice = {}) => {
    const readingTime = computed(() => {
        if (!notice) return 0;

        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = notice;
        const cleanContent = tempDiv.textContent || tempDiv.innerText || "";
        const wordCount = cleanContent.trim().split(/\s+/).length;

        const textMinutes = wordCount / 200;

        const totalMinutes = Math.ceil(textMinutes);

        return totalMinutes > 0 ? totalMinutes : 1;
    });


    return {
        readingTime,
    }
};
