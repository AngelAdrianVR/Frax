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

        return inertia('Payment/Index', compact('payments'));
    }

    
    public function adminIndex()
    {
        $payments = PaymentResource::collection(Payment::latest()->where('frax_id', auth()->user()->frax_id)->get());

        return inertia('Payment/AdminIndex', compact('payments'));
    }

    
    public function create()
    {
        return inertia('Payment/Create');
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


    public function pay($payment_id)
    {
        $payment = PaymentResource::make(Payment::find($payment_id));
        
        return inertia('Payment/Pay', compact('payment'));
    }


    public function feedback()
    {     
        return inertia('Payment/Feedback');
    }
}
