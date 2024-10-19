<?php

namespace App\Http\Requests\Subcriptions;

use Illuminate\Foundation\Http\FormRequest;

class SubcriptionCreateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'days_duration' => ['required', 'integer'],
        ];
    }
}
