<?php

namespace App\Http\Requests;


class CreateCourseRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'required|string',
            'title' => 'required|string',
            'sub_title'=> 'required|string',
            'price'=> 'nullable|numeric',
            'description'=> 'required|string',
            'type_cd'=> 'required|integer',
            'start_date' => 'required|date',
            'time_start'=> 'required',
            'province_id'=> 'required_if:type_cd,1',
            'district_id'=> 'required_if:type_cd,1',
            'street'=> 'required_if:type_cd,1',
            'link'=> 'required_if:type_cd,2',
            'content'=> 'required',
            'classes'=> 'required|array',
            'subjects'=> 'required|array',
            'tags' => 'required|array',
            'schedule'=> 'required|array',
        ];
    }
}
