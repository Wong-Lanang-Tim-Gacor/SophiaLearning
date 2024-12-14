<?php

namespace App\Http\Requests;

use App\Traits\ValidatesRequest;
use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
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
            'resource_id' => 'sometimes|required|exists:resources,id',
            'point' => 'sometimes',
            'attachments' => [
                'sometimes',
                'required',
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
