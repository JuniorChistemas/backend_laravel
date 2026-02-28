<?php 
namespace App\Modules\Customer\Contracts;

use App\Modules\Customer\Dtos\CustomerCreateDTO;
use App\Modules\Customer\Dtos\CustomerUpdateDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerRepositoryInterface{
  public function getAll(): LengthAwarePaginator;
  public function find(int $id);
  public function create(CustomerCreateDTO $data);
  public function update(int $id,  CustomerUpdateDTO $data);
  public function delete(int $id): bool;
}