<template>
    <div v-if="backups.data.length > 0" class="border rounded-xl mb-4">
        <table>
            <thead>
                <tr>
                    <th>Acción</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Resultado</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="item in backups.data" :key="item.id">
                    <td data-label="Acción">
                        {{ item.backup_action?.name }}
                    </td>
                    <td data-label="Usuario">
                        {{ item.user?.name }}
                    </td>
                    <td data-label="Nombre">
                        {{ item.name }}
                    </td>
                    <td data-label="Fecha">
                        {{ item.created_at.formatted }}
                    </td>
                    <td data-label="Resultado">
                        <Badge v-if="item.backup_status_id === 1" color="green">
                            {{ item.backup_status?.name }}
                        </Badge>
                        <Badge v-else color="red">
                            {{ item.backup_status?.name }}
                        </Badge>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <CardBoxComponentEmpty v-else />

    <Pagination :links="backups.meta.links" :total="backups.meta.total" :to="backups.meta.to"
        :from="backups.meta.from" />
</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    backups: {
        type: Object,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
});
</script>
