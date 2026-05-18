<script setup>
import { ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Tag from 'primevue/tag';

const props = defineProps({ permohonan: Object });

const statusLabel = {
    draft: 'Draft', submitted: 'Disubmit', reviewed: 'Ditinjau',
    approved: 'Disetujui', rejected: 'Ditolak',
};
const statusSeverity = {
    draft: 'secondary', submitted: 'info', reviewed: 'warn',
    approved: 'success', rejected: 'danger',
};

const submitForm = useForm({});
function submitPermohonan() {
    submitForm.post(`/jarsiplus/permohonan/${props.permohonan.id}/submit`);
}

const fileInput = ref(null);
const uploadForm = useForm({ file: null });
function onFileChange(e) {
    uploadForm.file = e.target.files[0];
}
function uploadFile() {
    if (!uploadForm.file) return;
    uploadForm.post(`/jarsiplus/permohonan/${props.permohonan.id}/upload`, {
        onSuccess: () => {
            uploadForm.reset();
            if (fileInput.value) fileInput.value.value = '';
        },
        forceFormData: true,
    });
}

function formatDate(d) {
    if (!d) return '-';
    return new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
}
</script>

<template>
    <AdminLayout>
        <div class="mb-4 flex items-center justify-between">
            <Link href="/jarsiplus/permohonan" class="text-xs text-zinc-600 hover:text-zinc-900 inline-flex items-center gap-1">
                <i class="pi pi-arrow-left text-[10px]"></i>
                Kembali ke daftar
            </Link>
        </div>

        <!-- Header -->
        <div class="bg-white border border-zinc-200 rounded p-5 mb-4">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1.5">
                        <span v-if="permohonan.kode" class="text-[10px] font-mono text-zinc-500 bg-zinc-100 px-1.5 py-0.5 rounded">
                            {{ permohonan.kode }}
                        </span>
                        <Tag
                            :value="statusLabel[permohonan.status] ?? (permohonan.status || '-')"
                            :severity="statusSeverity[permohonan.status] ?? 'secondary'"
                            class="!text-[10px] !py-0.5 !px-2"
                        />
                    </div>
                    <h1 class="text-lg font-semibold text-zinc-900">{{ permohonan.label || '(tanpa judul)' }}</h1>
                    <div class="flex items-center gap-3 text-xs text-zinc-500 mt-1.5">
                        <span v-if="permohonan.pemohon">
                            <i class="pi pi-user text-[10px] mr-1"></i>{{ permohonan.pemohon.name }}
                        </span>
                        <span v-if="permohonan.urusan">
                            <i class="pi pi-folder text-[10px] mr-1"></i>{{ permohonan.urusan.label }}
                        </span>
                        <span>
                            <i class="pi pi-calendar text-[10px] mr-1"></i>{{ formatDate(permohonan.created_at) }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <Link
                        v-if="permohonan.status === 'draft'"
                        :href="`/jarsiplus/permohonan/${permohonan.id}/edit`"
                        class="text-xs font-medium text-zinc-700 bg-white border border-zinc-300 hover:bg-zinc-50 px-3 py-1.5 rounded inline-flex items-center gap-1.5"
                    >
                        <i class="pi pi-pencil text-[10px]"></i>
                        Edit
                    </Link>
                    <button
                        v-if="permohonan.status === 'draft'"
                        @click="submitPermohonan"
                        :disabled="submitForm.processing"
                        class="text-xs font-medium text-white bg-zinc-900 hover:bg-zinc-800 px-3 py-1.5 rounded inline-flex items-center gap-1.5"
                    >
                        <i class="pi pi-send text-[10px]"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Main content -->
            <div class="lg:col-span-2 space-y-4">
                <section v-if="permohonan.rancang_bangun" class="bg-white border border-zinc-200 rounded p-5">
                    <h3 class="text-sm font-medium text-zinc-900 mb-2">Rancang Bangun</h3>
                    <p class="text-xs text-zinc-700 leading-relaxed whitespace-pre-line">{{ permohonan.rancang_bangun }}</p>
                </section>

                <section v-if="permohonan.tujuan_inovasi" class="bg-white border border-zinc-200 rounded p-5">
                    <h3 class="text-sm font-medium text-zinc-900 mb-2">Tujuan Inovasi</h3>
                    <p class="text-xs text-zinc-700 leading-relaxed whitespace-pre-line">{{ permohonan.tujuan_inovasi }}</p>
                </section>

                <section v-if="permohonan.manfaat_inovasi" class="bg-white border border-zinc-200 rounded p-5">
                    <h3 class="text-sm font-medium text-zinc-900 mb-2">Manfaat Inovasi</h3>
                    <p class="text-xs text-zinc-700 leading-relaxed whitespace-pre-line">{{ permohonan.manfaat_inovasi }}</p>
                </section>

                <section v-if="permohonan.hasil_inovasi" class="bg-white border border-zinc-200 rounded p-5">
                    <h3 class="text-sm font-medium text-zinc-900 mb-2">Hasil Inovasi</h3>
                    <p class="text-xs text-zinc-700 leading-relaxed whitespace-pre-line">{{ permohonan.hasil_inovasi }}</p>
                </section>

                <!-- Files -->
                <section class="bg-white border border-zinc-200 rounded p-5">
                    <h3 class="text-sm font-medium text-zinc-900 mb-3">File Pendukung ({{ permohonan.files?.length || 0 }})</h3>

                    <ul v-if="permohonan.files?.length" class="space-y-1.5 mb-4">
                        <li
                            v-for="f in permohonan.files"
                            :key="f.id"
                            class="flex items-center justify-between px-3 py-2 bg-zinc-50 border border-zinc-100 rounded text-xs"
                        >
                            <div class="flex items-center gap-2 min-w-0">
                                <i class="pi pi-file text-zinc-400 text-[11px]"></i>
                                <span class="text-zinc-900 truncate">{{ f.label || f.file }}</span>
                            </div>
                            <a
                                :href="`/download/${f.id}`"
                                class="text-zinc-600 hover:text-zinc-900 inline-flex items-center gap-1 text-[11px]"
                            >
                                <i class="pi pi-download text-[10px]"></i>
                                Download
                            </a>
                        </li>
                    </ul>
                    <p v-else class="text-xs text-zinc-500 italic mb-4">Belum ada file</p>

                    <div v-if="permohonan.status === 'draft'" class="border-t border-zinc-100 pt-4">
                        <input
                            ref="fileInput"
                            type="file"
                            @change="onFileChange"
                            class="block w-full text-xs text-zinc-700 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200"
                        />
                        <button
                            @click="uploadFile"
                            :disabled="!uploadForm.file || uploadForm.processing"
                            class="mt-2 text-xs font-medium text-white bg-zinc-900 hover:bg-zinc-800 disabled:opacity-50 px-3 py-1.5 rounded"
                        >
                            {{ uploadForm.processing ? 'Mengupload...' : 'Upload File' }}
                        </button>
                    </div>
                </section>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-4">
                <section class="bg-white border border-zinc-200 rounded p-4">
                    <h3 class="text-xs font-medium text-zinc-900 mb-3 uppercase tracking-wide">Informasi</h3>
                    <dl class="text-xs space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-zinc-500">Tahapan</dt>
                            <dd class="text-zinc-900 font-medium">{{ permohonan.tahapan || '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-zinc-500">Tematik</dt>
                            <dd class="text-zinc-900 font-medium">{{ permohonan.tematik || '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-zinc-500">Inisiator</dt>
                            <dd class="text-zinc-900 font-medium">{{ permohonan.inisiator || '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-zinc-500">Jenis</dt>
                            <dd class="text-zinc-900 font-medium">{{ permohonan.jenis || '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-zinc-500">Anggaran</dt>
                            <dd class="text-zinc-900 font-medium">{{ permohonan.anggaran || '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-zinc-500">Nilai Akhir</dt>
                            <dd class="text-zinc-900 font-medium tabular-nums">{{ permohonan.nilai_akhir || '-' }}</dd>
                        </div>
                    </dl>
                </section>

                <section v-if="permohonan.histories?.length" class="bg-white border border-zinc-200 rounded p-4">
                    <h3 class="text-xs font-medium text-zinc-900 mb-3 uppercase tracking-wide">
                        Riwayat ({{ permohonan.histories.length }})
                    </h3>
                    <ul class="space-y-2.5">
                        <li v-for="h in permohonan.histories.slice(0, 10)" :key="h.id" class="flex gap-2 text-xs">
                            <div class="w-1.5 h-1.5 rounded-full bg-zinc-900 mt-1.5 flex-shrink-0"></div>
                            <div class="min-w-0 flex-1">
                                <p class="text-zinc-900 leading-snug">{{ h.deskripsi || '-' }}</p>
                                <p class="text-[10px] text-zinc-500 mt-0.5">
                                    {{ h.operator?.name ?? 'System' }} · {{ formatDate(h.created_at) }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </section>
            </aside>
        </div>
    </AdminLayout>
</template>
