<template>
    <HeadLogo :title="title" />
    <LayoutAuthenticated>
        <SectionTitleLineWithButton :icon="mdiApplicationCogOutline" :title="title" main />

        <Tabs defaultValue="email-server">
            <TabsList class="grid w-full grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 h-auto ">
                <TabsTrigger v-for="tab in tabs" :value="tab.value" class=" flex items-center gap-2 p-2 cursor-pointer">
                    <div class="flex items-center">
                        <p class="text-start whitespace-pre-line">{{ tab.name }}</p>
                    </div>
                </TabsTrigger>
            </TabsList>

            <TabsContent value="email-server" class="pt-5">
                <EmailServer :mailSetting="props.mailSetting" />
            </TabsContent>

            <TabsContent value="privacy-compliance" class="pt-5">
                <PrivacyCompliance :privacityCompliances="props.privacityCompliances" :filters="props.filters"
                    :routeName="props.routeName" :consentConfigurations="props.consentConfigurations" />
            </TabsContent>

            <TabsContent value="usage-politics" class="pt-5">
                <UsagePoliticsForm :policies="props.policies" />
            </TabsContent>

            <TabsContent value="email-templates" class="pt-5">
                <EmailTemplates :routeName="props.routeName" :emailTemplates="props.emailTemplates" />
            </TabsContent>
        </Tabs>
    </LayoutAuthenticated>
</template>

<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import { mdiApplicationCogOutline } from '@mdi/js';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs/index.js";
import EmailServer from '../Components/EmailServer.vue';
import PrivacyCompliance from '../Components/PrivacyCompliance.vue';
import UsagePoliticsForm from '../Components/UsagePoliticsForm.vue';
import EmailTemplates from '../Components/EmailTemplates.vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    filters: {
        type: Object,
        required: false,
    },
    policies: {
        type: Object,
        required: true,
    },
    consentConfigurations: {
        type: Object,
        required: true,
    },
    privacityCompliances: {
        type: Object,
        required: true,
    },
    emailTemplates: {
        type: Object,
        required: true,
    },
    mailSetting: {
        type: Object,
        required: true,
    },
});

const tabs = [
    {
        value: "email-server",
        name: "Servidor de correo",
    },
    {
        value: "privacy-compliance",
        name: "Privacidad y cumplimiento",
    },
    {
        value: "usage-politics",
        name: "Políticas",
    },
    {
        value: "email-templates",
        name: "Plantillas de correo electrónico",
    },
];

</script>