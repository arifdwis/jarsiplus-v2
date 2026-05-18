import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';

/**
 * Auto-display toast for `flash.success` / `flash.error` from Inertia shared props.
 * Mount once at the layout level.
 */
export function useFlash() {
    const page = usePage();
    const toast = useToast();

    watch(
        () => page.props.flash,
        (flash) => {
            if (!flash) return;
            if (flash.success) {
                toast.add({ severity: 'success', summary: 'Berhasil', detail: flash.success, life: 3000 });
            }
            if (flash.error) {
                toast.add({ severity: 'error', summary: 'Gagal', detail: flash.error, life: 4000 });
            }
        },
        { immediate: true, deep: true },
    );
}
