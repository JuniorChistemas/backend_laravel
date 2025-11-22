<?php
namespace App\Modules\Customer\Dtos;
class CustomerUpdateDTO{
  public function __construct(
    public readonly ?string $first_name,
    public readonly ?string $last_name,
    public readonly ?string $email,
    public readonly ?string $phone,
    public readonly ?string $description,
    public readonly ?bool $status,
  )
  {}
}