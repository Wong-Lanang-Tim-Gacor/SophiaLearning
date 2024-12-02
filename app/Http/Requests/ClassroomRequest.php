<?php

namespace App\Http\Requests;

use App\Enums\ClassroomStatusEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClassroomRequest extends FormRequest
{
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
            'user_id' => 'sometimes|required|exists:users,id',
            'identifier_code' => 'sometimes|required|string|unique:classrooms,identifier_code,' . $this->identifier_code,
            'class_name' => 'sometimes|string|required',
            'description' => 'string|nullable',
            'background_image' => 'string|nullable',
            'background_color' => 'string|nullable',
            'text_color' => 'string|nullable',
            'status' => [
                'sometimes',
                'required',
                Rule::enum(ClassroomStatusEnums::class)
            ]
        ];
    }
}
