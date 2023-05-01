<?php

namespace App\Providers;

use App\Services\Interfaces\TransactionInterface;
use App\Services\Interfaces\TransactionReportInterface;
use App\Services\Repositories\TransactionReportRepository;
use App\Services\Repositories\TransactionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(TransactionInterface::class, TransactionRepository::class);
        app()->bind(TransactionReportInterface::class, TransactionReportRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
