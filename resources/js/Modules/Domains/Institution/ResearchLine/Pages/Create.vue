<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiLayersSearchOutline" :title="title" main
            :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <DataForm>
            <template #actions>
                <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton @click="storeForm" :icon="mdiSend" :processing="processing" color="success"
                    label="Guardar" />
            </template>
        </DataForm>
    </LayoutMain>
</template>

<script setup>
import HeadLogo from "@/Components/HeadLogo.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiClose, mdiLayersSearchOutline, mdiSend } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import DataForm from "../Components/DataForm.vue";
import { useResearchLine } from "../Composables/useResearchLine.js";

const props = defineProps({
    title: { type: String, required: true },
    routeName: { type: String, required: true },
    economicSectors: { type: Array, required: true },
    oecdSectors: { type: Array, required: true },
    departments: { type: Array, required: true },
    academics: { type: Array, required: true },
});

const { processing, storeForm } = useResearchLine(props);

</script>
