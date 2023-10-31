<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\CourseSubject;
use App\Repositories\Interfaces\CourseRepositoryInterface;

class CourseRepository implements CourseRepositoryInterface
{
    public function createCourseClass($input)
    {
        CourseClass::saveOrUpdateWithUuid($input);
    }

    public function createCourseSubject($input)
    {
        CourseSubject::saveOrUpdateWithUuid($input);
    }

    public function createOrUpdateCourse($input)
    {
        return Course::saveOrUpdateWithUuid($input);
    }

    public function getCoursesByUserId($user_id)
    {
        $courses = Course::with([
            'classes' => function ($query) {
                $query->whereNull('course_classes.deleted_at');
            }
        ])
            ->with([
                'subjects' => function ($query) {
                    $query->whereNull('course_subjects.deleted_at');
                }
            ])
            ->with('user')
            ->where("user_id", $user_id)->get();

        return $courses ? $courses->toArray() : [];
    }

    public function getCourseById($course_id)
    {
        $course = Course::with([
                'classes' => function ($query) {
                    $query->whereNull('course_classes.deleted_at');
                }
            ])
            ->with([
                'subjects' => function ($query) {
                    $query->whereNull('course_subjects.deleted_at');
                }
            ])
            ->with('user')
            ->find($course_id);

        return $course ? $course->toArray() : [];
    }

    public function deleteSubjectsOfCourse($course_id)
    {
        CourseSubject::where('course_id', $course_id)->delete();
    }

    public function deleteClassesOfCourse($course_id)
    {
        CourseClass::where('course_id', $course_id)->delete();
    }

    public function deleteCourse($course_id)
    {
        $this->deleteSubjectsOfCourse($course_id);
        $this->deleteClassesOfCourse($course_id);
        
        Course::where('id', $course_id)->delete();
    }
}