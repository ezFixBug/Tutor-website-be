<?php
namespace App\Repositories;

use App\Models\Payments;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
  private $request_tutor_repo;
  public function __construct(RequestTutorRepository $request_tutor_repo)
  {
    $this->request_tutor_repo = $request_tutor_repo;
  }

  public function createPayment($data)
  {
    $offer_id = null;
    if ($data['user_id'] && $data['request_id']) {
      $offer = $this->request_tutor_repo->getOfferByRequestIdAndUserId($data['request_id'], $data['user_id']);
      $offer_id = $offer->id;
    }
    Payments::create([
      'user_id' => $data['user_id'],
      'register_course_id' => $data['register_course_id'] ?? null,
      'offer_request_id' => $offer_id,
      'amount' => $data['payment']['vnp_Amount'],
      'bank_code' => $data['payment']['vnp_BankCode'],
      'bank_transaction_no' => $data['payment']['vnp_BankTranNo'],
      'card_type' => $data['payment']['vnp_CardType'],
      'order_info' => $data['payment']['vnp_OrderInfo'],
      'pay_date' => $data['payment']['vnp_PayDate'],
      'response_code' => $data['payment']['vnp_PayDate'],
      'tmn_code' => $data['payment']['vnp_TmnCode'],
      'transaction_no' => $data['payment']['vnp_TransactionNo'],
      'transaction_status' => $data['payment']['vnp_TransactionStatus'],
      'txn_ref' => $data['payment']['vnp_TxnRef'],
      'secure_hash' => $data['payment']['vnp_SecureHash'],
      'status' => 1,
      'payment_type' => $data['payment_type'],
    ]);
  }
}
