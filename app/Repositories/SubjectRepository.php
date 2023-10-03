<?php

namespace App\Repositories;
use App\Models\Subject;
use App\Repositories\Interfaces\SubjectRepositoryInterface;


class SubjectRepository implements SubjectRepositoryInterface
{
    public function getAllSubjects()
    {
        return Subject::get()->toArray();
    }
}