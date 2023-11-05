<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestTutorRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=> 'required|string',
            'subject_id' => 'required|integer',
            'class_id'=> 'required|integer',
            'course_type_cd'=> 'required|integer',
            'num_day_per_week'=> 'required|integer',
            'num_hour_per_day'=> 'required|integer',
            'num_student'=> 'required|integer',
            'price'=> 'required|integer',
            'sex'=> 'required|integer',
            'description'=> 'required|string',
            'schedule' => 'required|array',
        ];
    }
}
