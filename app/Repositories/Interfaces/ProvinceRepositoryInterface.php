<?php

namespace App\Repositories\Interfaces;

interface ProvinceRepositoryInterface
{
    public function findProvinceById($province_id);
    
    public function getAllProvinces();

    public function getDistrictByProvince($province_id);
}
