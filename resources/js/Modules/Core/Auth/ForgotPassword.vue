<script setup>
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue';
import SectionFullScreen from '@/Components/SectionFullScreen.vue'
import { mdiEmail } from '@mdi/js'
import { useForm } from '@inertiajs/vue3';
import BaseButton from '@/Components/BaseButton.vue';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <HeadLogo title="Recuperar contraseña" />

    <LayoutWelcome>
        <SectionFullScreen bg="white">
            <div class="grid space-y-4 md:space-y-0 md:space-x-4 md:grid-cols-3 lg:max-w-3xl h-[400px]">
                <div
                    class="flex flex-col justify-center items-center col-span-2 p-6 border-3 rounded-lg border-forest-100">
                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600 col-span-2 ">
                        {{ status }}
                    </div>

                    <FormField label="Ingresa tu correo electrónico" label-for="Correo electrónico"
                        class="dark:text-white w-full" :error="form.errors.email">
                        <FormControl @keyup.enter="submit" v-model="form.email" :icon="mdiEmail"
                            placeholder="Ej: usuario@mail.com" id="Correo electrónico" autocomplete="email" type="email"
                            required />
                    </FormField>

                    <BaseButton class="w-full" :small="false" :processing="form.processing" @click="submit" color="info"
                        label="Enviar correo" />
                </div>

                <div
                    class="flex flex-col p-4 justify-center items-center rounded-lg bg-pantone-400 text-sand-100">
                    <h1 class="my-4 text-center text-2xl lg:text-3xl font-bold">
                        Recuperar contraseña
                    </h1>
                    <div class="mb-4 text-center text-sm md:text-lg">
                        Introduce tu correo electrónico registrado para recibir un enlace que te permitirá restablecer
                        tu contraseña.
                    </div>
                </div>
            </div>
        </SectionFullScreen>
    </LayoutWelcome>
</template>
