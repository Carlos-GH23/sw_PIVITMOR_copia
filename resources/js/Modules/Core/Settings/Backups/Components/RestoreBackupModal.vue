<template>
    <Modal :show="show" max-width="xl" :closeable="true" @close="$emit('close')">
        <CardBox :hasBorder="false">
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <RotateCcw class="w-5 h-5 text-forest-400" />
                        <h2 class="text-forest-400 text-xl font-bold">
                            Restauración de Base de Datos
                        </h2>
                    </div>

                    <BaseButton color="light" @click="$emit('close')" :icon="mdiClose" />
                </div>
                <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                    Restaura tu base de datos desde un respaldo anterior
                </span>
            </div>

            <div class="space-y-6 py-4">
                <Alert class="border-warning/50 bg-warning/10">
                    <AlertTriangle class="h-4 w-4 text-warning" />
                    <AlertDescription class="text-warning-foreground">
                        <strong>Advertencia:</strong> La restauración sobrescribirá todos los datos actuales. Asegúrate
                        de crear
                        un respaldo antes de continuar.
                    </AlertDescription>
                </Alert>

                <div class="space-y-2">
                    <FormField required label="Seleccionar respaldo" :error="form.errors.backup_id">
                        <FormControl type="select" v-model="form.backup_id" :options="backupsData" />
                    </FormField>
                </div>

                <div v-if="selectedBackup.id" class="p-4 bg-secondary rounded-lg border border-border space-y-3">
                    <h4 class="text-sm font-semibold text-card-foreground flex items-center gap-2">
                        <CheckCircle2 class="h-4 w-4 text-success" />
                        Detalles del Respaldo
                    </h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-muted-foreground">Nombre</p>
                            <p class="text-card-foreground font-medium">
                                {{ selectedBackup.name }}
                            </p>
                        </div>
                        <div>
                            <p class="text-muted-foreground">Fecha</p>
                            <p class="text-card-foreground font-medium">
                                {{ selectedBackup.created_at.formatted }}
                            </p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-muted-foreground">Descripción</p>
                            <p class="text-card-foreground font-medium">
                                {{ selectedBackup.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <BaseButton @click="restore" :processing="processing" :disabled="!form.backup_id" class="w-full"
                color="info" label="Restaurar Base de Datos" :icon="mdiBackupRestore" />
        </CardBox>
    </Modal>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import CardBox from '@/Components/CardBox.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import Modal from '@/Components/Modal.vue';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { useRestoreBackup } from '../Composables/useRestoreBackup';
import { mdiBackupRestore, mdiClose } from '@mdi/js';
import { AlertTriangle, CheckCircle2, RotateCcw } from 'lucide-vue-next';

const props = defineProps({
    show: Boolean,
    routeName: String,
});

const emits = defineEmits(['close']);

const { form, processing, backupsData, selectedBackup, restore } = useRestoreBackup(props.routeName, emits);
</script>