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

    
    public function show(PaymentTicket $paymentTicket)
    {
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
}
