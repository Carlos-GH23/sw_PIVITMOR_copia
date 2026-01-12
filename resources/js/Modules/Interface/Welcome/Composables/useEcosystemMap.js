import L from "leaflet";
import "leaflet/dist/leaflet.css";
import "leaflet.markercluster/dist/MarkerCluster.css";
import "leaflet.markercluster/dist/MarkerCluster.Default.css";
import "leaflet.markercluster";
import { resourceColors, resourceLabels } from './ResourceColors';

export const useEcosystemMap = (mapId, resources) => {
    let map = null;
    let markersLayer = null;

    const createIcon = (color) => {
        return L.divIcon({
            className: 'custom-marker',
            html: `<div style="background-color: ${color}; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });
    };

    const initFallbackPolygon = () => {
        const morelosCoords = [
            [19.2, -99.5],
            [19.2, -98.8],
            [18.6, -98.8],
            [18.6, -99.5],
            [19.2, -99.5]
        ];

        const morelosPolygon = L.polygon(morelosCoords, {
            color: '#14b8a6',
            fillColor: '#14b8a6',
            fillOpacity: 0.3,
            weight: 2
        }).addTo(map);

        map.fitBounds(morelosPolygon.getBounds(), { padding: [20, 20] });
    };

    const updateMarkers = () => {
        if (!markersLayer || !resources.value) return;

        markersLayer.clearLayers();

        resources.value.forEach(resource => {
            if (resource.latitude != null && resource.longitude != null && 
                !(resource.latitude === 0 && resource.longitude === 0)) {
                
                let color, label;
                if ((resource.type === 'higher_education' || resource.type === 'research_center') && resource.institution_code) {
                    const institutionCode = resource.institution_code.toLowerCase();
                    color = resourceColors[institutionCode] || resourceColors['ies'];
                    label = resourceLabels[institutionCode] || resourceLabels['ies'];
                } else {
                    color = resourceColors[resource.type] || '#6b7280';
                    label = resourceLabels[resource.type] || resource.type;
                }
                
                const icon = createIcon(color);

                const marker = L.marker([resource.latitude, resource.longitude], { icon });

                let displayTitle = resource.title;
                if (!displayTitle && ['higher_education', 'research_center', 'company', 'non_profit', 'government_agency'].includes(resource.type)) {
                    displayTitle = resource.institution || resource.company || resource.title || 'Sin título';
                }
                if (!displayTitle) displayTitle = 'Sin título';

                const popupContent = `
                    <div class="p-2">
                        <div class="font-semibold text-sm mb-1" style="color: ${color}">${label}</div>
                        <div class="font-bold text-base mb-1">${displayTitle}</div>
                        ${resource.institution && resource.institution !== displayTitle ? `<div class="text-xs text-gray-600 mb-1">${resource.institution}</div>` : ''}
                        ${resource.company && resource.company !== displayTitle ? `<div class="text-xs text-gray-600 mb-1">${resource.company}</div>` : ''}
                        ${resource.description ? `<div class="text-sm text-gray-700 mt-2">${resource.description.substring(0, 100)}${resource.description.length > 100 ? '...' : ''}</div>` : ''}
                    </div>
                `;

                marker.bindPopup(popupContent);
                markersLayer.addLayer(marker);
            }
        });
    };

    const initMap = () => {
        map = L.map(mapId).setView([18.9186, -99.2342], 9);

        L.tileLayer('https://{s}.tile.openstreetMap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        markersLayer = L.markerClusterGroup({
            maxClusterRadius: 50,
            spiderfyOnMaxZoom: true,
            showCoverageOnHover: false,
            zoomToBoundsOnClick: true
        });
        map.addLayer(markersLayer);

        fetch("/mexico_estados.geojson")
            .then(res => res.json())
            .then(data => {
                let morelosLayer = null;

                L.geoJSON(data, {
                    style: feature => {
                        const stateName = feature.properties.name || feature.properties.NAME ||
                            feature.properties.ESTADO || feature.properties.estado ||
                            feature.properties.nom_ent || feature.properties.NOM_ENT;

                        if (stateName && stateName.toLowerCase().includes('morelos')) {
                            return {
                                color: "#14b8a6",
                                weight: 2,
                                fillColor: "#14b8a6",
                                fillOpacity: 0.3
                            };
                        }
                        return {
                            color: "#888",
                            weight: 1,
                            fillColor: "#3b82f6",
                            fillOpacity: 0.2
                        };
                    },
                    onEachFeature: (feature, layer) => {
                        const stateName = feature.properties.name || feature.properties.NAME ||
                            feature.properties.ESTADO || feature.properties.estado ||
                            feature.properties.nom_ent || feature.properties.NOM_ENT;

                        if (stateName && stateName.toLowerCase().includes('morelos')) {
                            morelosLayer = layer;
                            layer.bindTooltip('Estado de Morelos', {
                                permanent: false,
                                direction: 'center'
                            });
                        }
                    }
                }).addTo(map);

                if (morelosLayer) {
                    setTimeout(() => {
                        map.fitBounds(morelosLayer.getBounds(), {
                            padding: [15, 15],
                            maxZoom: 10
                        });
                    }, 100);
                }
            })
            .catch(err => {
                console.error('Error loading GeoJSON:', err);
                initFallbackPolygon();
            });
    };

    return {
        initMap,
        updateMarkers
    };
};
