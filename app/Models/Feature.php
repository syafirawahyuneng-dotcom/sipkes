<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'icon',
        'description',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get working route URL for this operational RME feature
     */
    public function getRouteUrlAttribute(): string
    {
        $name = strtolower($this->name);
        if (str_contains($name, 'pendaftaran')) {
            return route('rme.pendaftaran');
        }
        if (str_contains($name, 'antrian')) {
            return route('rme.antrian');
        }
        if (str_contains($name, 'pemeriksaan') || str_contains($name, '(so)')) {
            return route('rme.pemeriksaan.so');
        }
        if (str_contains($name, 'diagnosa') || str_contains($name, '(ap)')) {
            return route('rme.diagnosa.tindakan');
        }
        if (str_contains($name, 'farmasi')) {
            return route('rme.farmasi');
        }
        if (str_contains($name, 'kasir')) {
            return route('rme.kasir');
        }
        if (str_contains($name, 'rawat inap')) {
            return route('rme.rawat.inap');
        }
        if (str_contains($name, 'laporan')) {
            return route('rme.laporan');
        }
        if (str_contains($name, 'dashboard')) {
            return route('rme.dashboard');
        }
        if (str_contains($name, 'kartu')) {
            return route('rme.kartu.berobat');
        }
        if (str_contains($name, 'satusehat mobile') || str_contains($name, 'verifikasi')) {
            return route('rme.verifikasi.satusehat');
        }
        if (str_contains($name, 'keperawatan') || str_contains($name, 'askep')) {
            return route('rme.asuhan.keperawatan');
        }
        if (str_contains($name, 'integrasi') || str_contains($name, 'bpjs')) {
            return route('rme.pengaturan.integrasi');
        }
        if (str_contains($name, 'odontogram') || str_contains($name, 'gigi')) {
            return route('rme.odontogram');
        }
        if (str_contains($name, 'general consent')) {
            return route('rme.general.consent');
        }
        if (str_contains($name, 'informed consent')) {
            return route('rme.informed.consent');
        }
        if (str_contains($name, 'surat')) {
            return route('rme.surat.keterangan');
        }
        if (str_contains($name, 'laboratorium')) {
            return route('rme.laboratorium');
        }
        if (str_contains($name, 'sedasi')) {
            return route('rme.sedasi');
        }
        if (str_contains($name, 'lain-lain') || str_contains($name, 'master')) {
            return route('rme.master.data');
        }

        return route('rme.dashboard');
    }

    /**
     * Get action button label
     */
    public function getActionLabelAttribute(): string
    {
        $name = strtolower($this->name);
        if (str_contains($name, 'pendaftaran')) return 'Buka Pendaftaran Pasien';
        if (str_contains($name, 'antrian')) return 'Buka Layar Antrian & Audio';
        if (str_contains($name, 'pemeriksaan')) return 'Mulai Pemeriksaan SOAP (SO)';
        if (str_contains($name, 'diagnosa')) return 'Input Diagnosa ICD-10 (AP)';
        if (str_contains($name, 'farmasi')) return 'Kelola Obat & Resep';
        if (str_contains($name, 'kasir')) return 'Buka Kasir & Billing';
        if (str_contains($name, 'rawat inap')) return 'Monitoring Bed & CPPT';
        if (str_contains($name, 'laporan')) return 'Lihat Laporan Morbiditas';
        if (str_contains($name, 'dashboard')) return 'Buka Dashboard Klinik';
        if (str_contains($name, 'kartu')) return 'Cetak Kartu Berobat';
        if (str_contains($name, 'satusehat mobile') || str_contains($name, 'verifikasi')) return 'Uji Verifikasi SatuSehat';
        if (str_contains($name, 'keperawatan')) return 'Dokumentasi Askep (SDKI)';
        if (str_contains($name, 'integrasi')) return 'Kelola Bridging API';
        if (str_contains($name, 'odontogram')) return 'Buka Odontogram 32 Gigi';
        if (str_contains($name, 'general consent')) return 'Isi General Consent (TTD)';
        if (str_contains($name, 'informed consent')) return 'Isi Informed Consent (TTD)';
        if (str_contains($name, 'surat')) return 'Buat Surat Sakit / Sehat';
        if (str_contains($name, 'laboratorium')) return 'Input Hasil Uji Lab';
        if (str_contains($name, 'sedasi')) return 'Hitung Skor Aldrete';
        if (str_contains($name, 'lain-lain')) return 'Kelola Master Data & Faskes';

        return 'Gunakan Fitur Ini';
    }
}

