<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiAccountBox" :title="title" main />
        <CardBox>
            <form @submit.prevent="updateForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <FormField label="Correo electrónico" required :error="form.errors.email">
                        <FormControl v-model="form.email" placeholder="Correo electrónico" type="email" />
                    </FormField>
                    <FormField label="Dirección" required :error="form.errors.address">
                        <FormControl v-model="form.address" placeholder="Dirección" type="text" />
                    </FormField>
                    <FormField label="Hora de apertura" required :error="form.errors.opening_time">
                        <FormControl v-model="form.opening_time" placeholder="HH:MM" type="time" />
                    </FormField>
                    <FormField label="Hora de cierre" required :error="form.errors.closing_time">
                        <FormControl v-model="form.closing_time" placeholder="HH:MM" type="time" />
                    </FormField>
                </div>

                <FormField label="Ubicación en el mapa" help="Haz clic en el mapa para seleccionar la ubicación exacta">
                    <div class="relative">
                        <div ref="mapContainer" class="h-[400px] w-full rounded-xl border border-gray-300 z-0"></div>
                        <div v-if="isLoading" class="absolute top-2 right-2 bg-white px-3 py-1 rounded-lg shadow text-sm text-gray-600">
                            Obteniendo dirección...
                        </div>
                    </div>
                </FormField>

                <FormField label="Teléfonos">
                    <PhoneNumbersForm v-model="form.phones" :errors="form.errors" />
                </FormField>
                <div class="flex justify-end space-x-3">
                    <BaseButton :icon="mdiContentSave" color="success" label="Guardar" :disabled="processing" @click="updateForm" />
                </div>
            </form>
            <loading v-model:active="processing" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
        </CardBox>
    </LayoutMain>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import PhoneNumbersForm from '@/Components/PhoneNumbersForm.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import CardBox from '@/Components/CardBox.vue';
import { mdiContentSave, mdiAccountBox } from '@mdi/js';
import { useContactInformation } from '../Composables/useContactInformation';
import { useMap } from '@/Layouts/Composables/useMap';
import { onMounted, nextTick } from 'vue';

const props = defineProps({
    title: { type: String, required: true },
    routeName: { type: String, required: true },
    contactInformation: { type: [Object, null], default: null },
});

function handleLocationSelect({ lat, lng }) {
    form.latitude = lat;
    form.longitude = lng;
}

const { mapContainer, isLoading, initWithCoords, setMarker } = useMap({
    interactive: true,
    onLocationSelect: handleLocationSelect,
});

const DEFAULT_COORDS = { lat: 18.9242, lng: -99.2216 };

const { updateForm: baseUpdateForm, processing, form } = useContactInformation(props);

async function updateForm() {
    baseUpdateForm();
}

onMounted(async () => {
    await nextTick();
    if (form.latitude && form.longitude) {
        const lat = parseFloat(form.latitude);
        const lng = parseFloat(form.longitude);
        if (!isNaN(lat) && !isNaN(lng)) {
            initWithCoords(lat, lng, form.address || 'Ubicación guardada');
        }
    } else {
        setMarker(DEFAULT_COORDS.lat, DEFAULT_COORDS.lng, form.address || 'Ubicación no definida');
    }
});
</script>