<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnswerAttachment extends Model
{
    protected $guarded = ['id'];
    protected $table = 'answer_attachment';
    public  $timestamps = false;

    public function answer(): BelongsTo
    {
        return  $this->belongsTo(Answer::class);
    }
}
