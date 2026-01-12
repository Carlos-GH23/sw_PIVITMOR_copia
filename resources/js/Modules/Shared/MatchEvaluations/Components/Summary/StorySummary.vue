<template>
    <CardBox>
        <h3 class="text-base text-forest-400 font-semibold mb-6">
            Historia breve
        </h3>
        <div class="space-y-4 w-full h-[50vh] overflow-y-auto">
            <LabelText label="Historia">
                <div v-html="form.story" class="ql-content leading-relaxed mt-1 line-clamp-3"></div>
            </LabelText>

            <LabelText label="Objetivo">
                <div v-html="form.goals" class="ql-content leading-relaxed mt-1 line-clamp-3"></div>
            </LabelText>

            <LabelText label="Resultados">
                <div v-html="form.results" class="ql-content leading-relaxed mt-1 line-clamp-3"></div>
            </LabelText>

            <LabelText label="Lecciones">
                <div v-html="form.lessons" class="ql-content leading-relaxed mt-1 line-clamp-3"></div>
            </LabelText>
        </div>
    </CardBox>
</template>
<script setup>
import { inject } from 'vue';
import LabelText from '@/Components/LabelText.vue';
import CardBox from '@/Components/CardBox.vue';

const form = inject('matchEvaluationForm')
</script>