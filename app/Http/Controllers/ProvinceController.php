<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;

class ProvinceController extends Controller
{
    private $province_repository;

    public function __construct(ProvinceRepository $province_repository)
    {
        $this->province_repository = $province_repository;
    }
    
    public function getAllProvinces()
    {
        $provinces = $this->province_repository->getAllProvinces();
        
        return response()->json([
            'status' => 200,
            'provinces' => $provinces,
        ]);
    }

    public function getDistrictByProvince($province_id)
    {
        if (!$province = $this->province_repository->findProvinceById($province_id)){
            return response()->json([
                'status' => 404,
                'message' => "Not found district",
            ]);
        }

        $districts = $this->province_repository->getDistrictByProvince($province_id);
        
        return response()->json([
            'status' => 200,
            'province_name' => $province->name,
            'districts' => $districts,
        ]);
    }
}
