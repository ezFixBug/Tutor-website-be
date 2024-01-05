<?php

namespace App\Http\Requests;


class AddReportRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'relation_id'=> 'required|uuid',
            'user_id'=> 'required|exists:users,id',
            'reason' => 'required_if:type,4|string|string',
        ]; 
    }
}
