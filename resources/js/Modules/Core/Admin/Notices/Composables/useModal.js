import { computed } from 'vue';

export const  useModal = (notice = {}, publicationDate = null) => {

    const formattedDate = computed(() => {
        if (!publicationDate) return 'fecha no establecida';
        const date = new Date(publicationDate);
        return new Intl.DateTimeFormat('es-MX', { year: 'numeric', month: 'long', day: '2-digit', timeZone: 'UTC' }).format(date);
    });

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
        formattedDate,
    }
};