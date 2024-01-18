<?php

namespace App\Services;

use App\Repositories\Interfaces\AdminUserRepositoryInterface;

class AdminUserService
{
    protected $AdminUserRepositoryInterface;

    public function __construct(AdminUserRepositoryInterface $AdminUserRepository)
    {
        $this->AdminUserRepositoryInterface = $AdminUserRepository;
    }
    // Your service methods here

}
