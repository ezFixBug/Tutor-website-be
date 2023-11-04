<?php

namespace App\Traits;
use App\Models\Like;


trait HandleLikeTrait
{
    public function handleLike($input)
    {
        $is_like = $this->checkLike($input['relation_id'], $input['user_id']);
        
        if ($is_like) {
            Like::where('relation_id', $input['relation_id'])
                ->where('user_id', $input['user_id'])
                ->delete();

        } else {
            Like::saveOrUpdateWithUuid($input);
        }
    }

    public function checkLike($relation_id, $user_id)
    {
        return Like::where('relation_id', $relation_id)
            ->where('user_id', $user_id)
            ->exists();
    }

    public function getListLiked($user_id)
    {
        $results = Like::with('course.user', 'post.user')->where('user_id', $user_id)->get();

        return $results ? $results->toArray() : [];
    }
}
