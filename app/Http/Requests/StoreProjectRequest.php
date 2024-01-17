<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
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
            'name_project' => 'required|max:200|string|unique:projects',
            'date_creation' => 'required|date',
            'status' => [
                'required',
                Rule::in(['Completato', 'In corso', 'Non completato'])
            ],
            'description' => 'nullable|min:5|string',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'exists:technologies,id',
            'cover_image' => 'nullable|file|max:2048|mimes:jpg,png'
        ];
    }
}
