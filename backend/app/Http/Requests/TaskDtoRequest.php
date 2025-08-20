<?php

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class TaskDtoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // todo: make this admin only
        return request()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => ['required', 'string', 'max:30', 'min:5'],
            "description" => ['required', 'max:100' ,'min:5'],
            "status" => ['required', Rule::in(TaskStatus::getLabels())],
            "priority" => ['required', Rule::in(TaskPriority::getLabels())],
            "order" => ['integer'],
            "user_id" => ['exists:users,id']
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Priority must be one of: ' . implode(', ', TaskStatus::getLabels()),
            'priority.in' => 'Priority must be one of: ' . implode(', ', TaskPriority::getLabels()),
        ];
    }
}
