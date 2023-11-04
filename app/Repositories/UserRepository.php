<?php

namespace App\Repositories;

use App\Models\TeachPlace;
use App\Models\TeachSubject;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function register($input)
    {
        $user_id = User::saveOrUpdateWithUuid($input);
        return User::withCount('likes')->find($user_id);
    }

    public function findUserByEmail($email)
    {
        $user = User::withCount('likes')->where('email', $email)->first();

        return $user ? $user->toArray() : [];
    }

    public function findUserById($id)
    {
        $user = User::withCount('likes')->where('id', $id)->first(); 

        return $user ? $user->toArray() : [];
    }

    public function updateUser($input)
    {
        User::saveOrUpdateWithUuid($input);
    }

    public function createTeachSubjectOfUser($data)
    {
        TeachSubject::createOrUpdate($data);
    }

    public function createTeachPlacesOfUser($data)
    {
        TeachPlace::createOrUpdate($data);
    }

    public function searchTutorList($input) 
    {
        
    }
}