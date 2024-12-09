<?php

namespace App\Services;

use App\Base\Interface\MaterialAttachmentInterface;
use App\Base\Interface\UploadValidationInterface;
use App\Traits\UploadTrait;

class MaterialService implements UploadValidationInterface, MaterialAttachmentInterface
{
use UploadTrait;

    public function validateAndUpload(string $disk, object $file, string $old_file = null)
    {
        if ($old_file) $this->remove($old_file);

        return $this->upload($disk, $file);
    }

    public function saveAttachment(
        string $disk,
        mixed $attachment,
        string $attachmentType = "file",
        int $materialId
    )
    {
        $fileName = null;
//        if ($attachmentType === 'file') {
//            $fileName = $this->validateAndUpload('materials',$attachment, $attachment);
//        }
        dd($attachment);
        return [
            'material_id' => $materialId,
            'file_name' => explode('/', $fileName)[1],
            'file_path' => $fileName,
            'file_type' => $attachmentType,
            'file_size' => $attachment->getSize(),
            'file_extension' => $attachment->getExtension(),
            'file_mime' => $attachment->getMimeType(),
            'file_url' => $attachment,
        ];
    }
}
