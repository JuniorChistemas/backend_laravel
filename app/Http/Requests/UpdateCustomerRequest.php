<?php

namespace App\Http\Requests;

use App\Modules\Customer\Dtos\CustomerUpdateDTO;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'first_name' => 'sometimes|required|string|max:100',
            'last_name' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:customers,email,' . $this->route('customer'),
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
                'example' => 'Cliente VIP actualizado',
            ],
            'status' => [
                'description' => 'Estado del cliente',
                'example' => false,
            ],
        ];
    }

    public function toDto(): CustomerUpdateDTO{
        return new CustomerUpdateDTO(
            first_name: $this->input('first_name'),
            last_name: $this->input('last_name'),
            email: $this->input('email'),
            phone: $this->input('phone'),
            description: $this->input('description'),
            status: $this->input('status'),
        );
    }
}
