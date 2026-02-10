<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExecutionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_id' => [
                'required',
                'integer',
                'exists:jobs,id',
            ],
            'status_code' => [
                'nullable',
                'integer',
                'min:100',
                'max:599',
            ],
            'response_body' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'response_headers' => [
                'nullable',
                'array',
            ],
            'response_headers.*.name' => [
                'sometimes',
                'string',
                'max:100',
            ],
            'response_headers.*.value' => [
                'sometimes',
                'string',
                'max:500',
            ],
            'error_message' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'duration_ms' => [
                'required',
                'integer',
                'min:0',
                'max:300000', 
            ],
            'started_at' => [
                'required',
                'date',
                'before_or_equal:now',
            ],
            'finished_at' => [
                'nullable',
                'date',
                'after_or_equal:started_at',
                'before_or_equal:now',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'job_id.exists' => 'Задача с указанным ID не существует',
            'duration_ms.max' => 'Время выполнения не может превышать 5 минут',
            'started_at.before_or_equal' => 'Время начала не может быть в будущем',
            'finished_at.after_or_equal' => 'Время завершения не может быть раньше времени начала',
        ];
    }

    public function prepareForValidation(): void
    {
        if ($this->has('response_headers') && is_string($this->response_headers)) {
            $this->merge([
                'response_headers' => json_decode($this->response_headers, true),
            ]);
        }

        if ($this->has('duration_ms')) {
            $this->merge([
                'duration_ms' => (int) $this->duration_ms,
            ]);
        }
    }
}