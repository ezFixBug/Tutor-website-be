<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use Hash;
use JWTAuth;

class UserService
{
    private $user_repo;

    public function __construct(UserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function register($input)
    {   
        $input['id'] = \Str::orderedUuid()->toString();
        $input['password'] = Hash::make($input['password']);

        $user = $this->user_repo->register($input);
        $token = JWTAuth::fromUser($user);

        return [$user, $token];
    }
}