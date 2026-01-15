<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $guarded = ['id']; // Agar bisa diisi massal

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
