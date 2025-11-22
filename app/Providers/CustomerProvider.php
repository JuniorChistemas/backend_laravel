<?php

namespace App\Providers;

use App\Modules\Customer\Contracts\CustomerRepositoryInterface;
use App\Modules\Customer\Contracts\CustomerServiceInterface;
use App\Modules\Customer\Repositories\EloquentCustomerRepository;
use App\Modules\Customer\Services\CustomerService;
use Illuminate\Support\ServiceProvider;

class CustomerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CustomerServiceInterface::class,
            CustomerService::class
        );

        $this->app->bind(
            CustomerRepositoryInterface::class,
            EloquentCustomerRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
