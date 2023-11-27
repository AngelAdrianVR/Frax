<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function index()
    {
        $payments = PaymentResource::collection(Payment::latest()->where('user_id', auth()->id())->get());

        // return $payments;
        return inertia('Payment/Index', compact('payments'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show(Payment $payment)
    {
        //
    }

   
    public function edit(Payment $payment)
    {
        //
    }

    
    public function update(Request $request, Payment $payment)
    {
        //
    }

    
    public function destroy(Payment $payment)
    {
        //
    }


    public function pay(Payment $payment)
    {
        return inertia('Payment/Pay', compact('payment'));
    }
}
