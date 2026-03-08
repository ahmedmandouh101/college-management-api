<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['enrollment_id', 'grade', 'letter_grade'];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
