<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\VerifyPaymentRequest;
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


            Payment::create([
                'order_id' => $createdOrder->id,
                'gateway' => 'idpay',
                'res_id' => $refId,
                'ref_id' => $refCode,
                'status' => 'unpaid',
            ]);
            DB::commit();

            session(['totalPrice' => $totalAmount]);
            session(['ref_code' => $refCode]);
            session(['user_email' => $validatedData['email']]);
            return redirect()->route('frontend.payment.gateway');


        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

    }

    public function gateway()
    {   
        $totalPrice = session('totalPrice' , null);
        if (($totalPrice === null)) {
            return back()->with('error', 'مشکلی در رفتن به درگاه پرداخت پیش امده دوباره تلاش کنید.');
        }
        return view('frontend.sample-gateway',compact('totalPrice'));
    }

    public function callback(VerifyPaymentRequest $request)
    {   

        $validatedData = $request->validated();
        $totalPrice = session('totalPrice');
        $refCode = session('ref_code');
        $email = session('user_email');
        if ($totalPrice != $validatedData['amount']) {
            return view('frontend.e-callback');
        }

        DB::beginTransaction();
        try {

            Cookie::queue(Cookie::forget('basket'));
    
            $currentPayment = Payment::where('ref_id' , $refCode)->first();

            $currentPayment->update(['status' => 'paid']);
            $currentPayment->order()->update(['status' => 'paid']);

            $productsSourceImg = $currentPayment->order->orderItems->map(function ($item) {
                return storage_path('app/private_storage/'.$item->product->source_url);
            });
    
            Mail::to($email)->send(new sendOrderedImages($productsSourceImg->toArray()));
    
            DB::commit();
            
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());

        }


        return view('frontend.s-callback');
    }
}