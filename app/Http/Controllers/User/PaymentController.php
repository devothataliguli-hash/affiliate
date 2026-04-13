<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function create(Skill $skill)
    {
        // Ensure skill is paid and not free
        if ($skill->price <= 0) {
            return redirect()->route('user.skills.enroll', $skill);
        }
        
        return view('user.payment', compact('skill'));
    }

    public function store(Request $request, Skill $skill)
    {
        $request->validate([
            'payment_method' => 'required|in:mobile_money,bank_transfer',
            'transaction_id' => 'required|string',
        ]);
        
        $user = Auth::user();
        
        // Create payment record (pending)
        $payment = Payment::create([
            'user_id' => $user->id,
            'skill_id' => $skill->id,
            'amount' => $skill->price,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => 'pending',
        ]);
        
        // Create enrollment record (pending approval)
        $user->skills()->syncWithoutDetaching([$skill->id => [
            'is_approved' => false,
        ]]);
        
        return redirect()->route('dashboard')->with('success', 
            'Malipo yamepokelewa na yanasubiri kuthibitishwa. Utapata ufikiaji mara baada ya kuthibitishwa.');
    }
}