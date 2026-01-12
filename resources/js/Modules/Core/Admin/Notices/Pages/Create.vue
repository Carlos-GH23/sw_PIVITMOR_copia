<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>
        
        <NoticeForm>
            <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
            <BaseButton @click="openModal" type="button" v-if="activeTab === 'metadata'" :icon="mdiEye" color="contrast" label="Previsualizar" />
            <BaseButton @click="storeForm" :icon="mdiContentSave" color="lightDark" label="Guardar borrador" />
            <BaseButton @click="storeForm(false)" :icon="mdiSend" :processing="processing" color="success"
                label="Enviar" />
        </NoticeForm>

        <DialogModal :show="showFile" :closeable="true" @close="closeModal">
            
            <template #title>
                <SectionTitleLineWithButton title="Previsualización de la noticia" :hisBreadCrumb="false"
                :icon="mdiEye" />
            </template>

            <template #content>
                <Preview />
            </template>
            
            <template #footer>
                <BaseButton @click="closeModal" color="lightDark" label="Cerrar" :icon="mdiClose" />
            </template>
        </DialogModal>
    </LayoutMain>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { mdiClose, mdiContentSave, mdiPlus, mdiSend, mdiEye  } from '@mdi/js';
import NoticeForm from '../Components/NoticeForm.vue';
import { useNotice, previewNotice } from '../Composables/useNotice';
import { useTabs } from '../Composables/useTabs';
import Preview from '../Components/Preview.vue';
import DialogModal from '@/Components/DialogModal.vue';

const { activeTab } = useTabs();

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    },
    statuses: {
        type: Object,
        required: true,
    },
});

const { processing, storeForm } = useNotice(props);
const {  openModal, closeModal, showFile } = previewNotice();
</script>