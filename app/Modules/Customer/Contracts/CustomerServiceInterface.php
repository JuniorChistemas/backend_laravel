<?php

namespace App\Modules\Customer\Contracts;

use App\Modules\Customer\Dtos\CustomerCreateDTO;
use App\Modules\Customer\Dtos\CustomerDTO;
use App\Modules\Customer\Dtos\CustomerUpdateDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerServiceInterface{
  public function getAll(): LengthAwarePaginator;
  public function getById(int $id): CustomerDTO;
  public function create(CustomerCreateDTO $data):CustomerDTO;
  public function update(int $id, CustomerUpdateDTO $data): CustomerDTO;
  public function delete(int $id): bool;
}