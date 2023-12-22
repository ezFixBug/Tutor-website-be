<?php

namespace App\Repositories;

use App\Constants;
use App\Models\Coupon;
use App\Models\RatingCourse;
use App\Models\RatingTutor;
use App\Repositories\Interfaces\RatingRepositoryInterface;

class RatingRepository implements RatingRepositoryInterface
{
  public function ratingCourse($data)
  {
    RatingCourse::create([
      'course_id' => $data->route('course_id'),
      'user_id' => $data->user_id,
      'rating' => $data->rating,
      'comment' => $data->comment,
    ]);
  }
  public function ratingTutor($data)
  {
    RatingTutor::create([
      'tutor_id' => $data->route('id'),
      'user_id' => $data->user_id,
      'rating' => $data->rating,
      'comment' => $data->comment,
    ]);
  }
}
