<template>
    <HeadLogo :title="title" />
    <LayoutWelcome>
        <SectionWrapper :hasLayer="false">
            <div>
                <TitleLineWithIcon class="mx-auto mb-6">
                    Noticias de <span class="font-extrabold">interés</span>
                </TitleLineWithIcon>
                <div class="w-24 h-1 mb-5 bg-wine-50 mx-auto rounded-full" />

                <p class="text-center text-lg leading-relaxed ">
                    Te presentamos un resumen de las últimas noticias.
                </p>
            </div>
        </SectionWrapper>

        <div class="bg-sand-50/50 min-h-dvh">
            <div class="p-8 max-w-[120rem] mx-auto">
                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <NewCard @read-more="readMore(item)" v-for="item in notices.data" :key="item.id"
                        v-bind="item" />
                </div>
                <pagination v-if="notices?.meta" :links="notices.meta.links" :total="notices.meta.total" :to="notices.meta.to" :from="notices.meta.from" />
            </div>
            
        </div>
    </LayoutWelcome>
</template>

<script setup>
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutWelcome from '@/Layouts/LayoutWelcome.vue';
import SectionWrapper from '../Components/SectionWrapper.vue';
import TitleLineWithIcon from '@/Components/TitleLineWithIcon.vue';
import NewCard from '../Components/NewCard.vue';
import Pagination from '@/Components/Pagination.vue';
import { readMore } from '../Composables/useNew';

const props = defineProps({
    title: {
        type: String,
        default: 'Noticias',
    },
    notices: {
        type: Object,
        default: () => ({}),
    },
});

</script>