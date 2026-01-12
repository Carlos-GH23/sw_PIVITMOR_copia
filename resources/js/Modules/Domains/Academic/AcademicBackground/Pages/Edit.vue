<template>
    <HeadLogo :title="title" />

    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPencil" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <DataForm
            :form="form"
            :academicDegrees="academicDegrees"
            :knowledgeAreas="knowledgeAreas"
            :countries="countries"
        >
            <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
            <BaseButton @click="updateForm" :icon="mdiContentSave" color="success" label="Guardar cambios" :processing="processing" />
        </DataForm>
    </LayoutMain>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import DataForm from '../Components/DataForm.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiClose, mdiContentSave, mdiPencil } from '@mdi/js';
import { useAcademicBackground } from '../Composables/useAcademicBackground';

const props = defineProps({
    title: { type: String, default: 'Editar Formación Académica' },
    routeName: { type: String, required: true },
    academicBackground: { type: Object, required: true },
    academicDegrees: { type: Array, default: () => [] },
    knowledgeAreas: { type: Array, default: () => [] },
    countries: { type: Array, default: () => [] },
});

const { form, updateForm, processing } = useAcademicBackground(props.routeName, props.academicBackground);
</script>
