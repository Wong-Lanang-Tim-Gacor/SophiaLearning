<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentTaskAnswerCollection extends Model
{
    /** @use HasFactory<\Database\Factories\StudentTaskAnswerCollectionFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function assignments(): BelongsTo
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }
}