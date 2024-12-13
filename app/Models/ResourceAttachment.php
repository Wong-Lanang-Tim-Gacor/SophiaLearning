<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceAttachment extends Model
{
    /** @use HasFactory<\Database\Factories\ResourceAttachmentFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }
}
