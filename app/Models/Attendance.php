<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = ['id']; // Izinkan isi semua kolom

    // Relasi ke Internship (Anak Magang)
    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
