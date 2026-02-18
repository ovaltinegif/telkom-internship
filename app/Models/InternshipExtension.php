<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipExtension extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = ['new_start_date', 'new_end_date'];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
