<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use Hash;
use JWTAuth;
use Constants;
use PhpParser\Node\Stmt\Continue_;

class UserService
{
    private $user_repo;

    public function __construct(UserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function register($input)
    {
        $input['password'] = Hash::make($input['password']);

        $user = $this->user_repo->register($input);

        $token = JWTAuth::fromUser($user);

        return [$user, $token];
    }

    public function registTutor($input)
    {
        $user_id = $input['id'];
        $input['status_cd'] = Constants::CD_IN_PROGRESS;

        $this->user_repo->updateUser($input);

        $list_subject_class = $input['listSubjectClasses'] ?? [];
        if (!empty($list_subject_class)) {
            foreach ($list_subject_class as $subject_class) {
                $subject_id = $subject_class['subject'] ?? null;

                if (!$subject_id) continue;

                $list_class = $subject_class['classes'] ?? [];

                $teach_subject = $this->user_repo->createTeachSubjectOfUser([
                    'user_id' => $user_id,
                    'subject_id' => $subject_id,
                ]);

                foreach ($list_class as $class_id) {
                    $data = [
                        'teach_subject_id' => $teach_subject->id,
                        'class_id' => $class_id
                    ];
                    $this->user_repo->createTeachSubjectClass($data);
                }
            }
        }

        $list_teach_places = $input['listCityDistricts'] ?? [];
        if (!empty($list_teach_places)) {
            foreach ($list_teach_places as $place) {
                $province_id = $place['city'] ?? null;

                $teach_place = $this->user_repo->createTeachPlacesOfUser([
                    'user_id' => $user_id,
                    'province_id' => $province_id,
                ]);

                $list_district = $place['districts'] ?? [];
                foreach ($list_district as $district_id) {
                    $data = [
                        'teach_place_id' => $teach_place->id,
                        'district_id' => $district_id
                    ];
                    $this->user_repo->createTeachPlaceDistrict($data);
                }
            }
        }

        return $this->user_repo->findUserById($user_id);
    }
}
