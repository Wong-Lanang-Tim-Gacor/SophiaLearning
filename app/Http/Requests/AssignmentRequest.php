<?php

namespace App\Http\Requests;

use App\Enums\AssignmentStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignmentRequest extends FormRequest
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
            'classroom_id' => 'required|exists:classrooms,id',
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string',
            'content' => 'string',
            'due_date' => 'required|date',
            'max_score' => 'integer',
            'status' => [
                'required',
                Rule::enum(AssignmentStatusEnum::class)
            ]
        ];
    }
}
