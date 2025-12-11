<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnpointContact extends FormRequest
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
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'message' => 'required|string',
            'recaptcha_request' => 'required|array',
        ];
    }

    // Messages
    public function messages():array
    {   
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe exceder los 150 caracteres.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El campo correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El campo correo electrónico no debe exceder los 150 caracteres.',
            'message.required' => 'El campo mensaje es obligatorio.',
            'message.string' => 'El campo mensaje debe ser una cadena de texto.',
            'recaptcha_request.required' => 'El campo reCAPTCHA es obligatorio.',
            'recaptcha_request.array' => 'El campo reCAPTCHA debe ser un arreglo.',
        ];
    }

    
}
