<?php

namespace App\Repositories\Interfaces;

use App\Models\FeedBack;

interface FeedBackRepositoryInterface
{
    public function getAllFeedback();

    public function addFeedback($input);
}
