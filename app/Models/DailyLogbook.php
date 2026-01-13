<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyLogbook extends Model
{
   // Izinkan semua kolom diisi (kecuali id dan timestamps)
    protected $guarded = ['id'];

    // Relasi ke Internship
    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
