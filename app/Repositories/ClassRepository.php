<?php

namespace App\Repositories;
use App\Models\UserClass;
use App\Repositories\Interfaces\ClassRepositoryInterface;


class ClassRepository implements ClassRepositoryInterface
{
    public function getAllClasses()
    {
        return UserClass::get()->toArray();
    }
}