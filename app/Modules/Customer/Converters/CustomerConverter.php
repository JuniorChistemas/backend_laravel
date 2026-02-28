<?php

namespace App\Modules\Customer\Converters;

use App\Models\Customer;
use App\Modules\Customer\Dtos\CustomerDTO;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerConverter{

  /**
   * @param Customer $customer
   * @return CustomerDTO
   */
  public static function toDTO(Customer $customer): CustomerDTO{
    return new CustomerDTO(
      id: $customer->id,
      full_name: ($customer->first_name . ' ' . $customer->last_name),
      email: $customer->email,
      phone: $customer->phone,
      description: $customer->description,
      status: $customer->status,
    );
  }


  /**
   * @param LengthAwarePaginator $customers
   * @return LengthAwarePaginator
   */

  public static function toCollectionDTO(LengthAwarePaginator $customers): LengthAwarePaginator{
    $customers->setCollection(
      $customers->getCollection()->map(fn(Customer $customer) => self::toDTO($customer))
    );

    return $customers;
  }
}

