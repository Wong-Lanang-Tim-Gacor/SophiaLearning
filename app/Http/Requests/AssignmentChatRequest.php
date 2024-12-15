<?php

namespace App\Http\Requests;

use App\Traits\ValidatesRequest;
use Illuminate\Foundation\Http\FormRequest;

class AssignmentChatRequest extends FormRequest
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
            'assignment_id' => 'sometimes|required|exists:assignments,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'message' => 'required|string'
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
            'assignment_id.required' => 'ID tugas wajib diisi.',
            'assignment_id.exists' => 'ID tugas tidak ditemukan.',
            'user_id.required' => 'ID pengguna wajib diisi.',
            'user_id.exists' => 'ID pengguna tidak ditemukan.',
            'message.required' => 'Pesan wajib diisi.',
            'message.string' => 'Pesan harus berupa teks.',
        ];
    }
}
