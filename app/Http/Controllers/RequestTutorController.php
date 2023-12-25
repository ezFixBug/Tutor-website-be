<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestTutorRequest;
use App\Repositories\Interfaces\RequestTutorRepositoryInterface;
use Illuminate\Http\Request;
use App\Constants;

class RequestTutorController extends Controller
{
    private $request_tutor_repository;

    public function __construct(RequestTutorRepositoryInterface $request_tutor_repository)
    {
        $this->request_tutor_repository = $request_tutor_repository;
    }

    public function createRequest(RequestTutorRequest $request)
    {
        $input = $request->all();

        $request_id = $this->request_tutor_repository->createOrUpdateRequest($input);

        if (isset($input['tutor_id'])) {
            $data = [
                'request_id' => $request_id,
                'user_id' => $input['tutor_id'],
                'status_cd' => Constants::CD_OFFER_REQUEST_APPROVE,
                'status_student_cd' => Constants::CD_OFFER_REQUEST_DEFAULT,
            ];
            $this->request_tutor_repository->createOfferOfRequest($data);
        }

        return response()->json([
            'status' => 200,
            'result' => true,
            'request_id' => $request_id
        ], 200);
    }

    public function getRequestOfUser($user_id)
    {
        $requests = $this->request_tutor_repository->getRequestByUserId($user_id);

        return response()->json([
            'status' => 200,
            'result' => true,
            'requests' => $requests
        ], 200);
    }

    public function getDetailRequest($request_id)
    {
        $request = $this->request_tutor_repository->getRequestById($request_id);

        if (!$request) {
            return response()->json([
                'status' => 404,
                'result' => true,
                'message' => 'Không tìm thấy yêu cầu gia sư!'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'result' => true,
            'request' => $request
        ], 200);
    }

    public function getOfferOfRequest($request_id)
    {
        $users = $this->request_tutor_repository->getUserOfferByRequestId($request_id);

        return response()->json([
            'status' => 200,
            'result' => true,
            'users' => $users
        ], 200);
    }
    
    public function getOfferDetail($id)
    {
        $offer = $this->request_tutor_repository->getOfferDetail($id);

        return response()->json([
            'status' => 200,
            'result' => true,
            'offer' => $offer
        ], 200);
    }

    public function deleteRequest($request_id)
    {
        $request = $this->request_tutor_repository->getRequestById($request_id);

        if (!$request) {
            return response()->json([
                'status' => 404,
                'result' => true,
                'message' => 'Không tìm thấy yêu cầu gia sư!'
            ], 404);
        }

        $this->request_tutor_repository->deleteRequest($request_id);

        return response()->json([
            'status' => 200,
            'result' => true,
        ], 200);
    }

    public function getRequests(Request $request)
    {
        $input = $request->all();

        $data = $this->request_tutor_repository->getAll($input);

        $paginate = [
            'current_page' => $data['current_page'],
            'next_page' => $data['next_page_url'],
            'prev_page' => $data['prev_page_url'],
            'total_pages' => $data['last_page'],
            'total_count' => $data['total'],
        ];

        return response()->json([
            'result' => true,
            'status' => 200,
            'requests' => $data['data'],
            'paginate' => $paginate,
        ]);
    }

    public function createOfferRequest(Request $request, $request_id)
    {
        $input = $request->all();

        $input['request_id'] = $request_id;

        $this->request_tutor_repository->createOfferOfRequest($input);

        return response()->json([
            'status' => 200,
            'result' => true,
        ], 200);
    }

    public function cancelOffer($request_id)
    {
        $this->request_tutor_repository->deleteOfferOfRequest($request_id);

        return response()->json([
            'status' => 200,
            'result' => true,
        ], 200);
    }

    public function approveOffer($request_id, Request $request)
    {
        $data = $request->all();
        $user_id = $data['user_id'];
        return $this->request_tutor_repository->approveOfferOfRequest($request_id, $user_id);
    }

    public function getRequested($user_id)
    {
        $requests = $this->request_tutor_repository->getRequested($user_id);

        return response()->json([
            'status' => 200,
            'result' => true,
            'requests' => $requests
        ], 200);
    }

    public function getOfferStudent()
    {
        $offers = $this->request_tutor_repository->getOfferStudent();

        return response()->json([
            'status' => 200,
            'result' => true,
            'offers' => $offers
        ], 200);
    }

    public function approveOfferStudent(Request $request) 
    {
        $input = $request->all();

        $offer = $this->request_tutor_repository->getOfferDetail($input['offer_id'])->toArray();

        $offer['status_cd'] = Constants::CD_OFFER_REQUEST_APPROVE;
        $offer['status_student_cd'] = Constants::CD_OFFER_REQUEST_APPROVE;

        $this->request_tutor_repository->createOfferOfRequest($offer);

        return response()->json([
            'status' => 200,
            'result' => true,
        ], 200);
    }
}
