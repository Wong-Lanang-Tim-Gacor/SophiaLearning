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
            'user_id' => 'required|exists:users,id',
            'identifier_code' => 'required|string|unique:classrooms,identifier_code,' . $this->identifier_code,
            'class_name' => 'string|required',
            'description' => 'string|nullable',
            'background_image' => 'image|nullable',
            'is_archived' => 'sometimes|boolean',
        ];
    }
}
