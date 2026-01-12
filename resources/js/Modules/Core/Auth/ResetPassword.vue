<script setup>
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue';
import SectionFullScreen from '@/Components/SectionFullScreen.vue'
import { useForm } from '@inertiajs/vue3';
import { mdiEmail, mdiLock } from '@mdi/js'
import BaseButton from '@/Components/BaseButton.vue';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <HeadLogo title="Reestablecer contraseña" />
    <LayoutWelcome>
        <SectionFullScreen bg="white">
            <div class="w-xl">
                <div class="border-2 border-forest-100 p-6 rounded-lg shadow-sm">
                    <h1 class="mt-4 mb-8 text-center text-2xl lg:text-3xl font-bold text-earth-100">
                        Reestablecer contraseña
                    </h1>

                    <FormField label="Correo electrónico" label-for="Correo electrónico" :error="form.errors.email"
                        class="dark:text-white">
                        <FormControl v-model="form.email" :icon="mdiEmail" id="Correo electrónico" autocomplete="email"
                            type="email" required />
                    </FormField>

                    <FormField label="Contraseña Nueva:" :error="form.errors.password" class="dark:text-white">
                        <FormControl type="password" v-model="form.password" :icon="mdiLock"
                            placeholder="Contraseña Nueva" required />
                    </FormField>

                    <FormField label="Contraseña Confirmación:" :error="form.errors.password_confirmation"
                        class="dark:text-white">
                        <FormControl type="password" v-model="form.password_confirmation" :icon="mdiLock"
                            placeholder="Confirmar contraseña" required />
                    </FormField>

                    <BaseButton class="w-full" :small="false" :processing="form.processing" @click="submit" color="info"
                        label="Enviar correo" />
                </div>
            </div>
        </SectionFullScreen>
    </LayoutWelcome>
</template>
