<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTaskAnswerAttachment extends Model
{
    /** @use HasFactory<\Database\Factories\StudentTaskAnswerAttachmentFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function studentTaskAnswerCollection()
    {
        return $this->belongsTo(StudentTaskAnswerCollection::class, 'student_task_answer_collection_id');
    }
}