<?php

namespace App\Base\Interface;

interface MaterialAttachmentInterface
{
    public function saveAttachment(
        string $disk,
        mixed $attachment,
        string $attachmentType = "file", // url & file
        int $materialId,
    );
}
