<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiCalendarRange" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        PRODEP
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos del perfil deseable
                    </p>
                </div>
            </div>
        </template>

        <ToggleYesOrNot v-model="form.profile.has_profile" label="Cuenta con perfil deseable:" />

        <div v-if="form.profile.has_profile" class="grid md:grid-cols-2 gap-4">
            <FormField label="Fecha de inicio:" :error="form.errors?.['profile.start_date']">
                <FormControl type="date" v-model="form.profile.start_date" :icon="mdiCalendar" />
            </FormField>
            <FormField label="Fecha fin:" :error="form.errors?.['profile.end_date']">
                <FormControl type="date" v-model="form.profile.end_date" :icon="mdiCalendar" />
            </FormField>
        </div>
    </CardForm>
</template>

<script setup>
import { inject } from 'vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiCalendar, mdiCalendarRange } from '@mdi/js';
import CardForm from '@/Components/CardForm.vue';
import ToggleYesOrNot from '@/Components/ToggleYesOrNot.vue';

const form = inject('form')

</script>
