<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    transparent: { type: Boolean, default: false },
});

const mobileOpen = ref(false);

const navItems = [
    { label: 'Beranda', href: '/' },
    { label: 'Tentang', href: '/about' },
    { label: 'Inovasi', href: '/inovasi' },
    { label: 'FAQ', href: '/faq' },
    { label: 'Kontak', href: '/contact' },
];
</script>

<template>
    <nav
        :class="[
            'fixed top-0 left-0 right-0 z-50 transition-colors duration-200',
            transparent ? 'bg-transparent' : 'bg-[#222831]/95 backdrop-blur',
        ]"
    >
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <Link href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-[#00ADB5] rounded flex items-center justify-center text-[#222831] font-bold text-sm">
                        J+
                    </div>
                    <span class="text-[#EEEEEE] font-bold tracking-tight">JARSIPLUS</span>
                </Link>

                <div class="hidden md:flex items-center gap-1">
                    <Link
                        v-for="item in navItems"
                        :key="item.href"
                        :href="item.href"
                        class="text-sm text-[#EEEEEE]/80 hover:text-[#00ADB5] px-3 py-2 rounded transition-colors"
                    >
                        {{ item.label }}
                    </Link>
                </div>

                <div class="hidden md:flex items-center gap-2">
                    <Link
                        href="/login"
                        class="text-sm font-semibold text-[#222831] bg-[#00ADB5] hover:bg-[#00ADB5]/90 px-4 py-2 rounded transition-colors"
                    >
                        Masuk
                    </Link>
                </div>

                <button
                    @click="mobileOpen = !mobileOpen"
                    class="md:hidden text-[#EEEEEE] p-2"
                    aria-label="Toggle menu"
                >
                    <i :class="mobileOpen ? 'pi pi-times' : 'pi pi-bars'"></i>
                </button>
            </div>

            <div v-if="mobileOpen" class="md:hidden border-t border-[#393E46] py-3 space-y-1">
                <Link
                    v-for="item in navItems"
                    :key="item.href"
                    :href="item.href"
                    class="block text-sm text-[#EEEEEE]/80 hover:text-[#00ADB5] px-3 py-2 rounded"
                >
                    {{ item.label }}
                </Link>
                <Link
                    href="/login"
                    class="block text-sm font-semibold text-[#222831] bg-[#00ADB5] px-3 py-2 rounded mt-2 text-center"
                >
                    Masuk
                </Link>
            </div>
        </div>
    </nav>
</template>
