<?php

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskUpdateDtoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

   public function rules(): array
    {
        return [
            "title" => ['string', 'max:30', 'min:5'],
            "description" => ['string', 'max:100' ,'min:5'],
            "status" => [Rule::in(TaskStatus::getLabels())],
            "priority" => [Rule::in(TaskPriority::getLabels())],
            "order" => ['integer']
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
