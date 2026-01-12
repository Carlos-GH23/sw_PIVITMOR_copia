import { ref, computed } from 'vue';

export const useEcosystemFilters = (allResources, oecdSectors, economicSectors) => {
    const selectedTypes = ref({
        ies: true,
        ci: true,
        company: true,
        non_profit: true,
        capability: true,
        tech_service: true,
        academic_offering: true
    });

    const selectedOecdSector = ref('');
    const selectedEconomicSector = ref('');

    const filteredResources = computed(() => {
        if (!allResources.value) return [];

        return allResources.value.filter(resource => {
            const resourceType = resource.type === 'technology_service' ? 'tech_service' : resource.type;
            if (resource.type === 'higher_education' || resource.type === 'research_center') {
                const institutionCode = resource.institution_code?.toLowerCase();
                if (institutionCode === 'ies' && !selectedTypes.value.ies) {
                    return false;
                }
                if (institutionCode === 'ci' && !selectedTypes.value.ci) {
                    return false;
                }
            } else {
                if (!selectedTypes.value[resourceType] && !selectedTypes.value[resource.type]) {
                    return false;
                }
            }

            if (selectedOecdSector.value) {
                const resourceSectors = resource.oecd_sector_ids || [];
                const selectedId = parseInt(selectedOecdSector.value);

                if (!resourceSectors.includes(selectedId)) {
                    return false;
                }
            }

            if (selectedEconomicSector.value) {
                const resourceSectors = resource.economic_sector_ids || [];
                const selectedId = parseInt(selectedEconomicSector.value);

                if (!resourceSectors.includes(selectedId)) {
                    return false;
                }
            }

            return true;
        });
    });

    const toggleAll = (value) => {
        Object.keys(selectedTypes.value).forEach(key => {
            selectedTypes.value[key] = value;
        });
    };

    const selectAll = () => toggleAll(true);

    const deselectAll = () => toggleAll(false);

    return {
        selectedTypes,
        selectedOecdSector,
        selectedEconomicSector,
        filteredResources,
        selectAll,
        deselectAll,
        oecdSectors,
        economicSectors
    };
};
