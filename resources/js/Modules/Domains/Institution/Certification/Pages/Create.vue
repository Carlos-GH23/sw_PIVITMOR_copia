<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>
        <CardBox isForm>
            <DataForm :form="form" :errors="form.errors" :certificationTypes="certificationTypes"
                :departments="departments" :resourceTypes="resourceTypes" />
        </CardBox>
        <div class="my-6"></div>
        <CardBox>
            <BaseButtons>
                <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton @click="saveForm" :icon="mdiCheck" color="success" label="Guardar"
                    :processing="form.processing" />
            </BaseButtons>
        </CardBox>
    </LayoutMain>
</template>

<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiPlus, mdiClose, mdiCheck } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import DataForm from "../Components/DataForm.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useCertification } from "../Composables/useCertification";

const props = defineProps({
    title: { type: String, default: "Crear Certificación" },
    routeName: { type: String, default: "certifications." },
    certificationTypes: { type: Array, default: () => [] },
    departments: { type: Array, default: () => [] },
    resourceTypes: { type: Array, default: () => [] },
});

const { form, processing, saveForm } = useCertification(props.routeName);
</script>