<?php
namespace App\Modules\Customer\Services;

use App\Models\Customer;
use App\Modules\Customer\Contracts\CustomerRepositoryInterface;
use App\Modules\Customer\Contracts\CustomerServiceInterface;
use App\Modules\Customer\Converters\CustomerConverter;
use App\Modules\Customer\Dtos\CustomerCreateDTO;
use App\Modules\Customer\Dtos\CustomerDTO;
use App\Modules\Customer\Dtos\CustomerUpdateDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class CustomerService implements CustomerServiceInterface{
  public function __construct(private CustomerRepositoryInterface $repository){}

  public function getAll(): LengthAwarePaginator
  {
    $customers = $this->repository->getAll();
    $customers->setCollection(
      $customers->getCollection()->map(fn(Customer $customer) => CustomerConverter::toDTO($customer))
    );

    return $customers;
  } 
  public function getById(int $id): CustomerDTO
  {
    return CustomerConverter::toDTO($this->repository->find($id));
  }
  public function create(CustomerCreateDTO $data): CustomerDTO
  {
    Log::info('Creating customer with data: ', (array)$data);
    $model = $this->repository->create($data);
    return CustomerConverter::toDTO($model);
  } 
  public function update(int $id, CustomerUpdateDTO $data): CustomerDTO
  {
    Log::info('Updating customer with ID ' . $id . ' with data: ', (array)$data);
    return CustomerConverter::toDTO($this->repository->update($id, $data));
  } 
  public function delete(int $id): bool
  {
    return $this->repository->delete($id);
  }
}