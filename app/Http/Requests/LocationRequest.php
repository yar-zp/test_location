<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ];
    }

    public function messages(): array
    {
        return [
            'latitude.required' => 'The latitude field is required.',
            'latitude.numeric' => 'The latitude field must be a numeric value.',
            'latitude.between' => 'The latitude field must be between -90 and 90.',
            'longitude.required' => 'The longitude field is required.',
            'longitude.numeric' => 'The longitude field must be a numeric value.',
            'longitude.between' => 'The longitude field must be between -180 and 180.',
        ];
    }
}
