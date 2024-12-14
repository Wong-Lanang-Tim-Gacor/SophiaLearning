<?php

namespace App\Models;

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
}
