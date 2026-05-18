<script setup>
defineProps({
    message: { type: String, default: 'Sistem sedang dalam pemeliharaan. Mohon coba lagi nanti.' },
});
</script>

<template>
    <div class="min-h-screen bg-[#222831] text-[#EEEEEE] flex items-center justify-center p-4">
        <div class="max-w-md text-center">
            <i class="pi pi-cog text-[#00ADB5] text-6xl mb-6 animate-spin" style="animation-duration: 4s"></i>
            <h1 class="text-2xl font-bold mb-2">Sedang Pemeliharaan</h1>
            <p class="text-[#EEEEEE]/70">{{ message }}</p>
        </div>
    </div>
</template>
