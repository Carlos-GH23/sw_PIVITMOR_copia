<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import BaseButton from '@/Components/BaseButton.vue';
import { mdiEmailArrowRight } from '@mdi/js';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <HeadLogo title="Verificar correo" />
    <LayoutWelcome>
        <section class="flex items-center justify-center min-h-screen bg-gray-100">
            <div class="max-w-lg w-full">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h1 class="my-4 text-center text-2xl md:text-3xl font-extrabold text-earth-100">
                        Gracias por registrarte
                    </h1>

                    <div class="mb-4 text-base text-gray-600">
                        Para completar tu registro, verifica tu dirección de correo electrónico haciendo clic en el
                        enlace que te acabamos de enviar. Si no lo recibiste, con gusto te enviaremos otro.
                    </div>

                    <div class="mb-4 font-medium text-sm text-green-700" v-if="verificationLinkSent">
                        Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que
                        proporcionó
                        durante el registro.
                    </div>

                    <form @submit.prevent="submit">
                        <div class="mt-4 flex items-center justify-between gap-4">
                            <BaseButton :class="{ 'opacity-45': form.processing }" color="info"
                                :icon="mdiEmailArrowRight" label="Enviar email" type="submit" @click="submit" />

                            <Link :href="route('logout')" method="post" as="button"
                                class="text-center font-bold text-sm text-wine-400  hover:text-md hover:opacity-90 rounded-md hover:underline underline-offset-4 transition-all hover:cursor-pointer">
                            Cerrar sesión
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </LayoutWelcome>
</template>
