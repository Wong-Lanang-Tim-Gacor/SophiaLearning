<?php

namespace App\Http\Requests;

use App\Traits\ValidatesRequest;
use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest
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
            'class_name' => 'string|required',
            'description' => 'string|nullable',
            'background_image' => 'image|nullable',
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
            'class_name.string' => 'Nama kelas harus berupa teks.',
            'class_name.required' => 'Nama kelas wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'background_image.image' => 'Gambar latar belakang harus berupa file gambar.',
            'is_archived.boolean' => 'Status arsip harus berupa nilai true atau false.',
        ];
    }
}
