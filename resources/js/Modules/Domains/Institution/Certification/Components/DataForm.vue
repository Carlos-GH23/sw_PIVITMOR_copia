<template>
    <div class="space-y-6">
        <div class="flex gap-2 items-center py-4">
            <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                w="w-10" />
            <div>
                <p class="text-forest-400 text-xl font-bold">
                    Información General
                </p>
                <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                    Información general relacionada con la certificación
                </p>
            </div>
        </div>
        <FormField label="Nombre" required :error="errors.name">
            <FormControl v-model="form.name" placeholder="Nombre de la certificación" maxLength="255" />
        </FormField>
        <FormField label="Descripción" required :error="errors.description">
            <FormControl v-model="form.description" type="textarea" height="h-32" placeholder="Descripción..."
                maxLength="2000" />
        </FormField>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <FormField label="Entidad certificadora" required :error="errors.certifying_entity">
                <FormControl v-model="form.certifying_entity" placeholder="Entidad certificadora" maxLength="255" />
            </FormField>
            <FormField label="Tipo de certificación" required :error="errors.certification_type_id">
                <FormControl v-model="form.certification_type_id" :options="certificationTypes" value-select="id"
                    value-option="name" placeholder="Seleccione tipo de certificación" />
            </FormField>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
            <FormField label="Departamento" required :error="errors.department_id">
                <FormControl v-model="form.department_id" :options="departments" value-select="id" value-option="name"
                    placeholder="Seleccione departamento" />
            </FormField>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <FormField label="Tipo de recurso" required :error="errors.resource_type_id">
                <FormControl v-model="form.resource_type_id" :options="resourceTypes" value-select="id"
                    value-option="name" placeholder="Seleccione tipo de recurso" />
            </FormField>
            <FormField label="Recurso certificado" required :error="errors.certified_resource_id">
                <FormControl v-model="form.certified_resource_id" :options="resourceOptions" value-select="id"
                    value-option="name" placeholder="Seleccione el recurso certificado" />
            </FormField>
        </div>
        <FileUpload title="Archivos relacionados" :form="form" />
        <InputError :message="errors.files" />
        <div class="flex justify-end">
        </div>
    </div>
</template>

<script setup>
import FileUpload from '@/Components/FileUpload.vue'
import InputError from '@/Components/InputError.vue'
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import BaseIcon from '@/Components/BaseIcon.vue'
import { mdiInformation } from '@mdi/js'
import { ref, watch, onMounted } from 'vue'
import axios from 'axios'

const resourceOptions = ref([])

const props = defineProps({
    form: { type: Object, required: true },
    errors: { type: Object, default: () => ({}) },
    certificationTypes: { type: Array, default: () => [] },
    departments: { type: Array, default: () => [] },
    resourceTypes: { type: Array, default: () => [] },
    is_active: { type: Boolean, default: true },
})

watch(
    () => [props.form.department_id, props.form.resource_type_id],
    async ([newDep, newResType], [oldDep, oldResType]) => {
        if ((oldDep !== undefined && newDep !== oldDep) || (oldResType !== undefined && newResType !== oldResType)) {
            props.form.certified_resource_id = null;
        }

        if (newDep && newResType) {
            fetchResources(newDep, newResType);
        } else {
            resourceOptions.value = [];
        }
    }
);

onMounted(() => {
    if (props.form.department_id && props.form.resource_type_id) {
        fetchResources(props.form.department_id, props.form.resource_type_id);
    }
});

const fetchResources = async (departmentId, resourceTypeId) => {
    try {
        const response = await axios.get(route('institutions.certifications.resources'), {
            params: {
                department_id: departmentId,
                resource_type_id: resourceTypeId
            }
        });
        resourceOptions.value = response.data;
    } catch (error) {
        console.error("Error fetching resources:", error);
        resourceOptions.value = [];
    }
};
</script>