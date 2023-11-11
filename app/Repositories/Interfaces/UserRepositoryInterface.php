<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function register($request);
    
    public function findUserByEmail($email);

    public function findUserById($id);

    public function updateUser($input);

    public function createTeachSubjectOfUser($data);
    
    public function createTeachSubjectClass($data);

    public function createTeachPlaceDistrict($data);

    public function createTeachPlacesOfUser($data);

    public function searchTutorList($input);
}
