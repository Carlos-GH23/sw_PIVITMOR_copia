<template>
    <Modal :show="show" max-width="xl" :closeable="true" @close="$emit('close')">
        <CardBox :hasBorder="false">
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <Clock class="w-5 h-5 text-forest-400" />
                        <h2 class="text-forest-400 text-xl font-bold">Programación Automática de Respaldos</h2>
                    </div>

                    <BaseButton color="light" @click="$emit('close')" :icon="mdiClose" />
                </div>
                <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                    Configura respaldos automáticos según tu horario preferido
                </span>
            </div>

            <div class="grid gap-6 pt-4 md:grid-cols-2">
                <FormField required label="Frecuencia de Respaldo" :error="form.errors.backup_frequency_id">
                    <FormControl type="select" v-model="form.backup_frequency_id" :options="frequencies.data"
                        valueSelect="id" valueOption="name" />
                </FormField>

                <FormField required label="Hora de Ejecución" :error="form.errors.time">
                    <FormControl type="time" placeholder="Elige una hora" v-model="form.time" :icon="mdiClockOutline" />
                </FormField>
            </div>

            <div class="space-y-4 p-4 mb-6 bg-secondary rounded-lg border border-border">
                <label class="flex items-center justify-between cursor-pointer">
                    <div class="flex items-center gap-3">
                        <Mail class="w-5 h-5"
                            :class="[form.email_notification ? 'text-primary' : 'text-muted-foreground']" />
                        <div>
                            <span class="text-card-foreground font-medium">
                                Notificaciones por Correo
                            </span>
                            <p class="text-xs text-muted-foreground">
                                Recibe alertas sobre el estado de los respaldos
                            </p>
                        </div>
                    </div>
                    <FormCheckRadio v-model="form.email_notification" inputValue="boolean" name="notification"
                        type="switch" class="flex-shrink-0 ml-4" />
                </label>

                <div v-if="form.email_notification" class="pt-2">
                    <FormField label="Correo electrónico" :error="form.errors.email">
                        <FormControl type="email" v-model="form.email" :icon="mdiEmailOutline" disabled />
                    </FormField>
                </div>
            </div>

            <div class="p-4 bg-mono-100 rounded-lg border mb-6">
                <h4 class="text-sm font-semibold text-card-foreground mb-2">Próxima Ejecución Programada</h4>
                <p class="text-sm text-muted-foreground">
                    {{ frequencyLabel }} a las {{ form.time }}
                </p>
            </div>

            <BaseButton @click="updateForm" class="w-full" color="info" label="Guardar configuración"
                :icon="mdiContentSave" :disabled="processing || isLoading" />
        </CardBox>
    </Modal>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import CardBox from '@/Components/CardBox.vue';
import FormControl from '@/Components/FormControl.vue';
import FormCheckRadio from '@/Components/FormCheckRadio.vue';
import FormField from '@/Components/FormField.vue';
import Modal from '@/Components/Modal.vue';
import { Clock, Mail } from 'lucide-vue-next';
import { useScheduleBackup } from '../Composables/useScheduleBackup';
import { mdiClockOutline, mdiClose, mdiContentSave, mdiEmailOutline } from '@mdi/js';
import { computed } from 'vue';

const props = defineProps({
    show: Boolean,
    schedule: Object,
    frequencies: Object,
    routeName: String,
    user: Object,
});

const emits = defineEmits(['close']);
const { form, isLoading, processing, updateForm } = useScheduleBackup(props, emits);

const frequencyLabel = computed(() => {
    if (!form.backup_frequency_id) return 'No configurado';

    const frequency = props.frequencies.data.find(f => f.id === form.backup_frequency_id);

    if (!frequency) return 'No configurado';

    const labels = {
        'daily': 'Todos los días',
        'weekly': 'Cada lunes',
        'monthly': 'El día 1 de cada mes',
    };

    return labels[frequency.value] || frequency.name;
});
</script>