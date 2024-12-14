<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Classroom extends Model
{
    /** @use HasFactory<\Database\Factories\ClassroomFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    // order dari id terbaru
    protected static function booted()
    {
        static::addGlobalScope('orderByIdDesc', function (Builder $builder) {
            $builder->orderBy('id', 'DESC');
        });
    }

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

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    // Mengecek apakah siswa sudah tergabung dalam kelas
    public function isStudentEnrolled(mixed $userId): bool
    {
        return $this->students()->where('student_id', $userId)->exists() or $this->user_id === $userId;
    }

    // Mengambil kelas yang diikuti atau dibuat
    public function scopeGetJoinedClasses($query, mixed $userId, bool $isArchived = false)
    {
        $result = $query
            ->with('teacher:id,name')
            ->where(function ($subQuery) use ($userId) {
                $subQuery->where('user_id', $userId)
                    ->orWhereHas('students', function ($studentQuery) use ($userId) {
                        $studentQuery->where('student_id', $userId);
                    });
            })
            ->selectRaw('classrooms.*, CASE WHEN user_id = ? THEN true ELSE false END as is_teacher', [$userId]);
            
        $query->where('is_archived', $isArchived);

        return $result;
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
