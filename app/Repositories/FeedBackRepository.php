<?php

namespace App\Repositories;

use App\Models\FeedBack;
use App\Repositories\Interfaces\FeedBackRepositoryInterface;

class FeedBackRepository implements FeedBackRepositoryInterface
{
    public function getAllFeedback()
    {
        return FeedBack::orderBy("created_at","desc")->get()->toArray();
    }

    public function addFeedback($input)
    {
        return FeedBack::saveOrUpdateWithUuid($input);
    }
}
