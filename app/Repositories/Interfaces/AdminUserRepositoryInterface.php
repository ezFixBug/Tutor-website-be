<?php

namespace App\Repositories\Interfaces;

use App\Models\AdminUser;

interface AdminUserRepositoryInterface
{
    public function getTutors($input);

    public function getCourses($input);

    public function getStatistics();

    public function getListUsers();
    public function blockUserById($id, $data);
    public function deleteUser($id);
    public function getListReportedTutors();
    public function getListReportedCourses();
    public function blockCourseById($id, $data);
}
