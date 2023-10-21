<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'image' => 'required|string',
            'type_cd' => 'required|numeric',
            'title' => 'required|string',
            'description' => 'required|string',
            'content' => 'required|string',
            'tags' => 'required|array',
        ];
    }
}