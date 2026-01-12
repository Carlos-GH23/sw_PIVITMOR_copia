<template>
    <BaseDivider v-if="hasDivider" />

    <section>
        <div :class="{ 'flex items-center gap-2': $slots.icon }">
            <slot name="icon" />

            <slot v-if="$slots.title" name="title" />

            <div v-else>
                <h3 class="text-base/7 font-semibold">{{ title }}</h3>
                <span class="text-sm/6 text-gray-400">{{ description }}</span>
            </div>
        </div>

        <div class="mt-6">
            <slot />
        </div>
    </section>
</template>

<script setup>
import BaseDivider from '@/Components/BaseDivider.vue';

defineProps({
    title: String,
    description: String,
    hasDivider: { type: Boolean, default: true },
});
</script>