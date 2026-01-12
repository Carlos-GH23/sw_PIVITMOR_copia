<template>
    <HeadLogo :title="title" />
    <loading v-model:active="processing" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <AcademicOfferingForm>
            <template #actions>
                <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton @click="storeForm" :icon="mdiSend" color="success" label="Guardar" />
            </template>
        </AcademicOfferingForm>
    </LayoutMain>
</template>
<script setup>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiClose, mdiPlus, mdiSend } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import AcademicOfferingForm from "../Components/AcademicOfferingForm.vue";
import { useAcademicOffering } from "../Composables/useAcademicOffering";

const props = defineProps({
    title: { type: String, required: true },
    routeName: { type: String, required: true },
    educationalLevels: { type: Array, required: true },
    studyModes: { type: Array, required: true },
    copaesAccreditations: { type: Array, required: true },
    cieesAccreditations: { type: Array, required: true },
    fimpesAccreditations: { type: Array, required: true },
    departments: { type: Array, required: true },
    oecdSectors: { type: Array, required: true },
    economicSectors: { type: Array, required: true },
});

const { storeForm, processing } = useAcademicOffering(props);
</script>
