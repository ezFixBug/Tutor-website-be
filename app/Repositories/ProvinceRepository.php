<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ProvinceRepositoryInterface;


class ProvinceRepository implements ProvinceRepositoryInterface
{
    public function findProvinceById($province_id)
    {
        return \Kjmtrue\VietnamZone\Models\Province::where('id', $province_id)->first();
    }

    public function getAllProvinces()
    {
        $provinces = \Kjmtrue\VietnamZone\Models\Province::get();

        return $provinces->toArray();
    }

    
    public function getDistrictByProvince($province_id)
    {
        $districts = \Kjmtrue\VietnamZone\Models\District::whereProvinceId($province_id)->get();

        return $districts ? $districts->toArray() : [];
    }
}