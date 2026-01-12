<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiShieldLock" :title="title" main />

        <CardBox v-if="privacity" class="mt-2">
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Políticas de privacidad
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Versión: {{ privacity.version }}
                    </p>
                </div>
                <div class="ml-auto text-sm font-light text-slate-600 dark:text-slate-400">
                    <p>Última actualización: {{ privacity.formatted_date.human }}</p>
                </div>
            </div>

            <div class="prose prose-sm max-w-none text-gray-800 text-justify m-4 overflow-x-auto max-h-96">
                <div v-html="privacity.privacity_advice"></div>
            </div>

            <div v-if="isEmpty(privacityConfirmation)" class="text-forest-800 p-4 m-4 mb-0 text-sm flex flex-col items-center gap-4 border-t border-forest-300">
                <p>
                    He leído y acepto las políticas de privacidad y condiciones de uso.
                </p>
                <div class="flex flex-row gap-4">
                    <BaseButton @click="denyForm" color="lightDark" label="Rechazar" />
                    <BaseButton @click="acceptForm" color="info" label="Aceptar" />
                </div>
            </div>

            <div v-else-if="privacityConfirmation?.is_accepted === 1" class="text-forest-800 p-4 m-4 mb-0 text-sm flex flex-col items-center gap-4 border-t border-forest-300">
                <p>
                    Ya se han aceptado las políticas de privacidad y condiciones de uso.
                </p>
                <p>
                    Fecha de aceptación: {{ privacityConfirmation.formatted_date.human }}
                </p>
            </div>

            <div v-else-if="privacityConfirmation?.is_accepted === 0" class="text-forest-800 p-4 m-4 mb-0 text-sm flex flex-col items-center gap-4 border-t border-forest-300">
                <p>
                    Se han rechazado las políticas de privacidad y condiciones de uso.
                </p>
                <p>
                    Fecha de rechazo: {{ privacityConfirmation.formatted_date.human }}
                </p>
            </div>
        </CardBox>

        <CardBoxComponentEmpty v-else class="mt-2" />
    </LayoutMain>
</template>

<script setup>
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import { mdiShieldLock, mdiInformation } from '@mdi/js';
import BaseButton from '@/Components/BaseButton.vue';
import { usePolicy } from '../Composables/usePolicy';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBox from '@/Components/CardBox.vue';
import { isEmpty } from 'lodash';
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    privacity: {
        type: Object,
        required: true,
    },
    privacityConfirmation: {
        type: Object,
        required: true,
    },
});

const privacity = props.privacity?.data;
const privacityConfirmation = computed(() => props.privacityConfirmation?.data);

const { acceptForm, denyForm } = usePolicy(props);
</script>