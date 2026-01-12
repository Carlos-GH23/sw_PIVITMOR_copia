<template>
    <div class="space-y-3 py-2">
        <div class="w-full flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[150px]">
                <Slider v-model="sliderValue" :min="1" :max="5" :step="1" class="w-full" />
            </div>
            <span class="text-base font-semibold shrink-0" :class="ratingClass">
                {{ rating }}/5
            </span>
        </div>

        <div class="text-sm text-gray-600 leading-relaxed flex flex-wrap gap-x-1">
            <span class="font-medium">Escala:</span>
            <span class="text-error-300">1 Muy bajo</span> -
            <span class="text-warning-300">3 Neutral</span> -
            <span class="text-success-300">5 Muy alto</span>
        </div>
    </div>
</template>
<script setup>
import { Slider } from "@/Components/ui/slider"
import { computed } from "vue"

const rating = defineModel({ type: Number, default: 1 })

const sliderValue = computed({
    get: () => [rating.value],
    set: (val) => (rating.value = val[0]),
})

const ratingClass = computed(() => {
    if (rating.value <= 2) return 'text-error-300'
    if (rating.value === 3) return 'text-warning-300'
    if (rating.value >= 3) return 'text-success-300'
    return 'text-gray-600'
})
</script>
