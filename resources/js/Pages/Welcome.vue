<template>
  <div class="min-h-screen bg-gradient-to-br from-[#222831] to-[#393E46]">
    <!-- Navigation -->
    <nav class="bg-[#222831] shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <h1 class="text-2xl font-bold text-[#00ADB5]">JARSIPLUS</h1>
          </div>
          <div class="flex items-center space-x-4">
            <a href="#" class="text-[#EEEEEE] hover:text-[#00ADB5]">Beranda</a>
            <a href="#" class="text-[#EEEEEE] hover:text-[#00ADB5]">FAQ</a>
            <a href="/login" class="bg-[#00ADB5] text-[#222831] px-4 py-2 rounded hover:bg-[#393E46] hover:text-[#00ADB5]">
              Login
            </a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
      <div class="text-center">
        <h2 class="text-5xl font-bold text-[#EEEEEE] mb-4">
          Jaringan Inovasi Plus Daerah
        </h2>
        <p class="text-xl text-[#EEEEEE] mb-8">
          Platform untuk mengajukan dan mengelola inovasi daerah Kota Samarinda
        </p>
        <a href="/login" class="inline-block bg-[#00ADB5] text-[#222831] px-8 py-3 rounded-lg font-semibold hover:bg-[#393E46] hover:text-[#00ADB5]">
          Mulai Sekarang
        </a>
      </div>
    </section>

    <!-- Features Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-[#393E46] p-6 rounded-lg">
          <h3 class="text-xl font-bold text-[#00ADB5] mb-2">Mudah Digunakan</h3>
          <p class="text-[#EEEEEE]">Interface yang intuitif memudahkan Anda mengajukan inovasi</p>
        </div>
        <div class="bg-[#393E46] p-6 rounded-lg">
          <h3 class="text-xl font-bold text-[#00ADB5] mb-2">Transparan</h3>
          <p class="text-[#EEEEEE]">Pantau status permohonan Anda secara real-time</p>
        </div>
        <div class="bg-[#393E46] p-6 rounded-lg">
          <h3 class="text-xl font-bold text-[#00ADB5] mb-2">Aman</h3>
          <p class="text-[#EEEEEE]">Data Anda dilindungi dengan enkripsi tingkat enterprise</p>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#222831] text-[#EEEEEE] py-8 mt-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p>&copy; 2026 JARSIPLUS. Semua hak dilindungi.</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
</script>
