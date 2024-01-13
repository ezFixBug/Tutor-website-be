<?php

namespace App\Repositories\Interfaces;

use App\Models\AdminUser;

interface AdminUserRepositoryInterface
{
    public function getTutors($input);

    public function getCourses($input);

    public function getStatistics($data);

    public function getListUsers();
    public function blockUserById($id, $data);
    public function deleteUser($id);
    public function getListReportedTutors();
    public function getListReportedCourses();
    public function blockCourseById($id, $data);
    public function getPayments($data);
    public function getTotalRevenueWithUser($data);
    public function updateRevenue($data);
}
