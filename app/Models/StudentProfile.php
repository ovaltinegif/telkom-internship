<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    /**
     * Matikan proteksi mass assignment.
     * Artinya: Semua kolom boleh diisi kecuali 'id'.
     */
    protected $guarded = ['id'];

    /**
     * Relasi ke User (Kebalikan dari yang di User.php)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
