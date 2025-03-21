<?php

namespace App\Http\Requests\Tasks;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'status' => 'required|in:' . implode(',', array_column(TaskStatus::cases(), 'value')),
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.max' => 'Title must not be greater than 255 characters',
            'description.required' => 'Description is required',
            'description.string' => 'Description must be a string',
            'assigned_to.required' => 'Assigned To is required',
            'assigned_to.exists' => 'Assigned To must exist in the users table',
            'due_date.required' => 'Due Date is required',
            'due_date.date' => 'Due Date must be a date',
            'status.required' => 'Status is required',
            'status.in' => 'Status must be one of: ' . implode(', ', array_column(TaskStatus::cases(), 'value')),
        ];
    }
}
