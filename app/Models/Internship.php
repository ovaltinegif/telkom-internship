<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $guarded = ['id'];

    public function evaluation()
    {
        return $this->hasOne(Evaluation::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}
