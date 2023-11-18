<?php

namespace App\Repositories\Interfaces;

interface CourseRepositoryInterface
{
    public function createCourseClass($input);

    public function createCourseSubject($input);

    public function createOrUpdateCourse($input);

    public function getCoursesByUserId($user_id);

    public function getCourseById($course_id);

    public function deleteSubjectsOfCourse($input);

    public function deleteClassesOfCourse($input);

    public function deleteCourse($course_id);

    public function searchListCourse($input);

    public function increaseViewsOfCourse($course);

    public function saveOrUpdateRegisterCourse($input);

    public function findRegisterCourse($id);

    public function getRegisterCourses($course_id);

    public function isRegisterCourse($course_id);

    public function getStudentsByCoureId($course_id);

    public function getCoursesRegisted($user_id);
}