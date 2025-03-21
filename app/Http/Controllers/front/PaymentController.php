<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentService;
use App\Services\Payment\Requests\IDPayRequest;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay()
    {
        $paymentService = new PaymentService(PaymentService::IDPAY, new IDPayRequest());
        echo $paymentService->pay();
    }
}
