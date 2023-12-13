<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentHistoryResource;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
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

    
    public function show(PaymentHistory $paymentHistory)
    {
        //
    }

    
    public function edit(PaymentHistory $paymentHistory)
    {
        //
    }

    
    public function update(Request $request, PaymentHistory $paymentHistory)
    {
        //
    }

    
    public function destroy(PaymentHistory $paymentHistory)
    {
        //
    }

    public function getAll()
    {
        $payment_histories = PaymentHistoryResource::collection(PaymentHistory::latest()->where('user_id', auth()->id())->get());

        return response()->json(['items' => $payment_histories]);
    }
}
