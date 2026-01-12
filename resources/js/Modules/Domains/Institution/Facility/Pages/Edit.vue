<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox isForm>
            <DataForm :facility-types="facilityTypes" :departments="departments" :facility="facility" />
            <template #footer>
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="updateForm" :icon="mdiCheck" :processing="processing" color="success"
                        label="Guardar" />
                    <BaseButton @click="destroyForm" :icon="mdiDelete" :processing="processing" color="danger"
                        label="Eliminar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>

<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiPlus, mdiClose, mdiDelete, mdiCheck } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import DataForm from "../Components/DataForm.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useFacility } from "../Composables/useFacility";

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    facility: {
        type: Object,
        required: true
    },
    facilityTypes: {
        type: Array,
        required: true
    },
    departments: {
        type: Array,
        required: true
    },
});
const { form, processing, updateForm, destroyForm } = useFacility(props.routeName, props.facility);

</script>
