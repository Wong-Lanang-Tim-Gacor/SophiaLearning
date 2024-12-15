<?php

namespace App\Http\Requests;

use App\Traits\ValidatesRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|max:255|unique:users,username,' . $this->user()->id,
            'email' => 'sometimes|email|max:255|unique:users,email,' . $this->user()->id,
            'phone' => 'sometimes|string|max:15|unique:users,phone,' . $this->user()->id,
            'photo_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'password' => 'sometimes|string|min:8|confirmed', // Untuk input kata sandi baru
            'current_password' => 'required_with:password|string', // Harus diisi jika ingin mengubah kata sandi
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
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'username.string' => 'Username harus berupa teks.',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',
            'username.unique' => 'Username sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.string' => 'Nomor telepon harus berupa teks.',
            'phone.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter.',
            'phone.unique' => 'Nomor telepon sudah terdaftar.',
            'photo_profile.image' => 'Foto profil harus berupa gambar.',
            'photo_profile.mimes' => 'Foto profil harus berformat jpg, jpeg, atau png.',
            'photo_profile.max' => 'Ukuran foto profil tidak boleh lebih dari 5MB.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi harus memiliki minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'current_password.required_with' => 'Kata sandi saat ini harus diisi jika mengubah kata sandi.',
            'current_password.string' => 'Kata sandi saat ini harus berupa teks.',
        ];
    }
}
