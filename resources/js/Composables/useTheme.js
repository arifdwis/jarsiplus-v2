import { ref, watchEffect } from 'vue';

const STORAGE_KEY = 'jarsiplus-theme';

/**
 * Light / dark theme toggle persisted to localStorage.
 * Applies `.app-dark` to <html> when dark.
 */
export function useTheme() {
    const stored = typeof window !== 'undefined' ? localStorage.getItem(STORAGE_KEY) : null;
    const dark = ref(stored === 'dark');

    const apply = () => {
        if (typeof document === 'undefined') return;
        document.documentElement.classList.toggle('app-dark', dark.value);
    };

    watchEffect(() => {
        apply();
        if (typeof window !== 'undefined') {
            localStorage.setItem(STORAGE_KEY, dark.value ? 'dark' : 'light');
        }
    });

    const toggle = () => { dark.value = !dark.value; };

    return { dark, toggle };
}
