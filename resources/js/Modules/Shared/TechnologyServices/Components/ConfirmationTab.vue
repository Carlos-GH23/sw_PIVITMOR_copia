<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <div class="bg-forest-400 text-mono-100 rounded-lg">
                    <BaseIcon :path="mdiCheckCircle" size="24" h="h-10" w="w-10" />
                </div>
                <p class="text-forest-400 text-xl font-bold">
                    Resumen de Confirmación
                </p>
            </div>
            <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                Revisa la información antes de enviar tu solicitud
            </p>
        </template>

        <div class="grid gap-4">
            <LabelText label="Título" :text="form.title" />
            <LabelText label="Descripción" :text="form.technical_description" />
        </div>

        <BaseDivider />

        <h2 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
            <div class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                <BaseIcon :path="mdiAlphabeticalVariant" size="16" h="h-auto" w="w-auto" class="text-gray-700"  />
            </div>
            Palabras Clave
        </h2>

        <FormField :error="form.errors.keywords">
            <KeywordInput v-model="form.keywords"/>
        </FormField>
        <BaseDivider />

        <h2 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
            <div class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                <BaseIcon :path="mdiCog" size="16" h="h-auto" w="w-auto" class="text-gray-700" />
            </div>
            Detalles Técnicos
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 md:gap-4 mb-4">
            <FormField label="Tipo de servicio" :error="form.errors.technology_service_type_id">
                <FormControl v-model="form.technology_service_type_id" :options="serviceTypes" option-label="name"
                    option-value="id" :disabled="true" />
            </FormField>
            <FormField label="Categoría del servicio" :error="form.errors.technology_service_category_id">
                <FormControl v-model="form.technology_service_category_id" :options="serviceCategories" option-label="name"
                    option-value="id" :disabled="true" />
            </FormField>
        </div>

        <BaseDivider />


        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <CardSelectable :icon="mdiHammerWrench" title="Sectores económicos y productivos (ISIC)"
                v-model="form.economic_sectors" :items="flattenChildren.economicSectors" />
            <CardSelectable :icon="mdiAtom" title="Disciplinas científicas y tecnológicas (OCDE)"
                v-model="form.oecd_sectors" :items="flattenChildren.oecdSectors" />
        </div>


        <BaseDivider />

        <h2 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
            <div class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                <BaseIcon :path="mdiCrowd" size="16" h="h-auto" w="w-auto" class="text-gray-700" />
            </div>
            Recursos Asociados con el Servicio
        </h2>
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <CardSelectable :icon="mdiDomain" title="Departamento Académico" v-model="departmentArray"
                :items="departments"  v-if="useRoles(['IES/CI', 'Academico'])"/>
            <CardSelectable :icon="mdiAccountGroup" title="Recursos Humanos" v-model="form.academics"
                :items="academics" />
            <CardSelectable :icon="mdiHome" title="Infraestructura" v-model="form.facilities" :items="facilities" />
            <CardSelectable :icon="mdiHammerWrench" title="Recursos Tecnológicos" v-model="form.equipments"
                :items="equipments" />
        </div>
        <BaseDivider />

        <h2 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
            <div class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                <BaseIcon :path="mdiFileMultiple" size="16" h="h-auto" w="w-auto" class="text-gray-700" />
            </div>
            Archivos Adjuntos
        </h2>
        <p class=" text-sm font-light text-slate-800 dark:text-slate-300 mb-4">
            Revisa los archivos que has adjuntado a tu solicitud
        </p>
        <div v-if="form.files && form.files.length > 0" class="space-y-2">
            <div v-for="(file, index) in form.files" :key="`file-${index}`"
                class="flex items-center justify-between bg-gray-50 dark:bg-slate-950 rounded-lg px-3 py-2">
                <span class="text-gray-800 dark:text-gray-800">
                    {{ file.title }}
                </span>
                <a :href="file.path" target="_blank" class="text-blue-500 hover:text-blue-700">Ver</a>
            </div>
        </div>
        <div v-else class="text-slate-600 dark:text-slate-400">
            No hay ningun archivo adjunto.
        </div>
    </CardForm>
</template>

<script setup>
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import FormControl from "@/Components/FormControl.vue";
import FormField from "@/Components/FormField.vue";
import KeywordInput from "@/Components/KeywordInput.vue";
import { mdiAtom, mdiCrowd, mdiCheckCircle, mdiCog, mdiFileMultiple, mdiHammerWrench, mdiAlphabeticalVariant, mdiTag, mdiAccountGroup, mdiDomain, mdiHome } from "@mdi/js";
import { computed, inject } from "vue";
import CardSelectable from "@/Components/CardSelectable.vue";
import LabelText from "@/Components/LabelText.vue";
import { useRoles } from '@/Hooks/usePermissions';


const form = inject("form");
const serviceTypes = inject("serviceTypes");
const serviceCategories = inject("serviceCategories");
const economicSectors = inject("economicSectors");
const oecdSectors = inject("oecdSectors");
const departments = inject("departments");
const academics = inject("academics");
const facilities = inject("facilities");
const equipments = inject("equipments");

const flattenChildren = computed(() => ({
    economicSectors: (economicSectors || []).flatMap(function flatten(item) {
        return [item, ...(item.children || []).flatMap(flatten)];
    }),
    oecdSectors: (oecdSectors || []).flatMap(function flatten(item) {
        return [item, ...(item.children || []).flatMap(flatten)];
    }),
}));

const departmentArray = computed(() => {
    return form.department_id ? [form.department_id] : []
})


</script>