<?php

namespace App\Http\Requests;

use App\Modules\Customer\Dtos\CustomerCreateDTO;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|size:9',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ];
    }



    public function bodyParameters(): array
    {
        return [
            'first_name' => [
                'description' => 'Nombre del cliente',
                'example' => 'Juan',
            ],
            'last_name' => [
                'description' => 'Apellido del cliente',
                'example' => 'Pérez',
            ],
            'email' => [
                'description' => 'Correo electrónico del cliente',
                'example' => 'juan.perez@example.com',
            ],
            'phone' => [
                'description' => 'Teléfono del cliente (9 caracteres)',
                'example' => '987654321',
            ],
            'description' => [
                'description' => 'Descripción adicional del cliente',
                'example' => 'Cliente VIP',
            ],
            'status' => [
                'description' => 'Estado del cliente',
                'example' => true,
            ],
        ];
    }

    public function toDto(): CustomerCreateDTO{
        return new CustomerCreateDTO(
            first_name: $this->input('first_name'),
            last_name: $this->input('last_name'),
            email: $this->input('email'),
            phone: $this->input('phone'),
            description: $this->input('description'),
            status: $this->input('status', true),
        );
    }
}
