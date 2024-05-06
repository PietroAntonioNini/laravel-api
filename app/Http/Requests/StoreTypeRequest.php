<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTypeRequest extends FormRequest
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
            'name' => 'required | max:255',
            'description' => 'nullable | max:5000',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => "Il Nome deve essere inserito nell'apposito campo",
            'name.max' => "Il Nome supera il numero di caratteri cosentiti (:max)",
            'description.required' => "La descrizione deve essere inserita nell'apposito campo",
            'description.max' => "La descrizione supera il numero di caratteri cosentiti (:max)",           
        ];
    }
}
