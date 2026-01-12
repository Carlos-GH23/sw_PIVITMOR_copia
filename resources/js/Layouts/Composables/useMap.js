import { ref, onMounted, onUnmounted, nextTick } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: markerIcon2x,
    iconUrl: markerIcon,
    shadowUrl: markerShadow,
});

const DEFAULT_COORDS = { lat: 18.9242, lng: -99.2216 };
const DEFAULT_ZOOM = 14;

export const useMap = (options = {}) => {
    const {
        interactive = false,
        defaultCoords = DEFAULT_COORDS,
        defaultZoom = DEFAULT_ZOOM,
        onLocationSelect = null,
    } = options;

    const mapContainer = ref(null);
    const map = ref(null);
    const marker = ref(null);
    const isLoading = ref(false);
    const coordinates = ref({ lat: null, lng: null });
    const address = ref('');

    const setMarker = (lat, lng, popupText = '') => {
        if (!map.value) return;
        coordinates.value = { lat, lng };
        if (marker.value) {
            marker.value.setLatLng([lat, lng]);
            marker.value.setPopupContent(popupText);
        } else {
            marker.value = L.marker([lat, lng], { draggable: interactive })
                .addTo(map.value)
                .bindPopup(popupText || 'Ubicación seleccionada');
            if (interactive) {
                marker.value.on('dragend', handleMarkerDrag);
            }
        }
        marker.value.openPopup();
    };

    const handleMarkerDrag = (e) => {
        const { lat, lng } = e.target.getLatLng();
        coordinates.value = { lat: lat.toFixed(6), lng: lng.toFixed(6) };
        onLocationSelect?.({
            lat: coordinates.value.lat,
            lng: coordinates.value.lng,
            address: address.value
        });
    };

    const handleMapClick = (e) => {
        const { lat, lng } = e.latlng;
        coordinates.value = { lat: lat.toFixed(6), lng: lng.toFixed(6) };
        setMarker(lat, lng, address.value || 'Ubicación seleccionada');
        onLocationSelect?.({
            lat: coordinates.value.lat,
            lng: coordinates.value.lng,
            address: address.value
        });
    };

    const centerMap = (lat, lng, zoom = null) => {
        if (!map.value) return;
        map.value.setView([lat, lng], zoom || map.value.getZoom());
    };

    const initWithCoords = (lat, lng, popupText = '') => {
        if (!map.value) return;
        centerMap(lat, lng);
        setMarker(lat, lng, popupText);
        coordinates.value = { lat, lng };
    };

    const initMap = () => {
        if (!mapContainer.value || map.value) return;
        const initialLat = coordinates.value.lat || defaultCoords.lat;
        const initialLng = coordinates.value.lng || defaultCoords.lng;
        map.value = L.map(mapContainer.value).setView([initialLat, initialLng], defaultZoom);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map.value);
        if (interactive) {
            map.value.on('click', handleMapClick);
        }
    };

    const destroyMap = () => {
        if (map.value) {
            map.value.remove();
            map.value = null;
            marker.value = null;
        }
    };

    const invalidateSize = () => {
        if (map.value) {
            map.value.invalidateSize();
        }
    };

    onMounted(async () => {
        await nextTick();
        initMap();
    });

    onUnmounted(() => {
        destroyMap();
    });

    return {
        mapContainer,
        map,
        marker,
        isLoading,
        coordinates,
        address,
        setMarker,
        centerMap,
        initWithCoords,
        invalidateSize,
    };
};