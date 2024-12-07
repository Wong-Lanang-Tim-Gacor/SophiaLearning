<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentAttachment extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentAttachmentFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }
}
