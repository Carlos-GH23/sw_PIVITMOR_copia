<template>
    <div class="border group hover:shadow-md rounded-lg border-forest-50/40 transition-all duration-300">
        <div class="pb-2 pt-5 px-5">
            <div class="flex justify-between items-start mb-4">
                <Badge :color="resourceColor[data.resource_type]" variant="solid">
                    {{ resourceType[data.resource_type] }}
                </Badge>

                <Badge v-if="data.period?.remaining_days" variant="soft">
                    <Clock class="w-3 h-3" />
                    <span>{{ data.period.remaining_days }} días</span>
                </Badge>
            </div>

            <div class="flex flex-col text-xs text-slate-500 gap-1 mb-2">
                <span v-if="data.institution_category"
                    class="font-medium text-slate-400 uppercase tracking-wider text-[10px]">
                    {{ data.institution_category }}
                </span>
                <div v-if="data.institution_code !== 'ebt' && data.resource_type !== 'requirement'"
                    class="flex items-center gap-1 text-slate-600 font-medium">
                    <GraduationCap v-if="data.resource_type === 'academic'" class="w-3 h-3" />
                    <Building2 v-else class="w-3 h-3" />
                    <span>{{ data.institution_name }}</span>
                </div>
            </div>

            <h3
                class="font-bold text-lg leading-tight text-forest-400 group-hover:text-foreground transition-colors min-h-12 line-clamp-2 mb-1">
                {{ data.title }}
            </h3>

            <div v-if="data.state && data.municipality" class="flex items-center gap-1 text-xs text-slate-500 mb-2">
                <MapPin class="w-3 h-3" />
                <span>{{ data.municipality }}, {{ data.state }}</span>
            </div>
        </div>

        <div class="px-5 pb-4 flex-1">
            <p v-html="data.description"
                class="text-sm text-slate-600 min-h-16 line-clamp-3 text-justify leading-relaxed" />
            <div class="mt-4 flex flex-wrap gap-2">
                <Badge v-for="match in data.matches" :key="match" color="green">{{ match }}</Badge>
            </div>
        </div>

        <Separator class="bg-slate-100" />

        <div class="px-5 py-3 bg-slate-50/50 flex justify-end items-center mt-auto">
            <BaseButton @click="$emit('openModal', data)" class="border-0" outline color="info" label="Ver detalles" />
        </div>
    </div>
</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import BaseButton from '@/Components/BaseButton.vue';
import { Separator } from '@/Components/ui/separator';
import { Building2, Clock, GraduationCap, MapPin } from 'lucide-vue-next';
import { resourceType, resourceColor } from '@/Utils/resources.js';

const props = defineProps({
    data: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['openModal']);
</script>