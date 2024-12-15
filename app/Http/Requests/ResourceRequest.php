<?php

namespace App\Http\Requests;

use App\Enums\ResourceTypeEnum;
use App\Traits\ValidatesRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResourceRequest extends FormRequest
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
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string',
            'content' => 'string',
            'due_date' => 'nullable|date',
            'max_score' => 'integer',
            'type' => [
                Rule::enum(ResourceTypeEnum::class)
            ],
            'attachments' => [
                'array',
                function ($attribute, $value, $fail) {
                    // Validate each file in the array
                    foreach ($value as $file) {
                        // Check that each file is either an image or document
                        if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
                            return $fail('File harus berupa gambar atau dokumen dengan format: jpg, jpeg, png, pdf, doc, docx, xls, xlsx, ppt, pptx');
                            
                        }

                        // Validate file size (e.g., max 5MB)
                        if ($file->getSize() > 5 * 1024 * 1024) {
                            return $fail('Ukuran file tidak boleh lebih dari 5MB.');
                        }
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
            'classroom_id.required' => 'ID kelas wajib diisi.',
            'classroom_id.exists' => 'ID kelas tidak ditemukan.',
            'title.required' => 'Judul wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'content.string' => 'Konten harus berupa teks.',
            'due_date.date' => 'Tanggal jatuh tempo harus berupa format tanggal yang valid.',
            'max_score.integer' => 'Skor maksimum harus berupa angka.',
            'type.enum' => 'Tipe resource tidak valid.',
            'attachments.array' => 'Lampiran harus berupa array.',
            'attachments.*.mimes' => 'File lampiran harus berupa gambar atau dokumen (jpg, jpeg, png, pdf, doc, docx, xls, xlsx, ppt, pptx).',
            'attachments.*.max' => 'Ukuran file lampiran tidak boleh lebih dari 5MB.',
        ];
    }
}
