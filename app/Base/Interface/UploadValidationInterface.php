<?php

namespace App\Base\Interface;

interface UploadValidationInterface
{
    public function validateAndUpload(string $disk, object $file, string $old_file = null);
}
