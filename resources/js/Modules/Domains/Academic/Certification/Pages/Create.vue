<template>
    <HeadLogo :title="title" />

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
                    <BaseButton @click="saveForm" :icon="mdiCheck" color="success" label="Guardar"
                        :processing="processing" />
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
import { mdiCheck, mdiClose, mdiPlus } from '@mdi/js';
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
});

const { form, processing, saveForm } = useCertification(props);

</script>