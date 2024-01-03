<?php

namespace App\Repositories\Interfaces;

interface PaymentRepositoryInterface
{
  public function createPayment($data);
  public function getHistories($data);
  public function statistics($data);
}
