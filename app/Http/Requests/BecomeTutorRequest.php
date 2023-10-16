<?php

namespace App\Http\Requests;


class BecomeTutorRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:users,id',
            'full_name' => 'required|string',
            'avatar' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'district_id' => 'required|exists:districts,id',
            'street' => 'required|string',
            'birthday' => 'required|date',
            'sex' => 'required|integer|min:1|max:2',
            'education' => 'required|string',
            'job_current_id' => 'required|exists:jobs,id',
            'certificate' => 'required|string',
            'front_citizen_card' => 'required|string',
            'back_citizen_card' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'type_cd' => 'required|integer|min:1|max:2',
            'listCityDistricts' => 'required|array',
            'listSubjectClasses' => 'required|array',
            'listSubjectClasses.*.subject' => 'required|exists:subjects,id',
            'listSubjectClasses.*.classes' => 'required|array',
        ];
    }
}
