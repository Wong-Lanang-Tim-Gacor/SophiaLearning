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
            'photo_profile' => 'sometimes|image|mimes:jpg,jpeg,png|max:5120',
        ];
    }
}
