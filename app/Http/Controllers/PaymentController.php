<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentHistoryResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentTicketResource;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\PaymentTicket;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function index()
    {
        $payments = PaymentResource::collection(Payment::latest()->where('user_id', auth()->id())->get());
        
        $payment_tickets = PaymentTicketResource::collection(
            PaymentTicket::with('payment')->whereHas('payment', function ($query) {
                $query->where('user_id', auth()->id());
            })->latest()->get()
        );

        $payment_histories = PaymentHistoryResource::collection(PaymentHistory::latest()->where('user_id', auth()->id())->get());

        // return $payment_histories;
        return inertia('Payment/Index', compact('payments', 'payment_tickets', 'payment_histories'));
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
