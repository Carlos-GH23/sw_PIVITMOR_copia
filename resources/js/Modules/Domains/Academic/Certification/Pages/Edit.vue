<template>
    <HeadLogo :title="title" />
    <loading v-model:active="processing" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CertificationForm>
            <BaseButtons>
                <div class="flex gap-2">
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="destroyForm" :icon="mdiDelete" color="danger"
                        label="Eliminar" />
                    <BaseButton @click="updateForm" :icon="mdiCheck" color="success" label="Guardar" />
                </div>
            </BaseButtons>
        </CertificationForm>
    </LayoutMain>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiCheck, mdiClose, mdiPlus, mdiDelete } from '@mdi/js';
import { useCertification } from '../Composables/useCertification';
import CertificationForm from '../Components/CertificationForm.vue';
import BaseButtons from '@/Components/BaseButtons.vue';
import FormCheckRadio from '@/Components/FormCheckRadio.vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    countries: {
        type: Array,
        required: true,
    },
    levels: {
        type: Array,
        required: true,
    },
    entities: {
        type: Array,
        required: true,
    },
    statuses: {
        type: Array,
        required: true,
    },
    certification: {
        type: Object,
        required: true,
    },
});

const { form, processing, updateForm, destroyForm } = useCertification(props);
</script>