<?php

namespace App\Http\Controllers;

use App\Models\RatingCourse;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    private $ratingInterface;
    
    public function __construct(RatingRepositoryInterface $ratingInterface)
    {
        $this->ratingInterface = $ratingInterface;
    }
    public function createRatingCourse(Request $request)
    {
        try {
            $this->ratingInterface->ratingCourse($request);
            return response()->json([
                'result' => true,
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function createRatingTutor(Request $request)
    {
        try {
            $this->ratingInterface->ratingTutor($request);
            return response()->json([
                'result' => true,
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
