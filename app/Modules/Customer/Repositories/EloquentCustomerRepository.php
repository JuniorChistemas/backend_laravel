<?php

namespace App\Modules\Customer\Repositories;

use App\Models\Customer;
use App\Modules\Customer\Contracts\CustomerRepositoryInterface;
use App\Modules\Customer\Dtos\CustomerCreateDTO;
use App\Modules\Customer\Dtos\CustomerUpdateDTO;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentCustomerRepository implements CustomerRepositoryInterface{
  public function getAll(): LengthAwarePaginator 
  {
    // paginate
    return Customer::paginate(30);
  }
  public function find(int $id)
  {
      return Customer::findOrFail($id);
  }
  public function create(CustomerCreateDTO $data)
  {
    return Customer::create((array) $data);
  }
  public function update(int $id, CustomerUpdateDTO $data)
  {
    $customer = Customer::find($id);
    $customer->update(array_filter([
        'first_name' => $data->first_name,
        'last_name' => $data->last_name,
        'phone' => $data->phone,
        'email' => $data->email,
        'description' => $data->description,
        'status' => $data->status,
    ], fn ($v) => !is_null($v)));
    return $customer;
  }
  public function delete(int $id): bool
  {
    $customer = Customer::findOrFail($id);
    return $customer->delete();
  }
}