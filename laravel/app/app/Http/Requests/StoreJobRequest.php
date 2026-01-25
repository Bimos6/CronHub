<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:2000',
            'cron_expression' => [
                'required',
                'string',
                'regex:/^(\*|([0-9]|[1-5][0-9])(,([0-9]|[1-5][0-9]))*)(\s+(\*|([0-9]|[1-5][0-9])(,([0-9]|[1-5][0-9]))*)){4}$/'  
            ],
            'method' => [
                'required',
                'string',
                Rule::in(['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])
            ],
            'payload' => 'nullable|array',
            'headers' => 'nullable|array',
            'is_active' => 'boolean', 
        ];
    }

    public function messages(): array
    {
        return [
            'cron_expression.regex' => 'Неверный формат cron выражения',
            'url.url' => 'Указан неверный формат URL',
            'method.in' => 'Метод должен быть одним из: GET, POST, PUT, PATCH, DELETE',
        ];
    }
}
