<?php

namespace App\Repositories;

use App\Models\Report;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use Auth;

class ReportRepository implements ReportRepositoryInterface
{

  public function addReport($input){
    Report::create([
      'user_id' => Auth::id(),
      'relation_id' => $input['relation_id'],
      'reason' => isset($input['reason']) ? $input['reason'] : null,
      'type' => $input['type'],
    ]);
  }

  public function getCommentsByRelationId($relation_id){}
}
