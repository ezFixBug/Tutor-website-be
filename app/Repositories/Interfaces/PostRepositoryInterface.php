<?php

namespace App\Repositories\Interfaces;

interface PostRepositoryInterface
{
    public function getPostsByUserId($user_id);

    public function createOrUpdatePost($data);

    public function getPostById($post_id);

    public function deletePost($post_id);

    public function getAllPosts($input);

    public function getRelatedPosts($post);

    public function increaseViewsOfPost($post);
}