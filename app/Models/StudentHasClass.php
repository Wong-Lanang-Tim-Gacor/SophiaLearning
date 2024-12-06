<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model ini hanya dibuat untuk testing dan factory
 */
class StudentHasClass extends Model
{
    use HasFactory;

    // pivotFk
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // pivotFk
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
