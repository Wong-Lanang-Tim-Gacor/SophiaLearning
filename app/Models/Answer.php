<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Answer extends Model
{
    protected $table = 'answers';
    protected $guarded = ['id'];

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(AnswerAttachment::class);
    }
}
