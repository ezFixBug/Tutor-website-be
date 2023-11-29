<?php

namespace App\Repositories;

use App\Constants;
use App\Models\OfferRequest;
use App\Models\RequestTutor;
use App\Repositories\Interfaces\RequestTutorRepositoryInterface;
use Auth;

class RequestTutorRepository implements RequestTutorRepositoryInterface
{
    public function createOrUpdateRequest($input)
    {
        return RequestTutor::saveOrUpdateWithUuid($input);
    }

    public function getRequestByUserId($user_id)
    {
        $requests = RequestTutor::with('user', 'class', 'subject')
            ->withCount('offers')
            ->where('user_id', $user_id)
            ->get();

        return $requests ? $requests->toArray() : [];
    }

    public function getRequestById($id)
    {
        $result = RequestTutor::with('user.district', 'user.province', 'class', 'subject')->withCount('offers')->find($id);
        $result->is_requested = $this->isRequested($result->id);
        $result->offer_request = $this->getOfferByRequestIdAndUserId($result->id, Auth::id());
        return $result ? $result->toArray() : [];
    }

    public function getUserOfferByRequestId($request_id)
    {
        $users_offer = OfferRequest::where('request_id', $request_id)
            ->join('users', 'offer_requests.user_id', 'users.id')
            ->select('users.*', 'offer_requests.status_cd as offer_status_cd')
            ->get();

        return $users_offer ? $users_offer->toArray() : [];
    }

    public function getOfferByRequestIdAndUserId($request_id, $user_id)
    {
        return OfferRequest::where([
            'user_id' => $user_id,
            'request_id' => $request_id
        ])->first();
    }
    public function getOfferDetail($id)
    {
        return OfferRequest::with('request')->find($id);
    }
    public function deleteRequest($request_id)
    {
        RequestTutor::where('id', $request_id)->delete();
    }

    public function getAll($input)
    {
        $requests = RequestTutor::with('user.province', 'class', 'subject')
            ->withCount('offers')
            ->when(isset($input['subject_id']), function ($query) use ($input) {
                $query->where('subject_id', $input['subject_id']);
            })
            ->when(isset($input['class_id']), function ($query) use ($input) {
                $query->where('class_id', $input['class_id']);
            })
            ->when(isset($input['course_type_cd']), function ($query) use ($input) {
                $query->where('course_type_cd', $input['course_type_cd']);
            })
            // ->whereDoesntHave('offers', function ($query) {
            //     $query->where('status_cd', Constants::CD_OFFER_REQUEST_APPROVE);
            // })
            ->paginate(6);

        $requests->each(function ($request) {
            $request->is_requested = $this->isRequested($request->id);
            $request->offer_request = $this->getOfferByRequestIdAndUserId($request->id, Auth::id());
        });

        return $requests ? $requests->toArray() : [];
    }

    public function createOfferOfRequest($input)
    {
        OfferRequest::saveOrUpdateWithUuid($input);
    }

    public function deleteOfferOfRequest($request_id)
    {
        OfferRequest::where('request_id', $request_id)->where('user_id', Auth::id())->delete();
    }

    public function approveOfferOfRequest($request_id, $user_id)
    {
        $offer = OfferRequest::where('request_id', $request_id)->where('user_id', $user_id)->first();
        $offer->update([
            'status_cd' => Constants::CD_OFFER_REQUEST_APPROVE,
        ]);
        return $offer;
    }

    private function isRequested($request_id)
    {
        return OfferRequest::where('request_id', $request_id)->where('user_id', Auth::id())->where('status_cd', 1)->exists();
    }

    public function getRequested($user_id)
    {
        $requests = RequestTutor::with('subject', 'class', 'user', 'offers')
            ->whereHas('offers', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->get();

        return $requests ? $requests->toArray() : [];
    }
}
