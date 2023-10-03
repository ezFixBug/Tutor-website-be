<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Interfaces\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class,
        );
        $this->app->bind(
            \App\Repositories\Interfaces\ProvinceRepositoryInterface::class,
            \App\Repositories\ProvinceRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\SubjectRepositoryInterface::class,
            \App\Repositories\SubjectRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\JobRepositoryInterface::class,
            \App\Repositories\JobRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\ClassRepositoryInterface::class,
            \App\Repositories\ClassRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}