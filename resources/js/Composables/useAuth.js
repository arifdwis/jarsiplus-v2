import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

/**
 * Auth composable — exposes user, roles, permissions and helpers.
 * Reads from Inertia shared props seeded by HandleInertiaRequests middleware.
 */
export function useAuth() {
    const page = usePage();

    const user = computed(() => page.props.auth?.user ?? null);
    const roles = computed(() => page.props.auth?.roles ?? []);
    const permissions = computed(() => page.props.auth?.permissions ?? []);

    const hasRole = (slug) => roles.value.includes(slug);

    const hasAnyRole = (slugs) => slugs.some((s) => roles.value.includes(s));

    const hasPermission = (slug) =>
        permissions.value.includes(slug) || permissions.value.includes('*');

    const isAdmin = computed(() => hasAnyRole(['administrator', 'superadmin']));
    const isSuperadmin = computed(() => hasRole('superadmin'));
    const isPemohon = computed(() => hasRole('pemohon'));
    const isPembahas = computed(() => hasRole('Pembahas'));

    return {
        user,
        roles,
        permissions,
        hasRole,
        hasAnyRole,
        hasPermission,
        isAdmin,
        isSuperadmin,
        isPemohon,
        isPembahas,
    };
}
