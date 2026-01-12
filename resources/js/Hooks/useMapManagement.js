import { ref, watch } from 'vue';
import L from 'leaflet';
import axios from 'axios';
import { error422 } from "@/Hooks/useErrorsForm";

export function useMapManagement(form, states, municipalities, neighborhoods) {
    const mapContainer = ref(null);
    const map = ref(null);
    const marker = ref(null);
    const isGeocoding = ref(false);
    const geocodeDebounceTimer = ref(null);

    const findNameById = (collection, id) => {
        return collection.find(item => item.id === id)?.name || '';
    };

    const initMap = () => {
        if (mapContainer.value && !map.value) {
            map.value = L.map(mapContainer.value).setView([23.6345, -102.5528], 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map.value);
            map.value.on('click', onMapClick);

            if (form.value.latitude && form.value.longitude) {
                setMarker([form.value.latitude, form.value.longitude], 'Ubicación guardada', 14);
            }
        }
    };

    const setMarker = (coordinates, message, zoom = 17) => {
        if (marker.value) {
            map.value.removeLayer(marker.value);
        }
        map.value.setView(coordinates, zoom);
        marker.value = L.marker(coordinates).addTo(map.value).bindPopup(message).openPopup();
        form.value.latitude = coordinates[0];
        form.value.longitude = coordinates[1];
    };

    const removeMarker = () => {
        if (marker.value && map.value) {
            map.value.removeLayer(marker.value);
            marker.value = null;
        }
        form.value.latitude = null;
        form.value.longitude = null;
    };

    const onMapClick = (e) => {
        setMarker([e.latlng.lat, e.latlng.lng], 'Ubicación seleccionada manualmente');
    };

    const geocodeAddress = async (trigger = 'auto') => {
        if (isGeocoding.value) return;

        const addressData = {
            street: form.value.street,
            exterior_number: form.value.exterior_number,
            postal_code: form.value.postal_code,
            neighborhood: findNameById(neighborhoods.value, form.value.neighborhood_id),
            municipality: findNameById(municipalities.value, form.value.municipality_id),
            state: findNameById(states.value, form.value.state_id),
        };

        const hasData = (addressData.postal_code?.length === 5) ||
            (addressData.street?.length > 3) ||
            addressData.neighborhood;

        if (!hasData) {
            if (trigger === 'manual') {
                error422('Por favor, ingrese al menos la colonia o código postal.');
            }
            return;
        }

        isGeocoding.value = true;

        try {
            const response = await axios.post(route('api.geocode'), addressData);

            if (response.data.latitude && response.data.longitude) {
                const messages = {
                    exact: 'Ubicación encontrada',
                    neighborhood: 'Ubicación aproximada (colonia)',
                    approximate: 'Ubicación aproximada. Ajuste manualmente si es necesario.'
                };

                const message = messages[response.data.precision] || 'Ubicación encontrada';

                setMarker(
                    [response.data.latitude, response.data.longitude],
                    message
                );

                if (trigger === 'manual' && response.data.precision === 'approximate') {
                    error422('La ubicación es aproximada. Por favor, ajuste el marcador manualmente.');
                }
            } else {
                removeMarker();
                if (trigger === 'manual') {
                    error422(response.data.message || 'No se pudo encontrar la dirección.');
                }
            }
        } catch (error) {
            removeMarker();
            if (trigger === 'manual') {
                const message = error.response?.data?.message ||
                    (error.response?.status === 429 ? 'Demasiadas solicitudes. Espere un momento.' : 'Error al buscar la dirección.');
                error422(message);
            }
        } finally {
            isGeocoding.value = false;
        }
    };

    const setupAutoGeocode = () => {
        watch(
            [
                () => form.value.street,
                () => form.value.exterior_number,
                () => form.value.postal_code,
                () => form.value.neighborhood_id
            ],
            () => {
                removeMarker();
                clearTimeout(geocodeDebounceTimer.value);
                geocodeDebounceTimer.value = setTimeout(() => geocodeAddress(), 1500);
            }
        );
    };

    return {
        mapContainer,
        map,
        marker,
        isGeocoding,
        initMap,
        removeMarker,
        geocodeAddress,
        setupAutoGeocode
    };
}
