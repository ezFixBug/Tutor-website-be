<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestTutorRequest;
use App\Repositories\Interfaces\RequestTutorRepositoryInterface;
use Illuminate\Http\Request;

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

        $this->request_tutor_repository->createOrUpdateRequest($input);

        return response()->json([
            'status' => 200,
            'result' => true
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
}
