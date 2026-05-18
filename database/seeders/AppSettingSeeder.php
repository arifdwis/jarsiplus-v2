<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('app_settings')->insert([
            [
                'key' => 'submission_open_date',
                'value' => '2026-01-01',
                'type' => 'date',
                'group' => 'pengajuan',
                'label' => 'Tanggal Buka Pendaftaran',
                'description' => 'Tanggal dimulainya periode pengajuan inovasi',
                'is_public' => true,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'submission_close_date',
                'value' => '2026-12-31',
                'type' => 'date',
                'group' => 'pengajuan',
                'label' => 'Tanggal Tutup Pendaftaran',
                'description' => 'Tanggal berakhirnya periode pengajuan inovasi',
                'is_public' => true,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'active_year',
                'value' => '2026',
                'type' => 'integer',
                'group' => 'sistem',
                'label' => 'Tahun Aktif',
                'description' => 'Tahun penyelenggaraan inovasi daerah saat ini',
                'is_public' => true,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'app_name',
                'value' => 'JARSIPLUS',
                'type' => 'string',
                'group' => 'sistem',
                'label' => 'Nama Aplikasi',
                'description' => 'Nama aplikasi yang ditampilkan di header dan title',
                'is_public' => true,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'sistem',
                'label' => 'Mode Maintenance',
                'description' => 'Aktifkan mode maintenance untuk semua pengguna kecuali admin',
                'is_public' => false,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
