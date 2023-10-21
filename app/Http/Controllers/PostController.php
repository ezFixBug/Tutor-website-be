<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{    
    private $user_repo;

    private $post_repo;

    public function __construct(UserRepositoryInterface $user_repo,PostRepositoryInterface $post_repo)
    {
        $this->user_repo = $user_repo;
        $this->post_repo = $post_repo;
    }

    public function getPostsByUser($user_id)
    {
        $user = $this->user_repo->findUserById($user_id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy người dùng'
            ], 403);
        }

        $posts = $this->post_repo->getPostsByUserId($user_id);

        return response()->json([
            'result' => true,
            'status' => 200,
            'posts' => $posts,
        ]);
    }

    public function createPostByUser(CreatePostRequest $request, $user_id)
    {
        $user = $this->user_repo->findUserById($user_id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy người dùng'
            ], 404);
        }

        $input = $request->all();
        $input['user_id'] = $user_id;

        $post = $this->post_repo->createOrUpdatePost($input);

        return response()->json([
            'result' => true,
            'status' => 200,
            'post' => $post,
        ]);
    }

    public function getPostDetail($post_id)
    {
        $post = $this->post_repo->getPostById($post_id);

        if (!$post) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy bài viết'
            ], 404);
        }

        return response()->json([
            'result' => true,
            'status' => 200,
            'post' => $post,
        ]);
    }

    public function editPost(CreatePostRequest $request, $post_id)
    {
        $post = $this->post_repo->getPostById($post_id);

        if (!$post) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy bài viết'
            ], 404);
        }

        $input = $request->all();

        $post = $this->post_repo->createOrUpdatePost($input);

        return response()->json([
            'result' => true,
            'status' => 200,
            'post' => $post,
        ]);
    }
}
