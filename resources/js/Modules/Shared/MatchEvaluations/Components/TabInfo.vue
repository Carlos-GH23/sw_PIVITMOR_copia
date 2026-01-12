<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Información general
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos básicos de la vinculación tecnológica
                    </p>
                </div>
            </div>
        </template>
        <FormField label="Título" required :error="form.errors.title">
            <FormControl v-model="form.title" type="textarea" height="h-12" max-length="255"
                placeholder="Ejemplo: Optimización hídrica en riego de precisión con IA" />
        </FormField>

        <FormField label="Descripción corta" required :error="form.errors.description">
            <FormControl v-model="form.description" type="textarea" height="h-24" max-length="2000"
                placeholder="Describe brevemente el propósito y alcance del proyecto (máx. 300 caracteres). Ejemplo: Plataforma colaborativa que optimiza el riego agrícola mediante IA y sensores remotos." />
        </FormField>

        <FormField label="Selecciona una categoría" required :error="form.errors.categories">
            <SearchSelect v-model="form.categories" itemsKey="children" :items="categories"
                placeholder="Buscar categorías o subcategorías..." />
        </FormField>


        <CardSection title="Socios y aliados" description="Actores demandante y ofertante de la vinculación"
            iconClasses="bg-forest-400 text-mono-100" :icon="mdiHandshake">
            <div class="grid grid-cols-2 gap-4">
                <FormField label="IES/CI ofertante">
                    <LabelControl
                        :value="actors.offering_entity.name" />
                </FormField>

                <FormField label="Entidad demandante">
                    <LabelControl :value="actors.applicant_entity.name" />
                </FormField>
            </div>
        </CardSection>

        <CardSection title="Período de la colaboración" description="Período de la colaboración desde la vinculación"
            iconClasses="bg-forest-400 text-mono-100" :icon="mdiCalendarBlankOutline">
            <div class="grid grid-cols-2 gap-4">
                <FormField label="Fecha de inicio" :error="form.errors.start_date" required>
                    <FormControl v-model="form.start_date" type="date" />
                </FormField>

                <FormField label="Fecha de cierre" :error="form.errors.end_date" required>
                    <FormControl v-model="form.end_date" type="date" />
                </FormField>
            </div>
        </CardSection>
    </CardForm>
</template>
<script setup>
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import CardSection from "@/Components/CardSection.vue";
import FormControl from "@/Components/FormControl.vue";
import FormField from "@/Components/FormField.vue";
import LabelControl from "@/Components/LabelControl.vue";
import SearchSelect from "@/Components/SearchSelect.vue";
import { mdiCalendarBlankOutline, mdiHandshake, mdiInformation } from "@mdi/js";
import { inject } from "vue";

const form = inject('matchEvaluationForm')
const { categories, actors } = inject('props')
</script>