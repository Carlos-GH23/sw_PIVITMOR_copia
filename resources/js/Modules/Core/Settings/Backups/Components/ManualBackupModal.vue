<template>
    <Modal :show="show" max-width="xl" :closeable="true" @close="$emit('close')">
        <CardBox :hasBorder="false">
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <Database class="w-5 h-5 text-forest-400" />
                        <h2 class="text-forest-400 text-xl font-bold">Ejecución Manual de Respaldo</h2>
                    </div>

                    <BaseButton color="light" @click="$emit('close')" :icon="mdiClose" />
                </div>
                <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                    Crea un respaldo inmediato de tu base de datos con opciones personalizadas
                </span>
            </div>

            <div class="py-4">
                <FormField required label="Nombre del Respaldo" :error="form.errors.name">
                    <FormControl type="text" placeholder="nombre_del_respaldo" v-model="form.name" />
                </FormField>

                <FormField required label="Descripción" :error="form.errors.description">
                    <FormControl type="textarea" height="min-h-24" v-model="form.description"
                        placeholder="Describe el propósito de este respaldo..." />
                </FormField>
            </div>

            <div class="flex items-center justify-between p-4 bg-secondary rounded-lg border mb-6">
                <div class="flex items-center gap-3 w-full">
                    <Lock class="h-5 w-5" :class="[form.is_encrypted ? 'text-success' : 'text-muted-foreground']" />
                    <label class="flex items-center justify-between w-full cursor-pointer">
                        <div class="flex-1 mr-4">
                            <span class="text-card-foreground font-medium">
                                Cifrado
                            </span>
                            <p class="text-xs text-muted-foreground">
                                Protege el respaldo con cifrado simétrico de contraseñas en el archivo
                            </p>
                        </div>
                        <FormCheckRadio v-model="form.is_encrypted" inputValue="boolean" name="encryption" type="switch"
                            class="flex-shrink-0" />
                    </label>
                </div>
            </div>

            <BaseButton @click="storeBackup" :processing="processing" class="w-full" color="info"
                label="Ejecutar Respaldo Ahora" :icon="mdiPlay" />
        </CardBox>
    </Modal>
</template>

<script setup>
import CardBox from '@/Components/CardBox.vue';
import FormCheckRadio from '@/Components/FormCheckRadio.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import Modal from '@/Components/Modal.vue';
import { Database, Lock } from 'lucide-vue-next';
import { useManualBackup } from '../Composables/useManualBackup';
import BaseButton from '@/Components/BaseButton.vue';
import { mdiClose, mdiPlay } from '@mdi/js';

const props = defineProps({
    show: Boolean,
    routeName: String,
});

const emits = defineEmits(['close']);

const { form, processing, storeBackup } = useManualBackup(props.routeName, emits);
</script>
