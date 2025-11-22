<?php
namespace App\Modules\Customer\Dtos;


class CustomerDTO{
  public function __construct(
    public readonly int $id,
    public readonly string $full_name,
    public readonly string $email,
    public readonly ?string $phone,
    public readonly ?string $description,
    public readonly bool $status,
  )
  {}
}