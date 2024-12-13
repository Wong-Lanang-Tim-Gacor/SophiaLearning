<?php

namespace App\Services;

use App\Base\Interface\UploadValidationInterface;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;

class AttachmentService implements UploadValidationInterface
{
    use UploadTrait;
    public function validateAndUpload(string $disk, object $file, string $old_file = null)
    {
        if ($old_file) $this->remove($old_file);

        return $this->upload($disk, $file);
    }

    public function storeAttachment(
        mixed  $id,
        string $disk,
        array  $attachment,
        Model  $model,
        string $foreignIdName,
        string $attachmentKey = 'attachments',
    ): bool
    {
        $returnData = [];
        foreach ($attachment[$attachmentKey] as $key => $value) {
            // Assert that the value is an instance of UploadedFile
            if ($value instanceof \Illuminate\Http\UploadedFile) {
                $file = $this->validateAndUpload($disk, $value);
                $returnData[] = [
                    $foreignIdName => $id,
                    'file_name' => explode('/', $file)[1],
                    'file_mime' => $value->getMimeType(),
                    'file_size' => $value->getSize(),
                    'file_extension' => $value->getClientOriginalExtension(),
                    'file_type' => $value->getClientMimeType(),
                    'file_path' => $file,
                    'file_url' => config('app.url') . '/storage/'.$file,
                ];
            }
        }
        return $model->query()->insert($returnData);
    }
}
