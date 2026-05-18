<script setup>
import { Link } from '@inertiajs/vue3';

const year = new Date().getFullYear();

const columns = [
    {
        title: 'Inovasi',
        links: [
            { label: 'Galeri Inovasi', href: '/inovasi' },
            { label: 'Cara Mengajukan', href: '/about#cara' },
            { label: 'Jadwal Pengajuan', href: '/about#jadwal' },
        ],
    },
    {
        title: 'Tentang',
        links: [
            { label: 'Tentang JARSIPLUS', href: '/about' },
            { label: 'Pemerintah Kota Samarinda', href: 'https://samarindakota.go.id', external: true },
            { label: 'Kontak', href: '/contact' },
        ],
    },
    {
        title: 'Bantuan',
        links: [
            { label: 'FAQ', href: '/faq' },
            { label: 'Kontak Admin', href: '/contact' },
            { label: 'Login SSO', href: '/login' },
        ],
    },
];
</script>

<template>
    <footer class="bg-[#222831] text-[#EEEEEE]">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <Link href="/" class="flex items-center gap-2 mb-4">
                        <div class="w-9 h-9 bg-[#00ADB5] rounded flex items-center justify-center text-[#222831] font-bold">
                            J+
                        </div>
                        <span class="font-bold tracking-tight">JARSIPLUS</span>
                    </Link>
                    <p class="text-sm text-[#EEEEEE]/70 leading-relaxed">
                        Jaringan Inovasi Plus Daerah — platform inovasi Pemerintah Kota Samarinda untuk pengelolaan, penilaian, dan publikasi inovasi daerah.
                    </p>
                </div>

                <div v-for="col in columns" :key="col.title">
                    <h4 class="text-sm font-semibold mb-4 tracking-wide uppercase text-[#00ADB5]">{{ col.title }}</h4>
                    <ul class="space-y-2">
                        <li v-for="link in col.links" :key="link.label">
                            <a
                                v-if="link.external"
                                :href="link.href"
                                target="_blank"
                                rel="noopener"
                                class="text-sm text-[#EEEEEE]/80 hover:text-[#00ADB5]"
                            >
                                {{ link.label }}
                            </a>
                            <Link
                                v-else
                                :href="link.href"
                                class="text-sm text-[#EEEEEE]/80 hover:text-[#00ADB5]"
                            >
                                {{ link.label }}
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-[#393E46] flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-[#EEEEEE]/60">
                <p>© {{ year }} Pemerintah Kota Samarinda. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <span>Powered by Diskominfo Kota Samarinda</span>
                </div>
            </div>
        </div>
    </footer>
</template>
