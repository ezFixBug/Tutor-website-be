<?php

namespace App\Repositories;
use App\Models\Job;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;


class PostRepository implements PostRepositoryInterface
{
    public function getPostsByUserId($user_id)
    {
        $posts = Post::where('user_id', $user_id)->get();
        
        return $posts ? $posts->toArray() : [];
    }

    public function createOrUpdatePost($data)
    {
        return Post::saveOrUpdateWithUuid($data);
    }

    public function getPostById($post_id)
    {
        $post = Post::with('user')->find($post_id);

        return $post ? $post->toArray() : null;
    }

    public function deletePost($post_id)
    {
        return Post::where('id', '=', $post_id)->delete();
    }
}