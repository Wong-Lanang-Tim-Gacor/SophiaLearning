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
}
