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
        $this->app->bind(
            \App\Repositories\Interfaces\PostRepositoryInterface::class,
            \App\Repositories\PostRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\CommentRepositoryInterface::class,
            \App\Repositories\CommentRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\CourseRepositoryInterface::class,
            \App\Repositories\CourseRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\FeedBackRepositoryInterface::class,
            \App\Repositories\FeedBackRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\RequestTutorRepositoryInterface::class,
            \App\Repositories\RequestTutorRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\AdminUserRepositoryInterface::class,
            \App\Repositories\AdminUserRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\PaymentRepositoryInterface::class,
            \App\Repositories\PaymentRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\CouponRepositoryInterface::class,
            \App\Repositories\CouponRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\RatingRepositoryInterface::class,
            \App\Repositories\RatingRepository::class
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