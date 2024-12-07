<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    /** @use HasFactory<\Database\Factories\ClassroomFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    // Relasi untuk siswa yang tergabung dalam kelas (many-to-many)
    public function students()
    {
        return $this->belongsToMany(User::class, 'student_has_classes', 'classroom_id', 'student_id')->withPivot('joined_at');
    }

    // Relasi untuk guru yang membuat kelas ini (one-to-many)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi untuk kelas yang memiliki topik (one-to-many)
    public function topics()
    {
        return $this->hasMany(Topic::class, 'classroom_id');
    }

    // Mengecek apakah siswa sudah tergabung dalam kelas
    public function isStudentEnrolled(mixed $userId) :bool
    {
        return $this->students()->where('student_id', $userId)->exists();
    }

     // Mengambil kelas yang diikuti oleh siswa
     public function scopeGetJoinedClasses($query, mixed $userId)
     {
         return $query->whereHas('students', function ($query) use ($userId) {
             $query->where('student_id', $userId);
         })->with('teacher:id,name');
     }
 
     // Mengambil kelas yang dibuat oleh guru
     public function scopeGetCreatedClasses($query, mixed $userId)
     {
         return $query->where('user_id', $userId)->withCount('students');
     }
}
