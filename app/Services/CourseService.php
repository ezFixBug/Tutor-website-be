<?php

namespace App\Services;
use App\Repositories\Interfaces\CourseRepositoryInterface;

class CourseService
{
    private $course_repo;

    public function __construct(CourseRepositoryInterface $course_repo)
    {
        $this->course_repo = $course_repo;
    }
    
    public function createCourse($input) 
    {
        $course_id = $this->course_repo->createOrUpdateCourse($input);

        $this->createInfoForCoruse($input, $course_id);
    }

    public function updateCourse($input)
    {
        $this->course_repo->deleteClassesOfCourse($input['id']);
        $this->course_repo->deleteSubjectsOfCourse($input['id']);
        $this->createInfoForCoruse($input, $input['id']);

        $this->course_repo->createOrUpdateCourse($input);
    }

    public function createInfoForCoruse($input, $course_id)
    {
        $list_class = $input['classes'];
        foreach ($list_class as $class) {
            $data = [
                'course_id' => $course_id,
                'class_id' => $class
            ];

            $class = $this->course_repo->createCourseClass($data);
        }

        $list_subject = $input['subjects'];
        foreach ($list_subject as $subject) {
            $data = [
                'course_id' => $course_id,
                'subject_id'=> $subject
            ];

            $class = $this->course_repo->createCourseSubject($data);
        }
    }
}