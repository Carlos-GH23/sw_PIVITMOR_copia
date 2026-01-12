<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiPhone" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Contacto
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Información de contacto para la oferta laboral
                    </p>
                </div>
            </div>
        </template>

        <ContactFields :contact="jobOffer.contact" :phoneNumbers="jobOffer.phone_numbers"
            :socialLinks="jobOffer.social_links" />
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import ContactFields from '@/Components/ContactFields.vue';
import { mdiPhone } from '@mdi/js';
import { computed, inject } from 'vue';

const props = defineProps({
    hasBorder: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
        required: false,
    },
});

const injectData = inject('job_offer', null);

const jobOffer = computed(() => {
    return props.data || injectData || {};
});
</script>
