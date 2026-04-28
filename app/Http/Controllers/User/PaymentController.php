<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
public function index()
{
    $payments = auth()->user()
        ->payments()
        ->with('skill')
        ->latest()
        ->paginate(10);

    return view('user.payments', compact('payments'));
}
    
    public function create(Skill $skill)
    {
        return view('user.payment-create', compact('skill'));
    }
    
    public function store(Request $request, Skill $skill)
    {
        $request->validate([
            'phone_number' => 'required|string|regex:/^[0-9]{10,13}$/',
        ]);
        
        // Generate unique transaction ID
        $transactionId = 'TRX-' . strtoupper(Str::random(10));
        
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'skill_id' => $skill->id,
            'transaction_id' => $transactionId,
            'phone_number' => $request->phone_number,
            'amount' => $skill->price,
            'status' => 'pending',
        ]);
        
        // Attach skill to user with pending status
        auth()->user()->skills()->attach($skill->id, [
            'status' => 'pending',
            'payment_id' => $payment->id,
        ]);
        
        return redirect()->route('user.payments.index')
            ->with('success', 'Payment request submitted. Please complete payment to ' . $this->getMpesaNumber() . ' and wait for approval.');
    }
    
    private function getMpesaNumber()
    {
        return '0765289993';
    }
}