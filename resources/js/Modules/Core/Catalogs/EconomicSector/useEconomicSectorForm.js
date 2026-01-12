import { ref, computed, onMounted } from "vue";

export const useEconomicSectorForm = (props) => {
    const selectedSection = ref(null);

    const selectedLevel = computed({
        get: () => props.form.level,
        set: (val) => props.form.level = val
    });

    const level1Options = computed(() => {
        return props.categories || [];
    });

    const level2Options = computed(() => {
        if (!selectedSection.value) return [];
        const section = props.categories.find(cat => cat.id === selectedSection.value);
        return section?.children || [];
    });

    const sectionValue = computed({
        get() {
            if (selectedLevel.value === 'group') {
                return selectedSection.value;
            }
            return props.form.parent_id?.value ?? props.form.parent_id;
        },
        set(value) {
            if (selectedLevel.value === 'group') {
                selectedSection.value = typeof value === 'object' && value !== null ? value.value : value;
            } else {
                props.form.parent_id = typeof value === 'object' && value !== null ? value.value : value;
            }
        }
    });

    const divisionValue = computed({
        get() {
            const val = props.form.parent_id?.value ?? props.form.parent_id;
            return selectedLevel.value === 'group' ? val : null;
        },
        set(value) {
            if (selectedLevel.value === 'group') {
                props.form.parent_id = typeof value === 'object' && value !== null ? value.value : value;
            }
        }
    });

    const findParentInCategories = (parentId) => {
        for (const cat of props.categories) {
            if (cat.id == parentId) return cat;
            if (cat.children) {
                for (const child of cat.children) {
                    if (child.id == parentId) return child;
                }
            }
        }
        return null;
    };

    const onLevelChange = () => {
        if (selectedLevel.value !== 'group') {
            selectedSection.value = null;
        }
        props.form.parent_id = null;
    };

    const onSectionUpdate = (value) => {
        const numericValue = typeof value === 'object' && value !== null ? value.value : value;
        if (selectedLevel.value === 'group') {
            selectedSection.value = numericValue;
            props.form.parent_id = null;
        } else if (selectedLevel.value === 'division') {
            props.form.parent_id = numericValue;
        }
    };

    onMounted(() => {
        if (props.form.level) {
            const currentLevel = props.form.level;

            let parentId = props.form.parent_id;
            if (typeof parentId === 'object' && parentId !== null) {
                parentId = parentId.value;
            }

            if (currentLevel === 'group' && parentId) {
                const division = findParentInCategories(parentId);
                if (division) {
                    for (const section of props.categories) {
                        if (section.children && section.children.find(c => c.id == division.id)) {
                            selectedSection.value = section.id;
                            break;
                        }
                    }
                }
            }

            if (props.form.parent_id && typeof props.form.parent_id === 'object') {
                props.form.parent_id = props.form.parent_id.value;
            }
        }
    });

    return {
        selectedLevel,
        selectedSection,
        level1Options,
        level2Options,
        sectionValue,
        divisionValue,
        onLevelChange,
        onSectionUpdate,
    };
};
