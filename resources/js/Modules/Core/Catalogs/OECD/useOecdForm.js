import { ref, computed, onMounted } from "vue";

export const useOecdForm = (props) => {
    const selectedAreaPrincipal = ref(null);

    const selectedLevel = computed({
        get: () => props.form.level,
        set: (val) => props.form.level = val
    });

    const level1Options = computed(() => {
        return props.categories || [];
    });

    const level2Options = computed(() => {
        if (!selectedAreaPrincipal.value) return [];
        const area = props.categories.find(cat => cat.id === selectedAreaPrincipal.value);
        return area?.children || [];
    });

    const areaPrincipalValue = computed({
        get() {
            if (selectedLevel.value === 'discipline') {
                return selectedAreaPrincipal.value;
            }
            return props.form.parent_id?.value ?? props.form.parent_id;
        },
        set(value) {
            if (selectedLevel.value === 'discipline') {
                selectedAreaPrincipal.value = value;
            } else {
                props.form.parent_id = value;
            }
        }
    });

    const subAreaValue = computed({
        get() {
            const val = props.form.parent_id?.value ?? props.form.parent_id;
            return selectedLevel.value === 'discipline' ? val : null;
        },
        set(value) {
            if (selectedLevel.value === 'discipline') {
                props.form.parent_id = value;
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
        if (selectedLevel.value !== 'discipline') {
            selectedAreaPrincipal.value = null;
        }
        props.form.parent_id = null;
    };

    const onAreaPrincipalUpdate = (value) => {
        if (selectedLevel.value === 'discipline') {
            selectedAreaPrincipal.value = value;
            props.form.parent_id = null;
        } else if (selectedLevel.value === 'subarea') {
            props.form.parent_id = value;
        }
    };

    // Initialize form when editing
    onMounted(() => {
        if (props.form.level) {
            const currentLevel = props.form.level;

            let parentId = props.form.parent_id;
            if (typeof parentId === 'object' && parentId !== null) {
                parentId = parentId.value;
            }

            if (currentLevel === 'discipline' && parentId) {
                const subarea = findParentInCategories(parentId);
                if (subarea) {
                    for (const area of props.categories) {
                        if (area.children && area.children.find(c => c.id == subarea.id)) {
                            selectedAreaPrincipal.value = area.id;
                            break;
                        }
                    }
                }
            }
        }
    });

    return {
        selectedLevel,
        selectedAreaPrincipal,
        level1Options,
        level2Options,
        areaPrincipalValue,
        subAreaValue,
        onLevelChange,
        onAreaPrincipalUpdate,
    };
};
