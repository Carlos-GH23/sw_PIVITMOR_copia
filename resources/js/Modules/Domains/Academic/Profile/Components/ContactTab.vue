<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiAccountBoxOutline" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <h3 class="text-forest-400 text-xl font-bold">
                        Información de contacto
                    </h3>
                    <span class="text-sm font-light text-slate-800">
                        Agrega información de contacto
                    </span>
                </div>
            </div>
        </template>

        <ContactForm v-model:contact="form.contact" v-model:phones="form.phones"
            v-model:social-links="form.social_links" :has-contact-name="false" :errors="form.errors" />
    </CardForm>
</template>

<script setup>
import { inject } from 'vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import ContactForm from '@/Components/ContactForm.vue';
import { mdiAccountBoxOutline } from '@mdi/js';

const form = inject('form');
</script>