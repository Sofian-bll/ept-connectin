<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'        => 'sometimes|string|max:255',
            'last_name'         => 'sometimes|string|max:255',
            'name'              => 'sometimes|string|max:255',
            'email'             => [
                'sometimes', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
            'avatar'            => 'nullable|image|max:2048',
            'birthday'          => 'sometimes|nullable|date',
            'birthplace_city'   => 'sometimes|nullable|string|max:255',
            'birthplace_country' => 'sometimes|nullable|string|max:255',
            'bio'               => 'sometimes|nullable|string|max:1000',
        ];
    }
}
