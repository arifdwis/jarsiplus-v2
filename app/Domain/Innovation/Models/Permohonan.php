<?php

namespace App\Domain\Innovation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permohonan extends Model
{
    protected $table = 'permohonan';

    protected $fillable = [
        'uuid', 'id_pemohon_0', 'id_pemohon_1', 'id_provinsi', 'id_kota', 'id_kategori',
        'urusan_utama', 'urusan_lainnya', 'kode', 'label', 'slug',
        'tahapan', 'tematik', 'inisiator', 'jenis', 'nilai_akhir',
        'waktu_uji_coba', 'waktu_pelaksanaan',
        'rancang_bangun', 'tujuan_inovasi', 'manfaat_inovasi', 'hasil_inovasi',
        'anggaran', 'profil_bisnis', 'status', 'alasan_tolak',
    ];

    protected $casts = [
        'waktu_uji_coba' => 'date',
        'waktu_pelaksanaan' => 'date',
    ];

    /**
     * Pemohon utama (operator yang submit).
     */
    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(Pemohon::class, 'id_pemohon_0');
    }

    /**
     * Pemohon kedua (sekunder, opsional).
     */
    public function pemohonSekunder(): BelongsTo
    {
        return $this->belongsTo(Pemohon::class, 'id_pemohon_1');
    }

    public function urusan(): BelongsTo
    {
        return $this->belongsTo(Urusan::class, 'urusan_utama');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(UrusanKategori::class, 'id_kategori');
    }

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(\App\Domain\Region\Models\MasterProvince::class, 'id_provinsi');
    }

    public function kota(): BelongsTo
    {
        return $this->belongsTo(\App\Domain\Region\Models\MasterCity::class, 'id_kota');
    }

    public function files(): HasMany
    {
        return $this->hasMany(\App\Domain\DataDukung\Models\PermohonanFile::class, 'id_permohonan');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(PermohonanHistori::class, 'id_permohonan')->orderByDesc('created_at');
    }

    public function penilaians(): HasMany
    {
        return $this->hasMany(\App\Domain\Scoring\Models\PermohonanPenilaian::class, 'inovasi_id');
    }
}
