<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiFileCertificateOutline" size="24"
                    h="h-10" w="w-10" />
                <div>
                    <h3 class="text-forest-400 text-xl font-bold">
                        Información básica
                    </h3>
                    <span class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona información básica sobre la certificación
                    </span>
                </div>
            </div>
        </template>

        <div>
            <div class="grid mb-6 md:mb-0 md:grid-cols-2 md:gap-4">
                <FormField label="Nombre" required :error="form.errors.name">
                    <FormControl v-model="form.name" placeholder="Ingresa el nombre de la certificación"
                        maxLength="150" />
                </FormField>

                <FormField label="Nivel" required :error="form.errors.certification_level_id">
                    <FormControl type="select" placeholder="Selecciona un nivel" v-model="form.certification_level_id"
                        :options="levels" :icon="mdiFormatListNumbered" />
                </FormField>
            </div>

            <FormField label="Descripción" required :error="form.errors.description">
                <FormControl type="textarea" height="h-24" v-model="form.description"
                    placeholder="Ej: Certificación en seguridad de la información..." maxLength="2000" />
                <template #tooltip>
                    <p>Proporcione una descripción detallada de la certificación.</p>
                </template>
            </FormField>

            <div class="grid mb-6 md:mb-0 md:grid-cols-2 md:gap-4">
                <FormField label="Fecha de emisión" required :error="form.errors.issue_date">
                    <FormControl type="date" v-model="form.issue_date" :icon="mdiCalendarRange" />
                </FormField>

                <FormField label="Fecha vencimiento" required :error="form.errors.expiry_date">
                    <FormControl type="date" v-model="form.expiry_date" :icon="mdiCalendarRange" />
                </FormField>
            </div>
        </div>

        <CardSection :icon="mdiCityVariantOutline" title="Entidad certificadora"
            description="Información sobre la organización emisora">
            <div class="grid mb-6 md:mb-0 md:grid-cols-2 md:gap-4">
                <FormField label="Entidad certificadora" required :error="form.errors.certifying_entity">
                    <FormControl v-model="form.certifying_entity" placeholder="Ej: Coursera" maxLength="150" />
                </FormField>

                <FormField label="Acreditación entidad" required :error="form.errors.accreditation_entity_id">
                    <FormControl type="select" placeholder="Selecciona una entidad"
                        v-model="form.accreditation_entity_id" :options="entities" />
                    <template #tooltip>
                        <p>Seleccione la institución que realizó la acreditación.</p>
                    </template>
                </FormField>
            </div>

            <div class="grid mb-6 md:mb-0 md:grid-cols-3 md:gap-4">
                <FormField label="País" required :error="form.errors.country_id">
                    <FormControl placeholder="Selecciona un país" type="select" v-model="form.country_id"
                        :options="countries" :icon="mdiFlagOutline" />
                    <template #tooltip>
                        <p>Seleccione el país de la entidad certificadora.</p>
                    </template>
                </FormField>

                <FormField label="Estatus" required :error="form.errors.status_id">
                    <FormControl placeholder="Selecciona un estatus" type="select" v-model="form.status_id"
                        :options="statuses" :icon="mdiListStatus" />
                </FormField>

                <FormField label="Duración de la validez" help="Duración en meses"
                    :error="form.errors.validity_duration">
                    <FormControl type="number" placeholder="Ej: 12" v-model="form.validity_duration" :icon="mdiNumeric"
                        disabled />
                </FormField>
            </div>
        </CardSection>

        <FileUpload title="Documentos relacionados"
            description="Adjunta los documentos relacionados con la certificación" :form="form" />
    </CardForm>

    <CardBox class="mt-5">
        <div class="flex justify-end items-center md:space-y-0 space-y-2">
            <BaseButtons>
                <slot />
            </BaseButtons>
        </div>
    </CardBox>
</template>

<script setup>
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBox from '@/Components/CardBox.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import FileUpload from '@/Components/FileUpload.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import { mdiCalendarRange, mdiCityVariantOutline, mdiFileCertificateOutline, mdiFlagOutline, mdiFormatListNumbered, mdiListStatus, mdiNumeric } from '@mdi/js';
import { inject } from 'vue';

const form = inject('form');
const countries = inject('countries');
const levels = inject('levels');
const entities = inject('entities');
const statuses = inject('statuses');

</script>