<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiCertificateOutline" size="24"
                    h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Acreditaciones
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos de acreditacion de la oferta educativa.
                    </p>
                </div>
            </div>
        </template>
        <CardSection title="Acreditación COPAES" description="Completa los datos de acreditación COPAES"
            :has-divider="false">
            <ToggleYesOrNot v-model="form.has_copaes_accreditation" label="¿Tiene la acreditación COPAES?" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" v-if="form.has_copaes_accreditation">
                <FormField label="Tipo de Acreditación COPAES:" required :error="form.errors?.copaes_accreditation_id">
                    <FormControl v-model="form.copaes_accreditation_id" type="select" :options="copaesAccreditations"
                        placeholder="Seleccionar tipo de acreditación" />
                </FormField>

                <FormField label="Vigencia" required :error="form.errors?.copaes_expiry_date">
                    <FormControl v-model="form.copaes_expiry_date" type="date" />
                </FormField>
            </div>
        </CardSection>

        <CardSection title="Programas de posgrado" description="Completa los datos de posgrado">
            <ToggleYesOrNot v-model="form.has_snp" label="¿El programa es reconocido por el SNP?" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" v-if="form.has_snp">
                <FormField label="Fecha inicio:" :error="form.errors?.snp_start_date" required>
                    <FormControl v-model="form.snp_start_date" type="date" />
                </FormField>
                <FormField label="Fecha fin:" :error="form.errors?.snp_end_date" required>
                    <FormControl v-model="form.snp_end_date" type="date" />
                </FormField>
            </div>
        </CardSection>

        <CardSection title="Acreditación CIEES" description="Completa los datos de la acreditación CIEES">
            <ToggleYesOrNot v-model="form.has_ciees_accreditation" label="¿Tiene la acreditación CIEES?" />

            <div v-if="form.has_ciees_accreditation">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <FormField label="Tipo de CIEES:" required :error="form.errors?.ciees_accreditation_id">
                        <FormControl v-model="form.ciees_accreditation_id" :options="cieesAccreditations"
                            placeholder="Seleccionar un tipo de acreditación" />
                    </FormField>
                    <FormField label="Nivel CIEES:" :error="form.errors?.ciees_level" required>
                        <FormControl v-model="form.ciees_level" :options="cieesLevels"
                            placeholder="Seleccionar un nivel" />
                    </FormField>
                </div>
                <FormField label="Vigencia:" :error="form.errors?.ciees_expiry_date" required>
                    <FormControl v-model="form.ciees_expiry_date" type="date" />
                </FormField>
            </div>
        </CardSection>

        <CardSection title="Instituciones privadas">
            <FormField label="Acreditación FIMPES:" required :error="form.errors?.fimpes_accreditation_id">
                <FormControl v-model="form.fimpes_accreditation_id" :options="fimpesAccreditations"
                    placeholder="Seleccionar una acreditación" />
            </FormField>
        </CardSection>
    </CardForm>
</template>
<script setup>
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import FormControl from "@/Components/FormControl.vue";
import FormField from "@/Components/FormField.vue";
import { mdiCertificateOutline } from "@mdi/js";
import { inject } from 'vue';
import CardSection from "@/Components/CardSection.vue";
import ToggleYesOrNot from "@/Components/ToggleYesOrNot.vue";

const form = inject('form')
const fimpesAccreditations = inject('fimpesAccreditations')
const copaesAccreditations = inject('copaesAccreditations')
const cieesAccreditations = inject('cieesAccreditations')

const cieesLevels = [
    { id: 1, name: "Nivel 1" },
    { id: 2, name: "Nivel 2" },
    { id: 3, name: "Nivel 3" }
]

</script>