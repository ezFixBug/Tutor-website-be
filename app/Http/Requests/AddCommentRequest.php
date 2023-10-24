<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCommentRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'relation_id'=> 'required|uuid',
            'user_id'=> 'required|exists:users,id',
            'parent_id'=> 'nullable|exists:comments,id',
            'content' => 'required|string',
        ]; 
    }
}
