<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
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

            $products = Product::findMany(array_keys($orders));
            
            $totalAmount = $products->sum('price');

            $refId = Str::random(20);

            $createdOrder = Order::create([
                'user_id' => $user->id,
                'ref_id' => $refId,
                'amount' => $totalAmount,
                'status' => 'unpaid',
            ]);

            $orderItems = $products->map(function ($product) {
                $currentProduct = $product->only('id', 'price');
                $currentProduct['product_id'] = $currentProduct['id'];
                unset($currentProduct['id']);
                return $currentProduct;
            });

            $createdOrder->orderItems()->createMany($orderItems->toArray());


            $refId = rand(10000000, 99999999);


            $createdPayment = Payment::create([
                'order_id' => $createdOrder->id,
                'gateway' => 'idpay',
                'res_id' => $refId,
                'ref_id' => $refId,
                'status' => 'unpaid',
            ]);
            DB::commit();
            return back()->with('success', 'پرداخت با موفقیت انجام شد');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

        // $paymentService = new PaymentService(PaymentService::IDPAY, new IDPayRequest());
        // echo $paymentService->pay();
    }
}
