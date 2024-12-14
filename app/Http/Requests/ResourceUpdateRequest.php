<?php

namespace App\Http\Requests;

use App\Enums\ResourceTypeEnum;
use App\Traits\ValidatesRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResourceUpdateRequest extends FormRequest
{
    use ValidatesRequest;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'classroom_id' => 'sometimes|required|exists:classrooms,id',
            'title' => 'sometimes|required|string',
            'content' => 'sometimes|string',
            'due_date' => 'sometimes|date',
            'max_score' => 'sometimes|integer',
            'type' => [
                'sometimes',
                'required',
                Rule::enum(ResourceTypeEnum::class)
            ],
            'attachments' => [
                'sometimes',
                'array',
                function ($attribute, $value, $fail) {
                    // Validate each file in the array
                    foreach ($value as $file) {
                        // Check that each file is either an image or document
                        if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
                            return $fail('The file must be an image or document (jpg, jpeg, png, pdf, doc, docx, xls, xlsx, ppt, pptx).');
                        }

                        // Validate file size (e.g., max 5MB)
                        if ($file->getSize() > 5 * 1024 * 1024) {
                            return $fail('The file size cannot exceed 5MB.');
                        }
                    }
                },
            ],
        ];
    }
}
