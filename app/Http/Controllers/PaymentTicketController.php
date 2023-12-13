<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentTicketResource;
use App\Models\PaymentTicket;
use Illuminate\Http\Request;

class PaymentTicketController extends Controller
{
    
    public function index()
    {
        //
    
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($paymentTicket_id)
    {
        $paymentTicket = PaymentTicketResource::make(PaymentTicket::with('payment')->find($paymentTicket_id));
        
        return inertia('PaymentTicket/Show', compact('paymentTicket'));
    }

    
    public function edit(PaymentTicket $paymentTicket)
    {
        //
    }

    
    public function update(Request $request, PaymentTicket $paymentTicket)
    {
        //
    }

    
    public function destroy(PaymentTicket $paymentTicket)
    {
        //
    }

    public function getAll()
    {
        $payment_tickets = PaymentTicketResource::collection(
            PaymentTicket::with('payment')->whereHas('payment', function ($query) {
                $query->where('user_id', auth()->id());
            })->latest()->get()
        );

        return response()->json(['items' => $payment_tickets]);
    }
}
