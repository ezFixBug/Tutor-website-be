<?php

namespace App\Services;

use App\Constants;
use App\Repositories\PaymentRepository;
use Carbon\Carbon;

class PaymentService
{
  public function getVnPayUrl($data)
  {
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = $data['payment_type'] == Constants::PAYMENT_COURSE ? "http://localhost:8080/chi-tiet-khoa-hoc/" . $data['course_id'] : 'http://localhost:8080/chi-tiet-yeu-cau/' . $data['request_tutors_id'];
    $vnp_TmnCode = "97C1R16B";
    $vnp_HashSecret = "CTAWNGHKAEUFZPCFVUUPJBKTMZKBRQEG";

    $vnp_TxnRef = Carbon::now()->timestamp;
    $vnp_OrderInfo = $data['payment_type'] == Constants::PAYMENT_COURSE ? 'Thanh toán mua khoá học' : 'Thanh toán nhận học viên';
    $vnp_OrderType =  'billpayment';
    $vnp_Amount = $data['total_amount'] * 100;
    $vnp_Locale = 'vn';
    $vnp_BankCode = 'NCB';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

    $inputData = array(
      "vnp_Version" => "2.1.0",
      "vnp_TmnCode" => $vnp_TmnCode,
      "vnp_Amount" => $vnp_Amount,
      "vnp_Command" => "pay",
      "vnp_CreateDate" => date('YmdHis'),
      "vnp_CurrCode" => "VND",
      "vnp_IpAddr" => $vnp_IpAddr,
      "vnp_Locale" => $vnp_Locale,
      "vnp_OrderInfo" => $vnp_OrderInfo,
      "vnp_OrderType" => $vnp_OrderType,
      "vnp_ReturnUrl" => $vnp_Returnurl,
      "vnp_TxnRef" => $vnp_TxnRef
    );

    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
      $inputData['vnp_BankCode'] = $vnp_BankCode;
    }

    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
      if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
      } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
      }
      $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
      $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
      $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }

    return $vnp_Url;
  }

  public function getMomoUrl($data)
  {
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    $partnerCode = 'MOMOBKUN20180529';
    $accessKey = 'klm05TvNBzhg7h7j';
    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
    $orderInfo = 'Thanh toán tiền khoá học cho gia sư';
    if ($data['payment_type'] == Constants::PAYMENT_COURSE || $data['payment_type'] == Constants::PAYMENT_TUTOR) {
      $orderInfo = $data['payment_type'] == Constants::PAYMENT_COURSE
        ? 'Thanh toán mua khoá học'
        : 'Thanh toán nhận học viên';
    }
    $amount = $data['total_amount'];
    $orderId = time() . "";

    $redirectUrl = '';
    if (isset($data['redirect_url'])) {
      $redirectUrl = $data['redirect_url'];
    } else {
      $redirectUrl = $data['payment_type'] == Constants::PAYMENT_COURSE
        ? 'http://localhost:8080/chi-tiet-khoa-hoc/' . $data['course_id']
        : 'http://localhost:8080/chi-tiet-yeu-cau/' . $data['request_tutors_id'];
    }


    $ipnUrl = $redirectUrl;
    $extraData = "";

    $requestId = time() . "";
    $requestType = "payWithATM";

    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    $data = array(
      'partnerCode' => $partnerCode,
      'partnerName' => "Test",
      "storeId" => "MomoTestStore",
      'requestId' => $requestId,
      'amount' => $amount,
      'orderId' => $orderId,
      'orderInfo' => $orderInfo,
      'redirectUrl' => $redirectUrl,
      'ipnUrl' => $ipnUrl,
      'lang' => 'vi',
      'extraData' => $extraData,
      'requestType' => $requestType,
      'signature' => $signature
    );
    $result = $this->execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);  // decode json

    //Just a example, please check more in there

    return $jsonResult['payUrl'];
  }
  function execPostRequest($url, $data)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
      )
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
  }
}
