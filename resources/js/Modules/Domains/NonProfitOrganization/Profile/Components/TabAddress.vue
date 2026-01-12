<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiMapMarker" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Dirección de la Organización
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona la dirección
                    </p>
                </div>
            </div>
        </template>

        <AddressForm v-model="form.location" :errors="form.errors" />
    </CardForm>
</template>

<script setup>
import AddressForm from '@/Components/AddressForm.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import { mdiMapMarker } from '@mdi/js';
import { inject } from 'vue';

const form = inject('form');
</script>