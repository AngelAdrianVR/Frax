<?php

namespace App\Http\Controllers;

use App\Models\PaymentFeedback;
use Illuminate\Http\Request;

class PaymentFeedbackController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        return inertia('PaymentFeedback/Create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'feedback_type' => 'required|string',
            'description' => 'required|string',
            'answer_contact' => 'required|string|max:40',
            'urgency_level' => 'required|string',
        ]);

       $payment_feedback = PaymentFeedback::create($request->except('media') + ['user_id' => auth()->id()]);

        $payment_feedback->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

        return to_route('payments.index');
    }

    
    public function show(PaymentFeedback $payment_feedback)
    {
        //
    }

    
    public function edit(PaymentFeedback $payment_feedback)
    {
        //
    }

    
    public function update(Request $request, PaymentFeedback $payment_feedback)
    {
        //
    }

    
    public function destroy(PaymentFeedback $payment_feedback)
    {
        //
    }
}
