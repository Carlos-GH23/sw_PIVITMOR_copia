<template>
    <div class="w-full space-y-4">
        <div class="flex justify-between items-center">
            <Badge show-dot>
                {{ policies.length }} politicas
            </Badge>
            <BaseButton label="Agregar politica" :icon="mdiPlus" color="lightDark" rounded-full @click="addPolicy" />
        </div>
        <div class="space-y-3 max-h-[600px] overflow-y-auto">
            <div v-for="(item, index) in policies" :key="item.id"
                class="relative bg-gray-50 rounded-lg p-4 border border-gray-200 hover:border-gray-300 transition-colors">
                <div class="flex gap-2 justify-between items-center">
                    <p class="text-gray-500 font-semibold">
                        #{{ index + 1 }}
                    </p>
                    <BaseButton title="Eliminar" :icon="mdiClose" color="lightDark" rounded-full
                        @click="removePolicy(index)" />
                </div>
                <div class="space-y-3 pr-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <FormField label="Estatus" required :error="errors[`derived_policies.${index}.status`]">
                            <FormControl v-model="item.status" :options="policyStatuses" />
                        </FormField>
                        <FormField label="Fecha" required :error="errors[`derived_policies.${index}.date`]">
                            <FormControl v-model="item.date" type="date" />
                        </FormField>
                        <FormField label="URL" required :error="errors[`derived_policies.${index}.url`]">
                            <FormControl v-model="item.url" />
                        </FormField>
                    </div>
                    <FormField label="Descripción" required :error="errors[`derived_policies.${index}.description`]">
                        <FormControl v-model="item.description" type="textarea" height="h-24"
                            placeholder="Ingresa una descripción" max-length="2000" />
                    </FormField>
                </div>
            </div>
            <CardBoxComponentEmpty v-if="policies.length === 0" />
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
import { policyStatuses } from '../../Composables/useEnums'

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

const policies = defineModel({ type: Array, default: () => [] })

const addPolicy = () => {
    if (policies.value.length >= props.limit) return

    policies.value.push({
        status: null,
        date: null,
        url: null,
        description: null
    })
}

const removePolicy = (index) => {
    policies.value.splice(index, 1)
}

</script>
