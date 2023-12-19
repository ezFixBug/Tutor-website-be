<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CouponRepositoryInterface;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    private $couponInteface;
    public function __construct(CouponRepositoryInterface $couponInteface)
    {
        $this->couponInteface = $couponInteface;
    }

    public function getList()
    {
        return $this->couponInteface->getList();
    }

    public function show(int $id)
    {
        return $this->couponInteface->getById($id);
    }

    public function getCouponByCode(string $code)
    {
        $coupon =  $this->couponInteface->getByCode($code);
        if (!$coupon) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy mã giảm giá'
            ], 403);
        }

        return response()->json([
            'result' => true,
            'status' => 200,
            'coupon' => $coupon,
        ]);
    }

    public function create(Request $request)
    {
        try {
            $this->couponInteface->create($request->all());
            return response()->json([
                'result' => true,
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function update(Request $request, int $id)
    {
        try {

            $this->couponInteface->update($id, $request->all());
            return response()->json([
                'result' => true,
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function delete(int $id)
    {
        try {

            $this->couponInteface->delete($id);
            return response()->json([
                'result' => true,
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
