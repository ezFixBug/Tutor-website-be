<?php

namespace App\Repositories;

use App\Constants;
use App\Models\Coupon;
use App\Models\RatingCourse;
use App\Repositories\Interfaces\RatingRepositoryInterface;

class RatingRepository implements RatingRepositoryInterface
{
  public function create($data)
  {
    RatingCourse::create([
      'course_id' => $data->route('course_id'),
      'user_id' => $data->user_id,
      'rating' => $data->rating,
      'comment' => $data->comment,
  ]);
  }
}
