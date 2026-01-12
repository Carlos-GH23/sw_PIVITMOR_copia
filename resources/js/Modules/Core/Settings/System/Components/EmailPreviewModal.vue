<template>
    <Modal :show="show" max-width="2xl" :closeable="true" @close="$emit('close')">

        <CardBox :hasBorder="false" class="!p-0 overflow-hidden">

            <div class="flex justify-between items-center p-4 bg-white border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <FileText class="w-5 h-5 text-forest-400" />
                    <h2 class="text-forest-400 text-lg font-bold">
                        Vista Previa: {{ form.name || 'Sin plantilla seleccionada' }}
                    </h2>
                </div>
                <BaseButton color="light" small @click="$emit('close')" :icon="mdiClose" />
            </div>

            <div class="w-full bg-[#edf2f7] p-6 sm:p-10 font-sans antialiased overflow-y-auto max-h-[75vh]">

                <div class="mx-auto max-w-[570px]">

                    <div class="mb-6 text-center">
                        <span class="text-[19px] font-bold text-[#3d4852]">
                            PIVITMor
                        </span>
                    </div>

                    <div class="bg-white rounded shadow-sm p-8">

                        

                        <div class="text-[16px] leading-[1.5em] text-[#718096] prose prose-sm max-w-none break-words">
                            <div v-html="prettyBody"></div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-slate-100 text-[16px] text-[#718096]">
                            <div v-html="form.footer || '<p class=&quot;text-gray-400 italic&quot;>Sin pie de correo...</p>'"></div>
                        </div>
                    </div>

                    <div class="mt-8 text-center text-xs text-[#b0adc5]">
                        <p>© 2025 PIVITMor. Todos los derechos reservados.</p>
                    </div>

                </div>
            </div>

        </CardBox>
    </Modal>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import CardBox from '@/Components/CardBox.vue';
import Modal from '@/Components/Modal.vue';
import { mdiClose } from '@mdi/js';
import { FileText } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps({
    form: {
        type: Object,
        required: true
    },
    show: Boolean
});

const emit = defineEmits(['close']);

const prettyBody = computed(() => {
    let content = props.form.body || '';

    if (!content) return '<p class="text-gray-400 italic">Sin contenido...</p>';
    content = content.replace(
        /<a\s+(?:[^>]*?\s+)?href=(["'])(.*?)\1[^>]*>(.*?)<\/a>/gi,
        `<div style="width: 100%; text-align: center; margin: 32px 0;">
            <a href="$2" style="background-color: #283C2A; color: #ffffff; padding: 5px 20px; text-decoration: none; border-radius: 5px; display: inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                $3
            </a>
         </div>`
    );

    return content;
});

</script>