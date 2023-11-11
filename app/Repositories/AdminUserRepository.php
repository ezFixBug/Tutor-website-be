<?php

namespace App\Repositories;

use App\Models\AdminUser;
use App\Models\User;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use Constants;

class AdminUserRepository implements AdminUserRepositoryInterface
{
    public function getTutors($input)
    {
        $tutors = User::with('province', 'district', 'job')
            ->where(function ($q) {
                $q->where(function ($query) {
                    $query->where('role_cd', Constants::CD_ROLE_TUTOR)
                        ->where('status_cd', Constants::CD_APPROVED);
                })->orWhere(function ($query) {
                    $query->where('role_cd', Constants::CD_ROLE_STUDENT)
                        ->where('status_cd', Constants::CD_IN_PROGRESS);
                });
            })
            ->when(isset($input['status_cd']), function ($query) use ($input) {
                if ($input['status_cd'] == Constants::CD_APPROVED) {
                    $query = $query->where('role_cd', Constants::CD_ROLE_TUTOR)
                        ->where('status_cd', Constants::CD_APPROVED);
                } else {
                    $query = $query->where('role_cd', Constants::CD_ROLE_STUDENT)
                        ->where('status_cd', Constants::CD_IN_PROGRESS);
                }
            })->get();

        return $tutors ? $tutors->toArray() : [];
    }
}
