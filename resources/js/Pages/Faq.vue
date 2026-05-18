<template>
  <div class="min-h-screen bg-[#EEEEEE]">
    <!-- Navigation -->
    <nav class="bg-[#222831] shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <h1 class="text-2xl font-bold text-[#00ADB5]">JARSIPLUS</h1>
          <div class="flex items-center space-x-4">
            <a href="/" class="text-[#EEEEEE] hover:text-[#00ADB5]">Beranda</a>
            <a href="/faq" class="text-[#EEEEEE] hover:text-[#00ADB5]">FAQ</a>
            <a href="/dashboard" class="text-[#EEEEEE] hover:text-[#00ADB5]">Dashboard</a>
          </div>
        </div>
      </div>
    </nav>

    <!-- FAQ Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h2 class="text-4xl font-bold text-[#222831] mb-12">Pertanyaan yang Sering Diajukan</h2>

      <div class="space-y-6">
        <div v-for="item in faq" :key="item.id" class="bg-white p-6 rounded-lg shadow">
          <button
            @click="toggleFaq(item.id)"
            class="w-full text-left flex justify-between items-center"
          >
            <h3 class="text-lg font-semibold text-[#222831]">{{ item.label }}</h3>
            <span class="text-[#00ADB5] text-2xl">{{ expandedFaq.includes(item.id) ? '−' : '+' }}</span>
          </button>
          <div v-if="expandedFaq.includes(item.id)" class="mt-4 text-[#393E46]" v-html="item.jawaban"></div>
        </div>
      </div>

      <div v-if="faq.length === 0" class="text-center py-12">
        <p class="text-[#393E46]">Belum ada FAQ tersedia</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  faq: Array,
})

const expandedFaq = ref([])

const toggleFaq = (id) => {
  const index = expandedFaq.value.indexOf(id)
  if (index > -1) {
    expandedFaq.value.splice(index, 1)
  } else {
    expandedFaq.value.push(id)
  }
}
</script>
