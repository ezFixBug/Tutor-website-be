<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    public function addComment($input)
    {
        $comment_id = Comment::saveOrUpdateWithUuid($input);

        return Comment::find($comment_id)->toArray();
    }

    public function getCommentsByRelationId($relation_id, $quantity_comment)
    {
        $query = Comment::with('user', 'childrenComments.user')
            ->where("relation_id", $relation_id)
            ->whereNull("parent_id");

        $total_count = $query->count();

        $comments = $query->limit($quantity_comment)
            ->orderBy("created_at", "desc")
            ->get();

        return $comments ? [$comments->toArray(), $total_count] : [];
    }
}