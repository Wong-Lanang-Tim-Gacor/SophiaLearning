<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{

    public function exist(string $file)
    {
        return Storage::exists($file);
    }
    public function remove(string $file)
    {
        if ($this->exist($file)) Storage::delete($file);
    }

    public function upload(string $disk, UploadedFile $file, bool $originalName = false)
    {
        if($this->exist($disk)) Storage::makeDirectory($disk);

        if($originalName) {
            return $file->storeAs($disk, $file->getClientOriginalName());
        }
        return Storage::put($disk, $file);
    }
}
