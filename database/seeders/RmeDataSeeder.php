<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Medicine;
use App\Models\Examination;
use App\Models\Invoice;
use App\Models\InpatientRoom;
use App\Models\InpatientAdmission;
use App\Models\LabTest;
use App\Models\Odontogram;
use App\Models\MedicalCertificate;
use App\Models\NursingCare;
use App\Models\Sedation;
use App\Models\Consent;
use App\Models\SiteSetting;

class RmeDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pasien Sampel
        $p1 = Patient::updateOrCreate(['no_rm' => 'RM-2026-0001'], [
            'nik' => '3509121508890001',
            'bpjs_number' => '0001234567890',
            'name' => 'Budi Santoso',
            'gender' => 'L',
            'birth_date' => '1989-08-15',
            'phone' => '081234567890',
            'address' => 'Jl. Mastrip Timur No. 12, Jember',
            'blood_type' => 'O',
            'allergy_history' => 'Penisilin',
            'bpjs_status' => 'Aktif',
            'satusehat_ihs' => 'P10023456789',
        ]);

        $p2 = Patient::updateOrCreate(['no_rm' => 'RM-2026-0002'], [
            'nik' => '3509125204940003',
            'bpjs_number' => '0002345678901',
            'name' => 'Siti Aminah',
            'gender' => 'P',
            'birth_date' => '1994-04-12',
            'phone' => '085678901234',
            'address' => 'Jl. Danau Toba No. 45, Jember',
            'blood_type' => 'A',
            'allergy_history' => 'Tidak Ada',
            'bpjs_status' => 'Aktif',
            'satusehat_ihs' => 'P10023456790',
        ]);

        $p3 = Patient::updateOrCreate(['no_rm' => 'RM-2026-0003'], [
            'nik' => '3509122001850005',
            'bpjs_number' => '0003456789012',
            'name' => 'Hendra Pratama',
            'gender' => 'L',
            'birth_date' => '1985-01-20',
            'phone' => '082134567891',
            'address' => 'Jl. Kalimantan No. 8, Jember',
            'blood_type' => 'B',
            'allergy_history' => 'Aspirin',
            'bpjs_status' => 'Aktif',
            'satusehat_ihs' => 'P10023456791',
        ]);

        $p4 = Patient::updateOrCreate(['no_rm' => 'RM-2026-0004'], [
            'nik' => '3509126511020002',
            'bpjs_number' => '0004567890123',
            'name' => 'Dewi Lestari',
            'gender' => 'P',
            'birth_date' => '2002-11-25',
            'phone' => '089876543210',
            'address' => 'Jl. PB Sudirman No. 19, Jember',
            'blood_type' => 'AB',
            'allergy_history' => 'Udang, Seafood',
            'bpjs_status' => 'Aktif',
            'satusehat_ihs' => 'P10023456792',
        ]);

        // 2. Antrian Hari Ini
        Queue::updateOrCreate(['queue_number' => 'A-001'], [
            'poli' => 'Poli Umum',
            'patient_id' => $p1->id,
            'status' => 'dipanggil',
            'called_at' => now(),
        ]);
        Queue::updateOrCreate(['queue_number' => 'A-002'], [
            'poli' => 'Poli Umum',
            'patient_id' => $p2->id,
            'status' => 'menunggu',
        ]);
        Queue::updateOrCreate(['queue_number' => 'G-001'], [
            'poli' => 'Poli Gigi',
            'patient_id' => $p3->id,
            'status' => 'menunggu',
        ]);
        Queue::updateOrCreate(['queue_number' => 'K-001'], [
            'poli' => 'Poli KIA/KB',
            'patient_id' => $p4->id,
            'status' => 'menunggu',
        ]);

        // 3. Farmasi (Master Obat)
        $meds = [
            ['code' => 'OBT-001', 'name' => 'Paracetamol 500 mg', 'category' => 'Tablet', 'stock' => 350, 'unit' => 'Strip', 'price' => 6000, 'expired_date' => '2028-06-30', 'min_stock' => 50],
            ['code' => 'OBT-002', 'name' => 'Amoxicillin 500 mg', 'category' => 'Kapsul', 'stock' => 180, 'unit' => 'Strip', 'price' => 12000, 'expired_date' => '2027-11-15', 'min_stock' => 30],
            ['code' => 'OBT-003', 'name' => 'Antasida Doen', 'category' => 'Tablet Kunyah', 'stock' => 240, 'unit' => 'Strip', 'price' => 5000, 'expired_date' => '2028-02-28', 'min_stock' => 40],
            ['code' => 'OBT-004', 'name' => 'Captopril 25 mg', 'category' => 'Tablet', 'stock' => 90, 'unit' => 'Strip', 'price' => 8500, 'expired_date' => '2027-08-20', 'min_stock' => 25],
            ['code' => 'OBT-005', 'name' => 'Cetirizine 10 mg', 'category' => 'Tablet', 'stock' => 15, 'unit' => 'Strip', 'price' => 9000, 'expired_date' => '2027-05-10', 'min_stock' => 20], // Low stock!
            ['code' => 'OBT-006', 'name' => 'Metformin 500 mg', 'category' => 'Tablet', 'stock' => 120, 'unit' => 'Strip', 'price' => 7500, 'expired_date' => '2027-12-01', 'min_stock' => 30],
            ['code' => 'OBT-007', 'name' => 'Salep Hidrokortison 1%', 'category' => 'Salep / Tube', 'stock' => 45, 'unit' => 'Tube', 'price' => 15000, 'expired_date' => '2028-01-15', 'min_stock' => 15],
            ['code' => 'OBT-008', 'name' => 'Vitamin C 500 mg', 'category' => 'Tablet', 'stock' => 400, 'unit' => 'Botol', 'price' => 25000, 'expired_date' => '2028-10-30', 'min_stock' => 50],
        ];
        foreach ($meds as $m) {
            Medicine::updateOrCreate(['code' => $m['code']], $m);
        }

        // 4. Pemeriksaan SOAP Sampel
        $exam1 = Examination::updateOrCreate(['id' => 1], [
            'patient_id' => $p1->id,
            'poli' => 'Poli Umum',
            'doctor_name' => 'dr. Ahmad Santoso',
            'visit_date' => now()->toDateString(),
            'complaint_main' => 'Demam sejak 3 hari yang lalu, batuk kering, dan tenggorokan sakit.',
            'anamnesis' => 'Pasien mengeluh demam sumer sejak Kamis malam, batuk berdahak minimal, nafsu makan menurun.',
            'disease_history' => 'Riwayat maag terkontrol, tidak ada riwayat hipertensi atau diabetes.',
            'allergy' => 'Alergi Penisilin (gatal dan ruam merah).',
            'blood_pressure' => '120/80',
            'temperature' => 38.2,
            'pulse' => 84,
            'respiration' => 20,
            'weight' => 68.0,
            'height' => 172.0,
            'physical_exam' => 'Faring hiperemis (+), pembesaran tonsil T1/T1 tenang, cor/pulmo dalam batas normal.',
            'diagnosis_code' => 'J00',
            'diagnosis_name' => 'Acute nasopharyngitis [common cold]',
            'prognosis' => 'Bonam',
            'procedure_action' => 'Pemeriksaan fisik umum dan edukasi hidrasi hangat.',
            'prescription_notes' => 'Paracetamol 500mg 3x1 tab prn demam, Vitamin C 1x1 tab.',
            'status' => 'selesai',
        ]);

        // 5. Kasir Invoice Sampel
        Invoice::updateOrCreate(['invoice_number' => 'INV-2026-0001'], [
            'patient_id' => $p1->id,
            'examination_id' => $exam1->id,
            'admin_fee' => 15000,
            'doctor_fee' => 35000,
            'medicine_fee' => 31000,
            'action_fee' => 15000,
            'total_amount' => 96000,
            'paid_amount' => 100000,
            'change_amount' => 4000,
            'payment_status' => 'lunas',
            'payment_method' => 'Tunai',
        ]);

        // 6. Kamar Rawat Inap & Bed
        $rooms = [
            ['room_name' => 'Ruang Melati', 'bed_number' => 'Bed 01', 'class_type' => 'Kelas 1', 'price_per_day' => 175000, 'status' => 'terisi'],
            ['room_name' => 'Ruang Melati', 'bed_number' => 'Bed 02', 'class_type' => 'Kelas 1', 'price_per_day' => 175000, 'status' => 'tersedia'],
            ['room_name' => 'Ruang Mawar', 'bed_number' => 'Bed 01', 'class_type' => 'Kelas 2', 'price_per_day' => 125000, 'status' => 'tersedia'],
            ['room_name' => 'Ruang Mawar', 'bed_number' => 'Bed 02', 'class_type' => 'Kelas 2', 'price_per_day' => 125000, 'status' => 'tersedia'],
            ['room_name' => 'Ruang Anggrek (VIP)', 'bed_number' => 'VIP 01', 'class_type' => 'VIP', 'price_per_day' => 350000, 'status' => 'tersedia'],
        ];
        foreach ($rooms as $r) {
            $createdRoom = InpatientRoom::updateOrCreate(['room_name' => $r['room_name'], 'bed_number' => $r['bed_number']], $r);
            if ($r['status'] == 'terisi') {
                InpatientAdmission::updateOrCreate(['room_id' => $createdRoom->id], [
                    'patient_id' => $p3->id,
                    'check_in' => now()->subDays(2),
                    'initial_diagnosis' => 'Gastroenteritis Akut Dehidrasi Sedang (A09.0)',
                    'cppt_notes' => 'Hari rawat ke-2: Pasien merasa lebih segar, diare berkurang menjadi 1x hari ini, toleransi oral membaik, infus RL 20 tpm lancar.',
                    'status' => 'dirawat',
                ]);
            }
        }

        // 7. Odontogram Sampel Pasien Gigi
        Odontogram::updateOrCreate(['patient_id' => $p3->id, 'tooth_number' => '16'], [
            'condition' => 'Karies (K)',
            'notes' => 'Karies profunda oklusal, dianjurkan penambalan komposit.',
        ]);
        Odontogram::updateOrCreate(['patient_id' => $p3->id, 'tooth_number' => '24'], [
            'condition' => 'Tambalan Komposit (Co)',
            'notes' => 'Tambalan baik dan utuh.',
        ]);
        Odontogram::updateOrCreate(['patient_id' => $p3->id, 'tooth_number' => '36'], [
            'condition' => 'Gigi Hilang (Mis)',
            'notes' => 'Riwayat pencabutan 2 tahun lalu.',
        ]);

        // 8. General & Informed Consent Sampel
        Consent::updateOrCreate(['patient_id' => $p1->id, 'consent_type' => 'general'], [
            'signer_name' => 'Budi Santoso',
            'signer_relation' => 'Diri Sendiri',
            'procedure_name' => 'Pelayanan Rawat Jalan & Pemeriksaan Medis Terpadu',
            'signature_data' => 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="200" height="60"><path d="M10 40 Q 50 10 90 40 T 170 30" stroke="%232563eb" stroke-width="3" fill="none"/></svg>',
            'agreed' => true,
        ]);

        // 9. Surat Keterangan Sakit & Sehat Sampel
        MedicalCertificate::updateOrCreate(['certificate_number' => 'SKD/VKES/2026/001'], [
            'type' => 'sakit',
            'patient_id' => $p1->id,
            'doctor_name' => 'dr. Ahmad Santoso',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'rest_days' => 3,
            'purpose' => 'Istirahat Sakit karena Common Cold / Faringitis Akut',
            'condition_notes' => 'Pasien memerlukan istirahat tirah baring dan minum obat secara teratur selama 3 hari.',
        ]);

        MedicalCertificate::updateOrCreate(['certificate_number' => 'SKD/VKES/2026/002'], [
            'type' => 'sehat',
            'patient_id' => $p4->id,
            'doctor_name' => 'dr. Ahmad Santoso',
            'start_date' => now()->toDateString(),
            'rest_days' => 0,
            'purpose' => 'Persyaratan Melamar Pekerjaan / Magang Industri',
            'condition_notes' => 'Kondisi fisik sehat, tekanan darah 110/75 mmHg, tidak ditemukan tanda buta warna dan sehat jasmani.',
        ]);

        // 10. Laboratorium Sampel
        $labs = [
            ['parameter_name' => 'Hemoglobin (Hb)', 'result_value' => '14.2', 'normal_range' => '13.0 - 17.5', 'unit' => 'g/dL', 'status_indicator' => 'Normal', 'conclusion' => 'Dalam batas normal.'],
            ['parameter_name' => 'Leukosit', 'result_value' => '9.800', 'normal_range' => '4.000 - 10.000', 'unit' => '/µL', 'status_indicator' => 'Normal', 'conclusion' => 'Dalam batas normal.'],
            ['parameter_name' => 'Gula Darah Sewaktu (GDS)', 'result_value' => '115', 'normal_range' => '< 140', 'unit' => 'mg/dL', 'status_indicator' => 'Normal', 'conclusion' => 'Kadar glukosa darah sewaktu normal.'],
            ['parameter_name' => 'Asam Urat', 'result_value' => '7.8', 'normal_range' => '3.4 - 7.0', 'unit' => 'mg/dL', 'status_indicator' => 'Tinggi', 'conclusion' => 'Kadar asam urat sedikit meningkat.'],
        ];
        foreach ($labs as $lb) {
            LabTest::updateOrCreate(['patient_id' => $p1->id, 'parameter_name' => $lb['parameter_name']], array_merge($lb, [
                'doctor_name' => 'dr. Ahmad Santoso',
            ]));
        }

        // 11. Asuhan Keperawatan Sampel
        NursingCare::updateOrCreate(['patient_id' => $p3->id], [
            'nurse_name' => 'Ns. Rina Wulandari, S.Kep',
            'assessment' => 'Pasien mengeluh diare cair 4x sebelum masuk RS, lemas, turgor kulit kembali dalam 2 detik, bibir agak kering, TD 100/70, Nadi 88.',
            'sdki_diagnosis' => 'D.0023 Hipovolemia berhubungan dengan kehilangan cairan aktif (diare)',
            'siki_intervention' => 'I.03116 Manajemen Hipovolemia: Pasang jalur IV infus RL 20 tpm, monitor intake dan output cairan per 8 jam, anjurkan minum oralit sedikit demi sedikit.',
            'slki_evaluation' => 'L.03028 Status Cairan Membaik: Turgor kulit elastis, frekuensi buang air besar berkurang, mata tidak cekung, tanda dehidrasi teratasi.',
        ]);

        // 12. Sedasi Sampel
        Sedation::updateOrCreate(['patient_id' => $p1->id], [
            'procedure_name' => 'Eksisi Ateroma / Bedah Minor',
            'sedation_type' => 'Anestesi Infiltrasi Lokal (Lidokain 2%)',
            'doctor_name' => 'dr. Ahmad Santoso',
            'premedication' => 'Eksplorasi riwayat alergi obat, tanda vital stabil sebelum tindakan.',
            'monitor_bp' => '120/80',
            'monitor_hr' => 80,
            'monitor_spo2' => 99,
            'aldrete_score' => 10,
            'evaluation' => 'Tindakan insisi dan penjahitan berjalan lancar tanpa komplikasi, perdarahan minimal terkontrol, pasien pulih penuh dan dapat langsung pulang.',
        ]);

        // 13. Pengaturan Integrasi
        SiteSetting::set('satusehat_org_id', '100024567');
        SiteSetting::set('satusehat_client_id', 'ss_client_tefa_polije_prod_2026');
        SiteSetting::set('satusehat_client_secret', 'sec_satusehat_polije_secret_key_998');
        SiteSetting::set('satusehat_env', 'Sandbox Kemenkes');
        SiteSetting::set('satusehat_status', 'Terhubung (Status 200 OK)');

        SiteSetting::set('bpjs_cons_id', '18294');
        SiteSetting::set('bpjs_secret_key', '8hK92LmPq1');
        SiteSetting::set('bpjs_user_key', 'user_key_pcare_polije_fktp');
        SiteSetting::set('bpjs_env', 'Bridging Live BPJS');
        SiteSetting::set('bpjs_status', 'Terhubung (PCare Ready)');
    }
}

