<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    /** @use HasFactory<\Database\Factories\TopicFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    // Relasi untuk guru yang membuat kelas ini (one-to-many)
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
