<template>
    <div class="w-full space-y-4">
        <div class="flex justify-between items-center">
            <Badge show-dot>
                {{ testimonials.length }} testimonios
            </Badge>
            <BaseButton label="Agregar testimonio" :icon="mdiPlus" color="lightDark" rounded-full
                @click="addTestimonial" />
        </div>
        <div class="space-y-3 max-h-[600px] overflow-y-auto">
            <div v-for="(item, index) in testimonials" :key="item.id"
                class="relative bg-gray-50 rounded-lg p-4 border border-gray-200 hover:border-gray-300 transition-colors">
                <div class="flex gap-2 justify-between items-center">
                    <p class="text-gray-500 font-semibold">
                        #{{ index + 1 }}
                    </p>
                    <BaseButton title="Eliminar" :icon="mdiClose" color="lightDark" rounded-full
                        @click="removeTestimonial(index)" />
                </div>
                <div class="space-y-3 pr-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <FormField label="Nombre del autor" required :error="errors[`testimonials.${index}.name`]">
                            <FormControl v-model="item.name" placeholder="Nombre completo" />
                        </FormField>
                        <FormField label="Posición" required :error="errors[`testimonials.${index}.position`]">
                            <FormControl v-model="item.position" placeholder="Cargo o posición" />
                        </FormField>
                    </div>
                    <FormField label="Testimonio" required :error="errors[`testimonials.${index}.testimonial`]">
                        <FormControl v-model="item.testimonial" type="textarea" height="h-24"
                            placeholder="Ingrese el testimonio" max-length="2000" />
                    </FormField>
                </div>
            </div>
            <CardBoxComponentEmpty v-if="testimonials.length === 0" />
        </div>
    </div>
</template>
<script setup>
import Badge from '@/Components/Badge.vue'
import BaseButton from '@/Components/BaseButton.vue'
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue'
import FormControl from '@/Components/FormControl.vue'
import FormField from '@/Components/FormField.vue'
import { mdiClose, mdiPlus } from '@mdi/js'

const props = defineProps({
    errors: {
        type: Object,
        default: () => ({})
    },
    limit: {
        type: Number,
        default: 5
    }
})

const testimonials = defineModel({ type: Array, default: () => [] })

const addTestimonial = () => {
    if (testimonials.value.length >= props.limit) return
    // if (!name.value || !position.value || !testimonial.value) return

    testimonials.value.push({
        name: null,
        position: null,
        testimonial: null
    })
}

const removeTestimonial = (index) => {
    testimonials.value.splice(index, 1)
}

</script>
