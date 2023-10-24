<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LikeRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'relation_id' => 'required|uuid',
            'user_id' => 'required|exists:users,id',
        ];
    }
}