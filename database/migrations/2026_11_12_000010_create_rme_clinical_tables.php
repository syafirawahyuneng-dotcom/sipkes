<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Data Pasien
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm', 20)->unique();
            $table->string('nik', 20)->nullable();
            $table->string('bpjs_number', 30)->nullable();
            $table->string('name');
            $table->enum('gender', ['L', 'P'])->default('L');
            $table->date('birth_date');
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('blood_type', 5)->nullable();
            $table->text('allergy_history')->nullable();
            $table->string('bpjs_status')->default('Aktif');
            $table->string('satusehat_ihs')->nullable();
            $table->timestamps();
        });

        // 2. Antrian & Panggilan Suara
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('queue_number', 10);
            $table->string('poli'); // Poli Umum, Poli Gigi, KIA, UGD, dll
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('cascade');
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai'])->default('menunggu');
            $table->timestamp('called_at')->nullable();
            $table->timestamps();
        });

        // 3 & 4. Pemeriksaan SOAP (SO + AP)
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('poli');
            $table->string('doctor_name')->default('dr. Ahmad Santoso');
            $table->date('visit_date');
            // Subjective (S)
            $table->text('complaint_main'); // Keluhan Utama
            $table->text('anamnesis')->nullable(); // Riwayat Penyakit Sekarang
            $table->text('disease_history')->nullable(); // Riwayat Penyakit Dahulu / Keluarga
            $table->text('allergy')->nullable(); // Riwayat Alergi
            // Objective (O)
            $table->string('blood_pressure', 20)->nullable(); // Tensi TD (mmHg)
            $table->decimal('temperature', 4, 1)->nullable(); // Suhu °C
            $table->integer('pulse')->nullable(); // Nadi x/menit
            $table->integer('respiration')->nullable(); // Napas x/menit
            $table->decimal('weight', 5, 2)->nullable(); // Berat Badan kg
            $table->decimal('height', 5, 2)->nullable(); // Tinggi Badan cm
            $table->text('physical_exam')->nullable(); // Status lokalis fisik
            // Assessment (A)
            $table->string('diagnosis_code', 20)->nullable(); // ICD-10 (e.g. J00, A09)
            $table->string('diagnosis_name')->nullable();
            $table->string('prognosis', 50)->default('Bonam');
            // Plan (P)
            $table->text('procedure_action')->nullable(); // Tindakan Medis ICD-9-CM
            $table->text('prescription_notes')->nullable(); // Catatan Resep
            $table->enum('status', ['diperiksa', 'selesai'])->default('selesai');
            $table->timestamps();
        });

        // 5. Farmasi (Master Obat)
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('name');
            $table->string('category', 50)->default('Tablet');
            $table->integer('stock')->default(0);
            $table->string('unit', 20)->default('Strip');
            $table->decimal('price', 12, 2)->default(0);
            $table->date('expired_date')->nullable();
            $table->integer('min_stock')->default(10);
            $table->timestamps();
        });

        // 6. Kasir / Billing
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 30)->unique();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('examination_id')->nullable()->constrained('examinations')->onDelete('set null');
            $table->decimal('admin_fee', 10, 2)->default(15000);
            $table->decimal('doctor_fee', 10, 2)->default(35000);
            $table->decimal('medicine_fee', 10, 2)->default(0);
            $table->decimal('action_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('change_amount', 12, 2)->default(0);
            $table->enum('payment_status', ['belum_bayar', 'lunas'])->default('belum_bayar');
            $table->string('payment_method', 30)->default('Tunai');
            $table->timestamps();
        });

        // 7. Rawat Inap & Manajemen Bed
        Schema::create('inpatient_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_name'); // Melati, Mawar, ICU
            $table->string('bed_number', 10);
            $table->string('class_type', 30)->default('Kelas 1');
            $table->decimal('price_per_day', 10, 2)->default(150000);
            $table->enum('status', ['tersedia', 'terisi', 'maintenance'])->default('tersedia');
            $table->timestamps();
        });

        Schema::create('inpatient_admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('inpatient_rooms')->onDelete('cascade');
            $table->dateTime('check_in');
            $table->dateTime('check_out')->nullable();
            $table->string('initial_diagnosis');
            $table->text('cppt_notes')->nullable(); // Catatan Perkembangan Pasien Terintegrasi
            $table->enum('status', ['dirawat', 'pulang', 'dirujuk'])->default('dirawat');
            $table->timestamps();
        });

        // 12. Asuhan Keperawatan (Askep SDKI, SIKI, SLKI)
        Schema::create('nursing_cares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('nurse_name');
            $table->text('assessment');
            $table->string('sdki_diagnosis'); // e.g. D.0001 Bersihan Jalan Nafas Tidak Efektif
            $table->text('siki_intervention'); // e.g. I.01011 Manajemen Jalan Napas
            $table->text('slki_evaluation'); // e.g. L.01001 Bersihan Jalan Napas Meningkat
            $table->timestamps();
        });

        // 14. Odontogram Klinik Gigi
        Schema::create('odontograms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('tooth_number', 5); // 11-18, 21-28, 31-38, 41-48
            $table->string('condition'); // Karies, Tambalan Amalgam, Tambalan Komposit, Gigi Hilang, Protesa, Normal
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 15 & 16. General Consent & Informed Consent
        Schema::create('consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->enum('consent_type', ['general', 'informed'])->default('general');
            $table->string('signer_name');
            $table->string('signer_relation', 50)->default('Diri Sendiri');
            $table->string('procedure_name')->nullable(); // Untuk Informed Consent
            $table->text('signature_data')->nullable(); // Base64 data URL tanda tangan
            $table->boolean('agreed')->default(true);
            $table->timestamps();
        });

        // 17. Surat Keterangan Sakit & Surat Sehat
        Schema::create('medical_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number', 40)->unique();
            $table->enum('type', ['sakit', 'sehat'])->default('sakit');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('doctor_name')->default('dr. Ahmad Santoso');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('rest_days')->default(1);
            $table->string('purpose')->nullable(); // e.g. Melamar Pekerjaan / Masuk Perguruan Tinggi
            $table->text('condition_notes')->nullable(); // Catatan fisik
            $table->timestamps();
        });

        // 18. Laboratorium Medis
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('doctor_name')->default('dr. Ahmad Santoso');
            $table->string('parameter_name'); // e.g. Hemoglobin, Gula Darah Sewaktu, Asam Urat, Kolesterol
            $table->string('result_value');
            $table->string('normal_range');
            $table->string('unit', 20);
            $table->enum('status_indicator', ['Normal', 'Tinggi', 'Rendah'])->default('Normal');
            $table->text('conclusion')->nullable();
            $table->timestamps();
        });

        // 19. Sedasi & Bedah Minor
        Schema::create('sedations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('procedure_name'); // e.g. Eksisi Lipoma, Sirkumsisi, Debridement
            $table->string('sedation_type')->default('Lokal / Ringan');
            $table->string('doctor_name')->default('dr. Ahmad Santoso');
            $table->text('premedication')->nullable();
            $table->string('monitor_bp', 20)->nullable();
            $table->integer('monitor_hr')->nullable();
            $table->integer('monitor_spo2')->nullable();
            $table->integer('aldrete_score')->default(10); // Skor pemulihan 0-10
            $table->text('evaluation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sedations');
        Schema::dropIfExists('lab_tests');
        Schema::dropIfExists('medical_certificates');
        Schema::dropIfExists('consents');
        Schema::dropIfExists('odontograms');
        Schema::dropIfExists('nursing_cares');
        Schema::dropIfExists('inpatient_admissions');
        Schema::dropIfExists('inpatient_rooms');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('medicines');
        Schema::dropIfExists('examinations');
        Schema::dropIfExists('queues');
        Schema::dropIfExists('patients');
    }
};

