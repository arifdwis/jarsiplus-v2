<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import PublicHero from '@/Components/Public/PublicHero.vue';
import PublicSteps from '@/Components/Public/PublicSteps.vue';
import PublicCTA from '@/Components/Public/PublicCTA.vue';

const steps = [
    { number: 1, title: 'Login SSO', description: 'Masuk lewat SSO Pemkot Samarinda dengan akun ASN Anda.' },
    { number: 2, title: 'Isi Profil Inovasi', description: 'Lengkapi judul, urusan, rancang bangun, tujuan, dan manfaat.' },
    { number: 3, title: 'Upload Data Dukung', description: 'Pilih parameter per indikator dan unggah file pendukung.' },
    { number: 4, title: 'Submit & Pantau', description: 'Tim Pembahas menelaah dan memberikan validasi.' },
];
</script>

<template>
    <PublicLayout>
        <PublicHero
            eyebrow="Tentang Kami"
            title="Membangun ekosistem inovasi daerah Kota Samarinda."
            subtitle="JARSIPLUS adalah inisiatif Pemerintah Kota Samarinda untuk mengelola dan mempromosikan inovasi-inovasi terbaik dari ASN, OPD, dan masyarakat."
        />

        <section class="py-20 bg-white">
            <div class="max-w-4xl mx-auto px-4 lg:px-8 prose prose-zinc">
                <h2 class="text-3xl font-bold text-[#222831]">Visi & Misi</h2>
                <p class="text-base text-[#393E46] leading-relaxed">
                    Menjadikan Samarinda sebagai kota yang terus berinovasi dalam pelayanan publik melalui platform digital yang transparan, akuntabel, dan kolaboratif.
                </p>

                <h3 class="text-xl font-semibold text-[#222831] mt-10">Apa yang Bisa Anda Lakukan?</h3>
                <ul class="text-base text-[#393E46] leading-relaxed space-y-2 list-disc list-inside">
                    <li>Mengajukan inovasi pelayanan publik dari unit kerja Anda.</li>
                    <li>Mengelola portofolio inovasi tahunan dengan riwayat lengkap.</li>
                    <li>Mendapatkan penilaian dari tim pembahas dan juri eksternal.</li>
                    <li>Berkontribusi pada peningkatan kualitas pemerintahan di Samarinda.</li>
                </ul>
            </div>
        </section>

        <PublicSteps
            id="cara"
            eyebrow="Cara Mengajukan"
            title="Alur pengajuan inovasi."
            :steps="steps"
        />

        <PublicCTA
            title="Siap memulai?"
            subtitle="Login dengan akun SSO Anda dan mulai ajukan inovasi pertama hari ini."
            :primary-cta="{ label: 'Login SSO', href: '/login' }"
        />
    </PublicLayout>
</template>
