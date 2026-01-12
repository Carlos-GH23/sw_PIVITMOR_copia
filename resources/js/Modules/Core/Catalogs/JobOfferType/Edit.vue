<template>
    <HeadLogo :title="title" />
    <loading v-model:active="processing" :can-cancel="false" :is-full-page="true" loader="dots" color="#283C2A" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>
        <CardBox>
            <DataForm :form="form" />

            <template #footer>
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="updateForm" :icon="mdiCheck" color="success" label="Guardar"
                        :processing="form.processing" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>
<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiPlus, mdiClose, mdiCheck, mdiTrashCan } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import { useForm } from "@inertiajs/vue3";
import DataForm from "./DataForm.vue";
import HeadLogo from "@/Components/HeadLogo.vue";

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    jobOfferType: {
        type: Object,
        required: true
    },
});

const form = useForm({
    id: props.jobOfferType.data?.id,
    name: props.jobOfferType.data?.name,
    description: props.jobOfferType.data?.description,
});


import { computed } from 'vue';

const processing = computed(() => form.processing);

const updateForm = () => {
    form.put(route(`${props.routeName}update`, props.jobOfferType.data?.id));
};

</script>
