<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIssueRequest extends FormRequest
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
            'project_id' => ['sometimes', 'exists:projects,id'],
            'code' => [
                'sometimes', 'string', 'max:50',
                Rule::unique('issues', 'code')->ignore($this->issue),
            ],
            'title' => ['sometimes', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'status' => ['sometimes', 'in:open,in_progress,closed'],
            'priority' => ['sometimes', 'in:low,medium,high,urgent'],
            'due_window' => ['nullable', 'array'],
            'due_window.start' => ['nullable', 'date'],
            'due_window.end' => ['nullable', 'date', 'after_or_equal:due_window.start'],
            'assignees' => ['nullable', 'array'],
            'assignees.*' => ['integer', 'exists:users,id'],
            'labels' => ['nullable', 'array'],
            'labels.*' => ['integer', 'exists:labels,id'],
        ];
    }
}
