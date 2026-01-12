<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiPhone" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Contacto de la Organización
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos de contacto
                    </p>
                </div>
            </div>
        </template>

        <ContactForm v-model:contact="form.contact" v-model:phones="form.phones"
            v-model:social-links="form.social_links" :has-contact-name="true" :errors="form.errors"/>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import ContactForm from '@/Components/ContactForm.vue';
import { mdiPhone } from '@mdi/js';
import { inject } from 'vue';

const form = inject('form');
</script>
