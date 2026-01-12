<template>
    <Modal :show="showModal" :closeable="true" @close="close">
        <div class="bg-white">
            <div
                class="sticky top-0 z-10 flex items-center justify-between p-6 backdrop-blur-sm border-b border-border rounded-t-xl">
                <div class="flex items-center gap-3">
                    <div class="p-2 flex justify-center items-center bg-wine-400 rounded-lg">
                        <BaseIcon :path="mdiOffer" class="text-white" />
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-earth-300">{{ resourceTypeLabel }}</h2>
                        <p class="text-sm text-muted-foreground">{{ institutionDisplay }}</p>
                    </div>
                </div>
                <BaseButton @click="close" :icon="mdiClose" roundedFull color="white" />
            </div>

            <div class="p-6 space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="relative aspect-video rounded-lg overflow-hidden bg-muted">
                        <img :src="offer.photos && offer.photos.length ? offer.photos[0].path : IMAGES.image.src"
                            alt="Imagen tecnología" class="w-full h-full object-contain" loading="lazy" 
                            @error="$event.target.src = IMAGES.image.src" />
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-earth-200 leading-tight">
                            {{ offer.title }}
                        </h2>

                        <div v-if="allTags.length > 0" class="relative py-2">
                            <button v-if="allTags.length > 1" @click="scrollCarousel('left')"
                                class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/90 hover:bg-wine-50 hover:scale-110 shadow-lg hover:shadow-xl rounded-full p-1.5 transition-all cursor-pointer group">
                                <BaseIcon :path="mdiChevronLeft" class="w-4 h-4 text-wine-50 group-hover:text-white transition-colors" />
                            </button>

                            <div :class="allTags.length > 1 ? 'overflow-hidden px-10' : 'overflow-hidden'">
                                <div ref="tagsCarousel" :class="allTags.length > 1 ? 'flex justify-center items-center min-h-[32px]' : 'flex justify-start items-center min-h-[32px]'">
                                    <transition name="tag-fade" mode="out-in">
                                        <span :key="currentTagIndex"
                                            class="px-3 py-1 text-xs font-medium text-wine-50 bg-wine-50/20 rounded-full border border-wine-50 text-center">
                                            {{ allTags[currentTagIndex] }}
                                        </span>
                                    </transition>
                                </div>
                            </div>

                            <button v-if="allTags.length > 1" @click="scrollCarousel('right')"
                                class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/90 hover:bg-wine-50 hover:scale-110 shadow-lg hover:shadow-xl rounded-full p-1.5 transition-all cursor-pointer group">
                                <BaseIcon :path="mdiChevronRight" class="w-4 h-4 text-wine-50 group-hover:text-white transition-colors" />
                            </button>

                            <div v-if="allTags.length > 1" class="flex justify-center gap-1.5 mt-3">
                                <button v-for="(tag, index) in allTags" :key="`dot-${index}`" @click="goToTag(index)"
                                    :class="[
                                        'h-2 rounded-full transition-all duration-300 cursor-pointer hover:scale-150',
                                        currentTagIndex === index ? 'bg-wine-50 w-6' : 'bg-wine-50/30 w-2 hover:bg-wine-50'
                                    ]">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="text-mono-900 text-justify leading-relaxed">
                        {{ cleanDescription || 'Sin descripción técnica disponible.' }}
                    </p>
                </div>
            </div>


            <button @click="close"
                class="w-full py-2 rounded-t-none rounded-sm text-white hover:cursor-pointer hover:opacity-90 transition-all bg-wine-400">
                ¿Quieres conocer más de esta tecnología? Regístrate
            </button>
        </div>
    </Modal>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import Modal from '@/Components/Modal.vue';
import { IMAGES } from '@/Utils/Image';
import { mdiChevronLeft, mdiChevronRight, mdiClose, mdiOffer } from '@mdi/js';
import { useOfferModal } from '../Composables/useOfferModal';

const props = defineProps({
    showModal: {
        type: Boolean,
        required: true
    },
    offer: {
        type: Object
    }
});

const emit = defineEmits(['close']);

const {
    currentTagIndex,
    cleanDescription,
    allTags,
    scrollCarousel,
    goToTag,
    close,
    resourceTypeLabel,
    institutionDisplay
} = useOfferModal(props, emit);
</script>

<style scoped>
.tag-fade-enter-active,
.tag-fade-leave-active {
    transition: all 0.3s ease;
}

.tag-fade-enter-from {
    opacity: 0;
    transform: translateX(20px);
}

.tag-fade-leave-to {
    opacity: 0;
    transform: translateX(-20px);
}
</style>