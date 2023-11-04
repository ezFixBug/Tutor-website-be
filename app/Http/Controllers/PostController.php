<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\LikeRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Traits\HandleLikeTrait;
use Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{    
    use HandleLikeTrait;

    private $user_repo;

    private $post_repo;

    public function __construct(UserRepositoryInterface $user_repo, PostRepositoryInterface $post_repo)
    {
        $this->user_repo = $user_repo;
        $this->post_repo = $post_repo;
    }

    public function getAllPosts(Request $request)
    {
        $input = $request->all();

        $data = $this->post_repo->getAllPosts($input);

        $paginate = [
            'current_page' => $data['current_page'],
            'next_page' => $data['next_page_url'],
            'prev_page' => $data['prev_page_url'],
            'total_pages' => $data['last_page'],
        ];

        return response()->json([
            'result' => true,
            'status' => 200,
            'posts' => $data['data'],
            'paginate' => $paginate,
        ]);      
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

        $post['is_like'] = $this->checkLike($post_id, Auth::id());

        $this->post_repo->increaseViewsOfPost($post);

        $related_posts = $this->post_repo->getRelatedPosts($post);

        return response()->json([
            'result' => true,
            'status' => 200,
            'post' => $post,
            'related_posts' => $related_posts,
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

    public function deletePost($post_id)
    {
        $post = $this->post_repo->getPostById($post_id);

        if (!$post) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy bài viết'
            ], 404);
        }

        if(!$this->post_repo->deletePost($post_id)) {
            return response()->json([
                'status' => 403,
                'message' => 'Xóa bài viết không thành công'
            ], 403);
        }

        return response()->json([
            'result' => true,
            'status' => 200,
        ]);
    }

    public function hanleLike(LikeRequest $request)
    {
        $input = $request->all();

        $post = $this->post_repo->getPostById($input['relation_id']);

        if (!$post) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy bài viết'
            ], 404);
        }
        
        $this->handleLike($input);

        return response()->json([
            'result' => true,
            'status' => 200,
        ]);
    }
}
