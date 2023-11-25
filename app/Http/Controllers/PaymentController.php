<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Payments;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function getVnPayment(Request $request)
    {
        $data = $request->all();
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = $data['payment_type'] == Constants::PAYMENT_COURSE ? "http://localhost:8080/chi-tiet-khoa-hoc/" . $data['course_id'] : 'http://localhost:8080';
        $vnp_TmnCode = "97C1R16B";
        $vnp_HashSecret = "CTAWNGHKAEUFZPCFVUUPJBKTMZKBRQEG";

        $vnp_TxnRef = Carbon::now()->timestamp;
        $vnp_OrderInfo = $data['payment_type'] == Constants::PAYMENT_COURSE ? 'Thanh toán mua khoá học' : 'Thanh toán nhận lớp';
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

    public function createPayment(Request $request)
    {
        $data = $request->all();
        Payments::create([
            'user_id' => $data['user_id'],
            'register_course_id' => $data['register_course_id'],
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
