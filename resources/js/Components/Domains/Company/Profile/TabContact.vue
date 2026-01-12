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
                        Información de contacto de la empresa
                    </p>
                </div>
            </div>
        </template>

        <ContactFields :contact="data.contact" :phoneNumbers="data.phone_numbers" :socialLinks="data.social_links" />
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import ContactFields from '@/Components/ContactFields.vue';
import { mdiPhone } from '@mdi/js';

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
</script>
