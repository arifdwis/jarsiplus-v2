import { router } from '@inertiajs/vue3';

/**
 * DataTable helper for Inertia lazy paginator events.
 * Returns a single `onPage(event)` handler for PrimeVue DataTable lazy mode.
 */
export function useDataTable(routeName, extraQuery = () => ({})) {
    const onPage = (e) => {
        router.get(routeName, { ...extraQuery(), page: e.page + 1 }, { preserveState: true, preserveScroll: true });
    };

    const onSort = (e) => {
        router.get(
            routeName,
            { ...extraQuery(), sort: e.sortField, dir: e.sortOrder === 1 ? 'asc' : 'desc' },
            { preserveState: true, preserveScroll: true },
        );
    };

    const onFilter = (filters) => {
        router.get(
            routeName,
            { ...extraQuery(), ...filters, page: 1 },
            { preserveState: true, preserveScroll: true },
        );
    };

    return { onPage, onSort, onFilter };
}
