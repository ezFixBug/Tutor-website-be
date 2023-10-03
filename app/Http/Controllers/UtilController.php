<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\SubjectRepositoryInterface as SubjectRepository;
use App\Repositories\Interfaces\ClassRepositoryInterface as ClassRepository;
use App\Repositories\Interfaces\JobRepositoryInterface as JobRepository;

class UtilController extends Controller
{
    private $subject_repository;
    private $class_repository;
    private $job_repository;

    public function __construct(SubjectRepository $subject_repository, ClassRepository $class_repository, JobRepository $job_repository)
    {
        $this->subject_repository = $subject_repository;
        $this->class_repository = $class_repository;
        $this->job_repository = $job_repository;
    }
    public function getAllSubjects()
    {
        $subjects = $this->subject_repository->getAllSubjects();

        return response()->json([
            'status' => 200,
            'subjects' => $subjects,
        ]);
    }

    public function getAllJobs()
    {
        $jobs = $this->job_repository->getAllJobs();

        return response()->json([
            'status' => 200,
            'jobs' => $jobs,
        ]);
    }

    public function getAllClasses()
    {
        $classes = $this->class_repository->getAllClasses();

        return response()->json([
            'status' => 200,
            'classes' => $classes,
        ]);
    }
}
