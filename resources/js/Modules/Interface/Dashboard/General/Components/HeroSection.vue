<template>
    <div class="relative flex flex-col justify-center items-center p-6 lg:p-8 text-center text-white
             rounded-xl min-h-[180px] h-full w-full overflow-hidden">

        <div class="absolute inset-0 w-full h-full">
            <img :src="institution.logo || IMAGES.ccytem.src"
                :alt="institution.name || IMAGES.ccytem.alt"
                class="w-full h-full object-cover object-center blur-md select-none pointer-events-none"
                draggable="false" />
            <div class="absolute inset-0 w-full h-full bg-forest-900/60"></div>
        </div>

        <div class="relative z-10 space-y-6">
            <div class="w-24 h-24 lg:w-28 lg:h-28 mx-auto rounded-full flex items-center justify-center
                   border-4 border-white bg-white shadow-2xl overflow-hidden animate-fade-in">
                <div class="w-20 h-20 lg:w-24 lg:h-24 rounded-full bg-white flex items-center justify-center">
                    <img :src="institution.logo || IMAGES.ccytem.src"
                        :alt="institution.name || IMAGES.ccytem.alt" loading="lazy"
                        class="object-contain w-full h-full rounded-full" />
                </div>
            </div>

            <h1
                class="text-xl lg:text-2xl font-bold mb-2 text-balance leading-tight drop-shadow-lg animate-slide-in-up">
                {{ institution.name || 'CCYTEM' }}
            </h1>
        </div>
    </div>
</template>
<script setup>
import { IMAGES } from '@/Utils/Image';

const props = defineProps({
    institution: {
        type: Object,
        default: () => ({
            name: '',
            logo: null
        })
    }
});

</script>
<style scoped>
/* Animaciones y scrollbar (mantener las variables CSS si ya las corregiste) */
@keyframes fade-in {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes slide-in-up {
    from {
        transform: translateY(20px);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.animate-fade-in {
    animation: fade-in 1s ease-out forwards;
}

.animate-slide-in-up {
    animation: slide-in-up 0.8s ease-out forwards;
}

.animate-fade-in-delay {
    animation: fade-in 1.2s ease-out 0.3s forwards;
    opacity: 0;
}

.animate-pulse-dots div:nth-child(1) {
    animation: pulse 1.5s infinite ease-in-out;
}

.animate-pulse-dots div:nth-child(2) {
    animation: pulse 1.5s infinite ease-in-out 0.3s;
}

.animate-pulse-dots div:nth-child(3) {
    animation: pulse 1.5s infinite ease-in-out 0.6s;
}

@keyframes pulse {

    0%,
    100% {
        opacity: 1;
        transform: scale(1);
    }

    50% {
        opacity: 0.5;
        transform: scale(0.8);
    }
}

.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: var(--tw-bg-gray-100);
    border-radius: 10px;
}

.dark .custom-scrollbar::-webkit-scrollbar-track {
    background: var(--tw-bg-slate-700);
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: var(--tw-bg-blue-300);
    border-radius: 10px;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background: var(--tw-bg-blue-600);
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: var(--tw-bg-blue-400);
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: var(--tw-bg-blue-500);
}
</style>