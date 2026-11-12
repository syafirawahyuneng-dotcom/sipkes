<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function odontograms()
    {
        return $this->hasMany(Odontogram::class);
    }

    public function consents()
    {
        return $this->hasMany(Consent::class);
    }

    public function medicalCertificates()
    {
        return $this->hasMany(MedicalCertificate::class);
    }

    public function labTests()
    {
        return $this->hasMany(LabTest::class);
    }

    public function sedations()
    {
        return $this->hasMany(Sedation::class);
    }

    public function nursingCares()
    {
        return $this->hasMany(NursingCare::class);
    }

    public function inpatientAdmissions()
    {
        return $this->hasMany(InpatientAdmission::class);
    }

    public function getAgeAttribute(): int
    {
        return $this->birth_date ? $this->birth_date->age : 0;
    }
}

