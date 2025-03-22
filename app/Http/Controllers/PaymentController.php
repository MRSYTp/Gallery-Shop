<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\Payment\PaymentService;
use App\Services\Payment\Requests\IDPayRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function pay(PaymentRequest $request)
    {   
        $validatedData = $request->validated();

        $user = User::firstOrCreate([
            'email' => $validatedData['email'],
        ],[
            'name' => $validatedData['name'],
            'mobile' => $validatedData['mobile'],
        ]);


        DB::beginTransaction();
        try {

            $orders = json_decode(Cookie::get('basket'), true);

            $totalAmount = array_sum(array_column($orders, 'price'));

            $refId = Str::random(20);

            $createdOrder = Order::create([
                'user_id' => $user->id,
                'ref_id' => $refId,
                'amount' => $totalAmount,
                'status' => 'unpaid',
            ]);

            
            DB::commit();
            dd($createdOrder);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        // $paymentService = new PaymentService(PaymentService::IDPAY, new IDPayRequest());
        // echo $paymentService->pay();
    }
}
