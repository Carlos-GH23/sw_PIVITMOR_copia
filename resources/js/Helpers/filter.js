export const hasActiveFilters = (filters, excludeFields = []) => {
    return Object.entries(filters).some(([key, value]) => {
        if (excludeFields?.includes(key)) return false;

        if (typeof value === "string") return value.length > 0;
        if (Array.isArray(value)) return value.length > 0;
        if (typeof value === "boolean") return value;
        return false;
    });
};
