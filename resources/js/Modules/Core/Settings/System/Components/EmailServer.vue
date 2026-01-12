<template>
    <CardForm class="border-forest-100/20">
        <template #header>
            <div class="flex flex-col py-4">
                <div class="flex items-center">
                    <BaseIcon class="text-forest-400" :path="mdiServerOutline" size="24" h="h-10" w="w-10" />
                    <h3 class="text-forest-400 text-xl font-bold">
                        Configuración de servidor de correo
                    </h3>
                </div>
                <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                    Ajusta los parámetros de configuración del servidor de correo
                </span>
            </div>
        </template>

        <div class="grid mb-6 md:mb-0 md:grid-cols-2 md:gap-4">
            <FormField label="Usuario" required :error="form.errors.username">
                <FormControl placeholder="usuario@ccytem.morelos.gob.mx" v-model="form.username" />
            </FormField>

            <FormField label="Contraseña" required :error="form.errors.password">
                <FormControl type="password" placeholder="Ingresa la contraseña" v-model="form.password" :icon="mdiFormTextboxPassword " />
            </FormField>

            <FormField label="Correo principal" required :error="form.errors.from_address">
                <FormControl type="email" placeholder="usuario@ccytem.morelos.gob.mx" v-model="form.from_address" :icon="mdiEmailOutline" />
            </FormField>

            <FormField label="Nombre" required :error="form.errors.from_name">
                <FormControl type="input" placeholder="PIVITMor" v-model="form.from_name" />
            </FormField>

        </div>

        <div class="grid mb-6 md:mb-0 md:grid-cols-3 md:gap-4">
            <FormField label="Host" required :error="form.errors.host">
                <FormControl placeholder="host.ccytem.morelos.gob.mx" v-model="form.host" />
            </FormField>

            <FormField label="Puerto" required :error="form.errors.port">
                <FormControl type="number" placeholder="465" :icon="mdiNumeric" v-model="form.port" />
            </FormField>

            <FormField label="Trust" :error="form.errors.trust">
                <FormControl placeholder="" v-model="form.trust" />
            </FormField>
        </div>

        <div class="grid mb-6 md:mb-0 md:grid-cols-2 md:gap-4">
            <FormField label="Protocolo" required :error="form.errors.protocol">
                <FormControl type="select" placeholder="Seleccione un protocolo de red" v-model="form.protocol"
                    :icon="mdiProtocol" :options="protocolOptions" />
            </FormField>

            <FormField label="Codificación" required :error="form.errors.encoding">
                <FormControl placeholder="Seleccione un formato de codificación" v-model="form.encoding"
                    :options="codificationFormats" :icon="mdiLock" />
            </FormField>
        </div>

        <div class="grid mb-6 md:mb-0 md:grid-cols-2 md:gap-4">
            <SwitcherToggle label="Depurador" description="Detección de errores" name="debugger" v-model="form.debug"
                :icon="Bug" :error="form.errors.debug" inputValue="boolean" />

            <SwitcherToggle label="Autenticación" description="Habilitar autenticación" name="authentication"
                v-model="form.auth_enabled" :icon="UserLock" inputValue="boolean" />

            <SwitcherToggle classes="md:col-span-2" label="STARTTLS"
                description="Actualice una conexión insegura existente a una conexión cifrada utilizando TLS o SSL"
                name="authentication" v-model="form.starttls_enabled" :icon="GlobeLock" inputValue="boolean" />
        </div>
    </CardForm>

    <CardBox class="border-forest-100/20 mt-5">
        <div class="md:flex justify-end items-center md:space-y-0 space-y-2">
            <BaseButtons>
                <BaseButton :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton :icon="mdiContentSave" color="info" label="Guardar" @click="saveForm" :loading="processing" />
            </BaseButtons>
        </div>
    </CardBox>
</template>

<script setup>
import BaseButtons from '@/Components/BaseButtons.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBox from '@/Components/CardBox.vue';
import CardForm from '@/Components/CardForm.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import { mdiClose, mdiContentSave, mdiEmailOutline, mdiNumeric, mdiProtocol, mdiServerOutline, mdiFormTextboxPassword, mdiLock   } from '@mdi/js';
import { useEmailServer } from '../Composables/useEmailServer';
import { Bug, GlobeLock, UserLock } from 'lucide-vue-next';
import SwitcherToggle from '@/Components/SwitcherToggle.vue';

const props = defineProps({
    mailSetting: {
        type: Object,
        required: true,
    },
});

const { form, saveForm, processing } = useEmailServer(props);

const protocolOptions = [
    'smtp',
];

const codificationFormats = [
    { id: 'utf-8', name: 'UTF-8' },
    { id: 'caracter_set', name: 'CARACTER_SET' },
    { id: 'iso-8859-1', name: 'ISO-8859-1' },
];

</script>