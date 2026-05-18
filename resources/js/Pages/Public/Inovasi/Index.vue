<script setup>
import { Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import PublicHero from '@/Components/Public/PublicHero.vue';

defineProps({
    inovasi: { type: Object, required: true }, // paginator
});

const truncate = (s, n = 140) => {
    if (!s) return '';
    return s.length > n ? s.slice(0, n).trim() + '…' : s;
};
</script>

<template>
    <PublicLayout>
        <PublicHero
            eyebrow="Galeri Inovasi"
            title="Inovasi yang telah disetujui Pemkot Samarinda."
            subtitle="Jelajahi katalog inovasi yang telah berhasil melewati tahap penilaian."
        />

        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <Link
                        v-for="item in inovasi.data"
                        :key="item.id"
                        :href="`/inovasi/${item.slug}`"
                        class="group block bg-white border border-[#393E46]/10 rounded-lg p-6 hover:border-[#00ADB5] hover:shadow-md transition-all"
                    >
                        <p v-if="item.kode" class="text-[10px] font-mono text-[#393E46]/60 uppercase tracking-wide mb-2">{{ item.kode }}</p>
                        <h3 class="text-base font-semibold text-[#222831] group-hover:text-[#00ADB5] line-clamp-2">{{ item.label }}</h3>
                        <p class="text-sm text-[#393E46] mt-2 line-clamp-3">{{ truncate(item.tujuan_inovasi) }}</p>
                        <div class="mt-4 pt-4 border-t border-[#393E46]/10 flex items-center justify-between text-xs">
                            <span class="text-[#393E46]/70">{{ item.pemohon?.unit_kerja ?? item.pemohon?.name ?? '—' }}</span>
                            <span class="inline-flex items-center gap-1 text-[#00ADB5] font-semibold">
                                Detail
                                <i class="pi pi-arrow-right text-[10px]"></i>
                            </span>
                        </div>
                    </Link>
                </div>

                <div v-if="!inovasi.data.length" class="text-center py-12">
                    <i class="pi pi-folder-open text-3xl text-[#393E46]/40"></i>
                    <p class="text-sm text-[#393E46] mt-3">Belum ada inovasi yang dipublikasikan.</p>
                </div>

                <!-- Simple pagination -->
                <div v-if="inovasi.last_page > 1" class="mt-12 flex items-center justify-center gap-2">
                    <Link
                        v-for="link in inovasi.links"
                        :key="link.label"
                        :href="link.url ?? '#'"
                        :class="[
                            'min-w-[2.25rem] h-9 inline-flex items-center justify-center text-sm rounded',
                            link.active
                                ? 'bg-[#00ADB5] text-[#222831] font-semibold'
                                : 'bg-white border border-[#393E46]/20 text-[#393E46] hover:border-[#00ADB5]',
                            !link.url ? 'opacity-40 pointer-events-none' : '',
                        ]"
                        v-html="link.label"
                    />
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
