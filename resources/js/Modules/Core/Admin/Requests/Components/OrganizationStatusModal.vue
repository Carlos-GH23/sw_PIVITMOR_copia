<template>
    <Modal :show="show" max-width="2xl" :closeable="true" @close="$emit('close')">
        <div class="transition-all duration-300 border border-border/50 rounded-xl bg-white relative">
            <BaseButton @click="$emit('close')" class="absolute top-4 right-4 z-10" :icon="mdiClose"
                color="lightDark" small title="Cerrar" />
            
            <div class="p-6">
                <h2 class="text-2xl font-bold text-forest-400 mb-6">Detalles de la Solicitud</h2>

                <div class="space-y-4" v-if="registration">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <span class="text-xs font-semibold uppercase text-forest-500">Nombre de la organización</span>
                            <p class="text-base text-forest-900 mt-1">{{ registration.name }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase text-forest-500">Correo electrónico</span>
                            <p class="text-base text-forest-900 mt-1">{{ registration.email }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase text-forest-500">Tipo de organización</span>
                            <p class="text-base text-forest-900 mt-1">{{ registration.organization_type }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase text-forest-500">Sector</span>
                            <p class="text-base text-forest-900 mt-1">{{ registration.organization_sector === 'publico' ? 'Público' : 'Privado' }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase text-forest-500">Estado</span>
                            <p class="text-base text-forest-900 mt-1">{{ registration.state?.name || 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase text-forest-500">Municipio</span>
                            <p class="text-base text-forest-900 mt-1">{{ registration.municipality?.name || 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase text-forest-500">Fecha de solicitud</span>
                            <p class="text-base text-forest-900 mt-1">{{ registration.created_at?.formatted || 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase text-forest-500">Estatus actual</span>
                            <div class="mt-1">
                                <Badge v-if="registration.status?.name" :color="getStatusColor(registration.status?.name)" showDot variant="soft">
                                    {{ registration.status?.name || 'Pendiente' }}
                                </Badge>
                            </div>
                        </div>
                    </div>

                    <div v-if="registration.rejection_reason" class="col-span-2 mt-4">
                        <span class="text-xs font-semibold uppercase text-forest-500">Razón de rechazo</span>
                        <p class="text-base text-forest-900 mt-1">{{ registration.rejection_reason }}</p>
                    </div>

                    <div v-if="registration.status?.name === 'Pendiente'" class="border-t border-gray-200 pt-6 mt-6">
                        <p class="text-xs font-semibold uppercase text-forest-500 mb-4">Cambiar estatus de la solicitud</p>
                        
                        <div v-if="showRejectionForm" class="mb-4">
                            <FormField label="Motivo del rechazo" required :error="rejectionError">
                                <FormControl 
                                    v-model="rejectionReason" 
                                    type="textarea" 
                                    height="h-24" 
                                    maxLength="2000"
                                    placeholder="Describe el motivo del rechazo..."
                                />
                            </FormField>
                        </div>

                        <div class="flex gap-3">
                            <BaseButton 
                                v-if="!showRejectionForm"
                                color="success" 
                                label="Aceptar" 
                                @click="handleStatusChange('Aceptada')" 
                            />
                            <BaseButton 
                                v-if="!showRejectionForm"
                                color="danger" 
                                label="Rechazar" 
                                @click="showRejectionForm = true" 
                            />
                            <BaseButton 
                                v-if="showRejectionForm"
                                color="danger" 
                                label="Confirmar Rechazo" 
                                @click="handleStatusChange('Rechazada')" 
                            />
                            <BaseButton 
                                v-if="showRejectionForm"
                                color="lightDark" 
                                label="Cancelar" 
                                @click="showRejectionForm = false; rejectionReason = ''" 
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue';
import BaseButton from '@/Components/BaseButton.vue';
import Badge from '@/Components/Badge.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import { mdiClose } from '@mdi/js';
import { messageConfirm } from '@/Hooks/useErrorsForm';
import { ref, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    registration: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['close', 'update-status']);

const showRejectionForm = ref(false);
const rejectionReason = ref('');
const rejectionError = ref(null);

watch(() => props.show, (newVal) => {
    if (!newVal) {
        showRejectionForm.value = false;
        rejectionReason.value = '';
    }
});

const handleStatusChange = (status) => {
    rejectionError.value = null;
    if (status === 'Rechazada' && !rejectionReason.value.trim()) {
        rejectionError.value = 'El motivo del rechazo es obligatorio.';
        return;
    }
    if (status === 'Rechazada' && rejectionReason.value.length > 2000) {
        rejectionError.value = 'El motivo del rechazo no puede exceder 2000 caracteres.';
        return;
    }
    const action = status === 'Aceptada' ? 'aceptar' : 'rechazar';
    messageConfirm(`¿Estás seguro de ${action} esta solicitud?`).then((result) => {
        if (result.isConfirmed) {
            emit('update-status', {
                status,
                rejection_reason: status === 'Rechazada' ? rejectionReason.value : null
            });
            showRejectionForm.value = false;
            rejectionReason.value = '';
        }
    });
};

const getStatusColor = (status) => {
    const colors = {
        'Pendiente': 'yellow',
        'Aceptada': 'green',
        'Rechazada': 'red',
    };
    return colors[status] || 'gray';
};
</script>