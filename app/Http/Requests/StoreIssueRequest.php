<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIssueRequest extends FormRequest
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
            'project_id' => ['required', 'exists:projects,id'],
            'code'       => ['required', 'string', 'max:50', 'unique:issues,code'],
            'title'      => ['required', 'string', 'max:255'],
            'body'       => ['nullable', 'string'],
            'status'     => ['required', 'in:open,in_progress,closed'],
            'priority'   => ['required', 'in:low,medium,high,urgent'],
            'due_window' => ['nullable', 'array'],
            'due_window.start' => ['nullable', 'date'],
            'due_window.end'   => ['nullable', 'date', 'after_or_equal:due_window.start'],
            'assignees'  => ['nullable', 'array'],
            'assignees.*'=> ['integer', 'exists:users,id'],
            'labels'     => ['nullable', 'array'],
            'labels.*'   => ['integer', 'exists:labels,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'يجب تحديد المشروع المرتبطة به المشكلة.',
            'code.unique'         => 'رمز المشكلةلا يجب ان يكون مستخدم من قبل.',
            'title.required'      => 'يجب إدخال عنوان للمشكلة.',
            'priority.in'         => 'الأولوية يجب أن تكون واحدة من القيم المسموح بها.',
        ];
    }
}
