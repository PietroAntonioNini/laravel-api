<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required | max:255',
            'description' => 'required | max:5000',
            'image' => 'required | file | max:2048 | mimes:jpg,png,svg,jpeg',
            'technologies' => 'required | max:5000',
            'link_GitHub' => 'required | max:1000',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => "Il Nome deve essere inserito nell'apposito campo",
            'name.max' => "Il Nome supera il numero di caratteri cosentiti (:max)",
            'description.required' => "La descrizione deve essere inserita nell'apposito campo",
            'description.max' => "La descrizione supera il numero di caratteri cosentiti (:max)",
            'image.required' => "L'immagine deve essere inserita nell'apposito campo",
            'image.max' => "L'immagine supera il numero di caratteri cosentiti (:max)",
            'technologies.required' => "Le Tecnologie deveno essere inserite nell'apposito campo",
            'technologies.max' => "Le Tecnologie superano il numero di caratteri cosentiti (:max)",
            'link_GitHub.required' => "Il Link deve essere inserito nell'apposito campo",
            'link_GitHub.max' => "Il Link supera il numero di caratteri cosentiti (:max)",            
        ];
    }
}
