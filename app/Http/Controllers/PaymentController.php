<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentTicketResource;
use App\Models\Payment;
use App\Models\PaymentTicket;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function index()
    {
        $payments = PaymentResource::collection(Payment::latest()->where('user_id', auth()->id())->get());
        
        $paymentTickets = PaymentTicketResource::collection(
            PaymentTicket::with('payment')->whereHas('payment', function ($query) {
                $query->where('user_id', auth()->id());
            })->latest()->get()
        );

        // return $paymentTickets;
        return inertia('Payment/Index', compact('payments', 'paymentTickets'));
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


    public function pay($payment_id)
    {
        $payment = PaymentResource::make(Payment::find($payment_id));
        
        return inertia('Payment/Pay', compact('payment'));
    }
}
