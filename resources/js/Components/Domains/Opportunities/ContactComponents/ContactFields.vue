<template>
    <div class="space-y-4">
        <div v-if="contact" class="md:flex gap-4">
            <FormField v-if="contact.name" class="w-full" label="Nombre del contacto">
                <LabelControl :value="contact.name" />
            </FormField>
            <FormField v-if="contact.email" class="w-full" label="E-mail">
                <LabelControl :value="contact.email" />
            </FormField>
        </div>

        <FormField v-if="phoneNumbers && phoneNumbers.length > 0" label="Números de contacto">
            <div>
                <table>
                    <thead class="text-gray-700 bg-gray-100">
                        <tr>
                            <th>Teléfono</th>
                            <th>Extensión</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(phone, index) in phoneNumbers" :key="index">
                            <td>{{ phone.number }}</td>
                            <td>{{ phone.dial_code || 'N/A' }}</td>
                            <td>
                                <Badge color="gray" size="md" variant="soft">
                                    {{ phone.type || 'General' }}
                                </Badge>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </FormField>

        <div v-if="!contact && (!phoneNumbers || phoneNumbers.length === 0)">
            <CardBoxComponentEmpty message="No hay información de contacto disponible" />
        </div>
    </div>
</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import FormField from '@/Components/FormField.vue';
import LabelControl from '@/Components/LabelControl.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';

defineProps({
    contact: {
        type: Object,
        default: null
    },
    phoneNumbers: {
        type: Array,
        default: () => []
    }
});
</script>