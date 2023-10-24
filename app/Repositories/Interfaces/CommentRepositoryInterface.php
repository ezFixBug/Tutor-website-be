<?php

namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface
{
    public function addComment($input);

    public function getCommentsByRelationId($relation_id, $quantity_comment);
}