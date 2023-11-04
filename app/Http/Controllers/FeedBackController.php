<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Repositories\Interfaces\FeedBackRepositoryInterface;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{
    private $feedback_repo;

    public function __construct(FeedBackRepositoryInterface $feedback_repo)
    {
        $this->feedback_repo = $feedback_repo;
    }

    public function getAllFeedback()
    {
        $feedbacks = $this->feedback_repo->getAllFeedback();

        return response()->json([
            'result' => true,
            'status' => 200,
            'feedbacks' => $feedbacks,
        ]);      
    }

    public function addFeedBack(FeedbackRequest $request)
    {
        $this->feedback_repo->addFeedBack($request->all());
        return response()->json([
            'result' => true,
            'status' => 200,
        ]);  
    }
}
