import { onMounted, onUnmounted, ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';

export function usePageTracker(overrides = {}) {
    const page = usePage();

    const tracking = computed(() => page.props.pageTracking || {});

    const activityId = computed(() => overrides.activityId ?? tracking.value.activityId ?? null);
    const moduleKey = computed(() => overrides.moduleKey ?? tracking.value.moduleKey ?? null);
    const interval = computed(() => overrides.interval ?? tracking.value.interval ?? 30000);
    const enabled = computed(() => overrides.enabled ?? true);

    const isTracking = ref(false);
    const lastHeartbeat = ref(null);
    let heartbeatInterval = null;
    let visibilityHandler = null;

    const sendHeartbeat = async () => {
        if (!activityId.value || !moduleKey.value || !enabled.value) return;

        try {
            const response = await axios.post(route('api.heartbeat'), {
                activity_id: activityId.value,
                module_key: moduleKey.value,
            });

            if (response.data.status === 'ok') {
                lastHeartbeat.value = response.data.timestamp;
            }
        } catch (error) {
            console.debug('Heartbeat failed');
        }
    };

    const startTracking = () => {
        if (!activityId.value || !moduleKey.value || !enabled.value || isTracking.value) return;

        isTracking.value = true;
        sendHeartbeat();

        heartbeatInterval = setInterval(sendHeartbeat, interval.value);

        visibilityHandler = () => {
            if (document.visibilityState === 'hidden') {
                sendHeartbeat();
            }
        };
        document.addEventListener('visibilitychange', visibilityHandler);
        window.addEventListener('beforeunload', sendHeartbeat);
    };

    const stopTracking = () => {
        isTracking.value = false;

        if (heartbeatInterval) {
            clearInterval(heartbeatInterval);
            heartbeatInterval = null;
        }

        if (visibilityHandler) {
            document.removeEventListener('visibilitychange', visibilityHandler);
            visibilityHandler = null;
        }

        window.removeEventListener('beforeunload', sendHeartbeat);
        sendHeartbeat();
    };

    onMounted(() => {
        startTracking();
    });

    onUnmounted(() => {
        stopTracking();
    });

    return {
        isTracking,
        lastHeartbeat,
        sendHeartbeat,
        startTracking,
        stopTracking,
        activityId,
        moduleKey,
    };
}
