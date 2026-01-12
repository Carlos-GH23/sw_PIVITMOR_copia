export const usePaginationApi = () => {
    const isPrevious = (label) => {
        return (
            label.includes("Anterior") ||
            label.includes("Previous") ||
            label.includes("&laquo;")
        );
    };

    const isNext = (label) => {
        return (
            label.includes("Siguiente") ||
            label.includes("Next") ||
            label.includes("&raquo;")
        );
    };

    const isEllipsis = (label) => {
        return label.includes("...") || label.includes("&hellip;");
    };

    const extractPage = (url) => {
        if (!url) return null;
        const match = url.match(/[?&]page=(\d+)/);
        return match ? parseInt(match[1]) : null;
    };

    const getAriaLabel = (label, active) => {
        if (isPrevious(label)) return "Página anterior";
        if (isNext(label)) return "Página siguiente";
        if (active) return `Página actual ${label}`;
        if (!isEllipsis(label)) return `Ir a página ${label}`;
        return undefined;
    };

    const getLinkClasses = (url, label, active) => {
        const baseClasses =
            "inline-flex items-center justify-center px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md min-w-[40px]";

        if (!url) {
            return `${baseClasses} text-gray-400 dark:text-gray-500 cursor-not-allowed`;
        }

        if (active) {
            return `${baseClasses} bg-forest-400 text-white shadow-sm`;
        }

        if (isPrevious(label) || isNext(label)) {
            return `${baseClasses} text-gray-700 dark:text-gray-300 hover:bg-forest-100 hover:text-white dark:hover:bg-gray-700 border border-gray-300 dark:border-gray-600`;
        }

        return `${baseClasses} text-gray-700 dark:text-gray-300 hover:bg-forest-100 hover:text-white dark:hover:bg-gray-700`;
    };

    return {
        extractPage,
        getAriaLabel,
        getLinkClasses,
        isPrevious,
        isNext,
    };
};
