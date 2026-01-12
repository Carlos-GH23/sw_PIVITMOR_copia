<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiPhone" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Contacto de la institución
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos de contacto de la institución
                    </p>
                </div>
            </div>
        </template>
        <div>
            <ContactForm v-model:contact="form.contact" v-model:phones="form.phones"
                v-model:social-links="form.social_links" :has-contact-name="true" :errors="form.errors" />
        </div>
    </CardForm>
</template>

<script setup>
import { inject } from 'vue';
import CardForm from '@/Components/CardForm.vue';
import { mdiPhone } from '@mdi/js';
import BaseIcon from '@/Components/BaseIcon.vue';
import ContactForm from '@/Components/ContactForm.vue';

const form = inject('form');
</script>
