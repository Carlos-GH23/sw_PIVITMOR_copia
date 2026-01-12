<template>
    <div class="text-center">
        <TitleLineWithIcon class="mx-auto mb-6">
            <strong class="font-extrabold">Preguntas</strong> frecuentes
        </TitleLineWithIcon>

        <div class="flex flex-col md:flex-row md:space-x-6 items-center my-8">
            <div class="flex justify-center md:w-1/4 w-full mb-6 md:mb-0">
                <img src="/img/container/Asistente_PIVITMor_Dorado.png" alt="Asistente Virtual"
                    class="w-40 md:w-full max-w-xs" />
            </div>

            <div class="w-full md:w-3/4">
                <Accordion type="single" collapsible class="w-full">
                    <AccordionItem v-for="item in faq" :key="item.id" :value="`value-${item.id}`"
                        class="bg-mono-100 mb-4 shadow-md rounded-xl p-5">
                        <AccordionTrigger>
                            <div class="cursor-pointer text-lg hover:font-semibold">
                                {{ item.question }}
                            </div>
                        </AccordionTrigger>
                        <AccordionContent>
                            <p class="text-start text-mono-600">
                                {{ item.answer }}
                            </p>
                        </AccordionContent>
                    </AccordionItem>
                </Accordion>
            </div>
        </div>

        <div class="pt-4 flex flex-col items-center gap-4">
            <button @click="handleChat(true)"
                class="bg-wine-400 w-fit text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl cursor-pointer">
                Preguntar al asistente virtual
            </button>
        </div>
    </div>
</template>

<script setup>
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from "@/Components/ui/accordion"
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import { faq } from '../../Composables/useDictionaries';
import { inject } from "vue";

const handleChat = inject('handleChat')
</script>