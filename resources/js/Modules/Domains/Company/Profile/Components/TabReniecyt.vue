<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiCalendarRange" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        RENIECyT
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos de RENIECyT de la empresa
                    </p>
                </div>
            </div>
        </template>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <FormField label="Número de Registro" :error="form.errors['reniecyt.register_number']">
                <FormControl v-model="form.reniecyt.register_number" type="text" placeholder="0001" />
            </FormField>
            <FormField label="Fecha inicio" :error="form.errors['reniecyt.start_date']">
                <FormControl v-model="form.reniecyt.start_date" type="date" />
            </FormField>
            <FormField label="Fecha fin" :error="form.errors['reniecyt.end_date']">
                <FormControl v-model="form.reniecyt.end_date" type="date" />
            </FormField>
        </div>
    </CardForm>
</template>

<script setup>
import { inject } from 'vue';
import CardForm from '@/Components/CardForm.vue';
import { mdiCalendarRange } from '@mdi/js';
import BaseIcon from '@/Components/BaseIcon.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';

const form = inject('profileForm')
</script>