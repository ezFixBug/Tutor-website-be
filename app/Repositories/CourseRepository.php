<?php

namespace App\Repositories;

use App\Constants;
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
            ->withCount('likes')
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

    public function searchListCourse($input)
    {
        $courses = Course::with('user')
            ->with([
                'classes' => function ($query) {
                    $query->whereNull('course_classes.deleted_at');
                }
            ])
            ->with([
                'subjects' => function ($query) {
                    $query->whereNull('course_subjects.deleted_at');
                }
            ])
            ->when(isset($input['subject_id']), function ($query) use ($input) {
                $query->join('course_subjects as cs', 'courses.id', '=', 'cs.course_id')
                    ->where('cs.subject_id', $input['subject_id'])
                    ->whereNull('cs.deleted_at')
                    ->distinct();
            })
            ->when(isset($input['class_id']), function ($query) use ($input) {
                $query->join('course_classes as cc', 'courses.id', '=', 'cc.course_id')
                    ->where('cc.class_id', $input['class_id'])
                    ->whereNull('cc.deleted_at')
                    ->distinct();
            })
            ->when(isset($input['province_id']), function ($query) use ($input) {
                $query->where('province_id', $input['province_id']);
            })
            ->when(isset($input['district_id']), function ($query) use ($input) {
                $query->where('district_id', $input['district_id']);
            })
            ->when(isset($input['type_cd']), function ($query) use ($input) {
                $query->where('type_cd', $input['type_cd']);
            })
            ->when(isset($input['price_cd']), function ($query) use ($input) {
                if ($input['price_cd'] == Constants::CD_FREE) {
                    $query->whereNull('price');
                } else {
                    $query->whereNotNull('price');
                }
            })
            ->where('status_cd', Constants::CD_ACCEPT)
            ->select('courses.*')
            ->paginate(6);

        return $courses ? $courses->toArray() : [];
    }

    public function increaseViewsOfCourse($course)
    {
        $current_view = $course['view'];
        $view = $current_view + 1;
        
        Course::find($course['id'])->update(['view' => $view]);
    }
}