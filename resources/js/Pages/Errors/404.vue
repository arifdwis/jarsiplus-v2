<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-[#222831] text-[#EEEEEE] flex items-center justify-center p-4">
        <div class="max-w-md text-center">
            <p class="text-[#00ADB5] text-7xl font-bold tracking-tight mb-4">404</p>
            <h1 class="text-2xl font-bold mb-2">Halaman tidak ditemukan</h1>
            <p class="text-[#EEEEEE]/70 mb-8">
                Halaman yang Anda cari mungkin telah dipindahkan atau dihapus.
            </p>
            <Link
                href="/"
                class="inline-flex items-center gap-2 text-sm font-semibold text-[#222831] bg-[#00ADB5] hover:bg-[#00ADB5]/90 px-5 py-2.5 rounded transition-colors"
            >
                <i class="pi pi-arrow-left text-xs"></i>
                Kembali ke Beranda
            </Link>
        </div>
    </div>
</template>
