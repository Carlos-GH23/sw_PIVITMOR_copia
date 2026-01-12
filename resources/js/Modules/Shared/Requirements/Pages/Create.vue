<template>
    <HeadLogo :title="title" />
    <loading v-model:active="processing" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <RequirementForm>
            <template #actions>
                <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton @click="storeForm(true)" :icon="mdiContentSave" color="lightDark"
                    label="Guardar borrador" />
                <BaseButton @click="storeForm(false)" :icon="mdiSend" color="success" label="Enviar" />
            </template>
        </RequirementForm>
    </LayoutMain>
</template>
<script setup>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {
    mdiClose,
    mdiContentSave,
    mdiPlus,
    mdiSend,
} from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import RequirementForm from "../Components/RequirementForm.vue";
import { useRequirement } from "../Composables/useRequirement";
import { provide } from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    department: {
        type: Object,
        default: () => ({}),
    },
    intellectuals: {
        type: Object,
        default: () => ({}),
    },
    technologies: {
        type: Object,
        default: () => ({}),
    },
    oecdSectors: {
        type: Object,
        default: () => ({}),
    },
    economicSectors: {
        type: Object,
        default: () => ({}),
    },
    routeName: {
        type: String,
        required: true,
    },
});

const { storeForm, processing } = useRequirement(props);
provide("props", props)
</script>