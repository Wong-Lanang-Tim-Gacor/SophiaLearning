<?php

namespace App\Models;

use App\Enums\ResourceTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resource extends Model
{
    /** @use HasFactory<\Database\Factories\ResourceFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function answer(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function attachment(): HasMany
    {
        return $this->hasMany(ResourceAttachment::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    // Scope: Filter resource bertipe assignment
    public function scopeOfAssignmentType($query)
    {
        return $query->where('type', ResourceTypeEnum::ASSIGNMENT->value); 
    }

    // Scope: Filter resource bertipe material
    public function scopeOfMaterialType($query)
    {
        return $query->where('type', ResourceTypeEnum::MATERIAL->value); 
    }

    // Scope: Filter resource bertipe announcement
    public function scopeOfAnnouncementType($query)
    {
        return $query->where('type', ResourceTypeEnum::ANNOUNCEMENT->value); 
    }

    // Scope: Resource dari kelas yang diikuti atau dibuat user
    public function scopeFromUserClasses($query, $userId)
    {
        return $query->whereHas('classroom', function ($classroomQuery) use ($userId) {
            $classroomQuery->where('user_id', $userId) // Kelas dibuat oleh user
                ->orWhereHas('students', function ($studentQuery) use ($userId) {
                    $studentQuery->where('student_id', $userId); // Kelas diikuti oleh user
                });
        });
    }
}
