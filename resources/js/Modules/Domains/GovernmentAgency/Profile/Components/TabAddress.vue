<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiMapMarker" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Dirección de la Dependencia
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona la dirección oficial de la dependencia de gobierno.                    </p>
                </div>
            </div>
        </template>
        <AddressForm v-model="form.location" :errors="props.errors" />
    </CardForm>
</template>

<script setup>
import { inject } from 'vue';
import CardForm from '@/Components/CardForm.vue';
import { mdiMapMarker } from '@mdi/js';
import BaseIcon from '@/Components/BaseIcon.vue';
import AddressForm from '@/Components/AddressForm.vue';

const props = inject('props');
const form = inject('form');
</script>