<template>
    <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm text-earth-150 font-bold mb-2">Nombre de la organización</label>
            <input v-model="form.name" type="text" placeholder="Nombre de la organización"
                class="w-full bg-forest-400 text-sand-50 placeholder-earth-150/70 border border-earth-150 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-earth-200 focus:border-earth-200 transition"
                :class="{ 'border-red-500 focus:ring-red-500': form.errors.name }" />
            <p v-if="form.errors.name" class="text-red-400 text-sm mt-1">{{ form.errors.name }}</p>
        </div>

        <div>
            <label class="block text-sm text-earth-150 font-bold mb-2">Correo electrónico</label>
            <input v-model="form.email" type="text" placeholder="correo@ejemplo.com"
                class="w-full bg-forest-400 text-sand-50 placeholder-earth-150/70 border border-earth-150 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-earth-200 focus:border-earth-200 transition"
                :class="{ 'border-red-500 focus:ring-red-500': form.errors.email }" autocomplete="off" />
            <p v-if="form.errors.email" class="text-red-400 text-sm mt-1">{{ form.errors.email }}</p>
        </div>

        <div>
            <label class="block text-sm text-earth-150 font-bold mb-2">Tipo de organización</label>
            <SelectWelcome 
                v-model="form.organization_type"
                :items="props.organizationTypes"
                placeholder="Selecciona el tipo de organización"
            />
            <p v-if="form.errors.organization_type" class="text-red-400 text-sm mt-1">{{ form.errors.organization_type }}</p>
        </div>

        <div>
            <label class="block text-sm text-earth-150 font-bold mb-2">Sector</label>
            <SelectWelcome 
                v-model="form.organization_sector"
                :items="organizationSectors"
                placeholder="Selecciona el sector"
            />
            <p v-if="form.errors.organization_sector" class="text-red-400 text-sm mt-1">{{ form.errors.organization_sector }}</p>
        </div>

        <div>
            <label class="block text-sm text-earth-150 font-bold mb-2">Estado</label>
            <SelectWelcome 
                v-model="form.state_id"
                :items="props.states"
                placeholder="Selecciona tu estado"
            />
            <p v-if="form.errors.state_id" class="text-red-400 text-sm mt-1">{{ form.errors.state_id }}</p>
        </div>

        <div>
            <label class="block text-sm text-earth-150 font-bold mb-2">Municipio</label>
            <SelectWelcome 
                v-model="form.municipality_id"
                :items="filteredMunicipalities"
                placeholder="Selecciona tu municipio"
                :disabled="!form.state_id"
            />
            <p v-if="form.errors.municipality_id" class="text-red-400 text-sm mt-1">{{ form.errors.municipality_id }}</p>
        </div>

        <div class="col-span-1 md:col-span-2 flex justify-center mt-6">
            <button type="submit" :disabled="form.processing"
                class="bg-earth-150 text-forest-400 px-10 py-3 rounded-md font-semibold hover:bg-earth-200 focus:outline-none focus:ring-2 focus:ring-earth-200 focus:ring-offset-2 focus:ring-offset-forest-400 transition-all disabled:opacity-50 disabled:cursor-not-allowed shadow-md hover:shadow-lg">
                {{ form.processing ? 'Enviando...' : 'Enviar solicitud' }}
            </button>
        </div>
    </form>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import { computed, watch } from 'vue';
import { messageSuccess, error422, error500 } from '@/Hooks/useErrorsForm';
import { router } from '@inertiajs/vue3';
import SelectWelcome from './SelectWelcome.vue';

const props = defineProps({
    states: Array,
    municipalities: Array,
    organizationTypes: Array,
});

const form = useForm({
    name: '',
    email: '',
    organization_type: '',
    organization_sector: '',
    state_id: '',
    municipality_id: ''
});

const filteredMunicipalities = computed(() => {
    if (!form.state_id || !props.municipalities) return [];
    return props.municipalities.filter(m => m.state_id == form.state_id);
});

watch(() => form.state_id, () => {
    form.municipality_id = '';
});

const organizationSectors = [
    { id: 'publico', name: 'Público' },
    { id: 'privado', name: 'Privado' }
];

const submitForm = () => {
    form.post(route('organization-registrations.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            messageSuccess('Registro creado exitosamente. Gracias por tu interés.');
        },
        onError: (errors) => {
            if (Object.keys(errors).length > 0) {
                error422('Por favor revisa los campos del formulario.');
            } else {
                error500('Ha ocurrido un error al crear el registro. Intenta de nuevo.');
            }
        },
    });
};
</script>