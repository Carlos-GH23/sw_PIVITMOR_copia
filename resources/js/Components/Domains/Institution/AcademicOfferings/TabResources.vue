<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiCertificate" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Acreditaciones
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Acreditaciones y reconocimientos del programa
                    </p>
                </div>
            </div>
        </template>
        <CardSection title="Acreditación FIMPES"
            description="Acreditación de la Federación de Instituciones Mexicanas Particulares de Educación Superior"
            :hasDivider="false">
            <div v-if="data.fimpes_accreditation">
                <LabelText label="Acreditación" :text="data.fimpes_accreditation.name" />
            </div>
            <CardBoxComponentEmpty v-else />
        </CardSection>

        <CardSection title="Acreditaciones COPAES"
            description="Acreditaciones del Consejo para la Acreditación de la Educación Superior">
            <div v-if="data.copaes_accreditation_program" class="space-y-6">
                <div class="grid md:grid-cols-2 gap-4">
                    <LabelText label="Tipo de acreditación COPAES"
                        :text="data.copaes_accreditation_program.copaes_accreditation.name" />
                    <LabelText label="Vigencia" :text="data.copaes_accreditation_program.expiry_date" />
                </div>
            </div>
            <CardBoxComponentEmpty v-else />
        </CardSection>

        <CardSection title="Acreditaciones CIEES"
            description="Acreditaciones de los Comités Interinstitucionales para la Evaluación de la Educación Superior">
            <div v-if="data.ciees_accreditation_program" class="space-y-4">
                <div class="grid md:grid-cols-3 gap-4">
                    <LabelText label="Tipo de CIEES"
                        :text="data.ciees_accreditation_program.ciees_accreditation.name" />
                    <LabelText label="Vigencia" :text="data.ciees_accreditation_program.expiry_date" />
                    <LabelText label="Nivel de CIEES" :text="data.ciees_accreditation_program.level" />
                </div>
            </div>
            <CardBoxComponentEmpty v-else />
        </CardSection>

        <CardSection title="Archivos relacionados" description="Documentos y archivos de la oferta académica">
            <FilesTable :files="data.files" />
        </CardSection>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import LabelText from '@/Components/LabelText.vue';
import FilesTable from '@/Components/FilesTable.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import { mdiCertificate } from '@mdi/js';

const props = defineProps({
    hasBorder: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
        required: false,
    },
});
</script>
