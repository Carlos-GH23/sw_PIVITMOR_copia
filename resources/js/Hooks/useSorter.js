import { ref, computed } from "vue"

/**
 * Generic sorting composable
 * @param {Array} items - array to sort
 * @param {String} defaultKey - default field for sorting
 * @param {Boolean} defaultDesc - whether to start descending (true = newest first)
 */
export function useSorter(items, defaultKey = "created_at.raw", defaultDesc = true) {
  const sortKey = ref(defaultKey)
  const sortDesc = ref(defaultDesc)

  const toggleSortDirection = () => {
    sortDesc.value = !sortDesc.value
  }

  const sortBy = (key) => {
    sortKey.value = key
  }

  const sortedItems = computed(() => {
    if (!items.value?.length) return []

    return [...items.value].sort((a, b) => {
      // soporta rutas anidadas (e.g., created_at.raw)
      const getValue = (obj, path) =>
        path.split(".").reduce((acc, part) => acc?.[part], obj)

      const valueA = getValue(a, sortKey.value)
      const valueB = getValue(b, sortKey.value)

      if (valueA === undefined || valueB === undefined) return 0
      if (valueA === valueB) return 0

      // Si es fecha o número, compara correctamente
      if (!isNaN(Date.parse(valueA)) && !isNaN(Date.parse(valueB))) {
        return sortDesc.value
          ? new Date(valueB) - new Date(valueA)
          : new Date(valueA) - new Date(valueB)
      }

      if (typeof valueA === "number" && typeof valueB === "number") {
        return sortDesc.value ? valueB - valueA : valueA - valueB
      }

      // Comparación genérica alfabética
      return sortDesc.value
        ? String(valueB).localeCompare(String(valueA))
        : String(valueA).localeCompare(String(valueB))
    })
  })

  return { sortedItems, sortKey, sortDesc, toggleSortDirection, sortBy }
}
