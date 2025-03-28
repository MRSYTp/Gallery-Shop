<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Mail\sendOrderedImages;
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
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function pay(PaymentRequest $request)
    {   
        $validatedData = $request->validated();        

        DB::beginTransaction();
        try {

            
            $user = User::firstOrCreate([
                'email' => $validatedData['email'],
            ],[
                'name' => $validatedData['name'],
                'mobile' => $validatedData['mobile'],
            ]);

            $orders = json_decode(Cookie::get('basket'), true);

            if(is_null($orders))
            {
                return back();
            }

            $products = Product::findMany(array_keys($orders));
            
            $totalAmount = $products->sum('price');

            $refCode = Str::random(20);

            $createdOrder = Order::create([
                'user_id' => $user->id,
                'ref_id' => $refCode,
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
                'ref_id' => $refCode,
                'status' => 'unpaid',
            ]);
            DB::commit();
            
        // Gateway Payment

          //paying...

        //after payment

            DB::beginTransaction();
            Cookie::queue(Cookie::forget('basket'));

            $createdOrder->update([
                'status' => 'paid',
            ]);

            $createdPayment->update([
                'status' => 'paid',
            ]);


            $orderItems = $createdOrder->orderItems;

            $productsSourceImg = $orderItems->map(function ($item) {
                return storage_path('app/private_storage/'.$item->product->source_url);
            });

            
            Mail::to($validatedData['email'])->send(new sendOrderedImages($productsSourceImg->toArray()));

            DB::commit();
            return redirect()->route('frontend.payment.success-callback');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

    }

    public function successCallback()
    {

        return view('frontend.s-callback');
    }

    public function errorCallback()
    {
        return view('frontend.e-callback');
    }
}
