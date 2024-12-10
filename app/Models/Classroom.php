<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

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

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    // Mengecek apakah siswa sudah tergabung dalam kelas
    public function isStudentEnrolled(mixed $userId): bool
    {
        return $this->students()->where('student_id', $userId)->exists();
    }

    // Mengambil kelas yang diikuti oleh siswa
    public function scopeGetJoinedClasses($query, mixed $userId)
    {
        return $query
            ->orWhere('user_id', $userId)
            ->orWhereHas('students', function ($query) use ($userId) {
            $query->where('student_id', $userId);
        })->with('teacher:id,name');

    }


    // Mengambil kelas yang dibuat oleh guru
    public function scopeGetCreatedClasses($query, mixed $userId)
    {
        return $query->where('user_id', $userId)->withCount('students');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function (Classroom $classroom) {
            $randomColor = [
                'bg-rose-500',
                'bg-blue-500',
                'bg-purple-500',
                'bg-green-600',
                'bg-orange-500',
            ];
            $randomColor = $randomColor[array_rand($randomColor)];
            $classroom->bg_tw_class = $randomColor;
        });
    }
}
