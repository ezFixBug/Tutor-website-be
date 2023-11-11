<?php

namespace App\Services;

use App\Models\AdminUser;
use App\Repositories\AdminUserRepository;
use App\Repositories\AdminUserRepositoryInterface;

class AdminUserService
{
    protected $AdminUserRepositoryInterface;

    public function __construct(AdminUserRepositoryInterface $AdminUserRepository)
    {
        $this->AdminUserRepositoryInterface = $AdminUserRepository;
    }
    // Your service methods here
}
