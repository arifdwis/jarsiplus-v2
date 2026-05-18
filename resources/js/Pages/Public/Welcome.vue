<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import PublicHero from '@/Components/Public/PublicHero.vue';
import PublicFeatureGrid from '@/Components/Public/PublicFeatureGrid.vue';
import PublicSteps from '@/Components/Public/PublicSteps.vue';
import PublicCTA from '@/Components/Public/PublicCTA.vue';

defineProps({
    stats: { type: Object, default: () => ({ inovasi: 0, pemohon: 0, urusan: 0 }) },
    schedule: { type: Object, default: () => null }, // { open, close, isOpen, year }
});

const features = [
    {
        icon: 'pi pi-bolt',
        title: 'Mudah Digunakan',
        description: 'Wizard pengajuan 4 langkah yang intuitif. Pemohon ASN langsung login lewat SSO Pemkot.',
    },
    {
        icon: 'pi pi-eye',
        title: 'Transparan',
        description: 'Pantau status permohonan, riwayat pembahasan, dan skor penilaian secara real-time.',
    },
    {
        icon: 'pi pi-shield',
        title: 'Aman & Terintegrasi',
        description: 'Otentikasi SSO, audit lengkap, dan integrasi dengan sistem juri eksternal Pemkot.',
    },
    {
        icon: 'pi pi-chart-line',
        title: 'Data-Driven',
        description: 'Penilaian berbasis indikator dan parameter dengan bobot terukur, laporan komprehensif.',
    },
];

const steps = [
    { number: 1, title: 'Login SSO', description: 'Masuk lewat SSO Pemkot Samarinda dengan akun ASN Anda.' },
    { number: 2, title: 'Isi Profil Inovasi', description: 'Lengkapi judul, urusan, rancang bangun, tujuan, dan manfaat inovasi.' },
    { number: 3, title: 'Upload Data Dukung', description: 'Pilih parameter per indikator dan unggah file pendukung sesuai bukti.' },
    { number: 4, title: 'Submit untuk Review', description: 'Tim Pembahas akan menelaah dan memberikan validasi. Pantau statusnya.' },
];
</script>

<template>
    <PublicLayout transparent-nav>
        <PublicHero
            eyebrow="Pemerintah Kota Samarinda"
            title="Jaringan Inovasi Plus Daerah"
            subtitle="Platform untuk mengelola, menilai, dan mempublikasikan inovasi daerah Kota Samarinda secara transparan dan profesional."
            :primary-cta="{ label: 'Ajukan Inovasi', href: '/login' }"
            :secondary-cta="{ label: 'Lihat Galeri Inovasi', href: '/inovasi' }"
        >
            <template #meta>
                <div v-if="schedule" class="mt-12 inline-flex items-center gap-3 bg-[#00ADB5]/10 border border-[#00ADB5]/30 px-4 py-3 rounded">
                    <span :class="['w-2 h-2 rounded-full', schedule.isOpen ? 'bg-[#00ADB5] animate-pulse' : 'bg-red-400']"></span>
                    <p class="text-sm text-[#EEEEEE]">
                        <span v-if="schedule.isOpen">Pengajuan {{ schedule.year }} <strong>terbuka</strong> hingga {{ schedule.close }}</span>
                        <span v-else>Pengajuan {{ schedule.year }} sedang ditutup</span>
                    </p>
                </div>
            </template>
        </PublicHero>

        <!-- Stats strip -->
        <section class="bg-[#EEEEEE] py-12 border-y border-[#393E46]/10">
            <div class="max-w-7xl mx-auto px-4 lg:px-8 grid grid-cols-3 gap-6 text-center">
                <div>
                    <p class="text-3xl md:text-4xl font-bold text-[#222831] tabular-nums">{{ stats.inovasi.toLocaleString('id-ID') }}</p>
                    <p class="text-xs md:text-sm text-[#393E46] mt-1 uppercase tracking-wide">Inovasi Terdaftar</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-bold text-[#222831] tabular-nums">{{ stats.pemohon.toLocaleString('id-ID') }}</p>
                    <p class="text-xs md:text-sm text-[#393E46] mt-1 uppercase tracking-wide">Pemohon ASN</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-bold text-[#222831] tabular-nums">{{ stats.urusan.toLocaleString('id-ID') }}</p>
                    <p class="text-xs md:text-sm text-[#393E46] mt-1 uppercase tracking-wide">Urusan Pemerintahan</p>
                </div>
            </div>
        </section>

        <PublicFeatureGrid
            eyebrow="Mengapa JARSIPLUS"
            title="Sebuah platform untuk seluruh siklus inovasi daerah."
            subtitle="Dari pengajuan, pengisian data dukung, pembahasan, hingga penilaian — semuanya dalam satu aplikasi."
            :items="features"
        />

        <PublicSteps
            eyebrow="Cara Mengajukan"
            title="Empat langkah untuk mengajukan inovasi Anda."
            subtitle="Proses yang jelas, deadline yang transparan, dan dukungan tim Pemkot di setiap langkah."
            :steps="steps"
        />

        <PublicCTA
            title="Punya inovasi yang siap diajukan?"
            subtitle="Bergabunglah dengan ratusan ASN Pemkot Samarinda yang telah mengajukan inovasi mereka di JARSIPLUS."
            :primary-cta="{ label: 'Mulai Sekarang', href: '/login' }"
            :secondary-cta="{ label: 'Pelajari Selengkapnya', href: '/about' }"
        />
    </PublicLayout>
</template>
