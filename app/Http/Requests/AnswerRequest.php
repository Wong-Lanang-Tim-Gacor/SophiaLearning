<?php

namespace App\Http\Requests;

use App\Enums\AnswerStatusEnum;
use App\Traits\ValidatesRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'status' => [
                Rule::enum(AnswerStatusEnum::class)
            ],
            'attachments' => [
                'sometimes',
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    // Validate each file in the array
                    foreach ($value as $file) {
                        // Check that each file is either an image or document
                        if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
                            return $fail('File harus berupa gambar atau dokumen dengan format: jpg, jpeg, png, pdf, doc, docx, xls, xlsx, ppt, pptx.');                        }

                        // Validate file size (e.g., max 5MB)
                        if ($file->getSize() > 5 * 1024 * 1024) {
                            return $fail('Ukuran file tidak boleh lebih dari 5MB.');                        }
                    }
                },
            ],
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'resource_id.required' => 'Resource ID wajib diisi.',
            'resource_id.exists' => 'Resource ID tidak ditemukan.',
            'point.integer' => 'Point harus berupa angka.',
            'point.min' => 'Point tidak boleh kurang dari 0.',
            'point.max' => 'Point tidak boleh lebih dari 100.',
            'attachments.required' => 'Attachment wajib diunggah.',
            'attachments.array' => 'Attachment harus berupa array.',
        ];
    }
}
