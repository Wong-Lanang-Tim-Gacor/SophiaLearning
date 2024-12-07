<?php

namespace App\Services;

use App\Base\Interface\UploadValidationInterface;
use App\Traits\UploadTrait;

class ClassroomService implements UploadValidationInterface
{
    use UploadTrait;

    public function validateAndUpload(string $disk, object $file, string $old_file = null)
    {
        if ($old_file) $this->remove($old_file);

        return $this->upload($disk, $file);
    }
}
