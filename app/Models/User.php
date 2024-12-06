<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    // Relasi untuk kelas yang dibuat oleh guru (one-to-many)
    public function classroomsCreated()
    {
        return $this->hasMany(Classroom::class, 'user_id');
    }

    // Relasi untuk kelas yang diikuti oleh siswa (many-to-many)
    public function classroomsJoined()
    {
        return $this->belongsToMany(Classroom::class, 'student_has_classes', 'student_id', 'classroom_id');
    }
}