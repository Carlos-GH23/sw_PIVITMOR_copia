<template>
    <div class="space-y-6 text-center">
        <TitleLineWithIcon class="mx-auto mb-6">
            <strong class="font-extrabold">Preguntas</strong> frecuentes
        </TitleLineWithIcon>

        <div v-if="isLoading" class="py-10 text-center text-gray-500">
            Cargando preguntas frecuentes...
        </div>
        <div v-else>
            <Accordion type="single" class="w-full" collapsible>
                <AccordionItem v-for="item in displayedFaqs" :key="item.id" :value="`value-${item.id}`"
                    class="bg-mono-100 mb-5 shadow p-5">
                    <AccordionTrigger>
                        <div class="cursor-pointer text-lg hover:font-bold">
                            {{ item.question }}
                        </div>
                    </AccordionTrigger>
                    <AccordionContent>
                        <div class="text-start">
                            {{ item.answer }}
                        </div>
                    </AccordionContent>
                </AccordionItem>
            </Accordion>
            <div v-if="faq.length > 4" @click="showAllFaqs = !showAllFaqs"
                class="mt-2 text-wine-500 font-semibold cursor-pointer hover:underline">
                {{ showAllFaqs ? 'ver menos' : 'ver más' }}
            </div>
            <div v-if="error" class="text-red-500 mt-4">{{ error }}</div>
        </div>

        <div class="pt-4 flex flex-col items-center gap-4">
            <img :src="ICONS.assistantWine.src" class="w-44" :alt="ICONS.assistantWine.alt" loading="lazy" />
            <button @click="openChat"
                class="bg-wine-400 w-fit text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl cursor-pointer">
                Preguntar al asistente virtual
            </button>
        </div>
    </div>
</template>

<script setup>
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from "@/Components/ui/accordion"
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import { inject, ref, onMounted, computed } from 'vue';
import { ICONS } from '@/Utils/Icons';

const openChat = inject('openChat')

const faq = ref([]);
const isLoading = ref(true);
const error = ref('');
const showAllFaqs = ref(false);
const displayedFaqs = computed(() => showAllFaqs.value ? faq.value : faq.value.slice(0, 4));

onMounted(async () => {
    try {
        const res = await fetch('/api/faqs');
        faq.value = await res.json();
    } catch (e) {
        error.value = 'No se pudieron cargar las preguntas frecuentes.';
        faq.value = [];
    } finally {
        isLoading.value = false;
    }
});
</script>