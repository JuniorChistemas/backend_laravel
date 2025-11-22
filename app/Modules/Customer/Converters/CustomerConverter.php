<?php

namespace App\Modules\Customer\Converters;

use App\Models\Customer;
use App\Modules\Customer\Dtos\CustomerDTO;

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
   * @param Customer[] $customers
   * @return CustomerDTO[]
   */

  public static function toCollectionDTO(array $customers): array{
    return array_map(fn(Customer $customer) => self::toDTO($customer), $customers);
  }
}

