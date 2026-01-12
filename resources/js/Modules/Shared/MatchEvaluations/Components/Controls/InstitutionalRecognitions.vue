<template>
    <div class="w-full space-y-4">
        <div class="flex justify-between items-center">
            <Badge show-dot>
                {{ recognitions.length }} reconocimientos
            </Badge>
            <BaseButton label="Agregar reconocimiento" :icon="mdiPlus" color="lightDark" rounded-full
                @click="addRecognition" />
        </div>
        <div class="space-y-3 max-h-[770px] overflow-y-auto">
            <div v-for="(item, index) in recognitions" :key="item.id"
                class="relative bg-gray-50 rounded-lg p-4 border border-gray-200 hover:border-gray-300 transition-colors">
                <div class="flex gap-2 justify-between items-center">
                    <p class="text-gray-500 font-semibold">
                        #{{ index + 1 }}
                    </p>
                    <BaseButton title="Eliminar" :icon="mdiClose" color="lightDark" rounded-full
                        @click="removeRecognition(index)" />
                </div>
                <div class="space-y-3 pr-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <FormField label="Reconocimiento" required :error="errors[`recognitions.${index}.name`]">
                            <FormControl v-model="item.name" placeholder="Ingresa una descripción" />
                        </FormField>
                        <FormField label="Fecha" required :error="errors[`recognitions.${index}.recognized_at`]">
                            <FormControl v-model="item.recognized_at" type="date" />
                        </FormField>
                    </div>
                    <FormField label="URL" required :error="errors[`recognitions.${index}.url`]">
                        <FormControl v-model="item.url" :icon="mdiWeb" />
                    </FormField>
                </div>
            </div>
            <CardBoxComponentEmpty v-if="recognitions.length === 0" />
        </div>
    </div>
</template>
<script setup>
import Badge from '@/Components/Badge.vue'
import BaseButton from '@/Components/BaseButton.vue'
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue'
import FormControl from '@/Components/FormControl.vue'
import FormField from '@/Components/FormField.vue'
import { mdiClose, mdiPlus, mdiWeb } from '@mdi/js'

const props = defineProps({
    errors: {
        type: Object,
        default: () => ({})
    },
    limit: {
        type: Number,
        default: 255
    }
})

const recognitions = defineModel({ type: Array, default: () => [] })

const addRecognition = () => {
    if (recognitions.value.length >= props.limit) return
    // if (!name.value || !position.value || !testimonial.value) return

    recognitions.value.push({
        name: null,
        recognized_at: null,
        url: null
    })
}

const removeRecognition = (index) => {
    recognitions.value.splice(index, 1)
}

</script>
