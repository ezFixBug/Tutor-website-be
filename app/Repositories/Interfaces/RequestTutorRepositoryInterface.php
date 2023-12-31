<?php

namespace App\Repositories\Interfaces;

use App\Models\RequestTutor;

interface RequestTutorRepositoryInterface
{
    public function createOrUpdateRequest($input);

    public function getRequestByUserId($user_id);

    public function getRequestById($id);

    public function getOfferDetail($id);

    public function getUserOfferByRequestId($request_id);
    
    public function deleteRequest($request_id);

    public function getAll($input);

    public function createOfferOfRequest($input);

    public function deleteOfferOfRequest($request_id);

    public function approveOfferOfRequest($request_id, $user_id);

    public function getRequested($user_id);

    public function getOfferStudent();
}
