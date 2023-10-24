<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCommentRequest;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $comment_repo;
    private $user_repo;

    public function __construct(CommentRepositoryInterface $comment_repo, UserRepositoryInterface $user_repo)
    {
        $this->comment_repo = $comment_repo;
        $this->user_repo = $user_repo;
    }

    public function addComment(AddCommentRequest $request)
    {
        $input = $request->all();
        
        $user = $this->user_repo->findUserById($input['user_id']);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy người dùng'
            ], 403);
        }

        $comment = $this->comment_repo->addComment($input);

        return response()->json([
            'result' => true,
            'status' => 200,
            'comment' => $comment,
        ]);
    }

    public function getComments(Request $request, $relation_id)
    {
        $quantity_comment = $request->input('quantity');

        list($comments, $total_count) = $this->comment_repo->getCommentsByRelationId($relation_id, $quantity_comment);

        return response()->json([
            'result' => true,
            'status' => 200,
            'comments' => $comments,
            'total_count' => $total_count,
        ]);
    }
}
