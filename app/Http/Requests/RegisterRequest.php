<?php

namespace App\Http\Requests;

use App\Traits\ValidatesRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name" => 'required|string',
            "username" => 'required|string|unique:users,username,' . $this->username,
            "email" => 'required|email|unique:users,email,' . $this->email,
            "password" => 'required|string|min:8',
            "phone" => 'required'
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
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.unique' => 'Username sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            'phone.required' => 'Nomor telepon wajib diisi.',
        ];
    }
}
