<?php

namespace App\Repositories;

use App\Models\Like;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function getPostsByUserId($user_id)
    {
        $posts = Post::where('user_id', $user_id)->withCount('likes')->get();

        return $posts ? $posts->toArray() : [];
    }

    public function createOrUpdatePost($data)
    {
        return Post::saveOrUpdateWithUuid($data);
    }

    public function getPostById($post_id)
    {
        $post = Post::with('user')->withCount('likes')->find($post_id);

        return $post ? $post->toArray() : null;
    }

    public function deletePost($post_id)
    {
        return Post::where('id', '=', $post_id)->delete();
    }

    public function getAllPosts($input)
    {
        $result = Post::with('user')
            ->withCount('likes')
            ->when(isset($input['type_cd']), function ($query) use ($input) {
                return $query->where('type_cd', '=', $input['type_cd']);
            })->paginate(6);

        return $result ? $result->toArray() : [];
    }

    public function getRelatedPosts($post)
    {
        $result = Post::with('user')
            ->where('id', '!=', $post['id'])
            ->where(function ($query) use ($post) {
                $query->where('type_cd', '=', $post['type_cd'])
                    ->orWhereJsonContains('tags', $post['tags']);
            })
            ->limit(6)
            ->get();

        return $result ? $result->toArray() : [];
    }

    public function increaseViewsOfPost($post)
    {
        $current_view = $post['view'];
        $view = $current_view + 1;
        
        Post::find($post['id'])->update(['view' => $view]);
    }
}