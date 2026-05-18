<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Select from 'primevue/select';

defineProps({ urusan: Array });

const form = useForm({
    label: '',
    urusan_utama: null,
    rancang_bangun: '',
    tujuan_inovasi: '',
    manfaat_inovasi: '',
    hasil_inovasi: '',
});

function submit() {
    form.post(route('permohonan.store'));
}
</script>

<template>
    <AdminLayout>
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-zinc-900">Buat Permohonan</h1>
                <p class="text-xs text-zinc-500 mt-0.5">Isi data inovasi daerah</p>
            </div>
            <Link
                href="/jarsiplus/permohonan"
                class="text-xs text-zinc-600 hover:text-zinc-900 inline-flex items-center gap-1"
            >
                <i class="pi pi-arrow-left text-[10px]"></i>
                Kembali
            </Link>
        </div>

        <form @submit.prevent="submit" class="bg-white border border-zinc-200 rounded p-5 max-w-3xl space-y-4">
            <div>
                <label class="block text-xs font-medium text-zinc-700 mb-1">Judul Inovasi <span class="text-red-500">*</span></label>
                <InputText
                    v-model="form.label"
                    fluid
                    size="small"
                    placeholder="Contoh: Aplikasi Layanan Terpadu"
                    :invalid="!!form.errors.label"
                />
                <p v-if="form.errors.label" class="text-[11px] text-red-600 mt-1">{{ form.errors.label }}</p>
            </div>

            <div>
                <label class="block text-xs font-medium text-zinc-700 mb-1">Urusan Utama <span class="text-red-500">*</span></label>
                <Select
                    v-model="form.urusan_utama"
                    :options="urusan"
                    optionLabel="label"
                    optionValue="id"
                    placeholder="Pilih urusan"
                    fluid
                    size="small"
                    filter
                    :invalid="!!form.errors.urusan_utama"
                />
                <p v-if="form.errors.urusan_utama" class="text-[11px] text-red-600 mt-1">{{ form.errors.urusan_utama }}</p>
            </div>

            <div>
                <label class="block text-xs font-medium text-zinc-700 mb-1">Rancang Bangun</label>
                <Textarea
                    v-model="form.rancang_bangun"
                    rows="3"
                    autoResize
                    fluid
                    placeholder="Konsep / latar belakang inovasi"
                />
            </div>

            <div>
                <label class="block text-xs font-medium text-zinc-700 mb-1">Tujuan Inovasi</label>
                <Textarea v-model="form.tujuan_inovasi" rows="3" autoResize fluid />
            </div>

            <div>
                <label class="block text-xs font-medium text-zinc-700 mb-1">Manfaat Inovasi</label>
                <Textarea v-model="form.manfaat_inovasi" rows="3" autoResize fluid />
            </div>

            <div>
                <label class="block text-xs font-medium text-zinc-700 mb-1">Hasil Inovasi</label>
                <Textarea v-model="form.hasil_inovasi" rows="3" autoResize fluid />
            </div>

            <div class="flex gap-2 pt-2 border-t border-zinc-100">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="text-xs font-medium text-white bg-zinc-900 hover:bg-zinc-800 disabled:opacity-50 px-4 py-1.5 rounded"
                >
                    {{ form.processing ? 'Menyimpan...' : 'Simpan Permohonan' }}
                </button>
                <Link
                    href="/jarsiplus/permohonan"
                    class="text-xs font-medium text-zinc-700 bg-white border border-zinc-300 hover:bg-zinc-50 px-4 py-1.5 rounded"
                >
                    Batal
                </Link>
            </div>
        </form>
    </AdminLayout>
</template>
