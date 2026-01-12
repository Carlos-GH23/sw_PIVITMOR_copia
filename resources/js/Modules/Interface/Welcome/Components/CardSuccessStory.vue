<template>
    <div
        class="bg-white rounded-xl p-8 transition-shadow duration-600 cursor-default hover:shadow-2xl shadow flex flex-col">

        <div class="flex items-center justify-between mb-6 transition-opacity duration-600">
            <span class="bg-wine-400 text-white px-4 py-2 rounded-full text-sm font-medium">
                {{ successStory?.category }}
            </span>

            <div class="text-accent-yellow flex">
                <svg v-for="i in successStory.rating" :key="i" class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </div>
        </div>

        <div class="flex-1">
            <h3 class="text-forest-400 text-xl font-bold mb-4 transition-opacity duration-600 line-clamp-2">
                {{ successStory.title }}
            </h3>

            <p class="mb-4 line-clamp-2 text-justify transition-opacity duration-600">
                {{ successStory.description }}
            </p>

            <div>
                <div class="text-forest-400 flex flex-col md:flex-row md:items-center flex-wrap gap-2 mb-6">
                    <span class="text-xs font-medium w-full md:max-w-[46%]">
                        {{ successStory.actors.applicant_entity.name }}
                    </span>

                    <span class="text-gray-400 hidden md:block text-lg">×</span>

                    <span class="text-xs font-medium w-full md:max-w-[46%]">
                        {{ successStory.actors.offering_entity.name }}
                    </span>
                </div>

                <div class="rounded-lg p-4 mb-4">
                    <swiper :pagination="true" :modules="[Pagination]" class="mySwiper">
                        <swiper-slide v-for="item in successStory.testimonials">
                            <div class="flex items-start gap-3 mb-4 pb-2">
                                <img :src="IMAGES.user.src" :alt="IMAGES.user.alt"
                                    class="w-12 h-12 rounded-full object-cover" loading="lazy" />
                                <div class="text-forest-400 flex-1">
                                    <BaseIcon :path="mdiFormatQuoteClose" size="34" h="h-auto" w="w-auto" />
                                    <p class="font-extrabold italic mb-2 line-clamp-4">
                                        "{{ item.testimonial }}"
                                    </p>
                                    <p class="text-sm">
                                        — {{ item.name }}, {{ item.position }}
                                    </p>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>

                    <slot name="comments" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 justify-between mt-4 pt-4">
            <span class="font-semibold max-w-[46%]">
                {{ successStory.indicator_linking_satisfaction?.name }}
            </span>

            <slot name="actions" />
        </div>
    </div>
</template>
<script setup>
import BaseIcon from "@/Components/BaseIcon.vue";
import { IMAGES } from "@/Utils/Image";
import { mdiFormatQuoteClose } from "@mdi/js";
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

const props = defineProps({
    successStory: {
        type: Object,
        required: true,
    },
});
</script>
