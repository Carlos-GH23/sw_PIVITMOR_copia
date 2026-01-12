<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiMapMarkerOutline" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <h3 class="text-forest-400 text-xl font-bold">
                        Domicilio
                    </h3>
                    <span class=" text-sm font-light text-slate-800">
                        Dirección de residencia
                    </span>
                </div>
            </div>
        </template>

        <AddressForm v-model="form.location" :errors="props.errors" />
    </CardForm>
</template>

<script setup>
import { inject } from 'vue';
import AddressForm from '@/Components/AddressForm.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import { mdiMapMarkerOutline } from '@mdi/js';

const form = inject('form');
const props = inject('props');

</script>