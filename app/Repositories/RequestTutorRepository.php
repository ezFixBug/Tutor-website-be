<?php

namespace App\Repositories;

use App\Models\OfferRequest;
use App\Models\RequestTutor;
use App\Repositories\Interfaces\RequestTutorRepositoryInterface;

class RequestTutorRepository implements RequestTutorRepositoryInterface
{
    public function createOrUpdateRequest($input)
    {
        return RequestTutor::saveOrUpdateWithUuid($input);
    }

    public function getRequestByUserId($user_id)
    {
        $requests = RequestTutor::with('user', 'class', 'subject')
            ->where('user_id', $user_id)
            ->get();

        return $requests ? $requests->toArray() : [];
    }

    public function getRequestById($id)
    {
        return RequestTutor::with('user.district', 'user.province', 'class', 'subject')->find($id);
    }

    public function getUserOfferByRequestId($request_id)
    {
        $users_offer = OfferRequest::where('request_id', $request_id)
            ->join('users', 'offer_requests.user_id', 'users.id')
            ->select('users.*')
            ->get();
        
        return $users_offer ? $users_offer->toArray() : [];
    }

    public function deleteRequest($request_id)
    {
        RequestTutor::where('id', $request_id)->delete();
    }

    public function getAll($input)
    {
        $requests = RequestTutor::with('user.province', 'class', 'subject')
            ->when(isset($input['subject_id']), function ($query) use ($input) {
                $query->where('subject_id', $input['subject_id']);
            })
            ->when(isset($input['class_id']), function ($query) use ($input) {
                $query->where('class_id', $input['class_id']);
            })
            ->when(isset($input['course_type_cd']), function ($query) use ($input) {
                $query->where('course_type_cd', $input['course_type_cd']);
            })
            ->paginate(6);

        return $requests ? $requests->toArray() : [];
    }
}
