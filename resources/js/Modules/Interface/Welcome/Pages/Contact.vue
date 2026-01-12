<template>
    <HeadLogo title="Contacto" />
    <LayoutWelcome>
        <SectionWrapper :has-layer="false">
            <TitleLineWithIcon class="mx-auto mb-12">
                <strong class="font-extrabold">Contáctanos</strong>
            </TitleLineWithIcon>

            <div class="min-h-screen">
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 space-y-20">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-earth-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-earth-100 mb-1">Escríbenos a</h4>
                                <template v-if="contactInformation.email">
                                    <a :href="`mailto:${contactInformation.email}`" target="_blank"
                                        class="text-mono-400 hover:opacity-80 font-medium transition-colors">
                                        {{ contactInformation.email }}
                                    </a>
                                </template>
                                <template v-else>
                                    <span class="text-mono-300 italic">Correo electrónico no disponible</span>
                                </template>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-earth-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-earth-100 mb-1">Llámanos</h4>
                                <template v-if="phoneNumbers.length">
                                    <ul class="space-y-1">
                                        <li v-for="(phone, idx) in phoneNumbers" :key="phone?.id ?? idx">
                                            <a :href="`tel:${phone?.dial_code ? '+' + phone.dial_code : ''}${phone?.number ?? ''}`" target="_blank"
                                                class="text-mono-400 hover:opacity-80 font-medium transition-colors block">
                                                {{ phone?.number ?? '' }} {{ phone?.dial_code ? `ext. ${phone.dial_code} ` : '' }}
                                            </a>
                                        </li>
                                    </ul>
                                </template>
                                <template v-else>
                                    <span class="text-mono-300 italic">Teléfono no disponible</span>
                                </template>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-earth-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-earth-100 mb-1">Visítanos</h4>
                                <address class="text-mono-400 not-italic leading-relaxed">
                                    <template v-if="contactInformation.address">
                                        <span>{{ contactInformation.address }}</span>
                                    </template>
                                    <template v-else>
                                        <span class="text-mono-300 italic">Dirección no disponible</span>
                                    </template>
                                </address>
                            </div>
                        </div>
                    </div>

                    <div class="lg:sticky lg:top-8">
                        <div class="overflow-hidden">
                            <div class="mb-2">
                                <h3 class="text-xl font-semibold text-gray-900">Nuestra Ubicación</h3>
                                <p class="text-gray-600 mt-1">CCyTEM</p>
                            </div>
                            <div ref="mapContainer" class="h-[450px] w-full rounded-xl border border-gray-200"></div>
                        </div>
                    </div>
                </div>
            </div>
        </SectionWrapper>
    </LayoutWelcome>
</template>

<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue';
import SectionWrapper from '../Components/SectionWrapper.vue';
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import { usePage } from '@inertiajs/vue3';
import { computed, onMounted, nextTick } from 'vue';
import { useMap } from '@/Layouts/Composables/useMap';

const page = usePage();
const contactInformation = computed(() => page.props.contactInformation?.data || {});
const phoneNumbers = computed(() => contactInformation.value.phone_numbers || []);

const { mapContainer, initWithCoords, setMarker } = useMap({
    interactive: false, 
});

onMounted(async () => {
    await nextTick();
    const info = contactInformation.value;
    if (info.latitude && info.longitude) {        initWithCoords(info.latitude, info.longitude, info.address || 'Nuestra ubicación');
    } else {
        setMarker(18.9242, -99.2216, info.address || 'Ubicación no disponible');
    }
});
</script>