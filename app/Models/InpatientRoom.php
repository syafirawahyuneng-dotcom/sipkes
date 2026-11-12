<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InpatientRoom extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function admissions()
    {
        return $this->hasMany(InpatientAdmission::class, 'room_id');
    }

    public function activeAdmission()
    {
        return $this->hasOne(InpatientAdmission::class, 'room_id')->where('status', 'dirawat')->latest();
    }
}

