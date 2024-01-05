<?php

namespace App\Repositories\Interfaces;

interface ReportRepositoryInterface
{
    public function addReport($input);

    public function getCommentsByRelationId($relation_id);
}