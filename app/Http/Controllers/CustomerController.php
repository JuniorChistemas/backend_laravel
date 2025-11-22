<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Modules\Customer\Services\CustomerService;

class CustomerController extends Controller
{
    public function __construct(private CustomerService $customer_service){}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->customer_service->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return response()->json($this->customer_service->create($request->toDto()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($this->customer_service->getById((int)$id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, int $id)
    {
        return response()->json($this->customer_service->update($id, $request->toDto()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json(['deleted' => $this->customer_service->delete((int)$id)]);
    }
}
