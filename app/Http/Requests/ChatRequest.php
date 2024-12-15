<?php

namespace App\Http\Requests;

use App\Traits\ValidatesRequest;
use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
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
            'resource_id' => 'required|exists:resources,id',
            'message' => 'string|sometimes'
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
        'resource_id.required' => 'ID resource wajib diisi.',
        'resource_id.exists' => 'ID resource tidak ditemukan.',
        'message.string' => 'Pesan harus berupa teks.',
    ];
}
}
