<template>
    <footer class="py-8 bg-forest-400 text-sand-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col xl:flex-row items-start justify-between gap-8">
                <div class="flex flex-wrap items-center gap-6 lg:flex-1">
                    <img :src="IMAGES.pivitmorLogoDark.src" :alt="IMAGES.pivitmorLogoDark.alt" class="">
                    <a href="https://econonet.morelos.gob.mx/">
                        <img :src="IMAGES.econonetLogo.src" :alt="IMAGES.econonetLogo.alt" class="lg:w-44 w-28">
                    </a>
                </div>
                <div class="flex flex-col md:flex-row gap-8 lg:gap-12">
                    <div class="space-y-5">
                        <div class="space-y-3">
                            <h3 class="font-bold text-lg">Contáctanos en</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center gap-2">
                                    <BaseIcon :path="mdiPhoneInTalkOutline" />
                                    <ul class="space-y-1.5" v-if="phoneNumbers.length">
                                        <li v-for="phone in phoneNumbers" :key="phone?.id ?? phone">
                                            <a :href="`tel:${phone?.dial_code ? '+' + phone.dial_code : ''}${phone?.number ?? ''}`"
                                                target="_blank" class="hover:opacity-80 transition-colors block">
                                                {{ phone?.number }}
                                                {{ phone?.dial_code ? `ext. ${phone.dial_code}` : '' }}
                                            </a>
                                        </li>
                                    </ul>
                                    <span v-else class="text-mono-300 italic">Teléfono no disponible</span>
                                </div>
                                <div class="flex items-center gap-2" v-if="contactInformation.email">
                                    <BaseIcon :path="mdiEmailOutline" />
                                    <a :href="`mailto:${contactInformation.email}`" target="_blank"
                                        class="hover:opacity-80 font-medium transition-colors">
                                        {{ contactInformation.email }}
                                    </a>
                                </div>
                                <div class="flex items-center gap-2" v-else>
                                    <BaseIcon :path="mdiEmailOutline" />
                                    <span class="text-mono-300 italic">Correo electrónico no disponible</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h3 class="font-bold text-lg">Horario de Atención</h3>
                            <div class="flex items-center gap-2 text-sm">
                                <BaseIcon :path="mdiClockTimeEightOutline" />
                                <span v-if="contactInformation.opening_time && contactInformation.closing_time">
                                    {{ contactInformation.opening_time }} - {{ contactInformation.closing_time }}
                                </span>
                                <span v-else class="text-mono-300 italic">Horario no disponible</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-5">
                     <div class="space-y-3">
                        <h3 class="font-bold text-lg">Ubicación</h3>
                        <div class="text-sm space-y-1">
                            <span v-if="contactInformation.address" class="break-words max-w-xs block">
                                {{ contactInformation.address }}
                            </span>
                            <span v-else class="text-mono-300 italic">Dirección no disponible</span>
                        </div>
                    </div>

                        <div class="space-y-3">
                            <h3 class="font-bold text-lg">Políticas</h3>
                            <div class="text-sm space-y-1">
                                <a class="hover:opacity-80 transition-colors"
                                    @click.prevent="openCookiesPolicyForm" href="#"
                                    target="_blank">
                                    Uso de cookies
                                </a>
                                <br>
                                <a class="hover:opacity-80 transition-colors"
                                    @click.prevent="openTermsAndConditionsForm" href="#"
                                    target="_blank">
                                    Terminos y condiciones
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-3">
                        <h3 class="font-bold text-lg">Contacto Rápido</h3>
                        <div class="space-y-2 text-sm">
                            <a href="#" class="block hover:text-gray-300 transition-colors">Trámites</a>
                            <a href="#" class="block hover:text-gray-300 transition-colors">Noticias</a>
                            <a href="#" class="block hover:text-gray-300 transition-colors">Organigrama</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <CookiesPolicyModal :show="isCookiesPolicyFormOpen" @close="closeCookiesPolicyForm" />
    <TermsAndConditiosModal :show="isTermsAndConditionsFormOpen" @close="closeTermsAndConditionsForm" />
</template>
<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import { IMAGES } from '@/Utils/Image';
import { mdiClockTimeEightOutline, mdiEmailOutline, mdiPhoneInTalkOutline } from '@mdi/js';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import CookiesPolicyModal from '@/Modules/Interface/Welcome/Components/CookiesPolicyModal.vue';
import { useModal } from '@/Hooks/useModal';
import TermsAndConditiosModal from '@/Modules/Interface/Welcome/Components/TermsAndConditiosModal.vue';

const page = usePage();
const contactInformation = computed(() => page.props.contactInformation?.data || {});
const phoneNumbers = computed(() => contactInformation.value.phone_numbers || []);
const { isOpen: isCookiesPolicyFormOpen, open: openCookiesPolicyForm, close: closeCookiesPolicyForm } = useModal();
const { isOpen: isTermsAndConditionsFormOpen, open: openTermsAndConditionsForm, close: closeTermsAndConditionsForm } = useModal();
</script>