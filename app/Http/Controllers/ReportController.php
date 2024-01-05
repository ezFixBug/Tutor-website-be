<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddReportRequest;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class ReportController extends Controller
{
    private $report_repo;

    public function __construct(ReportRepositoryInterface $report_repo, UserRepositoryInterface $user_repo)
    {
        $this->report_repo = $report_repo;
    }

    public function addReport(AddReportRequest $request)
    {
        $input = $request->all();

        $this->report_repo->addReport($input);

        return response()->json([
            'result' => true,
            'status' => 200
        ]);
    }

    public function getComments($relation_id)
    {
        list($comments, $total_count) = $this->report_repo->getCommentsByRelationId($relation_id);

        return response()->json([
            'result' => true,
            'status' => 200,
            'comments' => $comments,
            'total_count' => $total_count,
        ]);
    }
}
