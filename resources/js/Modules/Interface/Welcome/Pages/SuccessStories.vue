<template>
    <HeadLogo :title="title" />
    <LayoutWelcome>
        <SectionWrapper :has-layer="false">
            <div class="text-center mb-16">
                <TitleLineWithIcon class="mx-auto mb-6">
                    Casos de <strong class="font-extrabold">éxito</strong>
                </TitleLineWithIcon>
                <div class="w-24 h-1 mb-5 bg-wine-50 mx-auto rounded-full" />

                <p class="text-lg max-w-3xl mx-auto">
                    Descubre cómo la industria y la academia están transformado Morelos a través de nuestras historias
                    de éxito y testimonios.
                </p>
            </div>

            <div v-if="successStories.data.length > 0"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <CardSuccessStory v-for="(successStory, index) in successStories.data" :key="index"
                    :successStory="successStory">
                    <template #actions>
                        <a @click="openSuccessStory(successStory)"
                            class="text-wine-400 hover:text-wine-50 cursor-pointer font-bold flex items-center group">
                            Leer historia completa
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </template>
                </CardSuccessStory>
            </div>
            <CardBoxComponentEmpty v-else />
            <Pagination :links="successStories.meta.links" :total="successStories.meta.total"
                :to="successStories.meta.to" :from="successStories.meta.from" />
        </SectionWrapper>
    </LayoutWelcome>
    <ModalSuccessStory :show="isOpen" :successStory="successStory" @close="close" />
</template>
<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue';
import CardSuccessStory from '../Components/CardSuccessStory.vue';
import ModalSuccessStory from '../Components/ModalSuccessStory.vue';
import SectionWrapper from '../Components/SectionWrapper.vue';
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import { ref } from 'vue';
import { useModal } from '@/Hooks/useModal';
import Pagination from '@/Components/Pagination.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';

defineProps({
    title: {
        type: String,
        required: true,
    },
    successStories: {
        type: Object,
        default: () => ({}),
    }
})

const { isOpen, open, close } = useModal();
const successStory = ref(null);

const openSuccessStory = (story) => {
    successStory.value = story;
    if (story) open();
}
</script>