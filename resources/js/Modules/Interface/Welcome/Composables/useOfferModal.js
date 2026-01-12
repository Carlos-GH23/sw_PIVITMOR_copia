import { computed, ref, watch } from 'vue';

export function useOfferModal(props, emit) {
    const currentTagIndex = ref(0);

    const stripHtml = (html) => {
        if (!html) return '';
        let text = html.replace(/<[^>]*>?/gm, '');
        return text.replace(/&nbsp;/g, ' ');
    };

    const cleanDescription = computed(() => stripHtml(props.offer?.technical_description));

    const allTags = computed(() => {
        const tags = [];

        if (props.offer?.economic_sectors) {
            props.offer.economic_sectors.forEach(sector => {
                tags.push(sector.name || sector);
            });
        }

        if (props.offer?.intellectual_property) {
            const ip = typeof props.offer.intellectual_property === 'object'
                ? props.offer.intellectual_property.name
                : props.offer.intellectual_property;
            tags.push(ip);
        }

        if (props.offer?.technology_level) {
            const tl = typeof props.offer.technology_level === 'object'
                ? props.offer.technology_level.name
                : props.offer.technology_level;
            tags.push(tl);
        }

        return tags;
    });

    const scrollCarousel = (direction) => {
        if (direction === 'left') {
            currentTagIndex.value = currentTagIndex.value > 0
                ? currentTagIndex.value - 1
                : allTags.value.length - 1;
        } else {
            currentTagIndex.value = (currentTagIndex.value + 1) % allTags.value.length;
        }
    };

    const goToTag = (index) => {
        currentTagIndex.value = index;
    };

    const close = () => {
        emit('close');
    };

    const resourceTypeLabel = computed(() => {
        const labels = {
            'institution': 'Institución',
            'capability': 'Capacidad Tecnológica',
            'requirement': 'Necesidad Tecnológica',
            'technology_service': 'Servicio Tecnológico',
            'academic_offering': 'Oferta Académica',
            'facility': 'Instalación especializada',
            'equipment': 'Infraestructura tecnológica',
            'conference': 'Conferencia',
        };
        return labels[props.offer?.resource_type] || 'Capacidad';
    });

    const institutionDisplay = computed(() => {
        if (props.offer?.resource_type === 'requirement' && props.offer?.institution_category === 'Empresa de Base Tecnológica') {
            return 'Empresa de base tecnológica';
        }

        return props.offer?.institution_name || props.offer?.department?.institution?.name || 'Sin institución';
    });

    watch(() => props.offer, () => {
        currentTagIndex.value = 0;
    }, { deep: true });

    return {
        currentTagIndex,
        cleanDescription,
        allTags,
        scrollCarousel,
        goToTag,
        close,
        resourceTypeLabel,
        institutionDisplay
    };
}
