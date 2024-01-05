<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $payment_interface;
    private $payment_service;

    public function __construct(
        PaymentRepositoryInterface $payment_interface,
        PaymentService $payment_service
    ) {
        $this->payment_interface = $payment_interface;
        $this->payment_service = $payment_service;
    }
    public function getVnPayment(Request $request)
    {
        $data = $request->all();
        return $this->payment_service->getVnPayUrl($data);
    }

    public function getMomoPayment(Request $request)
    {
        $data = $request->all();
        return $this->payment_service->getMomoUrl($data);
    }

    public function createPayment(Request $request)
    {
        $this->payment_interface->createPayment($request->all());
    }

    public function getHistories(Request $request)
    {
        return response()->json([
            'result' => true,
            'status' => 200,
            'data' => $this->payment_interface->getHistories($request->all()),
        ]);
    }

    public function statistics(Request $request)
    {
        return response()->json([
            'result' => true,
            'status' => 200,
            'data' => $this->payment_interface->statistics($request->all()),
        ]);
    }

    
}
