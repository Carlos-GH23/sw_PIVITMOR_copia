import L from "leaflet";
import "leaflet/dist/leaflet.css";
import "leaflet.heat";

(function () {
    const originalGetContext = HTMLCanvasElement.prototype.getContext;
    HTMLCanvasElement.prototype.getContext = function (type, options) {
        if (type === '2d' && this.classList.contains('leaflet-heatmap-layer')) {
            options = {
                ...options,
                willReadFrequently: true
            };
        }

        return originalGetContext.call(this, type, options);
    };
})();

export const useMatchHeatmap = (mapId, heatmapData) => {
    let map = null;
    let heatLayer = null;

    const morelosCenter = [18.9186, -99.2342];

    const initMap = () => {
        map = L.map(mapId).setView(morelosCenter, 9);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        loadMorelosGeoJSON();
    };

    const loadMorelosGeoJSON = () => {
        fetch("/mexico_estados.geojson")
            .then(res => res.json())
            .then(data => {
                let morelosLayer = null;

                L.geoJSON(data, {
                    style: feature => {
                        const stateName = feature.properties.name || feature.properties.NAME ||
                            feature.properties.ESTADO || feature.properties.estado ||
                            feature.properties.nom_ent || feature.properties.NOM_ENT;

                        if (stateName?.toLowerCase().includes('morelos')) {
                            return {
                                color: "#14b8a6",
                                weight: 2,
                                fillColor: "#14b8a6",
                                fillOpacity: 0.1
                            };
                        }
                        return {
                            color: "#888",
                            weight: 1,
                            fillColor: "#e5e7eb",
                            fillOpacity: 0.3
                        };
                    },
                    onEachFeature: (feature, layer) => {
                        const stateName = feature.properties.name || feature.properties.NAME ||
                            feature.properties.ESTADO || feature.properties.nom_ent;

                        if (stateName?.toLowerCase().includes('morelos')) {
                            morelosLayer = layer;
                        }
                    }
                }).addTo(map);

                if (morelosLayer) {
                    setTimeout(() => {
                        map.fitBounds(morelosLayer.getBounds(), { padding: [15, 15], maxZoom: 10 });
                    }, 100);
                }
            })
            .catch(err => {
                console.error(err);
            });
    };

    const updateHeatmap = () => {
        if (!map || !heatmapData.value) return;

        if (heatLayer) {
            map.removeLayer(heatLayer);
        }

        const points = heatmapData.value.filter(point => point.lat && point.lng).map(point => [point.lat, point.lng, 1]);

        if (points.length === 0) return;

        heatLayer = L.heatLayer(points, {
            radius: 25,
            blur: 15,
            maxZoom: 12,
            max: 1.0,
            gradient: {
                0.0: '#3b82f6',
                0.25: '#06b6d4',
                0.5: '#22c55e',
                0.75: '#f59e0b',
                1.0: '#ef4444'
            }
        }).addTo(map);
    };

    const destroy = () => {
        if (map) {
            map.remove();
            map = null;
            heatLayer = null;
        }
    };

    return {
        initMap,
        updateHeatmap,
        destroy
    };
};