<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiEmail" :title="title" main>
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" />
            </div>
        </SectionTitleLineWithButton>
        <DataForm />
        <CardBox class="mt-4">
            <div class="flex justify-end pr-4 gap-4 mt-2">
                <BaseButton :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton color="success" :icon="mdiSend" label="Enviar" @click="storeForm" :loading="processing"/> 
            </div>
        </CardBox>
    </LayoutMain>
</template>

<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiClose, mdiSend, mdiEmail } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import DataForm from "../Components/Dataform.vue";
import { useCommunications } from "../Composables/useCommunications";


const props = defineProps({
    title: {
        type: String,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    roles: {
        type: Object,
        required: true
    },
    statuses: {
        type: Object,
        required: true
    }
});

const { form, storeForm, processing } = useCommunications(props);

</script>
