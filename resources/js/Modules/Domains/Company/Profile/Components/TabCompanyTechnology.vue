<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Empresa de base tecnológica
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos solicitados de empresa de base tecnológica
                    </p>
                </div>
            </div>
        </template>
        <CardSection title="Información de la empresa" description="Completa los datos de la EBT" :has-divider="false"
            :icon="mdiRocketLaunch">
            <ToggleYesOrNot v-model="form.technology.has_company" label="Es una empresa de base tecnológica:" />

            <div v-if="form.technology.has_company" class="flex flex-col gap-4">
                <FormField label="Resumen de Propiedad Intelectual" required
                    :error="form.errors['technology.description']">
                    <FormControl v-model="form.technology.description" placeholder="Ingresa un resumen" type="textarea"
                        height="h-48" max-length="2000" />
                </FormField>

                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                    <FormField label="Origen EBT" required :error="form.errors['technology.origen_id']">
                        <FormControl v-model="form.technology.origen_id" :options="origens" value-select="id"
                            value-option="name" />
                    </FormField>
                    <FormField label="Tipo innovación" required :error="form.errors['technology.innovation_type_id']">
                        <FormControl v-model="form.technology.innovation_type_id" :options="innovationTypes" />
                    </FormField>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                    <FormField label="Alcance del mercado" required :error="form.errors['technology.market_reach_id']">
                        <FormControl v-model="form.technology.market_reach_id" :options="marketReaches" />
                    </FormField>
                    <FormField label="Nivel de madurez tecnológica" required
                        :error="form.errors['technology.technology_level_id']">
                        <FormControl v-model="form.technology.technology_level_id" :options="technologyLevels" />
                    </FormField>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                    <FormField label="Tamaño de la empresa" required :error="form.errors['technology.company_size_id']">
                        <FormControl v-model="form.technology.company_size_id" :options="companySizes" />
                    </FormField>
                    <FormField label="Empleados en Investigación y Desarrollo (I+D)" required
                        :error="form.errors['technology.num_employees']">
                        <FormControl v-model="form.technology.num_employees"
                            placeholder="Ingrese el número de empleados en Investigación y Desarrollo (I+D)"
                            type="number" />
                    </FormField>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                    <FormField label="Disciplinas científicas y tecnológicas (OCDE)" :error="form.errors.oecd_sectors">
                        <HierarchicalSelector v-model="form.oecd_sectors" :items="oecdSectors"
                            placeholder="Buscar área, subárea o disciplina..."
                            :level-labels="['Área Principal', 'Subárea', 'Disciplina']" />
                    </FormField>

                    <FormField label="Sectores económicos y productivos (ISIC)" :error="form.errors.economic_sectors">
                        <HierarchicalSelector v-model="form.economic_sectors" :items="economicSectors"
                            placeholder="Buscar sección, división o grupo..."
                            :level-labels="['Sección', 'División', 'Grupo']" />
                        <template #tooltip>
                            El capital humano relacionado con la oferta tecnológica, puede relacionar al creador autor
                            intelectual de dicha tecnología.
                        </template>
                    </FormField>
                </div>

                <FileUpload title="Archivos relacionados" :form="form" />
            </div>
        </CardSection>
    </CardForm>
</template>
<script setup>
import FormField from '@/Components/FormField.vue';
import { inject } from 'vue';
import FormControl from '@/Components/FormControl.vue';
import FileUpload from '@/Components/FileUpload.vue';
import CardForm from '@/Components/CardForm.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import HierarchicalSelector from '@/Components/Form/HierarchicalSelector/HierarchicalSelector.vue';
import { mdiInformation, mdiRocketLaunch } from '@mdi/js';
import ToggleYesOrNot from '@/Components/ToggleYesOrNot.vue';
import CardSection from '@/Components/CardSection.vue';

const form = inject('profileForm')
const origens = inject('origens')
const innovationTypes = inject('innovationTypes')
const marketReaches = inject('marketReaches')
const companySizes = inject('companySizes')
const technologyLevels = inject('technologyLevels')
const economicSectors = inject('economicSectors')
const oecdSectors = inject('oecdSectors')

</script>