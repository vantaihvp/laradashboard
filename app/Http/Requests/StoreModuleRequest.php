<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModuleRequest extends FormRequest
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
            'module' => 'required|file|mimes:zip',
        ];
    }

    /**
     * Get the custom messages for the validation rules.
     */
    public function messages(): array
    {
        return [
            'module.required' => __('The module file is required.'),
            'module.file' => __('The module must be a valid file.'),
            'module.mimes' => __('The module must be a zip file. Please follow the guidelines for module creation.'),
        ];
    }
}
