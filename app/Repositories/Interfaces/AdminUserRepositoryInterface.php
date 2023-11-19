<?php

namespace App\Repositories\Interfaces;

use App\Models\AdminUser;

interface AdminUserRepositoryInterface
{
    public function getTutors($input);

    public function getCourses($input);

    public function getStatistics();
}
