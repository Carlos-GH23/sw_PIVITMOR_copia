<template>
    <Modal :show="show" max-width="xl" :closeable="true">
        <CardBox :hasBorder="false">
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <FileText class="w-5 h-5 text-forest-400" />
                        <h2 class="text-forest-400 text-xl font-bold">Crear un nuevo aviso de privacidad</h2>
                    </div>

                    <BaseButton color="light" @click="$emit('close')" :icon="mdiClose" />
                </div>
                <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                    Ingrese los detalles de la política de privacidad y la información de la versión para crear un nuevo
                    registro de cumplimiento
                </span>
            </div>

            <div class="py-4">
                    <FormField required label="Versión" :error="form.errors.version">
                        <FormControl placeholder="v1.0" type="number" v-model="form.version" />
                    </FormField>
            </div>

            <FormField label="Aviso de privacidad" required :error="form.errors.privacity_advice">
                <ContentQuillEditor maxLength="5000"
                    placeholder="Ejemplo: Escribe el contenido de tu política de privacidad aquí." v-model="form.privacity_advice" />
            </FormField>
        </CardBox>
    </Modal>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import CardBox from '@/Components/CardBox.vue';
import ContentQuillEditor from '@/Components/ContentQuillEditor.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import Modal from '@/Components/Modal.vue';
import { mdiCalendarOutline, mdiClose, mdiContentSave } from '@mdi/js';
import { FileText } from 'lucide-vue-next';
import { usePrivacity } from '../Composables/usePrivacity';

const props = defineProps({
    props:{ 
        type: Object,
        required: true
    },
    show: Boolean
});

const emit = defineEmits(['close']);


const { form, saveForm } = usePrivacity(props.props, emit);
</script>