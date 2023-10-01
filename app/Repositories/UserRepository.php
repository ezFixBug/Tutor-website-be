<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function register($input)
    {
        return User::create($input);
    }

    public function findUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }
}