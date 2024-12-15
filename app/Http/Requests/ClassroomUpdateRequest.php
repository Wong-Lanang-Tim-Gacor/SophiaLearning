<?php

namespace App\Http\Requests;

use App\Traits\ValidatesRequest;
use Illuminate\Foundation\Http\FormRequest;

class ClassroomUpdateRequest extends FormRequest
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
            'identifier_code' => 'sometimes|required|string|unique:classrooms,identifier_code,' . $this->identifier_code,
            'class_name' => 'sometimes|string|required',
            'description' => 'sometimes|string|nullable',
            'background_image' => 'sometimes|image|nullable',
            'is_archived' => 'sometimes|boolean',
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
            'identifier_code.required' => 'Kode identifikasi wajib diisi.',
            'identifier_code.string' => 'Kode identifikasi harus berupa teks.',
            'identifier_code.unique' => 'Kode identifikasi sudah digunakan.',
            'class_name.required' => 'Nama kelas wajib diisi.',
            'class_name.string' => 'Nama kelas harus berupa teks.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'background_image.image' => 'Gambar latar belakang harus berupa file gambar.',
            'is_archived.boolean' => 'Status arsip harus berupa nilai true atau false.',
        ];
    }
}
