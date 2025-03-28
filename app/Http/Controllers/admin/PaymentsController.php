<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function all(Request $request)
    {
        $query = Payment::query();

        $payments = $query->paginate(10);
    
        if ($request->search) {

            $query->whereHas('order', function ($query) use ($request) {

                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });

            });

            $payments = $query->paginate(10);
        }
    
        return view('admin.payment-all', compact('payments'));
    }
}
