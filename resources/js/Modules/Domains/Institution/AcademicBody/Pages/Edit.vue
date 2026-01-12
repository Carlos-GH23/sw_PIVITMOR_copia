<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiSchoolOutline" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <DataForm>
            <template #actions>
                <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton @click="updateForm" :icon="mdiContentSave" :processing="processing" color="success"
                    label="Actualizar" />
            </template>
        </DataForm>
    </LayoutMain>
</template>

<script setup>
import HeadLogo from "@/Components/HeadLogo.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiSchoolOutline, mdiClose, mdiContentSave, mdiTrashCan } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import DataForm from "../Components/DataForm.vue";
import { useAcademicGroup } from "../Composables/useAcademicGroup.js";

const props = defineProps({
    title: { type: String, required: true },
    routeName: { type: String, required: true },
    academicBody: { type: Object, required: true },
    departments: { type: Array, required: true },
    consolidationDegrees: { type: Array, required: true },
    researchLines: { type: Array, required: true },
    academics: { type: Array, required: true },
    economicSectors: { type: Array, required: true },
    oecdSectors: { type: Array, required: true },
});

const { processing, updateForm } = useAcademicGroup(props);
</script>
