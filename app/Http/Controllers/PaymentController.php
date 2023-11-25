<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function index()
    {
        return inertia('Payment/Index');
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
}
