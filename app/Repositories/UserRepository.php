<?php

namespace App\Repositories;

use App\Models\TeachPlace;
use App\Models\TeachPlaceDistricts;
use App\Models\TeachSubject;
use App\Models\TeachSubjectClasses;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Constants;

class UserRepository implements UserRepositoryInterface
{
    public function register($input)
    {
        $user_id = User::saveOrUpdateWithUuid($input);
        return User::withCount('likes')->find($user_id);
    }

    public function findUserByEmail($email)
    {
        $user = User::withCount('likes')->where('email', $email)->first();

        return $user ? $user->toArray() : [];
    }

    public function findUserById($id)
    {
        $user = User::with([
            'teachSubjects' => function ($query) {
                $query->with(['teachSubjectClasses.class', 'subject:id,name']);
            },
            'subjects',
            'provinces',
            'teachPlaces' => function ($query) {
                $query->with([
                    'teachPlaceDistricts.district', 'province:id,name'
                ]);
            },
            'job',
            'province',
            'district',
            'rating' => function ($query) {
                $query->with('user');
            }
        ])
        ->withCount('likes')
        ->withCount('courses')
        ->where('id', $id)->first();
        $user->rating_avg = 0;

        if ($user->rating->count() > 0) {
            foreach ($user->rating as $rating) {
                $user->rating_avg += $rating->rating;
            }
            $user->rating_avg /= count($user->rating);
        }
        return $user ? $user->toArray() : [];
    }

    public function updateUser($input)
    {
        User::saveOrUpdateWithUuid($input);
    }

    public function createTeachSubjectOfUser($data)
    {
        return TeachSubject::createOrUpdate($data);
    }

    public function createTeachSubjectClass($data)
    {
        return TeachSubjectClasses::createOrUpdate($data);
    }

    public function createTeachPlaceDistrict($data)
    {
        return TeachPlaceDistricts::createOrUpdate($data);
    }

    public function createTeachPlacesOfUser($data)
    {
        return TeachPlace::createOrUpdate($data);
    }

    public function searchTutorList($input)
    {
        $tutors = User::with('teachSubjects.teachSubjectClasses.class', 'teachSubjects.subject')
            ->where('role_cd', Constants::CD_ROLE_TUTOR)
            ->when(isset($input['subject_id']), function ($query) use ($input) {
                $query->whereHas('teachSubjects', function ($sub_query) use ($input) {
                    $sub_query->where('subject_id', $input['subject_id']);
                });
            })
            ->when(isset($input['class_id']), function ($query) use ($input) {
                $query->whereHas('teachSubjects.teachSubjectClasses', function ($sub_query) use ($input) {
                    $sub_query->where('class_id', $input['class_id']);
                }); 
            })
            ->when(isset($input['province_id']), function ($query) use ($input) {
                $query->where('province_id', $input['province_id']);
            })
            ->when(isset($input['district_id']), function ($query) use ($input) {
                $query->where('district_id', $input['district_id']);
            })
            ->when(isset($input['job_current_id']), function ($query) use ($input) {
                $query->where('job_current_id', $input['job_current_id']);
            })
            ->when(isset($input['sex']), function ($query) use ($input) {
                $query->where('sex', $input['sex']);
            })
            ->when(isset($input['type_cd']), function ($query) use ($input) {
                $query->where('type_cd', $input['type_cd']);
            })
            ->when(isset($input['price_order_type']), function ($query) use ($input) {
                if ($input['price_order_type'] === 1) {
                    $query->orderBy('price', 'asc');
                } else {
                    $query->orderBy('price', 'desc');
                }
            })
            ->paginate(8);

        return $tutors ? $tutors->toArray() : [];
    }
}