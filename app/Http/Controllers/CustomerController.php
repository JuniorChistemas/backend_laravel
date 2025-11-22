<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Modules\Customer\Services\CustomerService;

class CustomerController extends Controller
{
    public function __construct(private CustomerService $customer_service){}


    /**
     * Obtener todos los clientes
     * 
     * @return JsonResponse
     * 
     * @group Cliente
     * @authenticated
     * 
     * @responseField data Lista de clientes
     */
    public function index()
    {
        return response()->json($this->customer_service->getAll());
    }

    /**
     * Crear un nuevo cliente
     * 
     * @param  StoreCustomerRequest  $request
     * @return JsonResponse
     * 
     * @group Cliente
     * @authenticated
     * 
     * @responseField data Información del cliente creado
     */
    public function store(StoreCustomerRequest $request)
    {
        return response()->json($this->customer_service->create($request->toDto()));
    }

    /**
     * Obtener un cliente específico
     * 
     * @param  string  $id
     * @return JsonResponse
     * 
     * @group Cliente
     * @authenticated
     * 
     * @urlParam id integer required ID del cliente. Example: 1
     * 
     * @responseField data Información del cliente
     */
    public function show(string $id)
    {
        return response()->json($this->customer_service->getById((int)$id));
    }

    /**
     * Actualizar un cliente existente
     * 
     * @param  UpdateCustomerRequest  $request
     * @param  int  $id
     * @return JsonResponse
     * 
     * @group Cliente
     * @authenticated
     * 
     * @urlParam id integer required ID del cliente a actualizar. Example: 1
     * 
     * @responseField data Información del cliente actualizado
     */
    public function update(UpdateCustomerRequest $request, int $id)
    {
        return response()->json($this->customer_service->update($id, $request->toDto()));
    }

    /**
     * Eliminar un cliente
     * 
     * @param  string  $id
     * @return JsonResponse
     * 
     * @group Cliente
     * @authenticated
     * 
     * @urlParam id integer required ID del cliente a eliminar. Example: 1
     * 
     * @responseField deleted Estado de la operación de eliminación
     */
    public function destroy(string $id)
    {
        return response()->json(['deleted' => $this->customer_service->delete((int)$id)]);
    }
}
