<?php

namespace App\Repositories;
use App\Models\Job;
use App\Repositories\Interfaces\JobRepositoryInterface;


class JobRepository implements JobRepositoryInterface
{
    public function getAllJobs()
    {
        return Job::get()->toArray();
    }
}