<script setup>
import { Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import PublicHero from '@/Components/Public/PublicHero.vue';

defineProps({
    inovasi: { type: Object, required: true },
});
</script>

<template>
    <PublicLayout>
        <PublicHero
            :eyebrow="inovasi.kode ?? 'Inovasi'"
            :title="inovasi.label"
            :subtitle="inovasi.urusan?.label"
        />

        <article class="py-20 bg-white">
            <div class="max-w-4xl mx-auto px-4 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
                    <div class="bg-[#EEEEEE] rounded p-4">
                        <p class="text-[10px] uppercase tracking-wider text-[#393E46]/70 font-semibold">Inisiator</p>
                        <p class="text-sm text-[#222831] mt-1 font-medium">{{ inovasi.inisiator || '—' }}</p>
                    </div>
                    <div class="bg-[#EEEEEE] rounded p-4">
                        <p class="text-[10px] uppercase tracking-wider text-[#393E46]/70 font-semibold">Tahapan</p>
                        <p class="text-sm text-[#222831] mt-1 font-medium">{{ inovasi.tahapan || '—' }}</p>
                    </div>
                    <div class="bg-[#EEEEEE] rounded p-4">
                        <p class="text-[10px] uppercase tracking-wider text-[#393E46]/70 font-semibold">Tematik</p>
                        <p class="text-sm text-[#222831] mt-1 font-medium">{{ inovasi.tematik || '—' }}</p>
                    </div>
                </div>

                <section v-if="inovasi.rancang_bangun" class="mb-10">
                    <h2 class="text-2xl font-bold text-[#222831] mb-3">Rancang Bangun</h2>
                    <p class="text-base text-[#393E46] leading-relaxed whitespace-pre-line">{{ inovasi.rancang_bangun }}</p>
                </section>

                <section v-if="inovasi.tujuan_inovasi" class="mb-10">
                    <h2 class="text-2xl font-bold text-[#222831] mb-3">Tujuan Inovasi</h2>
                    <p class="text-base text-[#393E46] leading-relaxed whitespace-pre-line">{{ inovasi.tujuan_inovasi }}</p>
                </section>

                <section v-if="inovasi.manfaat_inovasi" class="mb-10">
                    <h2 class="text-2xl font-bold text-[#222831] mb-3">Manfaat Inovasi</h2>
                    <p class="text-base text-[#393E46] leading-relaxed whitespace-pre-line">{{ inovasi.manfaat_inovasi }}</p>
                </section>

                <section v-if="inovasi.hasil_inovasi" class="mb-10">
                    <h2 class="text-2xl font-bold text-[#222831] mb-3">Hasil Inovasi</h2>
                    <p class="text-base text-[#393E46] leading-relaxed whitespace-pre-line">{{ inovasi.hasil_inovasi }}</p>
                </section>

                <div class="mt-12 pt-8 border-t border-[#393E46]/10">
                    <Link href="/inovasi" class="inline-flex items-center gap-2 text-sm text-[#00ADB5] font-semibold hover:text-[#222831]">
                        <i class="pi pi-arrow-left text-xs"></i>
                        Kembali ke Galeri
                    </Link>
                </div>
            </div>
        </article>
    </PublicLayout>
</template>
