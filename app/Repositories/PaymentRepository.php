<?php

namespace App\Repositories;

use App\Constants;
use App\Models\Payments;
use App\Models\Revenue;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\OfferRequest;
use App\Models\RegisterCourse;

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
    if ($data['user_id'] && isset($data['request_id'])) {
      $offer = $this->request_tutor_repo->getOfferByRequestIdAndUserId($data['request_id'], $data['user_id']);
      if (!$offer) {
        $offer = OfferRequest::where([
          'request_id' => $data['request_id'],
        ])
          ->orderBy('created_at', 'desc')
          ->first();
      }
      $offer_id = $offer->id;
    }
    $payment = $data['payment'];
    Payments::create([
      'user_id' => $data['user_id'],
      'register_course_id' => $data['register_course_id'] ?? null,
      'offer_request_id' => $offer_id,
      'amount' => isset($payment['vnp_Amount']) ? $payment['vnp_Amount'] / 100 : $payment['amount'],
      'bank_code' => isset($payment['vnp_BankCode']) ? $payment['vnp_BankCode'] : $payment['payType'],
      'bank_transaction_no' => isset($payment['vnp_BankTranNo']) ? $payment['vnp_BankTranNo'] : $payment['transId'],
      'card_type' => isset($payment['vnp_CardType']) ? $payment['vnp_CardType'] : $payment['paymentOption'],
      'order_info' => isset($payment['vnp_OrderInfo']) ? $payment['vnp_OrderInfo'] : $payment['orderInfo'],
      'pay_date' => isset($payment['vnp_PayDate']) ? $payment['vnp_PayDate'] : null,
      'response_code' => isset($payment['vnp_PayDate']) ? $payment['vnp_PayDate'] : null,
      'tmn_code' => isset($payment['vnp_TmnCode']) ? $payment['vnp_TmnCode'] : null,
      'transaction_no' => isset($payment['vnp_TransactionNo']) ? $payment['vnp_TransactionNo'] : $payment['transId'],
      'transaction_status' => isset($payment['vnp_TransactionStatus']) ? $payment['vnp_TransactionStatus'] : $payment['resultCode'],
      'txn_ref' => isset($payment['vnp_TxnRef']) ? $payment['vnp_TxnRef'] : $payment['orderId'],
      'secure_hash' => isset($payment['vnp_SecureHash']) ? $payment['vnp_SecureHash'] : $payment['signature'],
      'status' => 1,
      'payment_type' => $data['payment_type'],
    ]);

    if($data['payment_type'] == Constants::PAYMENT_COURSE){
      $register_course = RegisterCourse::with('course.user')->where('id', $data['register_course_id'])->first();
      Revenue::create([
        'user_id' => $register_course->course->user->id,
        'course_id' => $register_course->course->id,
        'amount' => isset($payment['vnp_Amount']) ? $payment['vnp_Amount'] / 100 : $payment['amount'],
        'status_cd' => Constants::STATUS_INACTIVE
      ]);
    }
  }

  public function getHistories($data)
  {
    $query = Payments::where([
      'user_id' => $data['user_id'],
      'payment_type' => $data['payment_type'],
    ]);

    if (isset($data['year'])) {
      $query->whereYear('created_at', $data['year']);
    }
    if (isset($data['month'])) {
      $query->whereMonth('created_at', $data['month']);
    }

    $payments = $query->get();

    $total_amount = 0;

    foreach ($payments ?? [] as $key => $payment) {
      $total_amount += $payment['amount'];
      if ($payment->payment_type == Constants::PAYMENT_COURSE) {
        $payments[$key]->register_course = $payment->registerCourse;
        $payments[$key]->register_course->course = $payments[$key]->register_course ? $payments[$key]->register_course->course : null;
        $payments[$key]->register_course->course->user = $payments[$key]->register_course->course ? $payments[$key]->register_course->course->user : null;
        $payments[$key]->register_course->user = $payments[$key]->register_course ? $payments[$key]->register_course->user : null;
      } else {
        $payments[$key]->register_offer = $payment->registerOffer;
        if ($payment->registerOffer && $payment->registerOffer->request) {
          $payments[$key]->register_offer->request = $payment->registerOffer->request;
        }
      }
    }

    return [
      'total_amount' => $total_amount,
      'payment' => $payments ? $payments->toArray() : [],
    ] ?? [];
  }
  public function statistics($data)
  {
    $query = Payments::where([
      'user_id' => $data['user_id']
    ]);

    if (isset($data['year'])) {
      $query->whereYear('created_at', $data['year']);
    }
    if (isset($data['month'])) {
      $query->whereMonth('created_at', $data['month']);
    }

    $payments = $query->get();

    $amount_spent = 0;
    $total_revenue = 0;

    foreach ($payments ?? [] as $payment) {
      $amount_spent += $payment['amount'];
    }

    $all_payment_query = Payments::orderBy('created_at');

    if (isset($data['year'])) {
      $all_payment_query->whereYear('created_at', $data['year']);
    }
    if (isset($data['month'])) {
      $all_payment_query->whereMonth('created_at', $data['month']);
    }

    $all_payment = $all_payment_query->get();
    foreach ($all_payment ?? [] as $payment) {
      if (
        $payment->payment_type == Constants::PAYMENT_COURSE
        && $payment
        && $payment->registerCourse
        && $payment->registerCourse->course
        && $payment->registerCourse->course->user_id == $data['user_id']
      ) {
        $total_revenue += $payment->amount;
      }
    }

    return [
      'amount_spent' => $amount_spent,
      'total_revenue' => $total_revenue
    ];
  }
}
