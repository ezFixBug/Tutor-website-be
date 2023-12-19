<?php

namespace App\Repositories;

use App\Constants;
use App\Models\Coupon;
use App\Repositories\Interfaces\CouponRepositoryInterface;

class CouponRepository implements CouponRepositoryInterface
{
  public function getList()
  {
    $coupons = Coupon::all();
    return $coupons ? $coupons->toArray() : [];
  }

  public function getById(int $id)
  {
    return Coupon::findOrFail($id);
  }

  public function getByCode(string $code)
  {
    return Coupon::where('code', $code)->first();
  }

  public function create($data)
  {
    Coupon::create([
      'name' => $data['name'],
      'code' => $data['code'],
      'type' => $data['type'],
      'discount' => $data['discount'],
      'start_date' => $data['startDate'],
      'end_date' => $data['endDate'],
    ]);
  }

  public function update(int $id, array $data)
  {
    Coupon::findOrFail($id)->update([
      'name' => $data['name'],
      'code' => $data['code'],
      'type' => $data['type'],
      'discount' => $data['discount'],
      'start_date' => $data['startDate'],
      'end_date' => $data['endDate'],
    ]);
  }

  public function delete(int $id)
  {
    Coupon::findOrFail($id)->delete();
  }
}
