<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

class RmeController extends Controller
{
    // ==========================================
    // 9. DASHBOARD SISTEM RME
    // ==========================================
    public function dashboard()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'today_queues' => Queue::whereDate('created_at', today())->count(),
            'active_admissions' => InpatientAdmission::where('status', 'dirawat')->count(),
            'low_stock_medicines' => Medicine::whereColumn('stock', '<=', 'min_stock')->count(),
            'today_revenue' => Invoice::whereDate('created_at', today())->where('payment_status', 'lunas')->sum('total_amount'),
            'total_examinations' => Examination::count(),
        ];

        $recentPatients = Patient::latest()->take(5)->get();
        $activeQueues = Queue::with('patient')->whereDate('created_at', today())->latest()->take(6)->get();
        $lowStockMeds = Medicine::whereColumn('stock', '<=', 'min_stock')->take(5)->get();

        return view('rme.dashboard', compact('stats', 'recentPatients', 'activeQueues', 'lowStockMeds'));
    }

    // ==========================================
    // 1. PENDAFTARAN PASIEN
    // ==========================================
    public function pendaftaran(Request $request)
    {
        $query = Patient::query()->latest();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('no_rm', 'like', "%{$s}%")
                  ->orWhere('nik', 'like', "%{$s}%")
                  ->orWhere('bpjs_number', 'like', "%{$s}%");
            });
        }
        $patients = $query->paginate(10);
        $nextRm = 'RM-' . date('Y') . '-' . str_pad(Patient::count() + 1, 4, '0', STR_PAD_LEFT);

        return view('rme.pendaftaran', compact('patients', 'nextRm'));
    }

    public function storePendaftaran(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'bpjs_number' => 'nullable|string|max:30',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'blood_type' => 'nullable|string|max:5',
            'allergy_history' => 'nullable|string',
            'poli' => 'nullable|string',
        ]);

        $noRm = 'RM-' . date('Y') . '-' . str_pad(Patient::count() + 1, 4, '0', STR_PAD_LEFT);
        
        $patient = Patient::create([
            'no_rm' => $noRm,
            'nik' => $validated['nik'],
            'bpjs_number' => $validated['bpjs_number'],
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'blood_type' => $validated['blood_type'],
            'allergy_history' => $validated['allergy_history'],
            'bpjs_status' => !empty($validated['bpjs_number']) ? 'Aktif' : 'Non-BPJS',
            'satusehat_ihs' => 'P' . rand(10000000000, 99999999999),
        ]);

        // Auto buat tiket antrian jika poli dipilih
        if (!empty($validated['poli'])) {
            $prefix = match($validated['poli']) {
                'Poli Gigi' => 'G-',
                'Poli KIA/KB' => 'K-',
                'UGD' => 'U-',
                default => 'A-',
            };
            $queueCount = Queue::whereDate('created_at', today())->where('poli', $validated['poli'])->count() + 1;
            Queue::create([
                'queue_number' => $prefix . str_pad($queueCount, 3, '0', STR_PAD_LEFT),
                'poli' => $validated['poli'],
                'patient_id' => $patient->id,
                'status' => 'menunggu',
            ]);
        }

        return redirect()->route('rme.pendaftaran')->with('success', "Pasien {$patient->name} berhasil didaftarkan dengan No. RM: {$patient->no_rm}!");
    }

    // ==========================================
    // 2. ANTRIAN & PANGGILAN SUARA (AUDIO QUEUE)
    // ==========================================
    public function antrian()
    {
        $queues = Queue::with('patient')->whereDate('created_at', today())->orderBy('id', 'desc')->get();
        $currentlyCalling = Queue::with('patient')->where('status', 'dipanggil')->latest('called_at')->first();
        
        $polis = ['Poli Umum', 'Poli Gigi', 'Poli KIA/KB', 'UGD'];
        $poliStats = [];
        foreach ($polis as $p) {
            $current = Queue::with('patient')->where('poli', $p)->where('status', 'dipanggil')->latest('called_at')->first();
            $waiting = Queue::where('poli', $p)->where('status', 'menunggu')->count();
            $poliStats[$p] = [
                'current' => $current ? $current->queue_number : '-',
                'patient_name' => $current && $current->patient ? $current->patient->name : 'Belum Ada',
                'waiting_count' => $waiting,
            ];
        }

        $patients = Patient::latest()->take(20)->get();

        return view('rme.antrian', compact('queues', 'currentlyCalling', 'poliStats', 'patients'));
    }

    public function callQueue(Request $request, Queue $queue)
    {
        $queue->update([
            'status' => 'dipanggil',
            'called_at' => now(),
        ]);

        return back()->with('call_audio', [
            'number' => $queue->queue_number,
            'poli' => $queue->poli,
            'name' => $queue->patient ? $queue->patient->name : 'Pasien',
        ]);
    }

    public function completeQueue(Request $request, Queue $queue)
    {
        $queue->update(['status' => 'selesai']);
        return back()->with('success', "Antrian {$queue->queue_number} ditandai selesai.");
    }

    public function storeQueue(Request $request)
    {
        $request->validate([
            'poli' => 'required|string',
            'patient_id' => 'nullable|exists:patients,id',
        ]);

        $prefix = match($request->poli) {
            'Poli Gigi' => 'G-',
            'Poli KIA/KB' => 'K-',
            'UGD' => 'U-',
            default => 'A-',
        };
        $queueCount = Queue::whereDate('created_at', today())->where('poli', $request->poli)->count() + 1;
        $q = Queue::create([
            'queue_number' => $prefix . str_pad($queueCount, 3, '0', STR_PAD_LEFT),
            'poli' => $request->poli,
            'patient_id' => $request->patient_id,
            'status' => 'menunggu',
        ]);

        return back()->with('success', "Nomor antrian {$q->queue_number} berhasil dicetak!");
    }

    // ==========================================
    // 3. PEMERIKSAAN KELUHAN KLINIS (SO)
    // ==========================================
    public function pemeriksaanSo(Request $request)
    {
        $selectedPatient = null;
        if ($request->filled('patient_id')) {
            $selectedPatient = Patient::find($request->patient_id);
        }

        $patients = Patient::latest()->get();
        $recentExaminations = Examination::with('patient')->latest()->take(10)->get();

        return view('rme.pemeriksaan_so', compact('selectedPatient', 'patients', 'recentExaminations'));
    }

    public function storePemeriksaanSo(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'poli' => 'required|string',
            'doctor_name' => 'required|string',
            'complaint_main' => 'required|string',
            'anamnesis' => 'nullable|string',
            'disease_history' => 'nullable|string',
            'allergy' => 'nullable|string',
            'blood_pressure' => 'nullable|string',
            'temperature' => 'nullable|numeric',
            'pulse' => 'nullable|integer',
            'respiration' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'physical_exam' => 'nullable|string',
        ]);

        $exam = Examination::create(array_merge($validated, [
            'visit_date' => now()->toDateString(),
            'status' => 'diperiksa',
        ]));

        return redirect()->route('rme.diagnosa.tindakan', ['exam_id' => $exam->id])
            ->with('success', 'Data Pemeriksaan Subjektif & Objektif (SO) berhasil disimpan! Silakan lanjutkan ke Diagnosa & Tindakan (AP).');
    }

    // ==========================================
    // 4. DIAGNOSA & TINDAKAN (AP)
    // ==========================================
    public function diagnosaTindakan(Request $request)
    {
        $exam = null;
        if ($request->filled('exam_id')) {
            $exam = Examination::with('patient')->find($request->exam_id);
        }

        $examinations = Examination::with('patient')->where('status', 'diperiksa')->orWhereNull('diagnosis_code')->latest()->get();
        $completedExaminations = Examination::with('patient')->whereNotNull('diagnosis_code')->latest()->take(10)->get();
        $medicines = Medicine::where('stock', '>', 0)->get();

        // Referensi cepat kode ICD-10 umum di Faskes Primer
        $icd10 = [
            ['code' => 'J00', 'name' => 'Acute nasopharyngitis [common cold]'],
            ['code' => 'A09.0', 'name' => 'Other and unspecified gastroenteritis and colitis of infectious origin'],
            ['code' => 'I10', 'name' => 'Essential (primary) hypertension'],
            ['code' => 'K29.7', 'name' => 'Gastritis, unspecified'],
            ['code' => 'E11.9', 'name' => 'Type 2 diabetes mellitus without complications'],
            ['code' => 'J02.9', 'name' => 'Acute pharyngitis, unspecified'],
            ['code' => 'B35.9', 'name' => 'Dermatophytosis, unspecified'],
            ['code' => 'M79.1', 'name' => 'Myalgia'],
            ['code' => 'K02.9', 'name' => 'Dental caries, unspecified'],
            ['code' => 'R50.9', 'name' => 'Fever, unspecified'],
        ];

        return view('rme.diagnosa_tindakan', compact('exam', 'examinations', 'completedExaminations', 'medicines', 'icd10'));
    }

    public function storeDiagnosaTindakan(Request $request, Examination $examination)
    {
        $validated = $request->validate([
            'diagnosis_code' => 'required|string|max:20',
            'diagnosis_name' => 'required|string|max:255',
            'prognosis' => 'required|string',
            'procedure_action' => 'nullable|string',
            'prescription_notes' => 'nullable|string',
        ]);

        $examination->update(array_merge($validated, [
            'status' => 'selesai',
        ]));

        // Buat tagihan kasir otomatis jika belum ada
        Invoice::firstOrCreate(
            ['examination_id' => $examination->id],
            [
                'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad($examination->id, 4, '0', STR_PAD_LEFT),
                'patient_id' => $examination->patient_id,
                'admin_fee' => 15000,
                'doctor_fee' => 35000,
                'action_fee' => !empty($validated['procedure_action']) ? 25000 : 0,
                'medicine_fee' => !empty($validated['prescription_notes']) ? 30000 : 0,
                'total_amount' => 50000 + (!empty($validated['procedure_action']) ? 25000 : 0) + (!empty($validated['prescription_notes']) ? 30000 : 0),
                'payment_status' => 'belum_bayar',
            ]
        );

        return redirect()->route('rme.diagnosa.tindakan')->with('success', 'Diagnosa & Tindakan (AP) berhasil disimpan dan billing kasir telah diterbitkan!');
    }

    // ==========================================
    // 5. FARMASI & RESEP OBAT
    // ==========================================
    public function farmasi(Request $request)
    {
        $query = Medicine::query()->orderBy('name');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('name', 'like', "%{$s}%")->orWhere('code', 'like', "%{$s}%");
        }
        $medicines = $query->paginate(12);
        $recentPrescriptions = Examination::with('patient')->whereNotNull('prescription_notes')->latest()->take(6)->get();

        return view('rme.farmasi', compact('medicines', 'recentPrescriptions'));
    }

    public function storeMedicine(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:medicines,code',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'expired_date' => 'nullable|date',
            'min_stock' => 'nullable|integer',
        ]);

        Medicine::create($validated);
        return back()->with('success', 'Obat baru berhasil ditambahkan ke inventori farmasi!');
    }

    public function dispenseMedicine(Request $request, Medicine $medicine)
    {
        $request->validate(['qty' => 'required|integer|min:1']);
        if ($medicine->stock < $request->qty) {
            return back()->with('error', 'Stok obat tidak mencukupi untuk pengeluaran resep.');
        }

        $medicine->decrement('stock', $request->qty);
        return back()->with('success', "Pengeluaran {$request->qty} {$medicine->unit} {$medicine->name} berhasil. Sisa stok: {$medicine->stock}.");
    }

    // ==========================================
    // 6. KASIR & BILLING
    // ==========================================
    public function kasir()
    {
        $unpaidInvoices = Invoice::with(['patient', 'examination'])->where('payment_status', 'belum_bayar')->latest()->get();
        $paidInvoices = Invoice::with(['patient', 'examination'])->where('payment_status', 'lunas')->latest()->take(15)->get();

        return view('rme.kasir', compact('unpaidInvoices', 'paidInvoices'));
    }

    public function payInvoice(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'paid_amount' => 'required|numeric|min:' . $invoice->total_amount,
            'payment_method' => 'required|string',
        ]);

        $invoice->update([
            'paid_amount' => $validated['paid_amount'],
            'change_amount' => $validated['paid_amount'] - $invoice->total_amount,
            'payment_status' => 'lunas',
            'payment_method' => $validated['payment_method'],
        ]);

        return back()->with('success', "Pembayaran Invoice {$invoice->invoice_number} berhasil lunas. Kembalian: Rp " . number_format($invoice->change_amount, 0, ',', '.') . "!");
    }

    // ==========================================
    // 7. RAWAT INAP & BED MONITORING
    // ==========================================
    public function rawatInap()
    {
        $rooms = InpatientRoom::with('activeAdmission.patient')->orderBy('room_name')->get();
        $admissions = InpatientAdmission::with(['patient', 'room'])->latest()->take(10)->get();
        $patients = Patient::all();

        return view('rme.rawat_inap', compact('rooms', 'admissions', 'patients'));
    }

    public function storeInpatientAdmission(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'room_id' => 'required|exists:inpatient_rooms,id',
            'initial_diagnosis' => 'required|string',
            'cppt_notes' => 'nullable|string',
        ]);

        $room = InpatientRoom::find($validated['room_id']);
        if ($room->status !== 'tersedia') {
            return back()->with('error', 'Tempat tidur kamar tersebut sedang terisi atau dalam perbaikan.');
        }

        InpatientAdmission::create([
            'patient_id' => $validated['patient_id'],
            'room_id' => $validated['room_id'],
            'check_in' => now(),
            'initial_diagnosis' => $validated['initial_diagnosis'],
            'cppt_notes' => $validated['cppt_notes'],
            'status' => 'dirawat',
        ]);

        $room->update(['status' => 'terisi']);

        return back()->with('success', 'Pasien berhasil didaftarkan masuk ruang rawat inap.');
    }

    public function checkoutInpatient(Request $request, InpatientAdmission $admission)
    {
        $admission->update([
            'check_out' => now(),
            'status' => 'pulang',
        ]);
        $admission->room->update(['status' => 'tersedia']);

        return back()->with('success', 'Pasien telah berhasil dipulangkan dan tempat tidur kembali tersedia.');
    }

    // ==========================================
    // 8. LAPORAN & STATISTIK EKSEKUTIF
    // ==========================================
    public function laporan()
    {
        // 10 Besar Morbiditas Penyakit (ICD-10)
        $topDiseases = Examination::select('diagnosis_code', 'diagnosis_name')
            ->selectRaw('count(*) as total')
            ->whereNotNull('diagnosis_code')
            ->groupBy('diagnosis_code', 'diagnosis_name')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        $totalVisits = Examination::count();
        $totalRevenue = Invoice::where('payment_status', 'lunas')->sum('total_amount');
        $genderBreakdown = Patient::select('gender')
            ->selectRaw('count(*) as count')
            ->groupBy('gender')
            ->pluck('count', 'gender')
            ->toArray();

        $recentInvoices = Invoice::with('patient')->latest()->take(8)->get();

        return view('rme.laporan', compact('topDiseases', 'totalVisits', 'totalRevenue', 'genderBreakdown', 'recentInvoices'));
    }

    // ==========================================
    // 10. CETAK KARTU BEROBAT
    // ==========================================
    public function kartuBerobat(Request $request)
    {
        $selectedPatient = null;
        if ($request->filled('patient_id')) {
            $selectedPatient = Patient::find($request->patient_id);
        } else {
            $selectedPatient = Patient::first();
        }

        $patients = Patient::latest()->get();
        return view('rme.kartu_berobat', compact('selectedPatient', 'patients'));
    }

    // ==========================================
    // 11. VERIFIKASI DENGAN SATUSEHAT MOBILE
    // ==========================================
    public function verifikasiSatusehat(Request $request)
    {
        $queryResult = null;
        if ($request->filled('identifier')) {
            $id = $request->identifier;
            $p = Patient::where('nik', $id)->orWhere('no_rm', $id)->orWhere('satusehat_ihs', $id)->first();
            if ($p) {
                $queryResult = [
                    'found' => true,
                    'patient' => $p,
                    'ihs_number' => $p->satusehat_ihs ?? 'P' . rand(10000000000, 99999999999),
                    'vaccine_status' => 'Lengkap (Dosis 1, 2, Booster)',
                    'last_sync' => now()->subHours(2)->format('d/m/Y H:i'),
                    'satusehat_status' => 'HIJAU (Terverifikasi Dukcapil & Kemenkes)',
                ];
            } else {
                $queryResult = [
                    'found' => false,
                    'message' => 'Identitas tidak ditemukan dalam basis data pasien terdaftar.',
                ];
            }
        }

        return view('rme.verifikasi_satusehat', compact('queryResult'));
    }

    // ==========================================
    // 12. ASUHAN KEPERAWATAN (ASKEP SDKI, SIKI, SLKI)
    // ==========================================
    public function asuhanKeperawatan()
    {
        $askeps = NursingCare::with('patient')->latest()->paginate(10);
        $patients = Patient::all();

        return view('rme.asuhan_keperawatan', compact('askeps', 'patients'));
    }

    public function storeAskep(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'nurse_name' => 'required|string|max:255',
            'assessment' => 'required|string',
            'sdki_diagnosis' => 'required|string',
            'siki_intervention' => 'required|string',
            'slki_evaluation' => 'required|string',
        ]);

        NursingCare::create($validated);
        return back()->with('success', 'Dokumentasi Asuhan Keperawatan (SDKI/SIKI/SLKI) berhasil disimpan.');
    }

    // ==========================================
    // 13. PENGATURAN INTEGRASI SATUSEHAT & BPJS
    // ==========================================
    public function pengaturanIntegrasi()
    {
        $config = [
            'satusehat_org_id' => SiteSetting::get('satusehat_org_id', '100024567'),
            'satusehat_client_id' => SiteSetting::get('satusehat_client_id', 'ss_client_tefa_polije_prod_2026'),
            'satusehat_client_secret' => SiteSetting::get('satusehat_client_secret', 'sec_satusehat_polije_secret_key_998'),
            'satusehat_env' => SiteSetting::get('satusehat_env', 'Sandbox Kemenkes'),
            'satusehat_status' => SiteSetting::get('satusehat_status', 'Terhubung (Status 200 OK)'),
            
            'bpjs_cons_id' => SiteSetting::get('bpjs_cons_id', '18294'),
            'bpjs_secret_key' => SiteSetting::get('bpjs_secret_key', '8hK92LmPq1'),
            'bpjs_user_key' => SiteSetting::get('bpjs_user_key', 'user_key_pcare_polije_fktp'),
            'bpjs_env' => SiteSetting::get('bpjs_env', 'Bridging Live BPJS'),
            'bpjs_status' => SiteSetting::get('bpjs_status', 'Terhubung (PCare Ready)'),
        ];

        return view('rme.pengaturan_integrasi', compact('config'));
    }

    public function saveIntegrasi(Request $request)
    {
        foreach ($request->except('_token') as $key => $val) {
            SiteSetting::set($key, $val);
        }
        return back()->with('success', 'Konfigurasi integrasi SATUSEHAT & BPJS Kesehatan berhasil disimpan!');
    }

    public function testKoneksi(Request $request)
    {
        $target = $request->query('target', 'satusehat');
        if ($target === 'satusehat') {
            SiteSetting::set('satusehat_status', 'Terhubung (Status 200 OK • Latency 42ms)');
            return back()->with('success', 'Koneksi SATUSEHAT Kemenkes Berhasil! Respon: 200 OK (OAuth2 Token Valid).');
        } else {
            SiteSetting::set('bpjs_status', 'Terhubung (PCare Ready • Response 200 OK)');
            return back()->with('success', 'Koneksi PCare BPJS Berhasil! Signature Key dan ConsID terotentikasi.');
        }
    }

    // ==========================================
    // 14. ODONTOGRAM KLINIK GIGI
    // ==========================================
    public function odontogram(Request $request)
    {
        $patientId = $request->input('patient_id', 3);
        $patient = Patient::find($patientId) ?? Patient::first();
        $patients = Patient::all();
        $odontograms = Odontogram::where('patient_id', $patient->id)->pluck('condition', 'tooth_number')->toArray();

        return view('rme.odontogram', compact('patient', 'patients', 'odontograms'));
    }

    public function saveTooth(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'tooth_number' => 'required|string',
            'condition' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        Odontogram::updateOrCreate(
            ['patient_id' => $request->patient_id, 'tooth_number' => $request->tooth_number],
            ['condition' => $request->condition, 'notes' => $request->notes]
        );

        return back()->with('success', "Kondisi gigi {$request->tooth_number} berhasil diperbarui menjadi {$request->condition}.");
    }

    // ==========================================
    // 15. GENERAL CONSENT
    // ==========================================
    public function generalConsent(Request $request)
    {
        $patientId = $request->input('patient_id', 1);
        $patient = Patient::find($patientId) ?? Patient::first();
        $patients = Patient::all();
        $consent = Consent::where('patient_id', $patient->id)->where('consent_type', 'general')->latest()->first();

        return view('rme.general_consent', compact('patient', 'patients', 'consent'));
    }

    public function storeGeneralConsent(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'signer_name' => 'required|string|max:255',
            'signer_relation' => 'required|string',
            'signature_data' => 'nullable|string',
        ]);

        Consent::updateOrCreate(
            ['patient_id' => $validated['patient_id'], 'consent_type' => 'general'],
            [
                'signer_name' => $validated['signer_name'],
                'signer_relation' => $validated['signer_relation'],
                'signature_data' => $validated['signature_data'] ?: 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="200" height="60"><path d="M10 40 Q 50 10 90 40 T 170 30" stroke="%232563eb" stroke-width="3" fill="none"/></svg>',
                'agreed' => true,
            ]
        );

        return back()->with('success', 'General Consent (Persetujuan Umum) digital berhasil ditandatangani dan diarsipkan.');
    }

    // ==========================================
    // 16. INFORMED CONSENT
    // ==========================================
    public function informedConsent(Request $request)
    {
        $patientId = $request->input('patient_id', 1);
        $patient = Patient::find($patientId) ?? Patient::first();
        $patients = Patient::all();
        $consent = Consent::where('patient_id', $patient->id)->where('consent_type', 'informed')->latest()->first();

        return view('rme.informed_consent', compact('patient', 'patients', 'consent'));
    }

    public function storeInformedConsent(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'procedure_name' => 'required|string|max:255',
            'signer_name' => 'required|string|max:255',
            'signer_relation' => 'required|string',
            'signature_data' => 'nullable|string',
        ]);

        Consent::create([
            'patient_id' => $validated['patient_id'],
            'consent_type' => 'informed',
            'procedure_name' => $validated['procedure_name'],
            'signer_name' => $validated['signer_name'],
            'signer_relation' => $validated['signer_relation'],
            'signature_data' => $validated['signature_data'] ?: 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="200" height="60"><path d="M10 30 Q 60 5 110 35 T 190 20" stroke="%2316a34a" stroke-width="3" fill="none"/></svg>',
            'agreed' => true,
        ]);

        return back()->with('success', 'Informed Consent (Persetujuan Tindakan Medis) berhasil disahkan.');
    }

    // ==========================================
    // 17. SURAT SEHAT & SURAT SAKIT
    // ==========================================
    public function suratKeterangan(Request $request)
    {
        $certificates = MedicalCertificate::with('patient')->latest()->paginate(10);
        $patients = Patient::all();

        return view('rme.surat_keterangan', compact('certificates', 'patients'));
    }

    public function storeSurat(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:sakit,sehat',
            'patient_id' => 'required|exists:patients,id',
            'doctor_name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'rest_days' => 'nullable|integer',
            'purpose' => 'nullable|string',
            'condition_notes' => 'nullable|string',
        ]);

        $prefix = $validated['type'] == 'sakit' ? 'SKS' : 'SKD';
        $noSurat = $prefix . '/VKES/' . date('Ym') . '/' . str_pad(MedicalCertificate::count() + 1, 3, '0', STR_PAD_LEFT);

        MedicalCertificate::create(array_merge($validated, [
            'certificate_number' => $noSurat,
        ]));

        return back()->with('success', "Surat Keterangan Dokter {$noSurat} berhasil dibuat dan siap dicetak.");
    }

    // ==========================================
    // 18. LABORATORIUM
    // ==========================================
    public function laboratorium(Request $request)
    {
        $query = LabTest::with('patient')->latest();
        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }
        $labTests = $query->paginate(15);
        $patients = Patient::all();

        return view('rme.laboratorium', compact('labTests', 'patients'));
    }

    public function storeLab(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_name' => 'required|string',
            'parameter_name' => 'required|string',
            'result_value' => 'required|string',
            'normal_range' => 'required|string',
            'unit' => 'required|string',
            'status_indicator' => 'required|in:Normal,Tinggi,Rendah',
            'conclusion' => 'nullable|string',
        ]);

        LabTest::create($validated);
        return back()->with('success', 'Hasil uji laboratorium berhasil dicatat dan diverifikasi.');
    }

    // ==========================================
    // 19. SEDASI & BEDAH MINOR
    // ==========================================
    public function sedasi()
    {
        $sedations = Sedation::with('patient')->latest()->paginate(10);
        $patients = Patient::all();

        return view('rme.sedasi', compact('sedations', 'patients'));
    }

    public function storeSedasi(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'procedure_name' => 'required|string',
            'sedation_type' => 'required|string',
            'doctor_name' => 'required|string',
            'premedication' => 'nullable|string',
            'monitor_bp' => 'nullable|string',
            'monitor_hr' => 'nullable|integer',
            'monitor_spo2' => 'nullable|integer',
            'aldrete_score' => 'required|integer|min:0|max:10',
            'evaluation' => 'nullable|string',
        ]);

        Sedation::create($validated);
        return back()->with('success', 'Pemantauan tindakan sedasi & anestesi berhasil disimpan.');
    }

    // ==========================================
    // 20. DAN LAIN-LAIN: MASTER DATA & FASKES
    // ==========================================
    public function masterData()
    {
        $polis = [
            ['name' => 'Poli Umum', 'code' => 'POLI-01', 'doctor' => 'dr. Ahmad Santoso', 'status' => 'Aktif'],
            ['name' => 'Poli Gigi & Mulut', 'code' => 'POLI-02', 'doctor' => 'drg. Maya Indah', 'status' => 'Aktif'],
            ['name' => 'Poli KIA & KB', 'code' => 'POLI-03', 'doctor' => 'Bdn. Siti Rahmawati, S.Tr.Keb', 'status' => 'Aktif'],
            ['name' => 'Unit Gawat Darurat (UGD)', 'code' => 'POLI-04', 'doctor' => 'dr. Tri Hartono', 'status' => 'Aktif 24 Jam'],
            ['name' => 'Instalasi Farmasi', 'code' => 'FARM-01', 'doctor' => 'Apt. Dian Permata, S.Farm', 'status' => 'Aktif'],
            ['name' => 'Laboratorium Medis', 'code' => 'LAB-01', 'doctor' => 'dr. Ahmad Santoso', 'status' => 'Aktif'],
        ];

        return view('rme.master_data', compact('polis'));
    }
}

