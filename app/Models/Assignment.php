<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    public function studentAnswer(): HasMany
    {
        return $this->hasMany(StudentTaskAnswerCollection::class);
    }
}
