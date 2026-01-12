import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { error422 } from "@/Hooks/useErrorsForm";

export function useAddressManagement(form) {
    const states = ref([]);
    const municipalities = ref([]);
    const neighborhoods = ref([]);

    const fetchStates = async () => {
        try {
            const response = await axios.get('/api/locations/states');
            states.value = response.data.data ?? response.data;
        } catch (error) {
            error422("Error al cargar estados");
        }
    };

    const fetchMunicipalities = async (stateId) => {
        if (!stateId) {
            municipalities.value = [];
            neighborhoods.value = [];
            return;
        }
        try {
            const response = await axios.get(`/api/locations/states/${stateId}/municipalities`);
            municipalities.value = response.data.data ?? response.data;
        } catch (error) {
            error422("Error al cargar municipios");
        }
    };

    const fetchNeighborhoods = async (municipalityId) => {
        if (!municipalityId) {
            neighborhoods.value = [];
            return;
        }
        try {
            const response = await axios.get(`/api/locations/municipalities/${municipalityId}/neighborhoods`);
            neighborhoods.value = response.data.data ?? response.data;
        } catch (error) {
            error422("Error al cargar colonias");
        }
    };

    const onStateChange = (stateId) => {
        form.value.municipality_id = null;
        form.value.neighborhood_id = null;
        form.value.postal_code = null
        form.value.street = null
        form.value.exterior_number = null
        form.value.interior_number = null
        municipalities.value = [];
        neighborhoods.value = [];
        fetchMunicipalities(stateId);
    };

    const onMunicipalityChange = (municipalityId) => {
        form.value.neighborhood_id = null;
        form.value.postal_code = null;
        form.value.street = null;
        form.value.exterior_number = null;
        form.value.interior_number = null;
        neighborhoods.value = [];
        fetchNeighborhoods(municipalityId);
    };

    watch(() => form.value.neighborhood_id, (newId, oldId) => {
        if (oldId !== undefined && newId !== oldId) {
            form.value.street = null;
            form.value.exterior_number = null;
            form.value.interior_number = null;
        }
    }, { immediate: false });

    watch([() => form.value.neighborhood_id, neighborhoods], ([newId, list]) => {
        if (newId && list.length > 0) {
            const selected = list.find(n => n.id === newId);
            if (selected && form.value.postal_code !== selected.postal_code) {
                form.value.postal_code = selected.postal_code;
            }
        }
    }, { immediate: true });

    const onPostalCodeChange = async (postalCode) => {
        if (!postalCode) {
            return;
        }

        if (postalCode.length !== 5) {
            error422("El código postal debe tener 5 dígitos");
            return;
        }

        try {
            const response = await axios.get(`/api/locations/postalCode/${postalCode}`);
            const payload = response.data.data ?? response.data;

            if (payload) {
                const stateId = payload.municipality?.state?.id;
                const municipalityId = payload.municipality?.id;
                const neighborhoodId = payload.id;

                if (stateId) {
                    form.value.state_id = stateId;
                    await fetchMunicipalities(stateId);
                }
                if (municipalityId) {
                    form.value.municipality_id = municipalityId;
                    await fetchNeighborhoods(municipalityId);
                }
                if (neighborhoodId) {
                    form.value.neighborhood_id = neighborhoodId;
                }
            }
        } catch (error) {
            const message = error.response?.data?.message;
            error422(message);
        }
    };

    onMounted(fetchStates);

    onMounted(() => {
        if (form.value.state_id) {
            fetchMunicipalities(form.value.state_id).then(() => {
                if (form.value.municipality_id) {
                    fetchNeighborhoods(form.value.municipality_id);
                }
            });
        }
    });

    return {
        states,
        municipalities,
        neighborhoods,
        onStateChange,
        onMunicipalityChange,
        onPostalCodeChange
    };
}