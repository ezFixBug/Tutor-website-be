<?php

namespace App\Repositories\Interfaces;

interface CouponRepositoryInterface
{
  public function getList();
  public function getById(int $id);
  public function getByCode(string $code);
  public function create($data);
  public function update(int $id, array $data);
  public function delete(int $id);
}
