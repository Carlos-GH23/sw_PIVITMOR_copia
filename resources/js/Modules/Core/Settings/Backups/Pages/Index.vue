<template>
    <HeadLogo :title="title" />

    <LayoutAuthenticated>
        <SectionTitleLineWithButton :icon="mdiDatabase" :title="title" main />

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <CardModal v-for="card in cardActions" :key="card.id" v-bind="card" @click="card.onClick" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <BackupStat v-for="(stat, index) in backupStats" v-bind="stat" :key="index" />
        </div>

        <AuditLog :backups="backups" :filters="filters" :route-name="routeName" />
        <ManualBackupModal :show="isManualOpen" @close="closeManual" :route-name="routeName" />
        <ScheduleBackupModal :show="isScheduleOpen" @close="closeSchedule" :schedule="schedule" :user="user"
            :frequencies="frequencies" :route-name="routeName" />
        <RestoreBackupModal :show="isRestoreOpen" @close="closeRestore" :route-name="routeName" />
    </LayoutAuthenticated>
</template>

<script setup>
import AuditLog from '../Components/AuditLog.vue';
import BackupStat from '../Components/BackupStat.vue';
import CardModal from '../Components/CardModal.vue';
import HeadLogo from '@/Components/HeadLogo.vue';
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import ManualBackupModal from '../Components/ManualBackupModal.vue';
import RestoreBackupModal from '../Components/RestoreBackupModal.vue';
import ScheduleBackupModal from '../Components/ScheduleBackupModal.vue';
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue';
import { Activity, Clock, Database, RotateCcw } from 'lucide-vue-next';
import { mdiDatabase } from '@mdi/js';
import { useModal } from '@/Hooks/useModal';
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    backups: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
    availableBackups: {
        type: Object,
        required: true,
    },
    latestBackup: {
        type: Object,
        default: null,
    },
    totalBackups: {
        type: Number,
        required: true,
    },
    schedule: Object,
    frequencies: {
        type: Object,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
    nextBackupDate: {
        type: String,
        required: true,
    },
});

const { isOpen: isManualOpen, open: openManual, close: closeManual } = useModal();
const { isOpen: isScheduleOpen, open: openSchedule, close: closeSchedule } = useModal();
const { isOpen: isRestoreOpen, open: openRestore, close: closeRestore } = useModal();

const cardActions = [
    {
        id: 'manual',
        label: 'Respaldo Manual',
        description: 'Crear respaldo inmediato',
        icon: Database,
        onClick: openManual,
    },
    {
        id: 'schedule',
        label: 'Programación',
        description: 'Configurar respaldos automáticos',
        icon: Clock,
        onClick: openSchedule,
    },
    {
        id: 'restore',
        label: 'Restaurar',
        description: 'Recuperar desde respaldo',
        icon: RotateCcw,
        onClick: openRestore,
    },
];

const backupStats = computed(() => [
    {
        label: 'Último Respaldo',
        description: props.latestBackup?.data?.created_at?.formatted ?? 'No disponible',
        icon: Activity,
    },
    {
        label: 'Próximo Programado',
        description: props.nextBackupDate,
        icon: Clock,
    },
    {
        label: 'Respaldos Totales',
        description: props.totalBackups,
        icon: Database,
    },
]);
</script>
