<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory;

    protected $guarded = ['id'];

     // Relasi dengan classroom
     public function classroom()
     {
         return $this->belongsTo(Classroom::class);
     }
 
     // Relasi dengan topic
     public function topic()
     {
         return $this->belongsTo(Topic::class);
     }
}
